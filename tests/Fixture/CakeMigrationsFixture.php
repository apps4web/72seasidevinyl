<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CakeMigrationsFixture
 */
class CakeMigrationsFixture extends TestFixture
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
                'version' => 1,
                'migration_name' => 'Lorem ipsum dolor sit amet',
                'plugin' => 'Lorem ipsum dolor sit amet',
                'start_time' => 1774763491,
                'end_time' => 1774763491,
                'breakpoint' => 1,
            ],
        ];
        parent::init();
    }
}
