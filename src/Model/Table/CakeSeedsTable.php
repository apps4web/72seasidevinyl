<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CakeSeeds Model
 *
 * @method \App\Model\Entity\CakeSeed newEmptyEntity()
 * @method \App\Model\Entity\CakeSeed newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CakeSeed> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CakeSeed get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CakeSeed findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CakeSeed patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CakeSeed> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CakeSeed|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CakeSeed saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CakeSeed>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CakeSeed>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CakeSeed>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CakeSeed> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CakeSeed>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CakeSeed>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CakeSeed>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CakeSeed> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CakeSeedsTable extends Table
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

        $this->setTable('cake_seeds');
        $this->setDisplayField('seed_name');
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
            ->scalar('plugin')
            ->maxLength('plugin', 100)
            ->allowEmptyString('plugin');

        $validator
            ->scalar('seed_name')
            ->maxLength('seed_name', 100)
            ->requirePresence('seed_name', 'create')
            ->notEmptyString('seed_name');

        $validator
            ->dateTime('executed_at')
            ->allowEmptyDateTime('executed_at');

        return $validator;
    }
}
