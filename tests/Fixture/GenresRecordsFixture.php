<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GenresRecordsFixture
 */
class GenresRecordsFixture extends TestFixture
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
                'genre_id' => 1,
                'record_id' => 1,
            ],
        ];
        parent::init();
    }
}
