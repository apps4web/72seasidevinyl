<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\DashboardController Test Case
 */
class DashboardControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Releases',
    ];

    /**
     * Test that the admin dashboard renders correctly.
     *
     * @return void
     */
    public function testIndex(): void
    {
        Configure::write('debug', true);
        $this->get('/admin');
        $this->assertResponseOk();
        $this->assertResponseContains('Dashboard');
        $this->assertResponseContains('72 Seaside Vinyl');
    }

    /**
     * Test that dashboard shows release statistics.
     *
     * @return void
     */
    public function testIndexShowsStats(): void
    {
        Configure::write('debug', true);
        $this->get('/admin');
        $this->assertResponseOk();
        $this->assertResponseContains('Total Releases');
        $this->assertResponseContains('In Stock');
        $this->assertResponseContains('Out of Stock');
    }

    /**
     * Test that dashboard shows recent releases.
     *
     * @return void
     */
    public function testIndexShowsRecentReleases(): void
    {
        Configure::write('debug', true);
        $this->get('/admin');
        $this->assertResponseOk();
        $this->assertResponseContains('Recent Releases');
    }
}
