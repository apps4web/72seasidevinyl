<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RecordsSupplier Entity
 *
 * @property int $id
 * @property int $record_id
 * @property int $supplier_id
 * @property string $external_id
 * @property string|null $external_uri
 * @property string|null $resource_url
 * @property string|null $title
 * @property string|null $country
 * @property \Cake\I18n\Date|null $released
 * @property int|null $year
 * @property string|null $formats
 * @property string|null $notes
 * @property string|null $payload
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Record $record
 * @property \App\Model\Entity\Supplier $supplier
 * @property \App\Model\Entity\RecordSupplierImage[] $record_supplier_images
 */
class RecordsSupplier extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'record_id' => true,
        'supplier_id' => true,
        'external_id' => true,
        'external_uri' => true,
        'resource_url' => true,
        'title' => true,
        'country' => true,
        'released' => true,
        'year' => true,
        'formats' => true,
        'notes' => true,
        'payload' => true,
        'created' => true,
        'modified' => true,
        'record' => true,
        'supplier' => true,
        'record_supplier_images' => true,
    ];
}
