<?php
/**
 * Admin Releases index template.
 *
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Release> $releases
 */
$this->assign('title', 'Vinyl Releases');
?>

<!-- Page heading -->
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-body-dark">Vinyl Releases</h1>
        <p class="text-sm text-gray-4 mt-1">Manage your vinyl catalogue</p>
    </div>
    <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Releases', 'action' => 'add']) ?>"
       class="inline-flex items-center gap-2 rounded bg-primary py-2 px-4 text-sm font-medium text-white hover:bg-opacity-90">
        <i class="fa-solid fa-plus"></i>
        Add Release
    </a>
</div>

<!-- Releases table -->
<div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default sm:px-7.5 xl:pb-1">

    <?php if ($releases->count() === 0): ?>
    <div class="text-center py-16 text-gray-4">
        <i class="fa-solid fa-record-vinyl fa-4x mx-auto mb-4 text-gray-3 block text-center"></i>
        <p class="text-lg font-medium mb-2">No releases in catalogue</p>
        <p class="text-sm mb-6">Add your first vinyl release to get started.</p>
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
                    <th class="min-w-[200px] py-4 px-4 font-medium text-body-dark">
                        <?= $this->Paginator->sort('name', 'Title') ?>
                    </th>
                    <th class="min-w-[150px] py-4 px-4 font-medium text-body-dark">Artist</th>
                    <th class="min-w-[100px] py-4 px-4 font-medium text-body-dark">
                        <?= $this->Paginator->sort('price', 'Price') ?>
                    </th>
                    <th class="min-w-[80px] py-4 px-4 font-medium text-body-dark">Label</th>
                    <th class="min-w-[90px] py-4 px-4 font-medium text-body-dark">
                        <?= $this->Paginator->sort('in_stock', 'Stock') ?>
                    </th>
                    <th class="py-4 px-4 font-medium text-body-dark">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($releases as $release): ?>
                <tr class="border-b border-stroke hover:bg-gray-1">
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full text-xs font-bold text-white shadow"
                                  style="background-color: <?= h($release->color) ?>">
                                <?= h($release->label_text) ?>
                            </span>
                            <span class="font-medium text-body-dark"><?= h($release->name) ?></span>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-gray-4"><?= $release->artist ? h($release->artist->name) : '-' ?></td>
                    <td class="py-3 px-4 font-medium text-body-dark">€<?= number_format((float)$release->price, 2, ',', '.') ?></td>
                    <td class="py-3 px-4">
                        <span class="inline-flex rounded-full py-1 px-3 text-xs font-medium"
                              style="background-color: <?= h($release->color) ?>1a; color: <?= h($release->color) ?>">
                            <?= h($release->label_text) ?>
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <?php if ($release->in_stock): ?>
                        <span class="inline-flex rounded-full bg-success-light py-1 px-3 text-xs font-medium text-success">In Stock</span>
                        <?php else: ?>
                        <span class="inline-flex rounded-full bg-danger-light py-1 px-3 text-xs font-medium text-danger">Out of Stock</span>
                        <?php endif; ?>
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Releases', 'action' => 'edit', $release->id]) ?>"
                               class="inline-flex items-center gap-1 text-sm font-medium text-primary hover:underline">
                                Edit
                            </a>
                            <?= $this->Form->postLink(
                                'Delete',
                                ['prefix' => 'Admin', 'controller' => 'Releases', 'action' => 'delete', $release->id],
                                [
                                    'confirm' => __('Are you sure you want to delete "{0}" by {1}?', $release->name, $release->artist ? $release->artist->name : ''),
                                    'class' => 'text-sm font-medium text-danger hover:underline',
                                ]
                            ) ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 py-4 px-4">
        <p class="text-sm text-gray-4">
            <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
        </p>
        <div class="flex items-center gap-2">
            <?= $this->Paginator->prev('‹ Prev', ['class' => 'inline-flex items-center rounded border border-stroke bg-white px-3 py-1.5 text-sm font-medium text-body-dark hover:bg-gray-2']) ?>
            <?= $this->Paginator->numbers(['class' => 'inline-flex items-center rounded border border-stroke bg-white px-3 py-1.5 text-sm font-medium text-body-dark hover:bg-gray-2', 'currentClass' => 'inline-flex items-center rounded border border-primary bg-primary px-3 py-1.5 text-sm font-medium text-white']) ?>
            <?= $this->Paginator->next('Next ›', ['class' => 'inline-flex items-center rounded border border-stroke bg-white px-3 py-1.5 text-sm font-medium text-body-dark hover:bg-gray-2']) ?>
        </div>
    </div>

    <?php endif; ?>
</div>
