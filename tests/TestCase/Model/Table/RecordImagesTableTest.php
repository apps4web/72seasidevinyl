<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RecordImagesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RecordImagesTable Test Case
 */
class RecordImagesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RecordImagesTable
     */
    protected $RecordImages;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.RecordImages',
        'app.Records',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RecordImages') ? [] : ['className' => RecordImagesTable::class];
        $this->RecordImages = $this->getTableLocator()->get('RecordImages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RecordImages);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\RecordImagesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\RecordImagesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
