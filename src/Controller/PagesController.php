<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/5/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    /**
     * Known cover filenames for seeded releases.
     *
     * @var array<string, string>
     */
    private const RELEASE_COVER_MAP = [
        'dua lipa|radical optimism' => 'dua-lipa-radical-optimism.jpg',
        'beyonce|cowboy carter' => 'beyonce-cowboy-carter.jpg',
        'beyoncé|cowboy carter' => 'beyonce-cowboy-carter.jpg',
        'sabrina carpenter|short n\' sweet' => 'sabrina-carpenter-short-n-sweet.jpg',
    ];

    /**
     * Fallback release data used when the database is unavailable.
     *
     * @return array<int, array<string, string>>
     */
    private function getFallbackLatestReleases(): array
    {
        return [
            [
                'title' => 'Radical Optimism',
                'artist' => 'Dua Lipa',
                'genre' => '',
                'price' => '29,99',
                'color' => '#6C3483',
                'label_text' => 'LP',
                'cover' => 'dua-lipa-radical-optimism.jpg',
            ],
            [
                'title' => 'Cowboy Carter',
                'artist' => 'Beyonce',
                'genre' => '',
                'price' => '34,99',
                'color' => '#1A5276',
                'label_text' => '2xLP',
                'cover' => 'beyonce-cowboy-carter.jpg',
            ],
            [
                'title' => 'Short n\' Sweet',
                'artist' => 'Sabrina Carpenter',
                'genre' => '',
                'price' => '27,99',
                'color' => '#C0392B',
                'label_text' => 'LP',
                'cover' => 'sabrina-carpenter-short-n-sweet.jpg',
            ],
        ];
    }

    /**
     * Resolve a cover filename for a release.
     *
     * @param string|null $title Release title.
     * @param string|null $artist Release artist.
     * @param string|null $cover Cover filename from the database.
     * @return string|null
     */
    private function getReleaseCoverFilename(?string $title, ?string $artist, ?string $cover = null): ?string
    {
        if ($cover) {
            return $cover;
        }

        $key = mb_strtolower(trim((string)$artist) . '|' . trim((string)$title));

        return self::RELEASE_COVER_MAP[$key] ?? null;
    }

    /**
     * Displays a view
     *
     * @param string ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\View\Exception\MissingTemplateException When the view file could not
     *   be found and in debug mode.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found and not in debug mode.
     * @throws \Cake\View\Exception\MissingTemplateException In debug mode.
     */
    public function display(string ...$path): ?Response
    {
        if (!$path) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        if ($page === 'home') {
            $latestReleases = $this->getFallbackLatestReleases();
            try {
                $dbReleases = $this->fetchTable('Releases')
                    ->find()
                    ->contain(['Artists'])
                    ->where([
                        'Releases.in_stock' => true,
                        'Releases.is_latest' => true,
                    ])
                    ->orderByDesc('Releases.created')
                    ->limit(6)
                    ->all();

                if ($dbReleases->count() > 0) {
                    $latestReleases = array_map(function ($release) {
                        return [
                            'title' => $release->name,
                            'artist' => $release->artist?->name ?? '',
                            'genre' => '',
                            'price' => number_format((float)$release->price, 2, ',', '.'),
                            'color' => $release->color,
                            'label_text' => $release->label_text,
                            'cover' => $this->getReleaseCoverFilename($release->name, $release->artist?->name, $release->cover),
                        ];
                    }, $dbReleases->toArray());
                }
            } catch (\Exception $e) {
                // Fall back to hardcoded releases if database is unavailable
            }
            $this->set('latestReleases', $latestReleases);
        }

        try {
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }
}
