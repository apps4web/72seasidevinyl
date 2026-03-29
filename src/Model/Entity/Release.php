<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Release Entity
 *
 * @property int $id
 * @property string $title
 * @property string $artist
 * @property string $genre
 * @property float $price
 * @property string $color
 * @property string $label_text
 * @property bool $in_stock
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
        'title' => true,
        'artist' => true,
        'genre' => true,
        'price' => true,
        'color' => true,
        'label_text' => true,
        'in_stock' => true,
        'created' => true,
        'modified' => true,
    ];
}
