<?php
/**
 * Admin Dashboard index template.
 *
 * @var \App\View\AppView $this
 * @var int $totalReleases
 * @var int $inStockCount
 * @var int $outOfStockCount
 * @var iterable<\App\Model\Entity\Release> $recentReleases
 */
$this->assign('title', 'Dashboard');
?>

<!-- Page heading -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-body-dark">Dashboard</h1>
    <p class="text-sm text-gray-4 mt-1">Welcome to the 72 Seaside Vinyl content management system.</p>
</div>

<!-- ============================================================
     STATS CARDS
     ============================================================ -->
<div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-3 2xl:gap-7.5 mb-8">

    <!-- Total Releases -->
    <div class="rounded-sm border border-stroke bg-white px-7 py-6 shadow-default">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-full bg-[#EEF2FF]">
                <i class="fa-solid fa-record-vinyl fa-lg text-primary"></i>
            </div>
            <span class="text-3xl font-bold text-body-dark"><?= $totalReleases ?></span>
        </div>
        <div class="mt-4">
            <h4 class="text-lg font-semibold text-body-dark">Total Releases</h4>
            <span class="text-sm text-gray-4">All vinyl records in catalogue</span>
        </div>
    </div>

    <!-- In Stock -->
    <div class="rounded-sm border border-stroke bg-white px-7 py-6 shadow-default">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-full bg-success-light">
                <i class="fa-solid fa-circle-check fa-lg text-success"></i>
            </div>
            <span class="text-3xl font-bold text-body-dark"><?= $inStockCount ?></span>
        </div>
        <div class="mt-4">
            <h4 class="text-lg font-semibold text-body-dark">In Stock</h4>
            <span class="text-sm text-gray-4">Available for purchase</span>
        </div>
    </div>

    <!-- Out of Stock -->
    <div class="rounded-sm border border-stroke bg-white px-7 py-6 shadow-default">
        <div class="flex items-center justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-full bg-danger-light">
                <i class="fa-solid fa-circle-xmark fa-lg text-danger"></i>
            </div>
            <span class="text-3xl font-bold text-body-dark"><?= $outOfStockCount ?></span>
        </div>
        <div class="mt-4">
            <h4 class="text-lg font-semibold text-body-dark">Out of Stock</h4>
            <span class="text-sm text-gray-4">Currently unavailable</span>
        </div>
    </div>

</div>

<!-- ============================================================
     RECENT RELEASES TABLE
     ============================================================ -->
<div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default sm:px-7.5 xl:pb-1">
    <div class="flex items-center justify-between mb-6">
        <h4 class="text-xl font-semibold text-body-dark">Recent Releases</h4>
        <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Releases', 'action' => 'add']) ?>"
           class="inline-flex items-center gap-2 rounded bg-primary py-2 px-4 text-sm font-medium text-white hover:bg-opacity-90">
            + Add Release
        </a>
    </div>

    <?php if (empty($recentReleases->toArray())): ?>
    <div class="text-center py-10 text-gray-4">
        <p class="text-lg mb-3">No releases yet.</p>
        <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Releases', 'action' => 'add']) ?>"
           class="inline-flex items-center gap-2 rounded bg-primary py-2 px-4 text-sm font-medium text-white hover:bg-opacity-90">
            Add your first release
        </a>
    </div>
    <?php else: ?>
    <div class="max-w-full overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-2 text-left">
                    <th class="min-w-[150px] py-4 px-4 font-medium text-body-dark">Title</th>
                    <th class="min-w-[120px] py-4 px-4 font-medium text-body-dark">Artist</th>
                    <th class="min-w-[100px] py-4 px-4 font-medium text-body-dark">Genre</th>
                    <th class="min-w-[80px] py-4 px-4 font-medium text-body-dark">Price</th>
                    <th class="min-w-[80px] py-4 px-4 font-medium text-body-dark">Stock</th>
                    <th class="py-4 px-4 font-medium text-body-dark">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentReleases as $release): ?>
                <tr class="border-b border-stroke hover:bg-gray-1">
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full text-xs font-bold text-white"
                                  style="background-color: <?= h($release->color) ?>">
                                <?= h($release->label_text) ?>
                            </span>
                            <span class="font-medium text-body-dark"><?= h($release->name) ?></span>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-gray-4"><?= $release->artist ? h($release->artist->name) : '-' ?></td>
                    <td class="py-3 px-4 text-gray-4"><?= !empty($release->genres) ? h(implode(', ', collection($release->genres)->extract('name')->toList())) : '-' ?></td>
                    <td class="py-3 px-4 font-medium text-body-dark">€<?= number_format((float)$release->price, 2, ',', '.') ?></td>
                    <td class="py-3 px-4">
                        <?php if ($release->in_stock): ?>
                        <span class="inline-flex rounded-full bg-success-light py-1 px-3 text-xs font-medium text-success">In Stock</span>
                        <?php else: ?>
                        <span class="inline-flex rounded-full bg-danger-light py-1 px-3 text-xs font-medium text-danger">Out of Stock</span>
                        <?php endif; ?>
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-2">
                            <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Releases', 'action' => 'edit', $release->id]) ?>"
                               class="hover:text-primary text-gray-4">Edit</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <div class="mt-4 pb-4">
        <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Releases', 'action' => 'index']) ?>"
           class="text-sm text-primary hover:underline">View all releases →</a>
    </div>
</div>
