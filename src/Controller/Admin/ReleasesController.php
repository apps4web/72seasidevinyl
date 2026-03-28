<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Http\Exception\NotFoundException;

/**
 * Admin Releases CRUD controller.
 *
 * @property \App\Model\Table\ReleasesTable $Releases
 */
class ReleasesController extends AppController
{
    /**
     * Index action – paginated list of all vinyl releases.
     *
     * @return void
     */
    public function index(): void
    {
        $releases = $this->paginate($this->Releases, [
            'order' => ['Releases.created' => 'DESC'],
        ]);

        $this->set(compact('releases'));
    }

    /**
     * View action – shows a single release.
     *
     * @param string|null $id Release id.
     * @return void
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function view(?string $id = null): void
    {
        $release = $this->Releases->get((int)$id);
        $this->set(compact('release'));
    }

    /**
     * Add action – create a new vinyl release.
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $release = $this->Releases->newEmptyEntity();
        if ($this->request->is('post')) {
            $release = $this->Releases->patchEntity($release, $this->request->getData());
            if ($this->Releases->save($release)) {
                $this->Flash->success(__('The release has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The release could not be saved. Please, try again.'));
        }
        $this->set(compact('release'));
    }

    /**
     * Edit action – update an existing vinyl release.
     *
     * @param string|null $id Release id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $release = $this->Releases->get((int)$id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $release = $this->Releases->patchEntity($release, $this->request->getData());
            if ($this->Releases->save($release)) {
                $this->Flash->success(__('The release has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The release could not be saved. Please, try again.'));
        }
        $this->set(compact('release'));
    }

    /**
     * Delete action – remove a vinyl release.
     *
     * @param string|null $id Release id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $release = $this->Releases->get((int)$id);
        if ($this->Releases->delete($release)) {
            $this->Flash->success(__('The release has been deleted.'));
        } else {
            $this->Flash->error(__('The release could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
