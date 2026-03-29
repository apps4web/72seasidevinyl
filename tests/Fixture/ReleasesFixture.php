<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ReleasesFixture – seeds the `records` table with is_latest records for testing.
 */
class ReleasesFixture extends TestFixture
{
    public string $table = 'records';

    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id'         => 1,
                'artist_id'  => 1,
                'name'       => 'Radical Optimism',
                'cover'      => null,
                'released'   => null,
                'is_latest'  => true,
                'price'      => 29.99,
                'color'      => '#6C3483',
                'label_text' => 'LP',
                'in_stock'   => true,
                'created'    => '2026-01-01 00:00:00',
                'modified'   => '2026-01-01 00:00:00',
            ],
            [
                'id'         => 2,
                'artist_id'  => 2,
                'name'       => 'Cowboy Carter',
                'cover'      => null,
                'released'   => null,
                'is_latest'  => true,
                'price'      => 34.99,
                'color'      => '#1A5276',
                'label_text' => '2xLP',
                'in_stock'   => true,
                'created'    => '2026-01-02 00:00:00',
                'modified'   => '2026-01-02 00:00:00',
            ],
            [
                'id'         => 3,
                'artist_id'  => 3,
                'name'       => 'Short n\' Sweet',
                'cover'      => null,
                'released'   => null,
                'is_latest'  => true,
                'price'      => 27.99,
                'color'      => '#C0392B',
                'label_text' => 'LP',
                'in_stock'   => false,
                'created'    => '2026-01-03 00:00:00',
                'modified'   => '2026-01-03 00:00:00',
            ],
        ];
        parent::init();
    }
}
