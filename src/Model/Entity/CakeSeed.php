<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CakeSeed Entity
 *
 * @property int $id
 * @property string|null $plugin
 * @property string $seed_name
 * @property \Cake\I18n\DateTime|null $executed_at
 */
class CakeSeed extends Entity
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
        'plugin' => true,
        'seed_name' => true,
        'executed_at' => true,
    ];
}
