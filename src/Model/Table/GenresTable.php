<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Genres Model
 *
 * @property \App\Model\Table\RecordsTable&\Cake\ORM\Association\BelongsToMany $Records
 *
 * @method \App\Model\Entity\Genre newEmptyEntity()
 * @method \App\Model\Entity\Genre newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Genre> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Genre get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Genre findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Genre patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Genre> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Genre|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Genre saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Genre>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Genre>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Genre>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Genre> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Genre>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Genre>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Genre>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Genre> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GenresTable extends Table
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

        $this->setTable('genres');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Records', [
            'foreignKey' => 'genre_id',
            'targetForeignKey' => 'record_id',
            'joinTable' => 'genres_records',
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
            ->notEmptyString('name');

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
        $rules->add($rules->isUnique(['slug']), ['errorField' => 'slug']);

        return $rules;
    }
}
