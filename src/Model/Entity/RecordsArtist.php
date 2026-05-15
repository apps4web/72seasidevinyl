<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RecordsArtist Entity
 *
 * @property int $id
 * @property int $record_id
 * @property int $company_id
 * @property string $type
 * @property string|null $role
 * @property int|null $position
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Record $record
 * @property \App\Model\Entity\Company $company
 */
class RecordsArtist extends Entity
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
        'company_id' => true,
        'type' => true,
        'role' => true,
        'position' => true,
        'created' => true,
        'modified' => true,
        'record' => true,
        'company' => true,
    ];
}
