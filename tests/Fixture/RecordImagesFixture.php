<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RecordImagesFixture
 */
class RecordImagesFixture extends TestFixture
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
                'filename' => 'Lorem ipsum dolor sit amet',
                'alt' => 'Lorem ipsum dolor sit amet',
                'sort_order' => 1,
                'created' => '2026-03-29 05:51:34',
                'modified' => '2026-03-29 05:51:34',
            ],
        ];
        parent::init();
    }
}
