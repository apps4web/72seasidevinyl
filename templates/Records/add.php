<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Record $record
 * @var \Cake\Collection\CollectionInterface|string[] $artists
 * @var \Cake\Collection\CollectionInterface|string[] $genres
 */

$this->assign('title', 'Add Record');

echo $this->Html->css('tom-select', ['block' => 'css']);
$this->Html->script('tom-select.complete.min', ['block' => 'scriptBottom']);
?>
<div class="mb-6">
    <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="inline-flex items-center gap-2 text-sm text-gray-4 hover:text-primary">
        <i class="fa-solid fa-arrow-left"></i>
        Back to Records
    </a>
    <div class="mt-3">
        <h1 class="text-2xl font-bold text-body-dark">Add New Record</h1>
        <p class="mt-1 text-sm text-gray-4">Add a new record to your catalogue</p>
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
                <?= $this->Form->control('cover_upload', [
                    'type' => 'file',
                    'label' => false,
                    'accept' => 'image/*',
                    'class' => 'w-full rounded border border-stroke bg-gray-1 px-5 py-3 text-sm text-body-dark outline-none transition focus:border-primary active:border-primary',
                ]) ?>
                <p class="mt-1 text-xs text-gray-4">Upload jpg, jpeg, png, webp, or gif (max 5MB).</p>
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
                    'id' => 'genres-select-add',
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
                    'checked' => true,
                ]) ?>
                <label for="in_stock" class="flex cursor-pointer items-center gap-3 text-sm font-medium text-body-dark">
                    <div class="relative h-5 w-10 rounded-full bg-gray-3 transition-colors duration-300 after:absolute after:left-0.5 after:top-0.5 after:h-4 after:w-4 after:rounded-full after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-5"></div>
                    In Stock
                </label>
            </div>
        </div>

        <div class="flex items-center gap-4 border-t border-stroke pt-4">
            <?= $this->Form->button('Save Record', [
                'class' => 'inline-flex cursor-pointer items-center gap-2 rounded bg-primary px-8 py-3 text-sm font-medium text-white hover:bg-opacity-90',
            ]) ?>
            <a href="<?= $this->Url->build(['action' => 'index']) ?>"
               class="inline-flex items-center gap-2 rounded border border-stroke px-8 py-3 text-sm font-medium text-body-dark hover:bg-gray-2">
                Cancel
            </a>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>

<?php $this->append('scriptBottom'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var genresSelect = document.getElementById('genres-select-add');
    if (genresSelect && !genresSelect.tomselect) {
        new TomSelect(genresSelect, {
            plugins: ['remove_button'],
            create: false,
            placeholder: 'Type to search genres...',
            maxOptions: 500,
        });
    }
});
</script>
<?php $this->end(); ?>
