<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Artists Model
 *
 * @property \App\Model\Table\RecordsTable&\Cake\ORM\Association\HasMany $Records
 *
 * @method \App\Model\Entity\Artist newEmptyEntity()
 * @method \App\Model\Entity\Artist newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Artist> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Artist get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Artist findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Artist patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Artist> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Artist|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Artist saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Artist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Artist>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Artist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Artist> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Artist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Artist>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Artist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Artist> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ArtistsTable extends Table
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

        $this->setTable('artists');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Records', [
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
            ->scalar('bio')
            ->allowEmptyString('bio');

        return $validator;
    }
}
