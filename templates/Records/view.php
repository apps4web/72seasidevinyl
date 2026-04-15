<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Record $record
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Record'), ['action' => 'edit', $record->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Record'), ['action' => 'delete', $record->id], ['confirm' => __('Are you sure you want to delete # {0}?', $record->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Records'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Record'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="records view content">
            <h3><?= h($record->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Artist') ?></th>
                    <td><?= $record->hasValue('artist') ? $this->Html->link($record->artist->name, ['controller' => 'Artists', 'action' => 'view', $record->artist->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($record->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cover') ?></th>
                    <td><?= h($record->cover) ?></td>
                </tr>
                <tr>
                    <th><?= __('Color') ?></th>
                    <td><?= h($record->color) ?></td>
                </tr>
                <tr>
                    <th><?= __('Label Text') ?></th>
                    <td><?= h($record->label_text) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($record->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Price') ?></th>
                    <td><?= $record->price === null ? '' : $this->Number->format($record->price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Released') ?></th>
                    <td><?= h($record->released) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($record->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($record->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Latest') ?></th>
                    <td><?= $record->is_latest ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('In Stock') ?></th>
                    <td><?= $record->in_stock ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Genres') ?></h4>
                <?php if (!empty($record->genres)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Slug') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($record->genres as $genre) : ?>
                        <tr>
                            <td><?= h($genre->id) ?></td>
                            <td><?= h($genre->name) ?></td>
                            <td><?= h($genre->slug) ?></td>
                            <td><?= h($genre->created) ?></td>
                            <td><?= h($genre->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Genres', 'action' => 'view', $genre->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Genres', 'action' => 'edit', $genre->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Genres', 'action' => 'delete', $genre->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $genre->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Record Images') ?></h4>
                <?php if (!empty($record->record_images)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Filename') ?></th>
                            <th><?= __('Alt') ?></th>
                            <th><?= __('Sort Order') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($record->record_images as $recordImage) : ?>
                        <tr>
                            <td><?= h($recordImage->id) ?></td>
                            <td><?= h($recordImage->filename) ?></td>
                            <td><?= h($recordImage->alt) ?></td>
                            <td><?= h($recordImage->sort_order) ?></td>
                            <td><?= h($recordImage->created) ?></td>
                            <td><?= h($recordImage->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'RecordImages', 'action' => 'view', $recordImage->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'RecordImages', 'action' => 'edit', $recordImage->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'RecordImages', 'action' => 'delete', $recordImage->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $recordImage->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>