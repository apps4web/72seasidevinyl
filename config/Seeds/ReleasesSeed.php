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
        $now = date('Y-m-d H:i:s');

        // Create a default admin user if it doesn't exist yet.
        $existingAdmin = $this->fetchRow("SELECT id FROM users WHERE username = 'admin' LIMIT 1");
        if (!$existingAdmin) {
            $this->table('users')->insert([
                [
                    'username' => 'admin',
                    'email' => 'admin@72seasidevinyl.nl',
                    'role' => 'admin',
                    'password' => password_hash('ChangeMe123!', PASSWORD_BCRYPT),
                    'created' => $now,
                    'modified' => $now,
                ],
            ])->save();
        } else {
            $this->execute("UPDATE users SET role = 'admin' WHERE username = 'admin'");
        }

        // Ensure some artists exist first
        $artistsTable = $this->table('artists');
        $artists = [
            ['id' => 1, 'name' => 'Dua Lipa',           'bio' => null, 'created' => $now, 'modified' => $now],
            ['id' => 2, 'name' => 'Beyoncé',             'bio' => null, 'created' => $now, 'modified' => $now],
            ['id' => 3, 'name' => 'Sabrina Carpenter',   'bio' => null, 'created' => $now, 'modified' => $now],
            ['id' => 4, 'name' => 'Halsey',              'bio' => null, 'created' => $now, 'modified' => $now],
            ['id' => 5, 'name' => 'MJ Lenderman',        'bio' => null, 'created' => $now, 'modified' => $now],
            ['id' => 6, 'name' => 'Magdalena Bay',       'bio' => null, 'created' => $now, 'modified' => $now],
        ];
        $artistsTable->insert($artists)->save();

        $data = [
            [
                'artist_id'  => 1,
                'name'       => 'Radical Optimism',
                'cover'      => 'dua-lipa-radical-optimism.jpg',
                'is_latest'  => true,
                'price'      => 29.99,
                'color'      => '#6C3483',
                'label_text' => 'LP',
                'in_stock'   => true,
                'created'    => $now,
                'modified'   => $now,
            ],
            [
                'artist_id'  => 2,
                'name'       => 'Cowboy Carter',
                'cover'      => 'beyonce-cowboy-carter.jpg',
                'is_latest'  => true,
                'price'      => 34.99,
                'color'      => '#1A5276',
                'label_text' => '2xLP',
                'in_stock'   => true,
                'created'    => $now,
                'modified'   => $now,
            ],
            [
                'artist_id'  => 3,
                'name'       => "Short n' Sweet",
                'cover'      => 'sabrina-carpenter-short-n-sweet.jpg',
                'is_latest'  => true,
                'price'      => 27.99,
                'color'      => '#C0392B',
                'label_text' => 'LP',
                'in_stock'   => true,
                'created'    => $now,
                'modified'   => $now,
            ],
            [
                'artist_id'  => 4,
                'name'       => 'The Great Impersonator',
                'is_latest'  => true,
                'price'      => 31.99,
                'color'      => '#1E8449',
                'label_text' => '2xLP',
                'in_stock'   => true,
                'created'    => $now,
                'modified'   => $now,
            ],
            [
                'artist_id'  => 5,
                'name'       => 'Manning Fireworks',
                'is_latest'  => true,
                'price'      => 26.99,
                'color'      => '#784212',
                'label_text' => 'LP',
                'in_stock'   => true,
                'created'    => $now,
                'modified'   => $now,
            ],
            [
                'artist_id'  => 6,
                'name'       => 'Imaginal Disk',
                'is_latest'  => true,
                'price'      => 29.99,
                'color'      => '#117A65',
                'label_text' => 'LP',
                'in_stock'   => true,
                'created'    => $now,
                'modified'   => $now,
            ],
        ];

        $table = $this->table('records');
        $table->insert($data)->save();
    }
}
