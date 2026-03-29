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
        $data = [
            [
                'title' => 'Radical Optimism',
                'artist' => 'Dua Lipa',
                'genre' => 'Pop',
                'price' => 29.99,
                'color' => '#6C3483',
                'label_text' => 'LP',
                'in_stock' => true,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Cowboy Carter',
                'artist' => 'Beyoncé',
                'genre' => 'Country / R&B',
                'price' => 34.99,
                'color' => '#1A5276',
                'label_text' => '2xLP',
                'in_stock' => true,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => "Short n' Sweet",
                'artist' => 'Sabrina Carpenter',
                'genre' => 'Pop',
                'price' => 27.99,
                'color' => '#C0392B',
                'label_text' => 'LP',
                'in_stock' => true,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'The Great Impersonator',
                'artist' => 'Halsey',
                'genre' => 'Alternative',
                'price' => 31.99,
                'color' => '#1E8449',
                'label_text' => '2xLP',
                'in_stock' => true,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Manning Fireworks',
                'artist' => 'MJ Lenderman',
                'genre' => 'Indie Rock',
                'price' => 26.99,
                'color' => '#784212',
                'label_text' => 'LP',
                'in_stock' => true,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Imaginal Disk',
                'artist' => 'Magdalena Bay',
                'genre' => 'Synth-Pop',
                'price' => 29.99,
                'color' => '#117A65',
                'label_text' => 'LP',
                'in_stock' => true,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('releases');
        $table->insert($data)->save();
    }
}
