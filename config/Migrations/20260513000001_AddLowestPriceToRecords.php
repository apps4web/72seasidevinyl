<?php
declare(strict_types=1);

use Migrations\BaseMigration;

/**
 * Add lowest Discogs price to records.
 */
class AddLowestPriceToRecords extends BaseMigration
{
    public function up(): void
    {
        $this->table('records')
            ->addColumn('lowest_price', 'string', [
                'limit' => 32,
                'null' => true,
                'default' => null,
                'after' => 'price',
            ])
            ->update();
    }

    public function down(): void
    {
        $this->table('records')
            ->removeColumn('lowest_price')
            ->update();
    }
}
