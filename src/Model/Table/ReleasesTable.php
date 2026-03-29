<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Releases Model
 *
 * @method \App\Model\Entity\Release newEmptyEntity()
 * @method \App\Model\Entity\Release newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Release> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Release get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Release findOrCreate(mixed $search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Release patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Release> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Release|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Release saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReleasesTable extends Table
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

        $this->setTable('records');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Artists', [
            'foreignKey' => 'artist_id',
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
            ->notEmptyString('name');

        $validator
            ->integer('artist_id')
            ->requirePresence('artist_id', 'create')
            ->notEmptyString('artist_id');

        $validator
            ->decimal('price')
            ->allowEmptyString('price');

        $validator
            ->scalar('color')
            ->maxLength('color', 7)
            ->allowEmptyString('color');

        $validator
            ->scalar('label_text')
            ->maxLength('label_text', 20)
            ->allowEmptyString('label_text');

        $validator
            ->boolean('in_stock');

        $validator
            ->boolean('is_latest');

        return $validator;
    }
}
