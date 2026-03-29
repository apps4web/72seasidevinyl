<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\ReleasesController Test Case
 */
class ReleasesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Artists',
        'app.Releases',
    ];

    /**
     * Test index returns a successful response.
     *
     * @return void
     */
    public function testIndex(): void
    {
        Configure::write('debug', true);
        $this->get('/admin/releases');
        $this->assertResponseOk();
        $this->assertResponseContains('Vinyl Releases');
    }

    /**
     * Test that the index lists existing releases.
     *
     * @return void
     */
    public function testIndexListsReleases(): void
    {
        Configure::write('debug', true);
        $this->get('/admin/releases');
        $this->assertResponseOk();
        $this->assertResponseContains('Radical Optimism');
        $this->assertResponseContains('Dua Lipa');
        $this->assertResponseContains('Cowboy Carter');
    }

    /**
     * Test add form renders correctly.
     *
     * @return void
     */
    public function testAdd(): void
    {
        Configure::write('debug', true);
        $this->get('/admin/releases/add');
        $this->assertResponseOk();
        $this->assertResponseContains('Add New Release');
    }

    /**
     * Test that a new release can be added via POST.
     *
     * @return void
     */
    public function testAddPost(): void
    {
        Configure::write('debug', true);
        $this->enableCsrfToken();
        $data = [
            'name'       => 'Test Album',
            'artist_id'  => 1,
            'price'      => 19.99,
            'color'      => '#FF0000',
            'label_text' => 'LP',
            'in_stock'   => true,
        ];
        $this->post('/admin/releases/add', $data);
        $this->assertResponseCode(302);
        $this->assertRedirect(['prefix' => 'Admin', 'controller' => 'Releases', 'action' => 'index']);
    }

    /**
     * Test add with missing required fields shows validation errors.
     *
     * @return void
     */
    public function testAddValidationError(): void
    {
        Configure::write('debug', true);
        $this->enableCsrfToken();
        $this->post('/admin/releases/add', ['name' => '', 'artist_id' => '']);
        $this->assertResponseOk();
        $this->assertResponseContains('Add New Release');
    }

    /**
     * Test edit form renders correctly.
     *
     * @return void
     */
    public function testEdit(): void
    {
        Configure::write('debug', true);
        $this->get('/admin/releases/edit/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Edit Release');
        $this->assertResponseContains('Radical Optimism');
    }

    /**
     * Test that an existing release can be updated via POST.
     *
     * @return void
     */
    public function testEditPost(): void
    {
        Configure::write('debug', true);
        $this->enableCsrfToken();
        $data = [
            'name'       => 'Updated Title',
            'artist_id'  => 1,
            'price'      => 29.99,
            'color'      => '#6C3483',
            'label_text' => 'LP',
            'in_stock'   => true,
        ];
        $this->post('/admin/releases/edit/1', $data);
        $this->assertResponseCode(302);
        $this->assertRedirect(['prefix' => 'Admin', 'controller' => 'Releases', 'action' => 'index']);
    }

    /**
     * Test that a release can be deleted.
     *
     * @return void
     */
    public function testDelete(): void
    {
        Configure::write('debug', true);
        $this->enableCsrfToken();
        $this->post('/admin/releases/delete/1');
        $this->assertResponseCode(302);
        $this->assertRedirect(['prefix' => 'Admin', 'controller' => 'Releases', 'action' => 'index']);
    }

    /**
     * Test that a GET request to delete is not allowed.
     *
     * @return void
     */
    public function testDeleteGetNotAllowed(): void
    {
        Configure::write('debug', true);
        $this->get('/admin/releases/delete/1');
        $this->assertResponseCode(405);
    }
}
