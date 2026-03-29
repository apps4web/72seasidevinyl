<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CakeMigrations Model
 *
 * @method \App\Model\Entity\CakeMigration newEmptyEntity()
 * @method \App\Model\Entity\CakeMigration newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CakeMigration> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CakeMigration get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CakeMigration findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CakeMigration patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CakeMigration> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CakeMigration|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CakeMigration saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CakeMigration>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CakeMigration>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CakeMigration>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CakeMigration> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CakeMigration>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CakeMigration>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CakeMigration>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CakeMigration> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CakeMigrationsTable extends Table
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

        $this->setTable('cake_migrations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->requirePresence('version', 'create')
            ->notEmptyString('version');

        $validator
            ->scalar('migration_name')
            ->maxLength('migration_name', 100)
            ->allowEmptyString('migration_name');

        $validator
            ->scalar('plugin')
            ->maxLength('plugin', 100)
            ->allowEmptyString('plugin');

        $validator
            ->dateTime('start_time')
            ->allowEmptyDateTime('start_time');

        $validator
            ->dateTime('end_time')
            ->allowEmptyDateTime('end_time');

        $validator
            ->boolean('breakpoint')
            ->notEmptyString('breakpoint');

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
        $rules->add($rules->isUnique(['version', 'plugin'], ['allowMultipleNulls' => true]), ['errorField' => 'version', 'message' => __('This combination of version and plugin already exists')]);

        return $rules;
    }
}
