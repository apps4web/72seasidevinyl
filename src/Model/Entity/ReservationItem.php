<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ReservationItem Entity
 *
 * @property int $id
 * @property int $reservation_id
 * @property int|null $record_id
 * @property string|null $artist
 * @property string $name
 * @property string|null $price
 * @property string|null $cover
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Reservation $reservation
 */
class ReservationItem extends Entity
{
    protected array $_accessible = [
        'reservation_id' => true,
        'record_id'      => true,
        'artist'         => true,
        'name'           => true,
        'price'          => true,
        'cover'          => true,
        'created'        => true,
        'modified'       => true,
    ];
}
