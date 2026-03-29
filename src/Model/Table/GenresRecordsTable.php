<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GenresRecords Model
 *
 * @property \App\Model\Table\GenresTable&\Cake\ORM\Association\BelongsTo $Genres
 * @property \App\Model\Table\RecordsTable&\Cake\ORM\Association\BelongsTo $Records
 *
 * @method \App\Model\Entity\GenresRecord newEmptyEntity()
 * @method \App\Model\Entity\GenresRecord newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\GenresRecord> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GenresRecord get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\GenresRecord findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\GenresRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\GenresRecord> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\GenresRecord|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\GenresRecord saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\GenresRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GenresRecord>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\GenresRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GenresRecord> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\GenresRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GenresRecord>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\GenresRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\GenresRecord> deleteManyOrFail(iterable $entities, array $options = [])
 */
class GenresRecordsTable extends Table
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

        $this->setTable('genres_records');
        $this->setDisplayField(['genre_id', 'record_id']);
        $this->setPrimaryKey(['genre_id', 'record_id']);

        $this->belongsTo('Genres', [
            'foreignKey' => 'genre_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Records', [
            'foreignKey' => 'record_id',
            'joinType' => 'INNER',
        ]);
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
        $rules->add($rules->existsIn(['genre_id'], 'Genres'), ['errorField' => 'genre_id']);
        $rules->add($rules->existsIn(['record_id'], 'Records'), ['errorField' => 'record_id']);

        return $rules;
    }
}
