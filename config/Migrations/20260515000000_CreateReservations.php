<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateReservations extends BaseMigration
{
    public bool $autoId = false;

    public function up(): void
    {
        $this->table('reservations', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('phone', 'string', ['limit' => 50, 'null' => true, 'default' => null])
            ->addColumn('note', 'text', ['null' => true, 'default' => null])
            ->addColumn('total', 'decimal', ['precision' => 10, 'scale' => 2, 'null' => true, 'default' => null])
            ->addColumn('status', 'string', ['limit' => 20, 'null' => false, 'default' => 'pending'])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->addIndex(['email'], ['name' => 'idx_reservations_email'])
            ->addIndex(['status'], ['name' => 'idx_reservations_status'])
            ->create();

        $this->table('reservation_items', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('reservation_id', 'integer', ['limit' => 11, 'null' => false, 'signed' => false])
            ->addColumn('record_id', 'integer', ['limit' => 11, 'null' => true, 'default' => null, 'signed' => false])
            ->addColumn('artist', 'string', ['limit' => 255, 'null' => true, 'default' => null])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2, 'null' => true, 'default' => null])
            ->addColumn('cover', 'string', ['limit' => 255, 'null' => true, 'default' => null])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->addIndex(['reservation_id'], ['name' => 'idx_reservation_items_reservation_id'])
            ->addForeignKey('reservation_id', 'reservations', 'id', [
                'delete' => 'CASCADE',
                'update' => 'NO_ACTION',
            ])
            ->create();
    }

    public function down(): void
    {
        $this->table('reservation_items')->drop()->save();
        $this->table('reservations')->drop()->save();
    }
}
