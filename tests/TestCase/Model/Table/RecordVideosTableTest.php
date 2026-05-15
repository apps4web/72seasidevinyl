<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RecordVideosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RecordVideosTable Test Case
 */
class RecordVideosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RecordVideosTable
     */
    protected $RecordVideos;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.RecordVideos',
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
        $config = $this->getTableLocator()->exists('RecordVideos') ? [] : ['className' => RecordVideosTable::class];
        $this->RecordVideos = $this->getTableLocator()->get('RecordVideos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RecordVideos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\RecordVideosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\RecordVideosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
