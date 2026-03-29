<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SectionsContentBlocksTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SectionsContentBlocksTable Test Case
 */
class SectionsContentBlocksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SectionsContentBlocksTable
     */
    protected $SectionsContentBlocks;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.SectionsContentBlocks',
        'app.Sections',
        'app.ContentBlocks',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SectionsContentBlocks') ? [] : ['className' => SectionsContentBlocksTable::class];
        $this->SectionsContentBlocks = $this->getTableLocator()->get('SectionsContentBlocks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SectionsContentBlocks);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\SectionsContentBlocksTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\SectionsContentBlocksTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
