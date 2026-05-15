<?php
declare(strict_types=1);

use Migrations\BaseMigration;

/**
 * Persist Discogs supplier data in normalized tables.
 */
class AddDiscogsSupplierData extends BaseMigration
{
    /**
     * Disable automatic id column injection so each table declares its own PK.
     */
    public bool $autoId = false;

    public function up(): void
    {
        $this->table('records')
            ->addColumn('barcode', 'string', [
                'limit' => 64,
                'null' => true,
                'default' => null,
                'after' => 'name',
            ])
            ->addColumn('discogs_release_id', 'integer', [
                'limit' => 11,
                'null' => true,
                'default' => null,
                'signed' => false,
                'after' => 'barcode',
            ])
            ->addIndex(['barcode'], ['name' => 'idx_records_barcode'])
            ->addIndex(['discogs_release_id'], ['name' => 'idx_records_discogs_release_id'])
            ->update();

        $this->table('suppliers', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->addIndex(['name'], ['unique' => true, 'name' => 'uq_suppliers_name'])
            ->addIndex(['slug'], ['unique' => true, 'name' => 'uq_suppliers_slug'])
            ->create();

        $this->table('records_suppliers', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('record_id', 'integer', [
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('supplier_id', 'integer', [
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('external_id', 'string', [
                'limit' => 64,
                'null' => false,
                'comment' => 'Supplier release id, e.g. Discogs release id',
            ])
            ->addColumn('external_uri', 'string', [
                'limit' => 255,
                'null' => true,
                'default' => null,
            ])
            ->addColumn('resource_url', 'string', [
                'limit' => 255,
                'null' => true,
                'default' => null,
            ])
            ->addColumn('title', 'string', [
                'limit' => 255,
                'null' => true,
                'default' => null,
            ])
            ->addColumn('country', 'string', [
                'limit' => 120,
                'null' => true,
                'default' => null,
            ])
            ->addColumn('released', 'date', [
                'null' => true,
                'default' => null,
            ])
            ->addColumn('year', 'integer', [
                'limit' => 4,
                'null' => true,
                'default' => null,
                'signed' => false,
            ])
            ->addColumn('formats', 'text', [
                'null' => true,
                'default' => null,
                'comment' => 'JSON encoded format entries from supplier payload',
            ])
            ->addColumn('notes', 'text', [
                'null' => true,
                'default' => null,
            ])
            ->addColumn('payload', 'text', [
                'null' => true,
                'default' => null,
                'comment' => 'JSON payload excluding ignored fields',
            ])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->addIndex(['record_id'], ['name' => 'idx_records_suppliers_record_id'])
            ->addIndex(['supplier_id'], ['name' => 'idx_records_suppliers_supplier_id'])
            ->addIndex(['supplier_id', 'external_id'], ['name' => 'idx_records_suppliers_supplier_external'])
            ->addIndex(['record_id', 'supplier_id'], ['unique' => true, 'name' => 'uq_records_suppliers_record_supplier'])
            ->addForeignKey('record_id', 'records', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('supplier_id', 'suppliers', 'id', [
                'delete' => 'RESTRICT',
                'update' => 'CASCADE',
            ])
            ->create();

        $this->table('companies', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('discogs_id', 'integer', [
                'limit' => 11,
                'null' => true,
                'default' => null,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->addIndex(['name'], ['unique' => true, 'name' => 'uq_companies_name'])
            ->addIndex(['slug'], ['unique' => true, 'name' => 'uq_companies_slug'])
            ->addIndex(['discogs_id'], ['unique' => true, 'name' => 'uq_companies_discogs_id'])
            ->create();

        $this->table('records_artist', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('record_id', 'integer', [
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('company_id', 'integer', [
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('type', 'string', [
                'limit' => 50,
                'null' => false,
                'comment' => 'artist | label | company',
            ])
            ->addColumn('role', 'string', [
                'limit' => 120,
                'null' => true,
                'default' => null,
            ])
            ->addColumn('position', 'integer', [
                'limit' => 6,
                'null' => true,
                'default' => null,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->addIndex(['record_id'], ['name' => 'idx_records_artist_record_id'])
            ->addIndex(['company_id'], ['name' => 'idx_records_artist_company_id'])
            ->addIndex(['record_id', 'company_id', 'type'], ['unique' => true, 'name' => 'uq_records_artist_record_company_type'])
            ->addForeignKey('record_id', 'records', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('company_id', 'companies', 'id', [
                'delete' => 'RESTRICT',
                'update' => 'CASCADE',
            ])
            ->create();

        $this->table('tracks', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('record_id', 'integer', [
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('position', 'string', [
                'limit' => 50,
                'null' => true,
                'default' => null,
            ])
            ->addColumn('title', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('duration', 'string', [
                'limit' => 20,
                'null' => true,
                'default' => null,
            ])
            ->addColumn('video', 'string', [
                'limit' => 255,
                'null' => true,
                'default' => null,
            ])
            ->addColumn('track_type', 'string', [
                'limit' => 20,
                'null' => false,
                'default' => 'track',
            ])
            ->addColumn('sort_order', 'integer', [
                'limit' => 6,
                'null' => false,
                'default' => 0,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->addIndex(['record_id'], ['name' => 'idx_tracks_record_id'])
            ->addForeignKey('record_id', 'records', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->create();

        $this->table('record_videos', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('record_id', 'integer', [
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('uri', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('embed', 'boolean', [
                'null' => false,
                'default' => false,
            ])
            ->addColumn('title', 'string', [
                'limit' => 255,
                'null' => true,
                'default' => null,
            ])
            ->addColumn('description', 'text', [
                'null' => true,
                'default' => null,
            ])
            ->addColumn('duration', 'integer', [
                'limit' => 11,
                'null' => true,
                'default' => null,
                'signed' => false,
            ])
            ->addColumn('sort_order', 'integer', [
                'limit' => 6,
                'null' => false,
                'default' => 0,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->addIndex(['record_id'], ['name' => 'idx_record_videos_record_id'])
            ->addIndex(['record_id', 'uri'], ['unique' => true, 'name' => 'uq_record_videos_record_uri'])
            ->addForeignKey('record_id', 'records', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->create();

        $this->table('record_supplier_images', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('record_id', 'integer', [
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('records_supplier_id', 'integer', [
                'limit' => 11,
                'null' => true,
                'default' => null,
                'signed' => false,
            ])
            ->addColumn('uri', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('resource_url', 'string', [
                'limit' => 255,
                'null' => true,
                'default' => null,
            ])
            ->addColumn('image_type', 'string', [
                'limit' => 50,
                'null' => true,
                'default' => null,
            ])
            ->addColumn('width', 'integer', [
                'limit' => 11,
                'null' => true,
                'default' => null,
                'signed' => false,
            ])
            ->addColumn('height', 'integer', [
                'limit' => 11,
                'null' => true,
                'default' => null,
                'signed' => false,
            ])
            ->addColumn('sort_order', 'integer', [
                'limit' => 6,
                'null' => false,
                'default' => 0,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('modified', 'datetime', ['null' => true, 'default' => null])
            ->addIndex(['record_id'], ['name' => 'idx_record_supplier_images_record_id'])
            ->addIndex(['records_supplier_id'], ['name' => 'idx_record_supplier_images_records_supplier_id'])
            ->addIndex(['record_id', 'uri'], ['unique' => true, 'name' => 'uq_record_supplier_images_record_uri'])
            ->addForeignKey('record_id', 'records', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('records_supplier_id', 'records_suppliers', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'CASCADE',
            ])
            ->create();
    }

    public function down(): void
    {
        $this->table('record_supplier_images')->drop()->save();
        $this->table('record_videos')->drop()->save();
        $this->table('tracks')->drop()->save();
        $this->table('records_artist')->drop()->save();
        $this->table('companies')->drop()->save();
        $this->table('records_suppliers')->drop()->save();
        $this->table('suppliers')->drop()->save();

        $this->table('records')
            ->removeIndex(['barcode'])
            ->removeIndex(['discogs_release_id'])
            ->removeColumn('barcode')
            ->removeColumn('discogs_release_id')
            ->update();
    }
}
