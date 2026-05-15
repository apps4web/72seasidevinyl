<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RecordSupplierImage Entity
 *
 * @property int $id
 * @property int $record_id
 * @property int|null $records_supplier_id
 * @property string $uri
 * @property string|null $resource_url
 * @property string|null $image_type
 * @property int|null $width
 * @property int|null $height
 * @property int $sort_order
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Record $record
 * @property \App\Model\Entity\RecordsSupplier $records_supplier
 */
class RecordSupplierImage extends Entity
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
        'records_supplier_id' => true,
        'uri' => true,
        'resource_url' => true,
        'image_type' => true,
        'width' => true,
        'height' => true,
        'sort_order' => true,
        'created' => true,
        'modified' => true,
        'record' => true,
        'records_supplier' => true,
    ];
}
