<?php
declare(strict_types=1);

use Migrations\BaseMigration;

/**
 * Initial schema migration for 72 Seaside Vinyl.
 *
 * Creates the following tables:
 *  - users           : CakePHP default users table for CMS login
 *  - artists         : music artists / bands
 *  - genres          : music genres
 *  - records         : vinyl records (belongs to one artist, many genres, many images)
 *  - record_images   : additional images for a record
 *  - genres_records  : join table – records <-> genres (many-to-many)
 *  - pages           : CMS pages
 *  - sections        : ordered sections within a page
 *  - content_blocks  : reusable content blocks
 *  - sections_content_blocks : join table – sections <-> content_blocks (many-to-many)
 */
class InitialSchema extends BaseMigration
{
    /**
     * Disable automatic `id` column injection so each table definition
     * can declare its own primary key explicitly.
     */
    public bool $autoId = false;

    public function up(): void
    {
        // -----------------------------------------------------------------
        // users
        // -----------------------------------------------------------------
        $this->table('users', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit'         => 11,
                'null'          => false,
                'signed'        => false,
            ])
            ->addColumn('username', 'string', [
                'limit' => 255,
                'null'  => false,
            ])
            ->addColumn('password', 'string', [
                'limit' => 255,
                'null'  => false,
            ])
            ->addColumn('email', 'string', [
                'limit' => 255,
                'null'  => false,
            ])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->addIndex(['username'], ['unique' => true, 'name' => 'uq_users_username'])
            ->addIndex(['email'], ['unique' => true, 'name' => 'uq_users_email'])
            ->create();

        // -----------------------------------------------------------------
        // artists
        // -----------------------------------------------------------------
        $this->table('artists', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit'         => 11,
                'null'          => false,
                'signed'        => false,
            ])
            ->addColumn('name', 'string', [
                'limit' => 255,
                'null'  => false,
            ])
            ->addColumn('bio', 'text', ['null' => true, 'default' => null])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->create();

        // -----------------------------------------------------------------
        // genres
        // -----------------------------------------------------------------
        $this->table('genres', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit'         => 11,
                'null'          => false,
                'signed'        => false,
            ])
            ->addColumn('name', 'string', [
                'limit' => 100,
                'null'  => false,
            ])
            ->addColumn('slug', 'string', [
                'limit' => 100,
                'null'  => false,
            ])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->addIndex(['slug'], ['unique' => true, 'name' => 'uq_genres_slug'])
            ->create();

        // -----------------------------------------------------------------
        // records
        // -----------------------------------------------------------------
        $this->table('records', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit'         => 11,
                'null'          => false,
                'signed'        => false,
            ])
            ->addColumn('artist_id', 'integer', [
                'limit'  => 11,
                'null'   => false,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'limit' => 255,
                'null'  => false,
            ])
            ->addColumn('cover', 'string', [
                'comment' => 'Filename / path of the primary cover image',
                'limit'   => 255,
                'null'    => true,
                'default' => null,
            ])
            ->addColumn('released', 'date', ['null' => true, 'default' => null])
            ->addColumn('is_latest', 'boolean', [
                'null'    => false,
                'default' => false,
            ])
            ->addColumn('price', 'decimal', [
                'precision' => 8,
                'scale'     => 2,
                'null'      => true,
                'default'   => null,
            ])
            ->addColumn('color', 'string', [
                'limit'   => 7,
                'null'    => true,
                'default' => '#000000',
            ])
            ->addColumn('label_text', 'string', [
                'limit'   => 20,
                'null'    => true,
                'default' => 'LP',
            ])
            ->addColumn('in_stock', 'boolean', [
                'null'    => false,
                'default' => true,
            ])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->addIndex(['artist_id'], ['name' => 'idx_records_artist_id'])
            ->addForeignKey('artist_id', 'artists', 'id', [
                'delete' => 'RESTRICT',
                'update' => 'CASCADE',
            ])
            ->create();

        // -----------------------------------------------------------------
        // record_images  (multiple images per record)
        // -----------------------------------------------------------------
        $this->table('record_images', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit'         => 11,
                'null'          => false,
                'signed'        => false,
            ])
            ->addColumn('record_id', 'integer', [
                'limit'  => 11,
                'null'   => false,
                'signed' => false,
            ])
            ->addColumn('filename', 'string', [
                'limit' => 255,
                'null'  => false,
            ])
            ->addColumn('alt', 'string', [
                'comment' => 'Alt text for accessibility',
                'limit'   => 255,
                'null'    => true,
                'default' => null,
            ])
            ->addColumn('sort_order', 'integer', [
                'limit'   => 6,
                'null'    => false,
                'default' => 0,
                'signed'  => false,
            ])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->addIndex(['record_id'], ['name' => 'idx_record_images_record_id'])
            ->addForeignKey('record_id', 'records', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->create();

        // -----------------------------------------------------------------
        // genres_records  (records <-> genres, many-to-many)
        // CakePHP join table convention: alphabetical order of table names
        // -----------------------------------------------------------------
        $this->table('genres_records', ['id' => false, 'primary_key' => ['genre_id', 'record_id']])
            ->addColumn('genre_id', 'integer', [
                'limit'  => 11,
                'null'   => false,
                'signed' => false,
            ])
            ->addColumn('record_id', 'integer', [
                'limit'  => 11,
                'null'   => false,
                'signed' => false,
            ])
            ->addIndex(['genre_id'], ['name' => 'idx_genres_records_genre_id'])
            ->addIndex(['record_id'], ['name' => 'idx_genres_records_record_id'])
            ->addForeignKey('genre_id', 'genres', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('record_id', 'records', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->create();

        // -----------------------------------------------------------------
        // pages
        // -----------------------------------------------------------------
        $this->table('pages', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit'         => 11,
                'null'          => false,
                'signed'        => false,
            ])
            ->addColumn('title', 'string', [
                'limit' => 255,
                'null'  => false,
            ])
            ->addColumn('slug', 'string', [
                'limit' => 255,
                'null'  => false,
            ])
            ->addColumn('status', 'string', [
                'comment' => 'draft | published',
                'limit'   => 20,
                'null'    => false,
                'default' => 'draft',
            ])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->addIndex(['slug'], ['unique' => true, 'name' => 'uq_pages_slug'])
            ->create();

        // -----------------------------------------------------------------
        // sections  (ordered sections within a page)
        // -----------------------------------------------------------------
        $this->table('sections', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit'         => 11,
                'null'          => false,
                'signed'        => false,
            ])
            ->addColumn('page_id', 'integer', [
                'limit'  => 11,
                'null'   => false,
                'signed' => false,
            ])
            ->addColumn('title', 'string', [
                'limit'   => 255,
                'null'    => true,
                'default' => null,
            ])
            ->addColumn('sort_order', 'integer', [
                'limit'   => 6,
                'null'    => false,
                'default' => 0,
                'signed'  => false,
            ])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->addIndex(['page_id'], ['name' => 'idx_sections_page_id'])
            ->addForeignKey('page_id', 'pages', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->create();

        // -----------------------------------------------------------------
        // content_blocks  (reusable content blocks)
        // -----------------------------------------------------------------
        $this->table('content_blocks', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit'         => 11,
                'null'          => false,
                'signed'        => false,
            ])
            ->addColumn('identifier', 'string', [
                'comment' => 'Unique machine-readable key used to reuse this block',
                'limit'   => 255,
                'null'    => false,
            ])
            ->addColumn('title', 'string', [
                'limit'   => 255,
                'null'    => true,
                'default' => null,
            ])
            ->addColumn('content', 'text', ['null' => true, 'default' => null])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->addIndex(['identifier'], ['unique' => true, 'name' => 'uq_content_blocks_identifier'])
            ->create();

        // -----------------------------------------------------------------
        // sections_content_blocks  (sections <-> content_blocks, many-to-many)
        // -----------------------------------------------------------------
        $this->table('sections_content_blocks', ['id' => false, 'primary_key' => ['section_id', 'content_block_id']])
            ->addColumn('section_id', 'integer', [
                'limit'  => 11,
                'null'   => false,
                'signed' => false,
            ])
            ->addColumn('content_block_id', 'integer', [
                'limit'  => 11,
                'null'   => false,
                'signed' => false,
            ])
            ->addColumn('sort_order', 'integer', [
                'limit'   => 6,
                'null'    => false,
                'default' => 0,
                'signed'  => false,
            ])
            ->addIndex(['section_id'], ['name' => 'idx_scb_section_id'])
            ->addIndex(['content_block_id'], ['name' => 'idx_scb_content_block_id'])
            ->addForeignKey('section_id', 'sections', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('content_block_id', 'content_blocks', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->create();
    }

    public function down(): void
    {
        // Drop in reverse dependency order
        $this->table('sections_content_blocks')->drop()->save();
        $this->table('content_blocks')->drop()->save();
        $this->table('sections')->drop()->save();
        $this->table('pages')->drop()->save();
        $this->table('genres_records')->drop()->save();
        $this->table('record_images')->drop()->save();
        $this->table('records')->drop()->save();
        $this->table('genres')->drop()->save();
        $this->table('artists')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
