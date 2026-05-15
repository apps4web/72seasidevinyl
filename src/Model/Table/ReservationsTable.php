<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ReservationsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('reservations');
        $this->addBehavior('Timestamp');

        $this->hasMany('ReservationItems', [
            'foreignKey' => 'reservation_id',
            'dependent'  => true,
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('name')
            ->email('email')
            ->notEmptyString('email')
            ->allowEmptyString('phone')
            ->allowEmptyString('note')
            ->allowEmptyString('total')
            ->inList('status', ['pending', 'confirmed', 'cancelled', 'picked_up']);

        return $validator;
    }
}
