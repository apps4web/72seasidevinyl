<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ReleasesFixture
 */
class ReleasesFixture extends TestFixture
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
                'title' => 'Radical Optimism',
                'artist' => 'Dua Lipa',
                'genre' => 'Pop',
                'price' => 29.99,
                'color' => '#6C3483',
                'label_text' => 'LP',
                'in_stock' => true,
                'created' => '2026-01-01 00:00:00',
                'modified' => '2026-01-01 00:00:00',
            ],
            [
                'id' => 2,
                'title' => 'Cowboy Carter',
                'artist' => 'Beyoncé',
                'genre' => 'Country / R&B',
                'price' => 34.99,
                'color' => '#1A5276',
                'label_text' => '2xLP',
                'in_stock' => true,
                'created' => '2026-01-02 00:00:00',
                'modified' => '2026-01-02 00:00:00',
            ],
            [
                'id' => 3,
                'title' => 'Short n\' Sweet',
                'artist' => 'Sabrina Carpenter',
                'genre' => 'Pop',
                'price' => 27.99,
                'color' => '#C0392B',
                'label_text' => 'LP',
                'in_stock' => false,
                'created' => '2026-01-03 00:00:00',
                'modified' => '2026-01-03 00:00:00',
            ],
        ];
        parent::init();
    }
}
