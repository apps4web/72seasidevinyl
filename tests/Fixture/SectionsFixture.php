<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SectionsFixture
 */
class SectionsFixture extends TestFixture
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
                'page_id' => 1,
                'title' => 'Lorem ipsum dolor sit amet',
                'sort_order' => 1,
                'created' => '2026-03-29 05:51:35',
                'modified' => '2026-03-29 05:51:35',
            ],
        ];
        parent::init();
    }
}
