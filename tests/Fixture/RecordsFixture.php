<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RecordsFixture
 */
class RecordsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'artist_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'barcode' => 'Lorem ipsum dolor sit amet',
                'discogs_release_id' => 1,
                'cover' => 'Lorem ipsum dolor sit amet',
                'released' => '2026-05-13',
                'is_latest' => 1,
                'price' => 1.5,
                'lowest_price' => 'Lorem ipsum dolor sit amet',
                'color' => 'Lorem',
                'label_text' => 'Lorem ipsum dolor ',
                'in_stock' => 1,
                'created' => '2026-05-13 23:52:15',
                'modified' => '2026-05-13 23:52:15',
            ],
        ];
        parent::init();
    }
}
