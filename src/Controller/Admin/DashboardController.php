<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * Admin Dashboard controller.
 */
class DashboardController extends AppController
{
    /**
     * Index action – displays the admin dashboard with summary statistics.
     *
     * @return void
     */
    public function index(): void
    {
        $releasesTable = $this->fetchTable('Releases');

        $totalReleases = $releasesTable->find()->count();
        $inStockCount = $releasesTable->find()->where(['in_stock' => true])->count();
        $outOfStockCount = $releasesTable->find()->where(['in_stock' => false])->count();
        $recentReleases = $releasesTable->find()
            ->contain(['Artists', 'Genres'])
            ->orderByDesc('Releases.created')
            ->limit(5)
            ->all();

        $this->set(compact('totalReleases', 'inStockCount', 'outOfStockCount', 'recentReleases'));
    }
}
