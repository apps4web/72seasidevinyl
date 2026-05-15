<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class ReservationItemsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('reservation_items');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Reservations', [
            'foreignKey' => 'reservation_id',
        ]);
    }
}
