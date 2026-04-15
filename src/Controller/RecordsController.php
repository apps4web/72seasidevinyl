<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Text;
use Psr\Http\Message\UploadedFileInterface;

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
            $payload = $this->prepareCoverPayload($this->request->getData(), null);
            if ($payload['error'] !== null) {
                $this->Flash->error($payload['error']);
            } else {
                $record = $this->Records->patchEntity($record, $payload['data']);
            }

            if ($payload['error'] === null && $this->Records->save($record)) {
                $this->deleteCoverFiles($payload['deleteAfterSave']);
                $this->Flash->success(__('The record has been saved.'));

                return $this->redirect(Router::url([
                    'prefix' => false,
                    'controller' => 'Records',
                    'action' => 'index',
                ], false));
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
     * Edit method
     *
     * @param string|null $id Record id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $record = $this->Records->get($id, contain: ['Genres']);
        $this->Authorization->authorize($record);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payload = $this->prepareCoverPayload($this->request->getData(), (string)$record->cover);
            if ($payload['error'] !== null) {
                $this->Flash->error($payload['error']);
            } else {
                $record = $this->Records->patchEntity($record, $payload['data']);
            }

            if ($payload['error'] === null && $this->Records->save($record)) {
                $this->deleteCoverFiles($payload['deleteAfterSave']);
                $this->Flash->success(__('The record has been saved.'));

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
        $this->set(compact('record', 'artists', 'genres'));
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

        return $this->redirect(Router::url([
            'prefix' => false,
            'controller' => 'Records',
            'action' => 'index',
        ], false));
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
        $targetDir = WWW_ROOT . 'img' . DS . 'records' . DS . 'covers' . DS;

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
        $path = WWW_ROOT . 'img' . DS . 'records' . DS . 'covers' . DS . $safeFilename;
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
}
