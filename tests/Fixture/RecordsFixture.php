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
                'cover' => 'Lorem ipsum dolor sit amet',
                'released' => '2026-03-29',
                'is_latest' => 1,
                'price' => 1.5,
                'color' => 'Lorem',
                'label_text' => 'Lorem ipsum dolor ',
                'in_stock' => 1,
                'created' => '2026-03-29 05:51:35',
                'modified' => '2026-03-29 05:51:35',
            ],
        ];
        parent::init();
    }
}
