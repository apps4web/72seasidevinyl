<?php
/**
 * Admin Releases edit template.
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Release $release
 */
$this->assign('title', 'Edit Release');
?>

<!-- Page heading -->
<div class="mb-6 flex items-center gap-3">
    <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Releases', 'action' => 'index']) ?>"
       class="text-gray-4 hover:text-primary">
        <i class="fa-solid fa-arrow-left fa-lg"></i>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-body-dark">Edit Release</h1>
        <p class="text-sm text-gray-4 mt-1"><?= h($release->name) ?> &mdash; <?= $release->artist ? h($release->artist->name) : '-' ?></p>
    </div>
</div>

<!-- Form card -->
<div class="rounded-sm border border-stroke bg-white shadow-default">
    <div class="border-b border-stroke px-7 py-4">
        <h3 class="font-medium text-body-dark">Release Information</h3>
    </div>
    <div class="p-7">
        <?= $this->Form->create($release, ['class' => 'space-y-6']) ?>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

            <!-- Title -->
            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">
                    Title <span class="text-danger">*</span>
                </label>
                <?= $this->Form->control('name', [
                    'label' => false,
                    'placeholder' => 'e.g. Radical Optimism',
                    'class' => 'w-full rounded border border-stroke bg-gray-1 py-3 px-5 text-sm font-medium text-body-dark outline-none transition focus:border-primary active:border-primary' . ($release->getError('name') ? ' border-danger' : ''),
                ]) ?>
                <?php if ($release->getError('name')): ?>
                <p class="mt-1 text-xs text-danger"><?= h(current($release->getError('name'))) ?></p>
                <?php endif; ?>
            </div>

            <!-- Artist -->
            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">
                    Artist <span class="text-danger">*</span>
                </label>
                <?= $this->Form->control('artist_id', [
                    'label' => false,
                    'options' => $artists,
                    'empty' => '-- Select Artist --',
                    'class' => 'w-full rounded border border-stroke bg-gray-1 py-3 px-5 text-sm font-medium text-body-dark outline-none transition focus:border-primary active:border-primary' . ($release->getError('artist_id') ? ' border-danger' : ''),
                ]) ?>
                <?php if ($release->getError('artist_id')): ?>
                <p class="mt-1 text-xs text-danger"><?= h(current($release->getError('artist_id'))) ?></p>
                <?php endif; ?>
            </div>

            <!-- Price -->
            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">
                    Price (€) <span class="text-danger">*</span>
                </label>
                <?= $this->Form->control('price', [
                    'label' => false,
                    'type' => 'number',
                    'step' => '0.01',
                    'min' => '0',
                    'placeholder' => '0.00',
                    'class' => 'w-full rounded border border-stroke bg-gray-1 py-3 px-5 text-sm font-medium text-body-dark outline-none transition focus:border-primary active:border-primary' . ($release->getError('price') ? ' border-danger' : ''),
                ]) ?>
                <?php if ($release->getError('price')): ?>
                <p class="mt-1 text-xs text-danger"><?= h(current($release->getError('price'))) ?></p>
                <?php endif; ?>
            </div>

            <!-- Colour -->
            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">Vinyl Colour</label>
                <div class="flex items-center gap-3">
                    <?= $this->Form->control('color', [
                        'label' => false,
                        'type' => 'color',
                        'class' => 'h-12 w-16 cursor-pointer rounded border border-stroke p-1',
                    ]) ?>
                    <span class="text-sm text-gray-4">Current colour for this release</span>
                </div>
            </div>

            <!-- Label text -->
            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">Label Text</label>
                <?= $this->Form->control('label_text', [
                    'label' => false,
                    'placeholder' => 'e.g. LP, 2xLP, EP',
                    'class' => 'w-full rounded border border-stroke bg-gray-1 py-3 px-5 text-sm font-medium text-body-dark outline-none transition focus:border-primary active:border-primary',
                ]) ?>
            </div>

        </div>

        <!-- Is Latest toggle -->
        <div class="flex items-center gap-4">
            <div class="relative">
                <?= $this->Form->control('is_latest', [
                    'type' => 'checkbox',
                    'label' => false,
                    'class' => 'sr-only peer',
                    'id' => 'is_latest',
                ]) ?>
                <label for="is_latest"
                       class="flex cursor-pointer items-center gap-3 text-sm font-medium text-body-dark">
                    <div class="relative h-5 w-10 rounded-full bg-gray-3 peer-checked:bg-primary transition-colors duration-300 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition-all peer-checked:after:translate-x-5"></div>
                    Latest Release
                </label>
            </div>
        </div>

        <!-- In Stock toggle -->
        <div class="flex items-center gap-4">
            <div class="relative">
                <?= $this->Form->control('in_stock', [
                    'type' => 'checkbox',
                    'label' => false,
                    'class' => 'sr-only peer',
                    'id' => 'in_stock',
                ]) ?>
                <label for="in_stock"
                       class="flex cursor-pointer items-center gap-3 text-sm font-medium text-body-dark">
                    <div class="relative h-5 w-10 rounded-full bg-gray-3 peer-checked:bg-primary transition-colors duration-300 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition-all peer-checked:after:translate-x-5"></div>
                    In Stock
                </label>
            </div>
        </div>

        <!-- Form actions -->
        <div class="flex items-center gap-4 pt-4 border-t border-stroke">
            <?= $this->Form->button('Save Changes', [
                'class' => 'inline-flex items-center gap-2 rounded bg-primary py-3 px-8 text-sm font-medium text-white hover:bg-opacity-90 cursor-pointer',
            ]) ?>
            <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Releases', 'action' => 'index']) ?>"
               class="inline-flex items-center gap-2 rounded border border-stroke py-3 px-8 text-sm font-medium text-body-dark hover:bg-gray-2">
                Cancel
            </a>
            <?= $this->Form->postLink(
                'Delete this release',
                ['prefix' => 'Admin', 'controller' => 'Releases', 'action' => 'delete', $release->id],
                [
                    'confirm' => __('Are you sure you want to delete "{0}" by {1}?', $release->name, $release->artist ? $release->artist->name : ''),
                    'class' => 'ml-auto text-sm font-medium text-danger hover:underline',
                ]
            ) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>
