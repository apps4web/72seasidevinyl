<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RecordSupplierImagesFixture
 */
class RecordSupplierImagesFixture extends TestFixture
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
                'records_supplier_id' => 1,
                'uri' => 'Lorem ipsum dolor sit amet',
                'resource_url' => 'Lorem ipsum dolor sit amet',
                'image_type' => 'Lorem ipsum dolor sit amet',
                'width' => 1,
                'height' => 1,
                'sort_order' => 1,
                'created' => '2026-05-14 00:10:02',
                'modified' => '2026-05-14 00:10:02',
            ],
        ];
        parent::init();
    }
}
