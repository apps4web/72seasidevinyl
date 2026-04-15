<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Record $record
 * @var string[]|\Cake\Collection\CollectionInterface $artists
 * @var string[]|\Cake\Collection\CollectionInterface $genres
 */

$this->assign('title', 'Edit Record');

echo $this->Html->css('tom-select', ['block' => 'css']);
$this->Html->script('tom-select.complete.min', ['block' => 'scriptBottom']);
?>
<div class="mb-6">
    <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="inline-flex items-center gap-2 text-sm text-gray-4 hover:text-primary">
        <i class="fa-solid fa-arrow-left"></i>
        Back to Records
    </a>
    <div class="mt-3">
        <h1 class="text-2xl font-bold text-body-dark">Edit Record</h1>
        <p class="mt-1 text-sm text-gray-4"><?= h($record->name) ?></p>
    </div>
</div>

<div class="rounded-sm border border-stroke bg-white shadow-default">
    <div class="border-b border-stroke px-7 py-4">
        <h3 class="font-medium text-body-dark">Record Information</h3>
    </div>
    <div class="p-7">
        <?= $this->Form->create($record, ['class' => 'space-y-6', 'type' => 'file']) ?>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">Artist <span class="text-danger">*</span></label>
                <?= $this->Form->control('artist_id', [
                    'label' => false,
                    'options' => $artists,
                    'empty' => '-- Select Artist --',
                    'class' => 'w-full rounded border border-stroke bg-gray-1 px-5 py-3 text-sm font-medium text-body-dark outline-none transition focus:border-primary active:border-primary' . ($record->getError('artist_id') ? ' border-danger' : ''),
                ]) ?>
            </div>

            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">Name <span class="text-danger">*</span></label>
                <?= $this->Form->control('name', [
                    'label' => false,
                    'placeholder' => 'Record name',
                    'class' => 'w-full rounded border border-stroke bg-gray-1 px-5 py-3 text-sm font-medium text-body-dark outline-none transition focus:border-primary active:border-primary' . ($record->getError('name') ? ' border-danger' : ''),
                ]) ?>
            </div>

            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">Price (EUR)</label>
                <?= $this->Form->control('price', [
                    'label' => false,
                    'type' => 'number',
                    'step' => '0.01',
                    'min' => '0',
                    'placeholder' => '0.00',
                    'class' => 'w-full rounded border border-stroke bg-gray-1 px-5 py-3 text-sm font-medium text-body-dark outline-none transition focus:border-primary active:border-primary',
                ]) ?>
            </div>

            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">Release Date</label>
                <?= $this->Form->control('released', [
                    'label' => false,
                    'type' => 'date',
                    'empty' => true,
                    'class' => 'w-full rounded border border-stroke bg-gray-1 px-5 py-3 text-sm font-medium text-body-dark outline-none transition focus:border-primary active:border-primary',
                ]) ?>
            </div>

            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">Cover Image</label>

                <?php if (!empty($record->cover)): ?>
                <div class="mb-3 overflow-hidden rounded border border-stroke bg-gray-1 p-3">
                    <?= $this->Html->image('covers/' . rawurlencode((string)$record->cover), [
                        'alt' => 'Current cover',
                        'class' => 'h-40 w-auto rounded object-contain',
                        'onerror' => "this.style.display='none'; this.nextElementSibling.style.display='block';",
                    ]) ?>
                    <p class="hidden text-xs text-danger">Current cover could not be loaded.</p>
                    <p class="mt-2 text-xs text-gray-4">Current file: <?= h($record->cover) ?></p>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('delete_cover', [
                        'type' => 'checkbox',
                        'label' => 'Delete current cover',
                        'id' => 'delete-cover-checkbox',
                        'hiddenField' => false,
                    ]) ?>
                </div>
                <?php endif; ?>

                <div id="cover-upload-wrapper" class="<?= !empty($record->cover) ? 'hidden' : '' ?>">
                    <?= $this->Form->control('cover_upload', [
                        'type' => 'file',
                        'label' => false,
                        'accept' => 'image/*',
                        'class' => 'w-full rounded border border-stroke bg-gray-1 px-5 py-3 text-sm text-body-dark outline-none transition focus:border-primary active:border-primary',
                    ]) ?>
                    <p class="mt-1 text-xs text-gray-4">Upload jpg, jpeg, png, webp, or gif (max 5MB).</p>
                </div>
            </div>

            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">Label Text</label>
                <?= $this->Form->control('label_text', [
                    'label' => false,
                    'placeholder' => 'LP, 2xLP, EP',
                    'class' => 'w-full rounded border border-stroke bg-gray-1 px-5 py-3 text-sm font-medium text-body-dark outline-none transition focus:border-primary active:border-primary',
                ]) ?>
            </div>

            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">Color</label>
                <div class="flex items-center gap-3">
                    <?= $this->Form->control('color', [
                        'label' => false,
                        'type' => 'color',
                        'class' => 'h-12 w-16 cursor-pointer rounded border border-stroke p-1',
                    ]) ?>
                    <span class="text-sm text-gray-4">Display color for this record</span>
                </div>
            </div>

            <div>
                <label class="mb-2.5 block text-sm font-medium text-body-dark">Genres</label>
                <?= $this->Form->control('genres._ids', [
                    'label' => false,
                    'options' => $genres,
                    'multiple' => true,
                    'id' => 'genres-select-edit',
                    'class' => 'w-full rounded border border-stroke bg-gray-1 px-5 py-3 text-sm text-body-dark outline-none transition focus:border-primary active:border-primary',
                ]) ?>
            </div>
        </div>

        <div class="flex items-center gap-8">
            <div class="relative">
                <?= $this->Form->control('is_latest', [
                    'type' => 'checkbox',
                    'label' => false,
                    'class' => 'sr-only peer',
                    'id' => 'is_latest',
                ]) ?>
                <label for="is_latest" class="flex cursor-pointer items-center gap-3 text-sm font-medium text-body-dark">
                    <div class="relative h-5 w-10 rounded-full bg-gray-3 transition-colors duration-300 after:absolute after:left-0.5 after:top-0.5 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-5"></div>
                    Latest Release
                </label>
            </div>

            <div class="relative">
                <?= $this->Form->control('in_stock', [
                    'type' => 'checkbox',
                    'label' => false,
                    'class' => 'sr-only peer',
                    'id' => 'in_stock',
                ]) ?>
                <label for="in_stock" class="flex cursor-pointer items-center gap-3 text-sm font-medium text-body-dark">
                    <div class="relative h-5 w-10 rounded-full bg-gray-3 transition-colors duration-300 after:absolute after:left-0.5 after:top-0.5 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-5"></div>
                    In Stock
                </label>
            </div>
        </div>

        <div class="flex items-center gap-4 border-t border-stroke pt-4">
            <?= $this->Form->button('Save Changes', [
                'class' => 'inline-flex cursor-pointer items-center gap-2 rounded bg-primary px-8 py-3 text-sm font-medium text-white hover:bg-opacity-90',
            ]) ?>
            <a href="<?= $this->Url->build(['action' => 'index']) ?>"
               class="inline-flex items-center gap-2 rounded border border-stroke px-8 py-3 text-sm font-medium text-body-dark hover:bg-gray-2">
                Cancel
            </a>
            <?= $this->Form->postLink(
                'Delete Record',
                ['action' => 'delete', $record->id],
                [
                    'confirm' => __('Are you sure you want to delete "{0}"?', $record->name),
                    'class' => 'ml-auto text-sm font-medium text-danger hover:underline',
                ]
            ) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>

<?php $this->append('scriptBottom'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var genresSelect = document.getElementById('genres-select-edit');
    if (genresSelect && !genresSelect.tomselect) {
        new TomSelect(genresSelect, {
            plugins: ['remove_button'],
            create: false,
            placeholder: 'Type to search genres...',
            maxOptions: 500,
        });
    }

    var deleteCoverCheckbox = document.getElementById('delete-cover-checkbox');
    var uploadWrapper = document.getElementById('cover-upload-wrapper');
    if (deleteCoverCheckbox && uploadWrapper) {
        var toggleUploadVisibility = function () {
            if (deleteCoverCheckbox.checked) {
                uploadWrapper.classList.remove('hidden');
            } else {
                uploadWrapper.classList.add('hidden');
            }
        };

        toggleUploadVisibility();
        deleteCoverCheckbox.addEventListener('change', toggleUploadVisibility);
    }
});
</script>
<?php $this->end(); ?>
