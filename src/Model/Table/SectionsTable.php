<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sections Model
 *
 * @property \App\Model\Table\PagesTable&\Cake\ORM\Association\BelongsTo $Pages
 * @property \App\Model\Table\ContentBlocksTable&\Cake\ORM\Association\BelongsToMany $ContentBlocks
 *
 * @method \App\Model\Entity\Section newEmptyEntity()
 * @method \App\Model\Entity\Section newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Section> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Section get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Section findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Section patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Section> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Section|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Section saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Section>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Section>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Section>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Section> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Section>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Section>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Section>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Section> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SectionsTable extends Table
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

        $this->setTable('sections');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Pages', [
            'foreignKey' => 'page_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('ContentBlocks', [
            'foreignKey' => 'section_id',
            'targetForeignKey' => 'content_block_id',
            'joinTable' => 'sections_content_blocks',
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
            ->nonNegativeInteger('page_id')
            ->notEmptyString('page_id');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

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
        $rules->add($rules->existsIn(['page_id'], 'Pages'), ['errorField' => 'page_id']);

        return $rules;
    }
}
