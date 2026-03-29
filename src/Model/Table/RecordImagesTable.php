<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RecordImages Model
 *
 * @property \App\Model\Table\RecordsTable&\Cake\ORM\Association\BelongsTo $Records
 *
 * @method \App\Model\Entity\RecordImage newEmptyEntity()
 * @method \App\Model\Entity\RecordImage newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\RecordImage> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RecordImage get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\RecordImage findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\RecordImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\RecordImage> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RecordImage|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\RecordImage saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\RecordImage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordImage>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RecordImage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordImage> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RecordImage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordImage>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RecordImage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordImage> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RecordImagesTable extends Table
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

        $this->setTable('record_images');
        $this->setDisplayField('filename');
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
            ->scalar('filename')
            ->maxLength('filename', 255)
            ->requirePresence('filename', 'create')
            ->notEmptyString('filename');

        $validator
            ->scalar('alt')
            ->maxLength('alt', 255)
            ->allowEmptyString('alt');

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
