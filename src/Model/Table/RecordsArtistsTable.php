<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RecordsArtists Model
 *
 * @property \App\Model\Table\RecordsTable&\Cake\ORM\Association\BelongsTo $Records
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 *
 * @method \App\Model\Entity\RecordsArtist newEmptyEntity()
 * @method \App\Model\Entity\RecordsArtist newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\RecordsArtist> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RecordsArtist get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\RecordsArtist findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\RecordsArtist patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\RecordsArtist> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RecordsArtist|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\RecordsArtist saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\RecordsArtist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordsArtist>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RecordsArtist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordsArtist> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RecordsArtist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordsArtist>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RecordsArtist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordsArtist> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RecordsArtistsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('records_artists');
        $this->setDisplayField('type');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Records', [
            'foreignKey' => 'record_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('record_id')
            ->notEmptyString('record_id');

        $validator
            ->nonNegativeInteger('company_id')
            ->notEmptyString('company_id');

        $validator
            ->scalar('type')
            ->maxLength('type', 50)
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->scalar('role')
            ->maxLength('role', 120)
            ->allowEmptyString('role');

        $validator
            ->nonNegativeInteger('position')
            ->allowEmptyString('position');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['record_id', 'company_id', 'type']), ['errorField' => 'record_id', 'message' => __('This combination of record_id, company_id and type already exists')]);
        $rules->add($rules->existsIn(['record_id'], 'Records'), ['errorField' => 'record_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);

        return $rules;
    }
}
