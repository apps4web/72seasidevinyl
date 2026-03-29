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
        <svg class="w-4 h-4 fill-current" viewBox="0 0 448 512">
            <path d="M432 256c0 17.7-14.3 32-32 32L240 288l0 160c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-160-160 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l160 0 0-160c0-17.7 14.3-32 32-32s32 14.3 32 32l0 160 160 0c17.7 0 32 14.3 32 32z"/>
        </svg>
        Add Release
    </a>
</div>

<!-- Releases table -->
<div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default sm:px-7.5 xl:pb-1">

    <?php if ($releases->count() === 0): ?>
    <div class="text-center py-16 text-gray-4">
        <svg class="w-16 h-16 fill-current mx-auto mb-4 text-gray-3" viewBox="0 0 512 512">
            <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm0-384c-101.7 0-184 82.3-184 184S154.3 440 256 440s184-82.3 184-184S357.7 72 256 72zm0 328c-79.4 0-144-64.6-144-144S176.6 112 256 112s144 64.6 144 144-64.6 144-144 144zm0-232c-48.6 0-88 39.4-88 88s39.4 88 88 88 88-39.4 88-88-39.4-88-88-88zm0 128c-22.1 0-40-17.9-40-40s17.9-40 40-40 40 17.9 40 40-17.9 40-40 40z"/>
        </svg>
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
                        <?= $this->Paginator->sort('title', 'Title') ?>
                    </th>
                    <th class="min-w-[150px] py-4 px-4 font-medium text-body-dark">
                        <?= $this->Paginator->sort('artist', 'Artist') ?>
                    </th>
                    <th class="min-w-[120px] py-4 px-4 font-medium text-body-dark">
                        <?= $this->Paginator->sort('genre', 'Genre') ?>
                    </th>
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
                            <span class="font-medium text-body-dark"><?= h($release->title) ?></span>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-gray-4"><?= h($release->artist) ?></td>
                    <td class="py-3 px-4 text-gray-4"><?= h($release->genre) ?></td>
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
                                    'confirm' => __('Are you sure you want to delete "{0}" by {1}?', $release->title, $release->artist),
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
