<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CakeSeedsFixture
 */
class CakeSeedsFixture extends TestFixture
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
                'plugin' => 'Lorem ipsum dolor sit amet',
                'seed_name' => 'Lorem ipsum dolor sit amet',
                'executed_at' => 1774763492,
            ],
        ];
        parent::init();
    }
}
