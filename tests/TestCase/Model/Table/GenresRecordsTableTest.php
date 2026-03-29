<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GenresRecordsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GenresRecordsTable Test Case
 */
class GenresRecordsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GenresRecordsTable
     */
    protected $GenresRecords;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.GenresRecords',
        'app.Genres',
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
        $config = $this->getTableLocator()->exists('GenresRecords') ? [] : ['className' => GenresRecordsTable::class];
        $this->GenresRecords = $this->getTableLocator()->get('GenresRecords', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->GenresRecords);

        parent::tearDown();
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\GenresRecordsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
