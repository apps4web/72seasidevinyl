<?php
declare(strict_types=1);

use Migrations\BaseSeed;

/**
 * Releases seed – pre-populates the catalogue with the initial vinyl releases.
 */
class ReleasesSeed extends BaseSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/migrations/4/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        // Ensure some artists exist first
        $artistsTable = $this->table('artists');
        $artists = [
            ['id' => 1, 'name' => 'Dua Lipa',           'bio' => null, 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')],
            ['id' => 2, 'name' => 'Beyoncé',             'bio' => null, 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')],
            ['id' => 3, 'name' => 'Sabrina Carpenter',   'bio' => null, 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')],
            ['id' => 4, 'name' => 'Halsey',              'bio' => null, 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')],
            ['id' => 5, 'name' => 'MJ Lenderman',        'bio' => null, 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')],
            ['id' => 6, 'name' => 'Magdalena Bay',       'bio' => null, 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')],
        ];
        $artistsTable->insert($artists)->save();

        $data = [
            [
                'artist_id'  => 1,
                'name'       => 'Radical Optimism',
                'is_latest'  => true,
                'price'      => 29.99,
                'color'      => '#6C3483',
                'label_text' => 'LP',
                'in_stock'   => true,
                'created'    => date('Y-m-d H:i:s'),
                'modified'   => date('Y-m-d H:i:s'),
            ],
            [
                'artist_id'  => 2,
                'name'       => 'Cowboy Carter',
                'is_latest'  => true,
                'price'      => 34.99,
                'color'      => '#1A5276',
                'label_text' => '2xLP',
                'in_stock'   => true,
                'created'    => date('Y-m-d H:i:s'),
                'modified'   => date('Y-m-d H:i:s'),
            ],
            [
                'artist_id'  => 3,
                'name'       => "Short n' Sweet",
                'is_latest'  => true,
                'price'      => 27.99,
                'color'      => '#C0392B',
                'label_text' => 'LP',
                'in_stock'   => true,
                'created'    => date('Y-m-d H:i:s'),
                'modified'   => date('Y-m-d H:i:s'),
            ],
            [
                'artist_id'  => 4,
                'name'       => 'The Great Impersonator',
                'is_latest'  => true,
                'price'      => 31.99,
                'color'      => '#1E8449',
                'label_text' => '2xLP',
                'in_stock'   => true,
                'created'    => date('Y-m-d H:i:s'),
                'modified'   => date('Y-m-d H:i:s'),
            ],
            [
                'artist_id'  => 5,
                'name'       => 'Manning Fireworks',
                'is_latest'  => true,
                'price'      => 26.99,
                'color'      => '#784212',
                'label_text' => 'LP',
                'in_stock'   => true,
                'created'    => date('Y-m-d H:i:s'),
                'modified'   => date('Y-m-d H:i:s'),
            ],
            [
                'artist_id'  => 6,
                'name'       => 'Imaginal Disk',
                'is_latest'  => true,
                'price'      => 29.99,
                'color'      => '#117A65',
                'label_text' => 'LP',
                'in_stock'   => true,
                'created'    => date('Y-m-d H:i:s'),
                'modified'   => date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('records');
        $table->insert($data)->save();
    }
}
