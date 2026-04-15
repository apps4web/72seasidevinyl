<?php
declare(strict_types=1);

use Migrations\BaseMigration;

/**
 * Add role column to users.
 */
class AddRoleToUsers extends BaseMigration
{
    /**
     * @return void
     */
    public function up(): void
    {
        $this->table('users')
            ->addColumn('role', 'string', [
                'limit' => 50,
                'null' => false,
                'default' => 'customer',
                'after' => 'email',
            ])
            ->update();
    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->table('users')
            ->removeColumn('role')
            ->update();
    }
}