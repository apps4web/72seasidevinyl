<?php
declare(strict_types=1);

namespace App\Controller\Admin;

class ReservationsController extends AppController
{
    public function index(): void
    {
        $statusFilter = (string)$this->request->getQuery('status', '');

        $query = $this->fetchTable('Reservations')
            ->find()
            ->contain(['ReservationItems'])
            ->orderBy(['Reservations.created' => 'DESC']);

        if ($statusFilter !== '' && in_array($statusFilter, ['pending', 'confirmed', 'cancelled', 'picked_up'], true)) {
            $query->where(['Reservations.status' => $statusFilter]);
        }

        $this->paginate = ['limit' => 25];
        $reservations = $this->paginate($query);

        $this->set(compact('reservations', 'statusFilter'));
    }

    public function updateStatus(?string $id = null)
    {
        $this->request->allowMethod(['post']);

        $reservation = $this->fetchTable('Reservations')->get((int)$id);
        $newStatus = (string)($this->request->getData('status') ?? '');

        $allowed = ['pending', 'confirmed', 'cancelled', 'picked_up'];
        if (!in_array($newStatus, $allowed, true)) {
            $this->Flash->error(__('Ongeldige status.'));
            return $this->redirect(['action' => 'index']);
        }

        $reservation->status = $newStatus;
        if ($this->fetchTable('Reservations')->save($reservation)) {
            $this->Flash->success(__('Status bijgewerkt.'));
        } else {
            $this->Flash->error(__('Status kon niet worden bijgewerkt.'));
        }

        return $this->redirect($this->referer(['action' => 'index']));
    }
}
