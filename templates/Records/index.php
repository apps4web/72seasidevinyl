<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Record> $records
 */

$this->assign('title', 'Records');
?>
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-body-dark">Records</h1>
        <p class="mt-1 text-sm text-gray-4">Manage records in your catalogue</p>
    </div>
    <a href="<?= $this->Url->build(['action' => 'add']) ?>"
       class="inline-flex items-center gap-2 rounded bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-opacity-90">
        <i class="fa-solid fa-plus"></i>
        Add Record
    </a>
</div>

<div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default sm:px-7.5 xl:pb-1">
    <?php if ($records->count() === 0): ?>
    <div class="py-16 text-center text-gray-4">
        <i class="fa-solid fa-compact-disc mx-auto mb-4 block text-center text-4xl text-gray-3"></i>
        <p class="mb-2 text-lg font-medium">No records in catalogue</p>
        <p class="mb-6 text-sm">Add your first record to get started.</p>
        <a href="<?= $this->Url->build(['action' => 'add']) ?>"
           class="inline-flex items-center gap-2 rounded bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-opacity-90">
            Add your first record
        </a>
    </div>
    <?php else: ?>
    <div class="max-w-full overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-2 text-left">
                    <th class="min-w-[200px] px-4 py-4 font-medium text-body-dark">
                        <?= $this->Paginator->sort('artist_id', 'Artist') ?>
                    </th>
                    <th class="min-w-[220px] px-4 py-4 font-medium text-body-dark">
                        <?= $this->Paginator->sort('name', 'Name') ?>
                    </th>
                    <th class="min-w-[120px] px-4 py-4 font-medium text-body-dark">
                        <?= $this->Paginator->sort('price', 'Price') ?>
                    </th>
                    <th class="px-4 py-4 font-medium text-body-dark">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $record): ?>
                <tr class="border-b border-stroke hover:bg-gray-1">
                    <td class="px-4 py-3 text-gray-4">
                        <?= $record->artist ? h($record->artist->name) : '-' ?>
                    </td>
                    <td class="px-4 py-3 font-medium text-body-dark">
                        <?= h($record->name) ?>
                    </td>
                    <td class="px-4 py-3 font-medium text-body-dark">
                        <?= $record->price === null ? '-' : 'EUR ' . number_format((float)$record->price, 2, ',', '.') ?>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <a href="<?= $this->Url->build(['action' => 'edit', $record->id]) ?>"
                               class="text-sm font-medium text-primary hover:underline">
                                Edit
                            </a>
                            <?= $this->Form->postLink(
                                'Delete',
                                ['action' => 'delete', $record->id],
                                [
                                    'confirm' => __('Are you sure you want to delete "{0}"?', $record->name),
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

    <div class="flex flex-col items-center justify-between gap-4 px-4 py-4 sm:flex-row">
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