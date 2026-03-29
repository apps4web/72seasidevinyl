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
        $query = $this->Releases->find()
            ->contain(['Artists'])
            ->where(['is_latest' => true])
            ->orderBy(['Releases.created' => 'DESC']);

        $releases = $this->paginate($query);

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
        $release = $this->Releases->find()
            ->contain(['Artists'])
            ->where(['Releases.id' => (int)$id])
            ->firstOrFail();
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
            $data = $this->request->getData();
            $data['is_latest'] = true;
            $release = $this->Releases->patchEntity($release, $data);
            if ($this->Releases->save($release)) {
                $this->Flash->success(__('The release has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The release could not be saved. Please, try again.'));
        }
        $artists = $this->Releases->Artists->find('list', limit: 200)->all();
        $this->set(compact('release', 'artists'));
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
        $release = $this->Releases->find()
            ->contain(['Artists'])
            ->where(['Releases.id' => (int)$id])
            ->firstOrFail();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $release = $this->Releases->patchEntity($release, $this->request->getData());
            if ($this->Releases->save($release)) {
                $this->Flash->success(__('The release has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The release could not be saved. Please, try again.'));
        }
        $artists = $this->Releases->Artists->find('list', limit: 200)->all();
        $this->set(compact('release', 'artists'));
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
