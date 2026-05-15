<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Track Entity
 *
 * @property int $id
 * @property int $record_id
 * @property string|null $position
 * @property string $title
 * @property string|null $duration
 * @property string|null $video
 * @property string $track_type
 * @property int $sort_order
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Record $record
 */
class Track extends Entity
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
        'position' => true,
        'title' => true,
        'duration' => true,
        'video' => true,
        'track_type' => true,
        'sort_order' => true,
        'created' => true,
        'modified' => true,
        'record' => true,
    ];
}
