<?php
declare(strict_types=1);

namespace App\Controller;

use Calliostro\Discogs\DiscogsClientFactory;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Text;
use Psr\Http\Message\UploadedFileInterface;
use Throwable;

/**
 * Records Controller
 *
 * @property \App\Model\Table\RecordsTable $Records
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 */
class RecordsController extends AppController
{
    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authorization.Authorization');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('admin');
        $this->Authorization->authorize($this->Records, 'index');

        $query = $this->Records->find()
            ->contain(['Artists']);
        $query = $this->Authorization->applyScope($query);
        $records = $this->paginate($query);

        $this->set(compact('records'));
    }

    /**
     * Quick-add an artist via AJAX from the record add/edit form.
     *
     * @return \Cake\Http\Response
     */
    public function quickAddArtist()
    {
        $this->request->allowMethod(['post']);
        $this->Authorization->authorize($this->Records, 'index');

        $name = trim((string)$this->request->getData('name'));
        if ($name === '') {
            return $this->jsonResponse(['success' => false, 'message' => 'Name is required.'], 400);
        }

        $artist = $this->Records->Artists->newEmptyEntity();
        $artist = $this->Records->Artists->patchEntity($artist, ['name' => $name]);

        if ($this->Records->Artists->save($artist)) {
            return $this->jsonResponse(['success' => true, 'id' => $artist->id, 'name' => $artist->name]);
        }

        $errors = $artist->getErrors();
        $message = !empty($errors['name']) ? implode(' ', (array)reset($errors['name'])) : 'Could not save artist.';

        return $this->jsonResponse(['success' => false, 'message' => $message], 422);
    }

    /**
     * View method
     *
     * @param string|null $id Record id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $record = $this->Records->get($id, contain: ['Artists', 'Genres', 'RecordImages']);
        $this->Authorization->authorize($record);
        $this->set(compact('record'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->setLayout('admin');
        $record = $this->Records->newEmptyEntity();
        $this->Authorization->authorize($record);
        if ($this->request->is('post')) {
            $requestData = $this->enrichRecordDataFromDiscogs((array)$this->request->getData());
            $payload = $this->prepareCoverPayload($requestData, null);
            if ($payload['error'] !== null) {
                $this->Flash->error($payload['error']);
            } else {
                $record = $this->Records->patchEntity($record, $payload['data']);
            }

            if ($payload['error'] === null && $this->Records->save($record)) {
                $discogsWarning = $this->syncDiscogsSupplierData($record, (array)$this->request->getData());
                $this->deleteCoverFiles($payload['deleteAfterSave']);
                $this->Flash->success(__('The record has been saved.'));
                if ($discogsWarning !== null) {
                    $this->Flash->warning($discogsWarning);
                }

                return $this->redirect([
                    'prefix' => false,
                    'controller' => 'Records',
                    'action' => 'index',
                ]);
            }
            if ($payload['newCover'] !== null) {
                $this->deleteCoverFile($payload['newCover']);
            }
            if ($payload['error'] === null) {
                $this->Flash->error(__('The record could not be saved. Please, try again.'));
            }
        }
        $artists = $this->Records->Artists->find('list', limit: 200)->all();
        $genres = $this->Records->Genres->find('list', limit: 200)->all();
        $this->set(compact('record', 'artists', 'genres'));
    }

    /**
     * Fill required record fields from selected Discogs release payload.
     *
     * @param array<string, mixed> $data Request data.
     * @return array<string, mixed>
     */
    private function enrichRecordDataFromDiscogs(array $data): array
    {
        $payloadRaw = trim((string)($data['discogs_release_payload'] ?? ''));
        if ($payloadRaw === '') {
            return $data;
        }

        /** @var mixed $payloadDecoded */
        $payloadDecoded = json_decode($payloadRaw, true);
        if (!is_array($payloadDecoded)) {
            return $data;
        }

        $recordName = trim((string)($data['name'] ?? ''));
        if ($recordName === '') {
            $recordName = trim((string)($payloadDecoded['title'] ?? ''));
            if ($recordName !== '') {
                $data['name'] = $recordName;
            }
        }

        if (empty($data['barcode'])) {
            $barcode = trim((string)($payloadDecoded['barcode'] ?? ''));
            if ($barcode !== '') {
                $data['barcode'] = $barcode;
            }
        }

        if (empty($data['discogs_release_id']) && !empty($payloadDecoded['id']) && is_numeric($payloadDecoded['id'])) {
            $data['discogs_release_id'] = (int)$payloadDecoded['id'];
        }

        if (array_key_exists('sale_price', $data)) {
            $salePrice = trim((string)$data['sale_price']);
            if ($salePrice !== '') {
                $data['price'] = $salePrice;
            }
            unset($data['sale_price']);
        }

        if (array_key_exists('lowest_price', $data)) {
            $lowestPrice = trim((string)$data['lowest_price']);
            $data['lowest_price'] = $lowestPrice !== '' ? $lowestPrice : null;
        }

        if (empty($data['released']) && !empty($payloadDecoded['released'])) {
            $released = $this->parseDiscogsReleasedDate((string)$payloadDecoded['released']);
            if ($released !== null) {
                $data['released'] = $released;
            }
        }

        $artistId = isset($data['artist_id']) && $data['artist_id'] !== '' ? (int)$data['artist_id'] : 0;
        if ($artistId <= 0) {
            $artistName = '';
            if (!empty($payloadDecoded['artists']) && is_array($payloadDecoded['artists'])) {
                $firstArtist = reset($payloadDecoded['artists']);
                if (is_array($firstArtist)) {
                    $artistName = trim((string)($firstArtist['name'] ?? ''));
                }
            }
            if ($artistName === '') {
                $artistName = trim((string)($payloadDecoded['artists_sort'] ?? ''));
            }

            if ($artistName !== '') {
                $artistEntity = $this->Records->Artists->find()
                    ->where(['name' => $artistName])
                    ->first();
                if ($artistEntity === null) {
                    $artistEntity = $this->Records->Artists->newEntity(['name' => $artistName]);
                    $artistEntity = $this->Records->Artists->save($artistEntity);
                }
                if ($artistEntity !== false && $artistEntity !== null) {
                    $data['artist_id'] = (int)$artistEntity->get('id');
                }
            }
        }

        return $data;
    }

    /**
     * Edit method
     *
     * @param string|null $id Record id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $record = $this->Records->get($id, contain: [
            'Genres',
            'Suppliers',
            'RecordImages',
            'RecordSupplierImages',
            'RecordVideos',
            'Tracks',
            'RecordsArtists.Companies',
        ]);
        $this->Authorization->authorize($record);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payload = $this->prepareCoverPayload($this->request->getData(), (string)$record->cover);
            if ($payload['error'] !== null) {
                $this->Flash->error($payload['error']);
            } else {
                $record = $this->Records->patchEntity($record, $payload['data']);
            }

            if ($payload['error'] === null && $this->Records->save($record)) {
                $discogsWarning = $this->syncDiscogsSupplierData($record, (array)$this->request->getData());
                $this->deleteCoverFiles($payload['deleteAfterSave']);
                $this->Flash->success(__('The record has been saved.'));
                if ($discogsWarning !== null) {
                    $this->Flash->warning($discogsWarning);
                }

                return $this->redirect(['action' => 'index']);
            }
            if ($payload['newCover'] !== null) {
                $this->deleteCoverFile($payload['newCover']);
            }
            if ($payload['error'] === null) {
                $this->Flash->error(__('The record could not be saved. Please, try again.'));
            }
        }
        $artists = $this->Records->Artists->find('list', limit: 200)->all();
        $genres = $this->Records->Genres->find('list', limit: 200)->all();
        $suppliers = $this->Records->Suppliers->find('list', limit: 200)->all();
        $this->set(compact('record', 'artists', 'genres', 'suppliers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Record id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $record = $this->Records->get($id);
        $this->Authorization->authorize($record);
        if ($this->Records->delete($record)) {
            $this->Flash->success(__('The record has been deleted.'));
        } else {
            $this->Flash->error(__('The record could not be deleted. Please, try again.'));
        }

        return $this->redirect([
            'prefix' => false,
            'controller' => 'Records',
            'action' => 'index',
        ]);
    }

    /**
     * Find releases on Discogs by barcode.
     *
     * Expects query parameter: barcode.
     *
     * @return \Cake\Http\Response
     */
    public function findByBarcode(): \Cake\Http\Response
    {
        $this->request->allowMethod(['get']);
        $this->Authorization->authorize($this->Records, 'index');

        $barcode = trim((string)$this->request->getQuery('barcode'));
        if ($barcode === '') {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Query parameter "barcode" is required.',
                'results' => [],
            ], 400);
        }

        $consumerKey = trim((string)Configure::read('Discogs.consumerKey', ''));
        $consumerSecret = trim((string)Configure::read('Discogs.consumerSecret', ''));
        if ($consumerKey === '' || $consumerSecret === '') {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Discogs credentials are missing. Set DISCOGS_CONSUMER_KEY and DISCOGS_CONSUMER_SECRET in config/.env.',
                'results' => [],
            ], 500);
        }

        try {
            $discogs = DiscogsClientFactory::createWithConsumerCredentials(
                $consumerKey,
                $consumerSecret,
                [
                    'headers' => [
                        'User-Agent' => '72SeasideVinyl/1.0 (+https://72seasidevinyl.local)',
                    ],
                ]
            );

            /** @var array<string, mixed> $response */
            $response = $discogs->search(barcode: $barcode, type: 'release', perPage: 25, page: 1);

            $results = [];
            foreach ((array)($response['results'] ?? []) as $item) {
                if (!is_array($item)) {
                    continue;
                }

                $releaseId = isset($item['id']) ? (int)$item['id'] : null;
                $lowestPrice = $this->normalizeLowestPrice($item['lowest_price'] ?? $item['lowestPrice'] ?? null);
                $numForSale = $this->normalizeNumForSale($item['num_for_sale'] ?? $item['numForSale'] ?? null);

                // Barcode search results often omit marketplace values; resolve per release when needed.
                if ($releaseId !== null && ($lowestPrice === null || $numForSale === null)) {
                    try {
                        /** @var array<string, mixed> $marketplaceStats */
                        $marketplaceStats = $discogs->getMarketplaceStats($releaseId);
                        if ($lowestPrice === null) {
                            $lowestPrice = $this->normalizeLowestPrice($marketplaceStats['lowest_price'] ?? null);
                        }
                        if ($numForSale === null) {
                            $numForSale = $this->normalizeNumForSale($marketplaceStats['num_for_sale'] ?? null);
                        }
                    } catch (Throwable) {
                        // Keep null values if marketplace stats cannot be resolved.
                    }
                }

                $results[] = [
                    'id' => $releaseId,
                    'title' => $item['title'] ?? null,
                    'year' => $item['year'] ?? null,
                    'country' => $item['country'] ?? null,
                    'catno' => $item['catno'] ?? null,
                    'lowest_price' => $lowestPrice,
                    'num_for_sale' => $numForSale,
                    'type' => $item['type'] ?? null,
                    'format' => $item['format'] ?? [],
                    'label' => $item['label'] ?? [],
                    'genre' => $item['genre'] ?? [],
                    'style' => $item['style'] ?? [],
                    'cover_image' => $item['cover_image'] ?? null,
                    'thumb' => $item['thumb'] ?? null,
                    'resource_url' => $item['resource_url'] ?? null,
                ];
            }

            return $this->jsonResponse([
                'success' => true,
                'barcode' => $barcode,
                'count' => count($results),
                'results' => $results,
            ]);
        } catch (Throwable $exception) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Discogs request failed.',
                'error' => $exception->getMessage(),
                'results' => [],
            ], 502);
        }
    }

    /**
     * Find LP releases on Discogs by artist and album name.
     *
     * Expects query parameters: artist, album.
     *
     * @return \Cake\Http\Response
     */
    public function findLpsByArtistAndAlbum()
    {
        $this->request->allowMethod(['get']);
        $this->Authorization->authorize($this->Records, 'index');

        $artist = trim((string)$this->request->getQuery('artist'));
        $album = trim((string)$this->request->getQuery('album'));
        $page = max(1, (int)$this->request->getQuery('page', 1));
        $perPage = (int)$this->request->getQuery('per_page', 10);
        $perPage = max(1, min(50, $perPage));

        if ($artist === '' || $album === '') {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Both "artist" and "album" query parameters are required.',
                'results' => [],
            ], 400);
        }

        $consumerKey = trim((string)Configure::read('Discogs.consumerKey', ''));
        $consumerSecret = trim((string)Configure::read('Discogs.consumerSecret', ''));
        if ($consumerKey === '' || $consumerSecret === '') {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Discogs credentials are missing. Set DISCOGS_CONSUMER_KEY and DISCOGS_CONSUMER_SECRET in config/.env.',
                'results' => [],
            ], 500);
        }

        try {
            $discogs = DiscogsClientFactory::createWithConsumerCredentials(
                $consumerKey,
                $consumerSecret,
                [
                    'headers' => [
                        'User-Agent' => '72SeasideVinyl/1.0 (+https://72seasidevinyl.local)',
                    ],
                ]
            );

            /** @var array<string, mixed> $response */
            $response = $discogs->search(
                q: $artist . ' ' . $album,
                type: 'release',
                artist: $artist,
                releaseTitle: $album,
                format: 'LP',
                perPage: $perPage,
                page: $page
            );

            $results = [];
            foreach ((array)($response['results'] ?? []) as $item) {
                if (!is_array($item)) {
                    continue;
                }

                $releaseId = isset($item['id']) ? (int)$item['id'] : null;
                $lowestPrice = $this->normalizeLowestPrice($item['lowest_price'] ?? $item['lowestPrice'] ?? null);
                $numForSale = $this->normalizeNumForSale($item['num_for_sale'] ?? $item['numForSale'] ?? null);

                // Search responses can miss marketplace data; fetch stats per release as fallback.
                if ($releaseId !== null && ($lowestPrice === null || $numForSale === null)) {
                    try {
                        /** @var array<string, mixed> $marketplaceStats */
                        $marketplaceStats = $discogs->getMarketplaceStats($releaseId);
                        if ($lowestPrice === null) {
                            $lowestPrice = $this->normalizeLowestPrice($marketplaceStats['lowest_price'] ?? null);
                        }
                        if ($numForSale === null) {
                            $numForSale = $this->normalizeNumForSale($marketplaceStats['num_for_sale'] ?? null);
                        }
                    } catch (Throwable) {
                        // Keep null values and continue; missing price data should not fail the whole response.
                    }
                }

                $results[] = [
                    'id' => $releaseId,
                    'title' => $item['title'] ?? null,
                    'year' => $item['year'] ?? null,
                    'country' => $item['country'] ?? null,
                    'catno' => $item['catno'] ?? null,
                    'lowest_price' => $lowestPrice,
                    'num_for_sale' => $numForSale,
                    'type' => $item['type'] ?? null,
                    'format' => $item['format'] ?? [],
                    'label' => $item['label'] ?? [],
                    'genre' => $item['genre'] ?? [],
                    'style' => $item['style'] ?? [],
                    'cover_image' => $item['cover_image'] ?? null,
                    'thumb' => $item['thumb'] ?? null,
                    'resource_url' => $item['resource_url'] ?? null,
                ];
            }

            $pagination = (array)($response['pagination'] ?? []);
            $currentPage = (int)($pagination['page'] ?? $page);
            $totalPages = (int)($pagination['pages'] ?? 1);
            $totalItems = (int)($pagination['items'] ?? count($results));
            $effectivePerPage = (int)($pagination['per_page'] ?? $perPage);

            return $this->jsonResponse([
                'success' => true,
                'artist' => $artist,
                'album' => $album,
                'count' => count($results),
                'pagination' => [
                    'page' => max(1, $currentPage),
                    'pages' => max(1, $totalPages),
                    'items' => max(0, $totalItems),
                    'per_page' => max(1, $effectivePerPage),
                ],
                'results' => $results,
            ]);
        } catch (Throwable $exception) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Discogs request failed.',
                'error' => $exception->getMessage(),
                'results' => [],
            ], 502);
        }
    }

    /**
     * Fetch full Discogs release details by release id.
     *
     * Expects query parameter: release_id.
     *
     * @return \Cake\Http\Response
     */
    public function discogsReleaseDetails()
    {
        $this->request->allowMethod(['get']);
        $this->Authorization->authorize($this->Records, 'index');

        $releaseId = (int)$this->request->getQuery('release_id');
        if ($releaseId <= 0) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Query parameter "release_id" must be a positive integer.',
            ], 400);
        }

        $consumerKey = trim((string)Configure::read('Discogs.consumerKey', ''));
        $consumerSecret = trim((string)Configure::read('Discogs.consumerSecret', ''));
        if ($consumerKey === '' || $consumerSecret === '') {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Discogs credentials are missing. Set DISCOGS_CONSUMER_KEY and DISCOGS_CONSUMER_SECRET in config/.env.',
            ], 500);
        }

        try {
            $discogs = DiscogsClientFactory::createWithConsumerCredentials(
                $consumerKey,
                $consumerSecret,
                [
                    'headers' => [
                        'User-Agent' => '72SeasideVinyl/1.0 (+https://72seasidevinyl.local)',
                    ],
                ]
            );

            /** @var array<string, mixed> $release */
            $release = $discogs->getRelease($releaseId);

            return $this->jsonResponse([
                'success' => true,
                'release_id' => $releaseId,
                // Return full payload from Discogs as requested.
                'release' => $release,
            ]);
        } catch (Throwable $exception) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Discogs request failed.',
                'error' => $exception->getMessage(),
            ], 502);
        }
    }

    /**
     * Normalize cover-related payload and process file operations.
     *
     * @param array<string, mixed> $data Request data.
     * @param string|null $existingCover Existing cover filename.
      * @return array{data: array<string, mixed>, error: string|null, newCover: string|null, deleteAfterSave: array<int, string>}
     */
    private function prepareCoverPayload(array $data, ?string $existingCover): array
    {
        $deleteCover = !empty($data['delete_cover']);
        $uploadedFile = $data['cover_upload'] ?? null;
          $newCover = null;
          $deleteAfterSave = [];
        unset($data['cover_upload'], $data['delete_cover']);

        // Keep existing cover by default when editing and no explicit action is taken.
        if ($existingCover !== null && !$deleteCover) {
            unset($data['cover']);
        }

        if ($deleteCover && $existingCover) {
            $data['cover'] = null;
            $deleteAfterSave[] = $existingCover;
        }

        if ($uploadedFile instanceof UploadedFileInterface && $uploadedFile->getError() === UPLOAD_ERR_OK) {
            $validation = $this->validateCoverUpload($uploadedFile);
            if ($validation !== null) {
                return [
                    'data' => $data,
                    'error' => $validation,
                    'newCover' => null,
                    'deleteAfterSave' => $deleteAfterSave,
                ];
            }

            $newCover = $this->storeCoverFile($uploadedFile);
            if ($newCover === null) {
                return [
                    'data' => $data,
                    'error' => __('The cover image could not be uploaded. Please try again.'),
                    'newCover' => null,
                    'deleteAfterSave' => $deleteAfterSave,
                ];
            }

            $data['cover'] = $newCover;
            if ($existingCover && $existingCover !== $newCover) {
                $deleteAfterSave[] = $existingCover;
            }
        }

        return [
            'data' => $data,
            'error' => null,
            'newCover' => $newCover,
            'deleteAfterSave' => array_values(array_unique($deleteAfterSave)),
        ];
    }

    /**
     * Validate uploaded cover image.
     *
     * @param \Psr\Http\Message\UploadedFileInterface $uploadedFile Uploaded file.
     * @return string|null
     */
    private function validateCoverUpload(UploadedFileInterface $uploadedFile): ?string
    {
        $filename = (string)$uploadedFile->getClientFilename();
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

        if (!in_array($extension, $allowedExtensions, true)) {
            return __('Invalid cover image type. Allowed types: jpg, jpeg, png, webp, gif.');
        }

        $maxSize = (int)Configure::read('Upload.coverMaxSize', 5 * 1024 * 1024);
        if ($uploadedFile->getSize() !== null && $uploadedFile->getSize() > $maxSize) {
            return __('Cover image is too large. Maximum size is 5 MB.');
        }

        return null;
    }

    /**
     * Store uploaded cover file and return the stored filename.
     *
     * @param \Psr\Http\Message\UploadedFileInterface $uploadedFile Uploaded file.
     * @return string|null
     */
    private function storeCoverFile(UploadedFileInterface $uploadedFile): ?string
    {
        $filename = (string)$uploadedFile->getClientFilename();
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $targetFilename = Text::uuid() . '.' . $extension;
        $targetDir = WWW_ROOT . 'img' . DS . 'records' . DS . 'images' . DS;

        if (!is_dir($targetDir) && !mkdir($targetDir, 0775, true) && !is_dir($targetDir)) {
            return null;
        }

        $targetPath = $targetDir . $targetFilename;
        $uploadedFile->moveTo($targetPath);

        return file_exists($targetPath) ? $targetFilename : null;
    }

    /**
     * Delete an existing cover file if present.
     *
     * @param string $filename Cover filename.
     * @return void
     */
    private function deleteCoverFile(string $filename): void
    {
        $safeFilename = basename($filename);
        $path = WWW_ROOT . 'img' . DS . 'records' . DS . 'images' . DS . $safeFilename;
        if (is_file($path)) {
            @unlink($path);
        }
    }

    /**
     * Delete multiple cover files.
     *
     * @param array<int, string> $filenames Cover filenames.
     * @return void
     */
    private function deleteCoverFiles(array $filenames): void
    {
        foreach ($filenames as $filename) {
            $this->deleteCoverFile($filename);
        }
    }

    /**
     * Persist selected Discogs release payload into normalized supplier tables.
     *
     * @param \App\Model\Entity\Record $record Persisted record entity.
     * @param array<string, mixed> $requestData Raw request data.
     * @return string|null Warning message when sync fails, null on success/no-op.
     */
    private function syncDiscogsSupplierData(\App\Model\Entity\Record $record, array $requestData): ?string
    {
        $payloadRaw = trim((string)($requestData['discogs_release_payload'] ?? ''));
        if ($payloadRaw === '') {
            return null;
        }

        /** @var mixed $decoded */
        $decoded = json_decode($payloadRaw, true);
        if (!is_array($decoded)) {
            return __('Discogs data could not be parsed and was not saved.');
        }

        $releaseId = (int)($requestData['discogs_release_id'] ?? ($decoded['id'] ?? 0));
        if ($releaseId <= 0) {
            return __('Discogs release id is missing and supplier data was skipped.');
        }

        $barcode = trim((string)($requestData['barcode'] ?? ''));

        try {
            $connection = $this->Records->getConnection();
            $connection->transactional(function () use ($record, $decoded, $releaseId, $barcode): void {
                $recordDataChanged = false;
                if ($barcode !== '' && (string)($record->get('barcode') ?? '') !== $barcode) {
                    $record->set('barcode', $barcode);
                    $recordDataChanged = true;
                }
                if ((int)($record->get('discogs_release_id') ?? 0) !== $releaseId) {
                    $record->set('discogs_release_id', $releaseId);
                    $recordDataChanged = true;
                }
                if ($recordDataChanged) {
                    $this->Records->saveOrFail($record, ['checkRules' => false, 'validate' => false]);
                }

                $suppliersTable = $this->fetchTable('Suppliers');
                $recordsSuppliersTable = $this->fetchTable('RecordsSuppliers');
                $companiesTable = $this->fetchTable('Companies');
                $recordsArtistsTable = $this->fetchTable('RecordsArtists');
                $genresRecordsTable = $this->fetchTable('GenresRecords');
                $tracksTable = $this->fetchTable('Tracks');
                $recordVideosTable = $this->fetchTable('RecordVideos');
                $recordSupplierImagesTable = $this->fetchTable('RecordSupplierImages');
                $recordImagesTable = $this->fetchTable('RecordImages');

                $supplier = $suppliersTable->find()
                    ->where(['slug' => 'discogs'])
                    ->first();
                if ($supplier === null) {
                    $supplier = $suppliersTable->newEntity([
                        'name' => 'Discogs',
                        'slug' => 'discogs',
                    ]);
                    $suppliersTable->saveOrFail($supplier);
                }

                $releasedDate = $this->parseDiscogsReleasedDate((string)($decoded['released'] ?? ''));
                $formatsJson = $this->encodeJson($decoded['formats'] ?? null);
                $payloadJson = $this->encodeJson($this->filterDiscogsPayload($decoded));

                $recordSupplier = $recordsSuppliersTable->find()
                    ->where([
                        'record_id' => (int)$record->id,
                        'supplier_id' => (int)$supplier->id,
                    ])
                    ->first();

                $recordSupplierData = [
                    'record_id' => (int)$record->id,
                    'supplier_id' => (int)$supplier->id,
                    'external_id' => (string)$releaseId,
                    'external_uri' => isset($decoded['uri']) ? (string)$decoded['uri'] : null,
                    'resource_url' => isset($decoded['resource_url']) ? (string)$decoded['resource_url'] : null,
                    'title' => isset($decoded['title']) ? (string)$decoded['title'] : null,
                    'country' => isset($decoded['country']) ? (string)$decoded['country'] : null,
                    'released' => $releasedDate,
                    'year' => is_numeric($decoded['year'] ?? null) ? (int)$decoded['year'] : null,
                    'formats' => $formatsJson,
                    'notes' => isset($decoded['notes']) ? (string)$decoded['notes'] : null,
                    'payload' => $payloadJson,
                ];

                if ($recordSupplier === null) {
                    $recordSupplier = $recordsSuppliersTable->newEntity($recordSupplierData);
                } else {
                    $recordSupplier = $recordsSuppliersTable->patchEntity($recordSupplier, $recordSupplierData);
                }
                $recordsSuppliersTable->saveOrFail($recordSupplier);

                $recordsArtistsTable->deleteAll(['record_id' => (int)$record->id]);
                $companyRelations = [];
                $companyRelations = array_merge($companyRelations, $this->buildCompanyRelations((array)($decoded['artists'] ?? []), 'artist'));
                $companyRelations = array_merge($companyRelations, $this->buildCompanyRelations((array)($decoded['labels'] ?? []), 'label'));
                $companyRelations = array_merge($companyRelations, $this->buildCompanyRelations((array)($decoded['companies'] ?? []), 'company'));

                $seenRecordCompanyType = [];
                foreach ($companyRelations as $index => $relation) {
                    $companyId = $this->upsertCompany($companiesTable, $relation['name'], $relation['discogs_id']);
                    if ($companyId === null) {
                        continue;
                    }

                    $uniqueKey = (int)$record->id . ':' . $companyId . ':' . $relation['type'];
                    if (isset($seenRecordCompanyType[$uniqueKey])) {
                        continue;
                    }
                    $seenRecordCompanyType[$uniqueKey] = true;

                    $recordsArtistEntity = $recordsArtistsTable->newEntity([
                        'record_id' => (int)$record->id,
                        'company_id' => $companyId,
                        'type' => $relation['type'],
                        'role' => $relation['role'],
                        'position' => $index,
                    ]);
                    $recordsArtistsTable->saveOrFail($recordsArtistEntity);
                }

                $existingGenreRows = $genresRecordsTable->find()
                    ->select(['genre_id'])
                    ->where(['record_id' => (int)$record->id])
                    ->enableHydration(false)
                    ->all()
                    ->toList();
                $existingGenreIds = [];
                foreach ($existingGenreRows as $genreRow) {
                    $existingGenreIds[] = (int)($genreRow['genre_id'] ?? 0);
                }

                $discogsGenreIds = $this->ensureDiscogsGenres((array)($decoded['genres'] ?? []), (array)($decoded['styles'] ?? []));
                $finalGenreIds = array_values(array_unique(array_merge($existingGenreIds, $discogsGenreIds)));

                $genresRecordsTable->deleteAll(['record_id' => (int)$record->id]);
                foreach ($finalGenreIds as $genreId) {
                    if ($genreId <= 0) {
                        continue;
                    }

                    // genres_records uses composite PK. Ensure junction keys are mass assignable.
                    $junctionEntity = $genresRecordsTable->newEntity(
                        [
                            'genre_id' => $genreId,
                            'record_id' => (int)$record->id,
                        ],
                        [
                            'accessibleFields' => [
                                'genre_id' => true,
                                'record_id' => true,
                            ],
                            'validate' => false,
                        ]
                    );
                    $genresRecordsTable->saveOrFail($junctionEntity, ['checkRules' => false]);
                }

                $tracksTable->deleteAll(['record_id' => (int)$record->id]);
                $tracklist = (array)($decoded['tracklist'] ?? []);
                $videos = (array)($decoded['videos'] ?? []);
                $usedTrackVideoUris = [];
                foreach ($tracklist as $trackIndex => $track) {
                    if (!is_array($track)) {
                        continue;
                    }
                    $trackTitle = trim((string)($track['title'] ?? ''));
                    if ($trackTitle === '') {
                        continue;
                    }

                    $trackVideo = isset($track['video']) ? trim((string)$track['video']) : '';
                    if ($trackVideo === '') {
                        $trackVideo = $this->matchTrackVideoUri($trackTitle, $videos, $trackIndex, $usedTrackVideoUris) ?? '';
                    }

                    $trackEntity = $tracksTable->newEntity([
                        'record_id' => (int)$record->id,
                        'position' => isset($track['position']) ? (string)$track['position'] : null,
                        'title' => $trackTitle,
                        'duration' => isset($track['duration']) ? (string)$track['duration'] : null,
                        'video' => $trackVideo !== '' ? $trackVideo : null,
                        'track_type' => isset($track['type_']) ? (string)$track['type_'] : 'track',
                        'sort_order' => $trackIndex,
                    ]);
                    $tracksTable->saveOrFail($trackEntity);
                }

                $recordVideosTable->deleteAll(['record_id' => (int)$record->id]);
                foreach ($videos as $videoIndex => $selectedVideo) {
                    if (!is_array($selectedVideo)) {
                        continue;
                    }

                    $uri = trim((string)($selectedVideo['uri'] ?? ''));
                    if ($uri === '') {
                        continue;
                    }

                    $videoEntity = $recordVideosTable->newEntity([
                        'record_id' => (int)$record->id,
                        'uri' => $uri,
                        'embed' => !empty($selectedVideo['embed']),
                        'title' => isset($selectedVideo['title']) ? (string)$selectedVideo['title'] : null,
                        'description' => isset($selectedVideo['description']) ? (string)$selectedVideo['description'] : null,
                        'duration' => is_numeric($selectedVideo['duration'] ?? null) ? (int)$selectedVideo['duration'] : null,
                        'sort_order' => $videoIndex,
                    ]);
                    if ((string)$videoEntity->get('uri') !== '') {
                        $recordVideosTable->saveOrFail($videoEntity);
                    }
                }

                $images = [];
                foreach ((array)($decoded['images'] ?? []) as $image) {
                    if (is_array($image)) {
                        $images[] = $image;
                    }
                }

                $primaryIndex = 0;
                foreach ($images as $index => $image) {
                    if (strtolower((string)($image['type'] ?? '')) === 'primary') {
                        $primaryIndex = $index;
                        break;
                    }
                }

                if ($images !== []) {
                    $primaryImage = $images[$primaryIndex] ?? null;
                    if (is_array($primaryImage)) {
                        $primaryUri = (string)($primaryImage['uri'] ?? $primaryImage['resource_url'] ?? '');
                        if ($primaryUri !== '') {
                            $downloadedCover = $this->storeRemoteCoverFile($primaryUri);
                            if ($downloadedCover !== null) {
                                $oldCover = (string)($record->get('cover') ?? '');
                                $record->set('cover', $downloadedCover);
                                $this->Records->saveOrFail($record, ['checkRules' => false, 'validate' => false]);
                                if ($oldCover !== '' && $oldCover !== $downloadedCover) {
                                    $this->deleteCoverFile($oldCover);
                                }
                            }
                        }
                    }
                }

                $recordSupplierImagesTable->deleteAll(['record_id' => (int)$record->id]);
                $recordImagesTable->deleteAll(['record_id' => (int)$record->id]);
                foreach ($images as $index => $image) {
                    if ($index === $primaryIndex) {
                        continue;
                    }

                    $uri = trim((string)($image['uri'] ?? ''));
                    if ($uri === '') {
                        continue;
                    }

                    $imageEntity = $recordSupplierImagesTable->newEntity([
                        'record_id' => (int)$record->id,
                        'records_supplier_id' => (int)$recordSupplier->id,
                        'uri' => $uri,
                        'resource_url' => isset($image['resource_url']) ? (string)$image['resource_url'] : null,
                        'image_type' => isset($image['type']) ? (string)$image['type'] : null,
                        'width' => is_numeric($image['width'] ?? null) ? (int)$image['width'] : null,
                        'height' => is_numeric($image['height'] ?? null) ? (int)$image['height'] : null,
                        'sort_order' => $index,
                    ]);
                    $recordSupplierImagesTable->saveOrFail($imageEntity);

                    $downloadedImage = $this->storeRemoteRecordImageFile($uri);
                    if ($downloadedImage !== null) {
                        $recordImageEntity = $recordImagesTable->newEntity([
                            'record_id' => (int)$record->id,
                            'filename' => $downloadedImage,
                            'alt' => isset($decoded['title']) ? (string)$decoded['title'] : null,
                            'sort_order' => $index,
                        ]);
                        $recordImagesTable->saveOrFail($recordImageEntity);
                    }
                }
            });
        } catch (Throwable $exception) {
            return __('The record was saved, but Discogs supplier data could not be fully persisted: {0}', $exception->getMessage());
        }

        return null;
    }

    /**
     * @param array<int, mixed> $artists
     * @param string $type
     * @return array<int, array{name: string, discogs_id: int|null, type: string, role: string|null}>
     */
    private function buildCompanyRelations(array $artists, string $type): array
    {
        $rows = [];
        foreach ($artists as $artist) {
            if (!is_array($artist)) {
                continue;
            }
            $name = trim((string)($artist['name'] ?? ''));
            if ($name === '') {
                continue;
            }
            $rows[] = [
                'name' => $name,
                'discogs_id' => is_numeric($artist['id'] ?? null) ? (int)$artist['id'] : null,
                'type' => $type,
                'role' => isset($artist['role']) ? trim((string)$artist['role']) : null,
            ];
        }

        return $rows;
    }

    /**
     * @param \Cake\ORM\Table $companiesTable
     * @param string $name
     * @param int|null $discogsId
     * @return int|null
     */
    private function upsertCompany(\Cake\ORM\Table $companiesTable, string $name, ?int $discogsId): ?int
    {
        $company = null;
        if ($discogsId !== null) {
            $company = $companiesTable->find()->where(['discogs_id' => $discogsId])->first();
        }
        if ($company === null) {
            $company = $companiesTable->find()->where(['name' => $name])->first();
        }

        $slug = strtolower(Text::slug($name));
        if ($slug === '') {
            $slug = 'company-' . Text::uuid();
        }

        if ($company === null) {
            $company = $companiesTable->newEntity([
                'name' => $name,
                'slug' => $slug,
                'discogs_id' => $discogsId,
            ]);
        } else {
            $company = $companiesTable->patchEntity($company, [
                'name' => $name,
                'slug' => $slug,
                'discogs_id' => $discogsId ?? $company->get('discogs_id'),
            ]);
        }

        $saved = $companiesTable->save($company);

        return $saved ? (int)$saved->get('id') : null;
    }

    /**
     * @param array<int, mixed> $genres
     * @param array<int, mixed> $styles
     * @return array<int, int>
     */
    private function ensureDiscogsGenres(array $genres, array $styles): array
    {
        $names = [];
        foreach (array_merge($genres, $styles) as $name) {
            $value = trim((string)$name);
            if ($value === '') {
                continue;
            }
            $names[strtolower($value)] = $value;
        }

        $genreIds = [];
        $genresTable = $this->Records->Genres;
        foreach ($names as $name) {
            $genre = $genresTable->find()->where(['name' => $name])->first();
            if ($genre === null) {
                $slug = strtolower(Text::slug($name));
                if ($slug === '') {
                    $slug = strtolower(Text::uuid());
                }

                $baseSlug = $slug;
                $suffix = 1;
                while ($genresTable->find()->where(['slug' => $slug])->count() > 0) {
                    $slug = $baseSlug . '-' . $suffix;
                    $suffix++;
                }

                $genre = $genresTable->newEntity([
                    'name' => $name,
                    'slug' => $slug,
                ]);
                $genre = $genresTable->save($genre);
            }

            if ($genre !== false && $genre !== null) {
                $genreIds[] = (int)$genre->get('id');
            }
        }

        return array_values(array_unique($genreIds));
    }

    /**
     * @param array<int, mixed> $videos
     * @param string $recordName
     * @param string|null $artistName
     * @return array<string, mixed>|null
     */
    private function pickMatchingVideo(array $videos, string $recordName, ?string $artistName): ?array
    {
        if ($videos === []) {
            return null;
        }

        $recordNameNeedle = strtolower(trim($recordName));
        $artistNeedle = strtolower(trim((string)$artistName));

        foreach ($videos as $video) {
            if (!is_array($video)) {
                continue;
            }
            $title = strtolower(trim((string)($video['title'] ?? '')));
            if ($title === '') {
                continue;
            }

            $matchesRecord = $recordNameNeedle !== '' && str_contains($title, $recordNameNeedle);
            $matchesArtist = $artistNeedle !== '' && str_contains($title, $artistNeedle);
            if ($matchesRecord || $matchesArtist) {
                return $video;
            }
        }

        foreach ($videos as $video) {
            if (!is_array($video)) {
                continue;
            }
            if (trim((string)($video['uri'] ?? '')) !== '') {
                return $video;
            }
        }

        return null;
    }

    /**
     * Match a Discogs video URI to a specific track title.
     *
     * @param string $trackTitle
     * @param array<int, mixed> $videos
     * @return string|null
     */
    private function matchTrackVideoUri(string $trackTitle, array $videos, int $trackIndex, array &$usedUris): ?string
    {
        $trackNeedle = $this->normalizeMatchText($trackTitle);
        if ($videos === []) {
            return null;
        }

        if ($trackNeedle !== '') {
            foreach ($videos as $video) {
                if (!is_array($video)) {
                    continue;
                }

                $uri = trim((string)($video['uri'] ?? ''));
                if ($uri === '' || isset($usedUris[$uri])) {
                    continue;
                }

                $title = $this->normalizeMatchText((string)($video['title'] ?? ''));
                if ($title === '') {
                    continue;
                }

                if ($title === $trackNeedle || str_contains($title, $trackNeedle) || str_contains($trackNeedle, $title)) {
                    $usedUris[$uri] = true;

                    return $uri;
                }
            }

            $bestUri = null;
            $bestScore = 0.0;
            foreach ($videos as $video) {
                if (!is_array($video)) {
                    continue;
                }

                $uri = trim((string)($video['uri'] ?? ''));
                if ($uri === '' || isset($usedUris[$uri])) {
                    continue;
                }

                $title = $this->normalizeMatchText((string)($video['title'] ?? ''));
                if ($title === '') {
                    continue;
                }

                $score = $this->tokenOverlapScore($trackNeedle, $title);
                if ($score > $bestScore) {
                    $bestScore = $score;
                    $bestUri = $uri;
                }
            }

            if ($bestUri !== null && $bestScore >= 0.35) {
                $usedUris[$bestUri] = true;

                return $bestUri;
            }
        }

        $videoByIndex = $videos[$trackIndex] ?? null;
        if (is_array($videoByIndex)) {
            $indexedUri = trim((string)($videoByIndex['uri'] ?? ''));
            if ($indexedUri !== '' && !isset($usedUris[$indexedUri])) {
                $usedUris[$indexedUri] = true;

                return $indexedUri;
            }
        }

        foreach ($videos as $video) {
            if (!is_array($video)) {
                continue;
            }
            $uri = trim((string)($video['uri'] ?? ''));
            if ($uri === '' || isset($usedUris[$uri])) {
                continue;
            }

            $usedUris[$uri] = true;

            return $uri;
        }

        return null;
    }

    /**
     * @param string $left
     * @param string $right
     * @return float
     */
    private function tokenOverlapScore(string $left, string $right): float
    {
        $leftTokens = array_values(array_unique(array_filter(explode(' ', $left), static fn(string $token): bool => strlen($token) > 1)));
        $rightTokens = array_values(array_unique(array_filter(explode(' ', $right), static fn(string $token): bool => strlen($token) > 1)));

        if ($leftTokens === [] || $rightTokens === []) {
            return 0.0;
        }

        $common = array_intersect($leftTokens, $rightTokens);
        $denominator = max(count($leftTokens), count($rightTokens));
        if ($denominator <= 0) {
            return 0.0;
        }

        return count($common) / $denominator;
    }

    /**
     * Normalize text for loose title matching.
     *
     * @param string $value
     * @return string
     */
    private function normalizeMatchText(string $value): string
    {
        $lower = mb_strtolower(trim($value));
        if ($lower === '') {
            return '';
        }

        $normalized = preg_replace('/[^a-z0-9\s]+/i', ' ', $lower);
        if (!is_string($normalized)) {
            return $lower;
        }

        $normalized = preg_replace('/\s+/', ' ', trim($normalized));

        return is_string($normalized) ? $normalized : $lower;
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    private function filterDiscogsPayload(array $payload): array
    {
        unset(
            $payload['community'],
            $payload['identifiers'],
            $payload['date_added'],
            $payload['date_changed'],
            $payload['num_for_sale'],
            $payload['thumb']
        );

        return $payload;
    }

    /**
     * @param mixed $value
     * @return string|null
     */
    private function encodeJson(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $json = json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return $json === false ? null : $json;
    }

    /**
     * @param string $value
     * @return string|null
     */
    private function parseDiscogsReleasedDate(string $value): ?string
    {
        $released = trim($value);
        if ($released === '') {
            return null;
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $released) === 1) {
            return $released;
        }

        return null;
    }

    /**
     * Download a remote image and store it as local cover image.
     *
     * @param string $url Remote image URL.
     * @return string|null Saved filename.
     */
    private function storeRemoteCoverFile(string $url): ?string
    {
        $cleanUrl = trim($url);
        if ($cleanUrl === '' || !preg_match('/^https?:\/\//i', $cleanUrl)) {
            return null;
        }

        $path = (string)parse_url($cleanUrl, PHP_URL_PATH);
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (!in_array($extension, $allowedExtensions, true)) {
            $extension = 'jpg';
        }

        $context = stream_context_create([
            'http' => [
                'timeout' => 15,
                'follow_location' => 1,
                'header' => "User-Agent: 72SeasideVinyl/1.0\r\n",
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
     * Download a remote image and store it as local additional record image.
     *
     * @param string $url Remote image URL.
     * @return string|null Saved filename.
     */
    private function storeRemoteRecordImageFile(string $url): ?string
    {
        $cleanUrl = trim($url);
        if ($cleanUrl === '' || !preg_match('/^https?:\/\//i', $cleanUrl)) {
            return null;
        }

        $path = (string)parse_url($cleanUrl, PHP_URL_PATH);
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (!in_array($extension, $allowedExtensions, true)) {
            $extension = 'jpg';
        }

        $context = stream_context_create([
            'http' => [
                'timeout' => 15,
                'follow_location' => 1,
                'header' => "User-Agent: 72SeasideVinyl/1.0\r\n",
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
     * Determine whether a Discogs search result represents an LP vinyl release.
     *
     * @param array<string, mixed> $result Discogs result item.
     * @return bool
     */
    private function isLpDiscogsResult(array $result): bool
    {
        $formats = $result['format'] ?? [];
        if (!is_array($formats) || $formats === []) {
            return false;
        }

        $formatText = strtolower(implode(' ', array_map(static fn($value): string => (string)$value, $formats)));

        return str_contains($formatText, 'lp') && str_contains($formatText, 'vinyl');
    }

    /**
     * Build a JSON response.
     *
     * @param array<string, mixed> $payload Response payload.
     * @param int $status HTTP status code.
     * @return \Cake\Http\Response
     */
    private function jsonResponse(array $payload, int $status = 200)
    {
        $json = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            $json = '{"success":false,"message":"Unable to encode response."}';
            $status = 500;
        }

        return $this->response
            ->withType('application/json')
            ->withStatus($status)
            ->withStringBody($json);
    }

    /**
     * Normalize Discogs lowest_price field to a displayable string value.
     *
     * @param mixed $value Raw lowest_price value.
     * @return string|null
     */
    private function normalizeLowestPrice(mixed $value): ?string
    {
        if (is_numeric($value)) {
            return (string)$value;
        }

        if (is_array($value)) {
            $amount = $value['value'] ?? null;
            $currency = $value['currency'] ?? null;
            if (is_numeric($amount)) {
                return $currency !== null && $currency !== ''
                    ? (string)$amount . ' ' . (string)$currency
                    : (string)$amount;
            }
        }

        return null;
    }

    /**
     * Normalize Discogs num_for_sale field.
     *
     * @param mixed $value Raw num_for_sale value.
     * @return int|null
     */
    private function normalizeNumForSale(mixed $value): ?int
    {
        if (is_int($value)) {
            return $value;
        }
        if (is_numeric($value)) {
            return (int)$value;
        }

        return null;
    }
}
