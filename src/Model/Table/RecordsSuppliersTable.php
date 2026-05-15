<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RecordsSuppliers Model
 *
 * @property \App\Model\Table\RecordsTable&\Cake\ORM\Association\BelongsTo $Records
 * @property \App\Model\Table\SuppliersTable&\Cake\ORM\Association\BelongsTo $Suppliers
 * @property \App\Model\Table\RecordSupplierImagesTable&\Cake\ORM\Association\HasMany $RecordSupplierImages
 *
 * @method \App\Model\Entity\RecordsSupplier newEmptyEntity()
 * @method \App\Model\Entity\RecordsSupplier newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\RecordsSupplier> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RecordsSupplier get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\RecordsSupplier findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\RecordsSupplier patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\RecordsSupplier> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RecordsSupplier|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\RecordsSupplier saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\RecordsSupplier>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordsSupplier>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RecordsSupplier>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordsSupplier> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RecordsSupplier>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordsSupplier>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RecordsSupplier>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecordsSupplier> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RecordsSuppliersTable extends Table
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

        $this->setTable('records_suppliers');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Records', [
            'foreignKey' => 'record_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('RecordSupplierImages', [
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
            ->nonNegativeInteger('supplier_id')
            ->notEmptyString('supplier_id');

        $validator
            ->scalar('external_id')
            ->maxLength('external_id', 64)
            ->requirePresence('external_id', 'create')
            ->notEmptyString('external_id');

        $validator
            ->scalar('external_uri')
            ->maxLength('external_uri', 255)
            ->allowEmptyString('external_uri');

        $validator
            ->scalar('resource_url')
            ->maxLength('resource_url', 255)
            ->allowEmptyString('resource_url');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('country')
            ->maxLength('country', 120)
            ->allowEmptyString('country');

        $validator
            ->date('released')
            ->allowEmptyDate('released');

        $validator
            ->nonNegativeInteger('year')
            ->allowEmptyString('year');

        $validator
            ->scalar('formats')
            ->allowEmptyString('formats');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->scalar('payload')
            ->allowEmptyString('payload');

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
        $rules->add($rules->isUnique(['record_id', 'supplier_id']), ['errorField' => 'record_id', 'message' => __('This combination of record_id and supplier_id already exists')]);
        $rules->add($rules->existsIn(['record_id'], 'Records'), ['errorField' => 'record_id']);
        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'), ['errorField' => 'supplier_id']);

        return $rules;
    }
}
