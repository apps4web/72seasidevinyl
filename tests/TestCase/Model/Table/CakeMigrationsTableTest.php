<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CakeMigrationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CakeMigrationsTable Test Case
 */
class CakeMigrationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CakeMigrationsTable
     */
    protected $CakeMigrations;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.CakeMigrations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CakeMigrations') ? [] : ['className' => CakeMigrationsTable::class];
        $this->CakeMigrations = $this->getTableLocator()->get('CakeMigrations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CakeMigrations);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\CakeMigrationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\CakeMigrationsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
