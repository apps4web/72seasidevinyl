<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RecordsSuppliersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RecordsSuppliersTable Test Case
 */
class RecordsSuppliersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RecordsSuppliersTable
     */
    protected $RecordsSuppliers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.RecordsSuppliers',
        'app.Records',
        'app.Suppliers',
        'app.RecordSupplierImages',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RecordsSuppliers') ? [] : ['className' => RecordsSuppliersTable::class];
        $this->RecordsSuppliers = $this->getTableLocator()->get('RecordsSuppliers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RecordsSuppliers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\RecordsSuppliersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\RecordsSuppliersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
