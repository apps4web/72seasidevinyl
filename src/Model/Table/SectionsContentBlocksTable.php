<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SectionsContentBlocks Model
 *
 * @property \App\Model\Table\SectionsTable&\Cake\ORM\Association\BelongsTo $Sections
 * @property \App\Model\Table\ContentBlocksTable&\Cake\ORM\Association\BelongsTo $ContentBlocks
 *
 * @method \App\Model\Entity\SectionsContentBlock newEmptyEntity()
 * @method \App\Model\Entity\SectionsContentBlock newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\SectionsContentBlock> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SectionsContentBlock get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\SectionsContentBlock findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\SectionsContentBlock patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\SectionsContentBlock> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SectionsContentBlock|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\SectionsContentBlock saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\SectionsContentBlock>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SectionsContentBlock>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SectionsContentBlock>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SectionsContentBlock> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SectionsContentBlock>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SectionsContentBlock>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SectionsContentBlock>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SectionsContentBlock> deleteManyOrFail(iterable $entities, array $options = [])
 */
class SectionsContentBlocksTable extends Table
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

        $this->setTable('sections_content_blocks');
        $this->setDisplayField(['section_id', 'content_block_id']);
        $this->setPrimaryKey(['section_id', 'content_block_id']);

        $this->belongsTo('Sections', [
            'foreignKey' => 'section_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ContentBlocks', [
            'foreignKey' => 'content_block_id',
            'joinType' => 'INNER',
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
            ->nonNegativeInteger('sort_order')
            ->notEmptyString('sort_order');

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
        $rules->add($rules->existsIn(['section_id'], 'Sections'), ['errorField' => 'section_id']);
        $rules->add($rules->existsIn(['content_block_id'], 'ContentBlocks'), ['errorField' => 'content_block_id']);

        return $rules;
    }
}
