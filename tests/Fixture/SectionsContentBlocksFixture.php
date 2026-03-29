<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SectionsContentBlocksFixture
 */
class SectionsContentBlocksFixture extends TestFixture
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
                'section_id' => 1,
                'content_block_id' => 1,
                'sort_order' => 1,
            ],
        ];
        parent::init();
    }
}
