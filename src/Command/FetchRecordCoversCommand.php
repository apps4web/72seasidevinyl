<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Utility\Text;
use Throwable;

/**
 * Fetches the official front cover art for records via MusicBrainz + Cover Art Archive.
 *
 * Looks up each record's barcode on MusicBrainz to find the canonical release MBID,
 * then downloads the front-cover image from the Cover Art Archive (official scans,
 * not user-uploaded Discogs images).
 *
 * Usage:
 *   bin/cake fetch_record_covers
 *   bin/cake fetch_record_covers --record-id=5
 *   bin/cake fetch_record_covers --overwrite
 *   bin/cake fetch_record_covers --dry-run
 */
class FetchRecordCoversCommand extends Command
{
    private const MB_API_BASE = 'https://musicbrainz.org/ws/2';
    private const CAA_BASE = 'https://coverartarchive.org/release';
    private const USER_AGENT = '72SeasideVinyl/1.0 (info@72SeasideVinyl.nl)';

    public static function defaultName(): string
    {
        return 'fetch_record_covers';
    }

    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->setDescription(
            'Fetches official front cover art from MusicBrainz / Cover Art Archive using the record barcode.'
        );
        $parser->addOption('record-id', [
            'short' => 'r',
            'help' => 'Only process this specific record ID.',
            'default' => null,
        ]);
        $parser->addOption('dry-run', [
            'help' => 'Preview what would happen without downloading or saving anything.',
            'boolean' => true,
            'default' => false,
        ]);
        $parser->addOption('overwrite', [
            'help' => 'Also replace covers for records that already have one.',
            'boolean' => true,
            'default' => false,
        ]);

        return $parser;
    }

    public function execute(Arguments $args, ConsoleIo $io): ?int
    {
        $dryRun = (bool)$args->getOption('dry-run');
        $overwrite = (bool)$args->getOption('overwrite');
        $recordId = $args->getOption('record-id');

        if ($dryRun) {
            $io->info('[dry-run mode — nothing will be saved]');
        }

        $recordsTable = $this->fetchTable('Records');

        $query = $recordsTable->find()
            ->contain(['Artists'])
            ->where(['Records.barcode IS NOT' => null, 'Records.barcode !=' => '']);

        if ($recordId !== null) {
            $query->where(['Records.id' => (int)$recordId]);
        } elseif (!$overwrite) {
            $query->where(['OR' => [
                'Records.cover IS' => null,
                'Records.cover' => '',
            ]]);
        }

        $records = $query->all();
        $total = count($records);

        if ($total === 0) {
            $io->success('No records to process.');

            return self::CODE_SUCCESS;
        }

        $io->out("Found {$total} record(s) to process.");

        $updated = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($records as $record) {
            $barcode = trim((string)($record->barcode ?? ''));
            $artistName = (string)($record->artist->name ?? 'Unknown');
            $label = "\"{$record->name}\" by {$artistName} (barcode: {$barcode})";

            $io->out('');
            $io->out("Processing: {$label}");

            try {
                $mbid = $this->lookupMbidByBarcode($barcode);
                if ($mbid === null) {
                    $io->warning("  No MusicBrainz release found for barcode {$barcode}.");
                    $skipped++;
                    // Respect MusicBrainz rate limit: max 1 req/sec
                    usleep(1100000);
                    continue;
                }

                $io->out("  MusicBrainz MBID: {$mbid}");
                // Respect rate limit between MusicBrainz and CAA calls
                usleep(1100000);

                $imageUrl = $this->fetchFrontCoverUrl($mbid);
                if ($imageUrl === null) {
                    $io->warning("  No front cover found in Cover Art Archive for MBID {$mbid}.");
                    $skipped++;
                    continue;
                }

                $io->out("  Cover URL: {$imageUrl}");

                if ($dryRun) {
                    $io->info("  [dry-run] Would download and save cover.");
                    $updated++;
                    continue;
                }

                $savedFilename = $this->downloadImage($imageUrl);
                if ($savedFilename === null) {
                    $io->error("  Failed to download image.");
                    $failed++;
                    continue;
                }

                $oldCover = trim((string)($record->cover ?? ''));
                $record->cover = $savedFilename;

                if ($recordsTable->save($record, ['checkRules' => false, 'validate' => false])) {
                    $io->success("  Cover saved: {$savedFilename}");
                    if ($oldCover !== '' && $oldCover !== $savedFilename) {
                        $this->deleteLocalImage($oldCover);
                    }
                    $updated++;
                } else {
                    $io->error("  Could not update record in database.");
                    $this->deleteLocalImage($savedFilename);
                    $failed++;
                }
            } catch (Throwable $e) {
                $io->error("  Error: {$e->getMessage()}");
                $failed++;
                usleep(1100000);
            }
        }

        $io->out('');
        $io->out("Done. Updated: {$updated}, Skipped: {$skipped}, Failed: {$failed}");

        return $failed > 0 ? self::CODE_ERROR : self::CODE_SUCCESS;
    }

    /**
     * Query MusicBrainz by barcode and return the best-matching release MBID.
     */
    private function lookupMbidByBarcode(string $barcode): ?string
    {
        $url = self::MB_API_BASE . '/release?query=barcode:' . urlencode($barcode) . '&fmt=json&limit=5';

        $context = stream_context_create([
            'http' => [
                'timeout' => 15,
                'follow_location' => 1,
                'header' => 'User-Agent: ' . self::USER_AGENT . "\r\n" .
                            "Accept: application/json\r\n",
            ],
        ]);

        $body = @file_get_contents($url, false, $context);
        if ($body === false || $body === '') {
            return null;
        }

        /** @var mixed $decoded */
        $decoded = json_decode($body, true);
        if (!is_array($decoded)) {
            return null;
        }

        $releases = (array)($decoded['releases'] ?? []);
        foreach ($releases as $release) {
            if (!is_array($release)) {
                continue;
            }
            $mbid = trim((string)($release['id'] ?? ''));
            if ($mbid !== '') {
                return $mbid;
            }
        }

        return null;
    }

    /**
     * Query Cover Art Archive for the front image URL of a release MBID.
     */
    private function fetchFrontCoverUrl(string $mbid): ?string
    {
        $url = self::CAA_BASE . '/' . urlencode($mbid);

        $context = stream_context_create([
            'http' => [
                'timeout' => 15,
                'follow_location' => 1,
                'header' => 'User-Agent: ' . self::USER_AGENT . "\r\n" .
                            "Accept: application/json\r\n",
            ],
        ]);

        $body = @file_get_contents($url, false, $context);
        if ($body === false || $body === '') {
            return null;
        }

        /** @var mixed $decoded */
        $decoded = json_decode($body, true);
        if (!is_array($decoded)) {
            return null;
        }

        $images = (array)($decoded['images'] ?? []);

        // Prefer the image explicitly typed as Front
        foreach ($images as $image) {
            if (!is_array($image)) {
                continue;
            }
            $types = array_map('strtolower', (array)($image['types'] ?? []));
            if (in_array('front', $types, true)) {
                $imageUrl = trim((string)($image['image'] ?? ''));
                if ($imageUrl !== '') {
                    return $imageUrl;
                }
            }
        }

        // Fall back to first available image
        foreach ($images as $image) {
            if (!is_array($image)) {
                continue;
            }
            $imageUrl = trim((string)($image['image'] ?? ''));
            if ($imageUrl !== '') {
                return $imageUrl;
            }
        }

        return null;
    }

    /**
     * Download a remote image and store it in the local cover images directory.
     */
    private function downloadImage(string $url): ?string
    {
        $cleanUrl = trim($url);
        if ($cleanUrl === '' || !preg_match('/^https?:\/\//i', $cleanUrl)) {
            return null;
        }

        $path = (string)parse_url($cleanUrl, PHP_URL_PATH);
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
            $extension = 'jpg';
        }

        $context = stream_context_create([
            'http' => [
                'timeout' => 20,
                'follow_location' => 1,
                'header' => 'User-Agent: ' . self::USER_AGENT . "\r\n",
            ],
        ]);

        $binary = @file_get_contents($cleanUrl, false, $context);
        if ($binary === false || $binary === '') {
            return null;
        }

        $targetFilename = Text::uuid() . '.' . $extension;
        $targetDir = WWW_ROOT . 'img' . DS . 'records' . DS . 'images' . DS;
        if (!is_dir($targetDir) && !mkdir($targetDir, 0775, true) && !is_dir($targetDir)) {
            return null;
        }

        $targetPath = $targetDir . $targetFilename;
        $written = @file_put_contents($targetPath, $binary);
        if ($written === false || $written <= 0 || !is_file($targetPath)) {
            return null;
        }

        return $targetFilename;
    }

    /**
     * Delete a locally stored cover image file.
     */
    private function deleteLocalImage(string $filename): void
    {
        $safeFilename = basename($filename);
        $path = WWW_ROOT . 'img' . DS . 'records' . DS . 'images' . DS . $safeFilename;
        if (is_file($path)) {
            @unlink($path);
        }
    }
}
