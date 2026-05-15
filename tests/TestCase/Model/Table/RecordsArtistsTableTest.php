<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RecordsArtistsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RecordsArtistsTable Test Case
 */
class RecordsArtistsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RecordsArtistsTable
     */
    protected $RecordsArtists;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.RecordsArtists',
        'app.Records',
        'app.Companies',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RecordsArtists') ? [] : ['className' => RecordsArtistsTable::class];
        $this->RecordsArtists = $this->getTableLocator()->get('RecordsArtists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RecordsArtists);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\RecordsArtistsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\RecordsArtistsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
