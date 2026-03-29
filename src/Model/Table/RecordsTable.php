<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Records Model
 *
 * @property \App\Model\Table\ArtistsTable&\Cake\ORM\Association\BelongsTo $Artists
 * @property \App\Model\Table\RecordImagesTable&\Cake\ORM\Association\HasMany $RecordImages
 * @property \App\Model\Table\GenresTable&\Cake\ORM\Association\BelongsToMany $Genres
 *
 * @method \App\Model\Entity\Record newEmptyEntity()
 * @method \App\Model\Entity\Record newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Record> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Record get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Record findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Record patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Record> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Record|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Record saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Record>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Record>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Record>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Record> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Record>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Record>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Record>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Record> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RecordsTable extends Table
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
            'joinType' => 'INNER',
        ]);
        $this->hasMany('RecordImages', [
            'foreignKey' => 'record_id',
        ]);
        $this->belongsToMany('Genres', [
            'foreignKey' => 'record_id',
            'targetForeignKey' => 'genre_id',
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
            ->nonNegativeInteger('artist_id')
            ->notEmptyString('artist_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('cover')
            ->maxLength('cover', 255)
            ->allowEmptyString('cover');

        $validator
            ->date('released')
            ->allowEmptyDate('released');

        $validator
            ->boolean('is_latest')
            ->notEmptyString('is_latest');

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
            ->boolean('in_stock')
            ->notEmptyString('in_stock');

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
        $rules->add($rules->existsIn(['artist_id'], 'Artists'), ['errorField' => 'artist_id']);

        return $rules;
    }
}
