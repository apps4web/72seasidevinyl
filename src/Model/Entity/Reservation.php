<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reservation Entity
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $note
 * @property string|null $total
 * @property string $status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\ReservationItem[] $reservation_items
 */
class Reservation extends Entity
{
    protected array $_accessible = [
        'name'              => true,
        'email'             => true,
        'phone'             => true,
        'note'              => true,
        'total'             => true,
        'status'            => true,
        'reservation_items' => true,
        'created'           => true,
        'modified'          => true,
    ];
}
