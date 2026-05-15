<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TracksFixture
 */
class TracksFixture extends TestFixture
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
                'position' => 'Lorem ipsum dolor sit amet',
                'title' => 'Lorem ipsum dolor sit amet',
                'duration' => 'Lorem ipsum dolor ',
                'video' => null,
                'track_type' => 'Lorem ipsum dolor ',
                'sort_order' => 1,
                'created' => '2026-05-13 23:51:08',
                'modified' => '2026-05-13 23:51:08',
            ],
        ];
        parent::init();
    }
}
