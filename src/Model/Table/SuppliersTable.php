<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Suppliers Model
 *
 * @property \App\Model\Table\RecordsTable&\Cake\ORM\Association\BelongsToMany $Records
 *
 * @method \App\Model\Entity\Supplier newEmptyEntity()
 * @method \App\Model\Entity\Supplier newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Supplier> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Supplier get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Supplier findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Supplier patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Supplier> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Supplier|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Supplier saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Supplier>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Supplier>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Supplier>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Supplier> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Supplier>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Supplier>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Supplier>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Supplier> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SuppliersTable extends Table
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

        $this->setTable('suppliers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Records', [
            'foreignKey' => 'supplier_id',
            'targetForeignKey' => 'record_id',
            'joinTable' => 'records_suppliers',
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
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('slug')
            ->maxLength('slug', 100)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['name']), ['errorField' => 'name']);
        $rules->add($rules->isUnique(['slug']), ['errorField' => 'slug']);

        return $rules;
    }
}
