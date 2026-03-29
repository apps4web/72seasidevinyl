<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Admin users controller for CMS login/logout.
 */
class UsersController extends AppController
{
    /**
     * Allow unauthenticated access to login.
     *
     * @param \Cake\Event\EventInterface $event Event instance.
     * @return void
     */
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login']);
    }

    /**
     * Admin login action.
     *
     * @return \Cake\Http\Response|null
     */
    public function login(): ?Response
    {
        $this->Authorization->skipAuthorization();
        $this->viewBuilder()->setLayout('admin_login');

        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            $redirect = $this->request->getQuery('redirect');

            return $this->redirect($redirect ?: ['prefix' => 'Admin', 'controller' => 'Dashboard', 'action' => 'index']);
        }

        if ($this->request->is('post')) {
            $this->Flash->error(__('Invalid username or password. Please try again.'));
        }

        return null;
    }

    /**
     * Logout and redirect to login.
     *
     * @return \Cake\Http\Response
     */
    public function logout(): Response
    {
        $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['post', 'get']);
        $this->Authentication->logout();

        return $this->redirect(['action' => 'login']);
    }
}
