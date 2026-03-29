<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CakeSeedsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CakeSeedsTable Test Case
 */
class CakeSeedsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CakeSeedsTable
     */
    protected $CakeSeeds;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.CakeSeeds',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CakeSeeds') ? [] : ['className' => CakeSeedsTable::class];
        $this->CakeSeeds = $this->getTableLocator()->get('CakeSeeds', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CakeSeeds);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\CakeSeedsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
