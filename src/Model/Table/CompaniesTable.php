<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Companies Model
 *
 * @property \App\Model\Table\RecordsArtistsTable&\Cake\ORM\Association\HasMany $RecordsArtist
 *
 * @method \App\Model\Entity\Company newEmptyEntity()
 * @method \App\Model\Entity\Company newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Company> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Company get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Company findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Company patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Company> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Company|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Company saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Company>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Company>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Company>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Company> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Company>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Company>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Company>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Company> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CompaniesTable extends Table
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

        $this->setTable('companies');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('RecordsArtists', [
            'foreignKey' => 'company_id',
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
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->nonNegativeInteger('discogs_id')
            ->allowEmptyString('discogs_id')
            ->add('discogs_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['discogs_id'], ['allowMultipleNulls' => true]), ['errorField' => 'discogs_id']);

        return $rules;
    }
}
