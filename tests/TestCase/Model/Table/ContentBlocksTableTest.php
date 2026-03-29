<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContentBlocksTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContentBlocksTable Test Case
 */
class ContentBlocksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ContentBlocksTable
     */
    protected $ContentBlocks;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ContentBlocks',
        'app.Sections',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ContentBlocks') ? [] : ['className' => ContentBlocksTable::class];
        $this->ContentBlocks = $this->getTableLocator()->get('ContentBlocks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ContentBlocks);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ContentBlocksTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ContentBlocksTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
