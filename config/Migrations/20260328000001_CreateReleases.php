<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateReleases extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('releases');
        $table
            ->addColumn('title', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('artist', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('genre', 'string', ['limit' => 100, 'null' => false, 'default' => ''])
            ->addColumn('price', 'decimal', ['precision' => 8, 'scale' => 2, 'null' => false, 'default' => '0.00'])
            ->addColumn('color', 'string', ['limit' => 7, 'null' => false, 'default' => '#000000'])
            ->addColumn('label_text', 'string', ['limit' => 20, 'null' => false, 'default' => 'LP'])
            ->addColumn('in_stock', 'boolean', ['default' => true, 'null' => false])
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('modified', 'datetime', ['null' => true])
            ->create();
    }
}
