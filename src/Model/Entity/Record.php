<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Record Entity
 *
 * @property int $id
 * @property int $artist_id
 * @property string $name
 * @property string|null $cover
 * @property \Cake\I18n\Date|null $released
 * @property bool $is_latest
 * @property string|null $price
 * @property string|null $color
 * @property string|null $label_text
 * @property bool $in_stock
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Artist $artist
 * @property \App\Model\Entity\RecordImage[] $record_images
 * @property \App\Model\Entity\Genre[] $genres
 */
class Record extends Entity
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
        'artist_id' => true,
        'name' => true,
        'cover' => true,
        'released' => true,
        'is_latest' => true,
        'price' => true,
        'color' => true,
        'label_text' => true,
        'in_stock' => true,
        'created' => true,
        'modified' => true,
        'artist' => true,
        'record_images' => true,
        'genres' => true,
    ];
}
