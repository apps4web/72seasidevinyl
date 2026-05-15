<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;s. 

/**
 * RecordsArtistsFixture
 */
class RecordsArtistsFixture extends TestFixture
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
                'record_id' => 1,
                'company_id' => 1,
                'type' => 'Lorem ipsum dolor sit amet',
                'role' => 'Lorem ipsum dolor sit amet',
                'position' => 1,
                'created' => '2026-05-14 00:09:14',
                'modified' => '2026-05-14 00:09:14',
            ],
        ];
        parent::init();
    }
}
