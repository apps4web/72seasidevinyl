<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SectionsContentBlock Entity
 *
 * @property int $section_id
 * @property int $content_block_id
 * @property int $sort_order
 *
 * @property \App\Model\Entity\Section $section
 * @property \App\Model\Entity\ContentBlock $content_block
 */
class SectionsContentBlock extends Entity
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
        'sort_order' => true,
        'section' => true,
        'content_block' => true,
    ];
}
