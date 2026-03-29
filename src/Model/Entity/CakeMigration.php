<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CakeMigration Entity
 *
 * @property int $id
 * @property int $version
 * @property string|null $migration_name
 * @property string|null $plugin
 * @property \Cake\I18n\DateTime|null $start_time
 * @property \Cake\I18n\DateTime|null $end_time
 * @property bool $breakpoint
 */
class CakeMigration extends Entity
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
        'version' => true,
        'migration_name' => true,
        'plugin' => true,
        'start_time' => true,
        'end_time' => true,
        'breakpoint' => true,
    ];
}
