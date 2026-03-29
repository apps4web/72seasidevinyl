<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Release Entity (maps to the `records` table).
 *
 * @property int $id
 * @property int $artist_id
 * @property string $name
 * @property string|null $cover
 * @property \Cake\I18n\Date|null $released
 * @property bool $is_latest
 * @property float|null $price
 * @property string|null $color
 * @property string|null $label_text
 * @property bool $in_stock
 * @property \App\Model\Entity\Artist|null $artist
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 */
class Release extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'artist_id'  => true,
        'name'       => true,
        'cover'      => true,
        'released'   => true,
        'is_latest'  => true,
        'price'      => true,
        'color'      => true,
        'label_text' => true,
        'in_stock'   => true,
        'created'    => true,
        'modified'   => true,
    ];
}
