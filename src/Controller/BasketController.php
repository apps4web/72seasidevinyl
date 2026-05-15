<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Mailer\MailerAwareTrait;

class BasketController extends AppController
{
    use MailerAwareTrait;
    public function add($recordId = null)
    {
        $this->request->allowMethod(['post']);

        $record = $this->fetchTable('Records')->get((int)$recordId, contain: ['Artists']);

        $session = $this->request->getSession();
        $basket = (array)($session->read('Basket') ?? []);

        $id = (int)$record->id;
        if (!isset($basket[$id])) {
            $basket[$id] = [
                'record_id' => $id,
                'name'      => (string)$record->name,
                'artist'    => $record->hasValue('artist') ? (string)$record->artist->name : '',
                'price'     => $record->price,
                'cover'     => (string)($record->cover ?? ''),
            ];
            $session->write('Basket', $basket);
            $this->Flash->success(__('"{0}" is toegevoegd aan uw winkelwagen.', $record->name));
        } else {
            $this->Flash->info(__('"{0}" staat al in uw winkelwagen.', $record->name));
        }

        $referer = $this->referer(['controller' => 'Shop', 'action' => 'record', $id]);

        return $this->redirect($referer);
    }

    public function remove($recordId = null)
    {
        $this->request->allowMethod(['post']);

        $session = $this->request->getSession();
        $basket = (array)($session->read('Basket') ?? []);
        unset($basket[(int)$recordId]);
        $session->write('Basket', $basket);

        $this->Flash->success(__('Item verwijderd uit uw winkelwagen.'));

        return $this->redirect(['action' => 'view']);
    }

    public function view()
    {
        $session = $this->request->getSession();
        $basket = (array)($session->read('Basket') ?? []);

        $total = 0.0;
        foreach ($basket as $item) {
            if ($item['price'] !== null && $item['price'] !== '') {
                $total += (float)$item['price'];
            }
        }

        $this->set(compact('basket', 'total'));
    }

    public function checkout()
    {
        $session = $this->request->getSession();
        $basket = (array)($session->read('Basket') ?? []);

        if (empty($basket)) {
            return $this->redirect(['action' => 'view']);
        }

        $total = 0.0;
        foreach ($basket as $item) {
            if ($item['price'] !== null && $item['price'] !== '') {
                $total += (float)$item['price'];
            }
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $name  = trim((string)($data['name'] ?? ''));
            $email = trim((string)($data['email'] ?? ''));
            $phone = trim((string)($data['phone'] ?? ''));
            $note  = trim((string)($data['note'] ?? ''));

            $errors = [];
            if ($name === '') {
                $errors[] = 'Vul uw naam in.';
            }
            if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Vul een geldig e-mailadres in.';
            }

            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $this->Flash->error($error);
                }
            } else {
                $reservationsTable = $this->fetchTable('Reservations');

                $itemsData = array_values(array_map(fn($item) => [
                    'record_id' => $item['record_id'],
                    'name'      => $item['name'],
                    'artist'    => $item['artist'] !== '' ? $item['artist'] : null,
                    'price'     => ($item['price'] !== null && $item['price'] !== '') ? (float)$item['price'] : null,
                    'cover'     => $item['cover'] !== '' ? $item['cover'] : null,
                ], $basket));

                $reservation = $reservationsTable->newEntity([
                    'name'              => $name,
                    'email'             => $email,
                    'phone'             => $phone !== '' ? $phone : null,
                    'note'              => $note !== '' ? $note : null,
                    'total'             => $total > 0 ? $total : null,
                    'status'            => 'pending',
                    'reservation_items' => $itemsData,
                ], ['associated' => ['ReservationItems']]);

                try {
                    $reservationsTable->saveOrFail($reservation, ['associated' => ['ReservationItems']]);
                } catch (\Throwable $e) {
                    $this->Flash->error(__('Er is een fout opgetreden bij het opslaan van uw reservering. Probeer het opnieuw.'));
                    $this->set(compact('basket', 'total'));
                    return null;
                }

                try {
                    $this->getMailer('Reservation')->send('clientConfirmation', [$reservation]);
                } catch (\Throwable) {
                    // email failure does not block reservation
                }

                try {
                    $this->getMailer('Reservation')->send('adminAlert', [$reservation]);
                } catch (\Throwable) {
                    // email failure does not block reservation
                }

                $session->write('BasketReservationId', $reservation->id);
                $session->delete('Basket');

                return $this->redirect(['action' => 'confirm']);
            }
        }

        $this->set(compact('basket', 'total'));
    }

    public function confirm()
    {
        $session = $this->request->getSession();
        $reservationId = $session->read('BasketReservationId');

        if (empty($reservationId)) {
            return $this->redirect(['action' => 'view']);
        }

        $reservation = $this->fetchTable('Reservations')->get(
            (int)$reservationId,
            contain: ['ReservationItems']
        );

        $session->delete('BasketReservationId');

        $this->set('reservation', $reservation);
    }
}
