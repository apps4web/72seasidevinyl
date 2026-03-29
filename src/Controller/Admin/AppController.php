<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController as BaseController;
use Cake\Event\EventInterface;

/**
 * Admin AppController - base controller for all admin controllers.
 * Sets the admin layout and any shared admin logic.
 */
class AppController extends BaseController
{
    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->viewBuilder()->setLayout('admin');
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization');
    }

    /**
     * Run authentication + request authorization for all admin actions.
     *
     * @param \Cake\Event\EventInterface $event Event instance.
     * @return void
     */
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);

        $this->Authorization->authorize($this->request);
    }
}
