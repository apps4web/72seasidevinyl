<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tracks Model
 *
 * @property \App\Model\Table\RecordsTable&\Cake\ORM\Association\BelongsTo $Records
 *
 * @method \App\Model\Entity\Track newEmptyEntity()
 * @method \App\Model\Entity\Track newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Track> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Track get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Track findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Track patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Track> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Track|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Track saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Track>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Track>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Track>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Track> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Track>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Track>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Track>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Track> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TracksTable extends Table
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

        $this->setTable('tracks');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Records', [
            'foreignKey' => 'record_id',
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
            ->scalar('position')
            ->maxLength('position', 50)
            ->allowEmptyString('position');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('duration')
            ->maxLength('duration', 20)
            ->allowEmptyString('duration');

        $validator
            ->scalar('video')
            ->maxLength('video', 255)
            ->allowEmptyString('video');

        $validator
            ->scalar('track_type')
            ->maxLength('track_type', 20)
            ->notEmptyString('track_type');

        $validator
            ->nonNegativeInteger('sort_order')
            ->notEmptyString('sort_order');

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
        $rules->add($rules->existsIn(['record_id'], 'Records'), ['errorField' => 'record_id']);

        return $rules;
    }
}
