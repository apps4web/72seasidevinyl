<?php
declare(strict_types=1);

use Migrations\BaseMigration;

/**
 * Rename record_tracks to tracks and ensure video column exists.
 */
class RenameRecordTracksToTracks extends BaseMigration
{
    public function up(): void
    {
        if ($this->hasTable('record_tracks') && !$this->hasTable('tracks')) {
            $this->table('record_tracks')->rename('tracks')->save();
        }

        $columns = $this->fetchAll('SHOW COLUMNS FROM `tracks` LIKE \'video\'');
        if (empty($columns)) {
            $this->table('tracks')
                ->addColumn('video', 'string', [
                    'limit' => 255,
                    'null' => true,
                    'default' => null,
                    'after' => 'duration',
                ])
                ->update();
        }
    }

    public function down(): void
    {
        $columns = $this->fetchAll('SHOW COLUMNS FROM `tracks` LIKE \'video\'');
        if (!empty($columns)) {
            $this->table('tracks')
                ->removeColumn('video')
                ->update();
        }

        if ($this->hasTable('tracks') && !$this->hasTable('record_tracks')) {
            $this->table('tracks')->rename('record_tracks')->save();
        }
    }
}
