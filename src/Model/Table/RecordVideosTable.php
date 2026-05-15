<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RecordVideos Model
 *
 * @property \App\Model\Table\RecordsTable&\Cake\ORM\Association\BelongsTo $Records
 *
 * @method \App\Model\Entity\RecordVideo newEmptyEntity()
 * @method \App\Model\Entity\RecordVideo newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\RecordVideo> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RecordVideo get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\RecordVideo findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\RecordVideo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\RecordVideo> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RecordVideo|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\RecordVideo saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\RecordVideo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordVideo>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RecordVideo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordVideo> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RecordVideo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordVideo>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RecordVideo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordVideo> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RecordVideosTable extends Table
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

        $this->setTable('record_videos');
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
            ->scalar('uri')
            ->maxLength('uri', 255)
            ->requirePresence('uri', 'create')
            ->notEmptyString('uri');

        $validator
            ->boolean('embed')
            ->notEmptyString('embed');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->nonNegativeInteger('duration')
            ->allowEmptyString('duration');

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
        $rules->add($rules->isUnique(['record_id', 'uri']), ['errorField' => 'record_id', 'message' => __('This combination of record_id and uri already exists')]);
        $rules->add($rules->existsIn(['record_id'], 'Records'), ['errorField' => 'record_id']);

        return $rules;
    }
}
