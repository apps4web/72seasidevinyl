<?php
declare(strict_types=1);

use Migrations\BaseSeed;

/**
 * Genres seed - populates a broad set of genres suitable for vinyl records.
 */
class GenresSeed extends BaseSeed
{
    /**
     * @return void
     */
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        $genres = [
            ['name' => 'Afrobeat', 'slug' => 'afrobeat'],
            ['name' => 'Alternative', 'slug' => 'alternative'],
            ['name' => 'Alternative Rock', 'slug' => 'alternative-rock'],
            ['name' => 'Ambient', 'slug' => 'ambient'],
            ['name' => 'Art Rock', 'slug' => 'art-rock'],
            ['name' => 'Baroque Pop', 'slug' => 'baroque-pop'],
            ['name' => 'Bebop', 'slug' => 'bebop'],
            ['name' => 'Big Band', 'slug' => 'big-band'],
            ['name' => 'Bluegrass', 'slug' => 'bluegrass'],
            ['name' => 'Blues', 'slug' => 'blues'],
            ['name' => 'Bossa Nova', 'slug' => 'bossa-nova'],
            ['name' => 'Britpop', 'slug' => 'britpop'],
            ['name' => 'Chillout', 'slug' => 'chillout'],
            ['name' => 'Chiptune', 'slug' => 'chiptune'],
            ['name' => 'Classical', 'slug' => 'classical'],
            ['name' => 'Contemporary R&B', 'slug' => 'contemporary-r-and-b'],
            ['name' => 'Country', 'slug' => 'country'],
            ['name' => 'Crust Punk', 'slug' => 'crust-punk'],
            ['name' => 'Dance', 'slug' => 'dance'],
            ['name' => 'Darkwave', 'slug' => 'darkwave'],
            ['name' => 'Death Metal', 'slug' => 'death-metal'],
            ['name' => 'Deep House', 'slug' => 'deep-house'],
            ['name' => 'Disco', 'slug' => 'disco'],
            ['name' => 'Dream Pop', 'slug' => 'dream-pop'],
            ['name' => 'Drum and Bass', 'slug' => 'drum-and-bass'],
            ['name' => 'Dub', 'slug' => 'dub'],
            ['name' => 'Electronic', 'slug' => 'electronic'],
            ['name' => 'Electro', 'slug' => 'electro'],
            ['name' => 'Emo', 'slug' => 'emo'],
            ['name' => 'Experimental', 'slug' => 'experimental'],
            ['name' => 'Folk', 'slug' => 'folk'],
            ['name' => 'Funk', 'slug' => 'funk'],
            ['name' => 'Garage Rock', 'slug' => 'garage-rock'],
            ['name' => 'Glam Rock', 'slug' => 'glam-rock'],
            ['name' => 'Gospel', 'slug' => 'gospel'],
            ['name' => 'Grunge', 'slug' => 'grunge'],
            ['name' => 'Hard Rock', 'slug' => 'hard-rock'],
            ['name' => 'Hardcore', 'slug' => 'hardcore'],
            ['name' => 'Heavy Metal', 'slug' => 'heavy-metal'],
            ['name' => 'Hip Hop', 'slug' => 'hip-hop'],
            ['name' => 'House', 'slug' => 'house'],
            ['name' => 'IDM', 'slug' => 'idm'],
            ['name' => 'Indie', 'slug' => 'indie'],
            ['name' => 'Industrial', 'slug' => 'industrial'],
            ['name' => 'Jazz', 'slug' => 'jazz'],
            ['name' => 'Jazz Fusion', 'slug' => 'jazz-fusion'],
            ['name' => 'Krautrock', 'slug' => 'krautrock'],
            ['name' => 'Latin', 'slug' => 'latin'],
            ['name' => 'Lo-Fi', 'slug' => 'lo-fi'],
            ['name' => 'Math Rock', 'slug' => 'math-rock'],
            ['name' => 'Metal', 'slug' => 'metal'],
            ['name' => 'Minimal', 'slug' => 'minimal'],
            ['name' => 'Neo Soul', 'slug' => 'neo-soul'],
            ['name' => 'New Wave', 'slug' => 'new-wave'],
            ['name' => 'Noise', 'slug' => 'noise'],
            ['name' => 'Opera', 'slug' => 'opera'],
            ['name' => 'Pop', 'slug' => 'pop'],
            ['name' => 'Post Punk', 'slug' => 'post-punk'],
            ['name' => 'Post Rock', 'slug' => 'post-rock'],
            ['name' => 'Power Metal', 'slug' => 'power-metal'],
            ['name' => 'Progressive Metal', 'slug' => 'progressive-metal'],
            ['name' => 'Progressive Rock', 'slug' => 'progressive-rock'],
            ['name' => 'Psychedelic', 'slug' => 'psychedelic'],
            ['name' => 'Psych Rock', 'slug' => 'psych-rock'],
            ['name' => 'Punk', 'slug' => 'punk'],
            ['name' => 'R&B', 'slug' => 'r-and-b'],
            ['name' => 'Reggae', 'slug' => 'reggae'],
            ['name' => 'Rock', 'slug' => 'rock'],
            ['name' => 'Rock and Roll', 'slug' => 'rock-and-roll'],
            ['name' => 'Shoegaze', 'slug' => 'shoegaze'],
            ['name' => 'Ska', 'slug' => 'ska'],
            ['name' => 'Sludge Metal', 'slug' => 'sludge-metal'],
            ['name' => 'Smooth Jazz', 'slug' => 'smooth-jazz'],
            ['name' => 'Soul', 'slug' => 'soul'],
            ['name' => 'Soundtrack', 'slug' => 'soundtrack'],
            ['name' => 'Space Rock', 'slug' => 'space-rock'],
            ['name' => 'Surf Rock', 'slug' => 'surf-rock'],
            ['name' => 'Swing', 'slug' => 'swing'],
            ['name' => 'Synth Pop', 'slug' => 'synth-pop'],
            ['name' => 'Synthwave', 'slug' => 'synthwave'],
            ['name' => 'Techno', 'slug' => 'techno'],
            ['name' => 'Trance', 'slug' => 'trance'],
            ['name' => 'Trip Hop', 'slug' => 'trip-hop'],
            ['name' => 'Vaporwave', 'slug' => 'vaporwave'],
            ['name' => 'World', 'slug' => 'world'],
        ];

        $existingRows = $this->fetchAll('SELECT slug FROM genres');
        $existingSlugs = [];
        foreach ($existingRows as $row) {
            $existingSlugs[(string)$row['slug']] = true;
        }

        $rowsToInsert = [];
        foreach ($genres as $genre) {
            if (!isset($existingSlugs[$genre['slug']])) {
                $rowsToInsert[] = [
                    'name' => $genre['name'],
                    'slug' => $genre['slug'],
                    'created' => $now,
                    'modified' => $now,
                ];
            }
        }

        if ($rowsToInsert !== []) {
            $this->table('genres')->insert($rowsToInsert)->save();
        }
    }
}
