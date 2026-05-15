<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RecordSupplierImagesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RecordSupplierImagesTable Test Case
 */
class RecordSupplierImagesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RecordSupplierImagesTable
     */
    protected $RecordSupplierImages;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.RecordSupplierImages',
        'app.Records',
        'app.RecordsSuppliers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RecordSupplierImages') ? [] : ['className' => RecordSupplierImagesTable::class];
        $this->RecordSupplierImages = $this->getTableLocator()->get('RecordSupplierImages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RecordSupplierImages);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\RecordSupplierImagesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\RecordSupplierImagesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
