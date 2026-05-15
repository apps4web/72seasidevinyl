<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RecordSupplierImages Model
 *
 * @property \App\Model\Table\RecordsTable&\Cake\ORM\Association\BelongsTo $Records
 * @property \App\Model\Table\RecordsSuppliersTable&\Cake\ORM\Association\BelongsTo $RecordsSuppliers
 *
 * @method \App\Model\Entity\RecordSupplierImage newEmptyEntity()
 * @method \App\Model\Entity\RecordSupplierImage newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\RecordSupplierImage> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RecordSupplierImage get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\RecordSupplierImage findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\RecordSupplierImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\RecordSupplierImage> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RecordSupplierImage|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\RecordSupplierImage saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\RecordSupplierImage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordSupplierImage>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RecordSupplierImage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordSupplierImage> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RecordSupplierImage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordSupplierImage>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RecordSupplierImage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordSupplierImage> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RecordSupplierImagesTable extends Table
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

        $this->setTable('record_supplier_images');
        $this->setDisplayField('uri');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Records', [
            'foreignKey' => 'record_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('RecordsSuppliers', [
            'foreignKey' => 'records_supplier_id',
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
            ->nonNegativeInteger('records_supplier_id')
            ->allowEmptyString('records_supplier_id');

        $validator
            ->scalar('uri')
            ->maxLength('uri', 255)
            ->requirePresence('uri', 'create')
            ->notEmptyString('uri');

        $validator
            ->scalar('resource_url')
            ->maxLength('resource_url', 255)
            ->allowEmptyString('resource_url');

        $validator
            ->scalar('image_type')
            ->maxLength('image_type', 50)
            ->allowEmptyString('image_type');

        $validator
            ->nonNegativeInteger('width')
            ->allowEmptyString('width');

        $validator
            ->nonNegativeInteger('height')
            ->allowEmptyString('height');

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
        $rules->add($rules->existsIn(['records_supplier_id'], 'RecordsSuppliers'), ['errorField' => 'records_supplier_id']);

        return $rules;
    }
}
