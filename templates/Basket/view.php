<?php
/**
 * @var \App\View\AppView $this
 * @var array $basket
 * @var float $total
 */
$this->assign('title', 'Winkelwagen');
?>

<div class="shop-page">
    <div class="container" style="padding-top: 56px; padding-bottom: 64px;">

        <h1 class="record-detail__title" style="margin-bottom: 8px;">Winkelwagen</h1>
        <p style="color:#888; margin-bottom: 40px;">Ophalen in de winkel &mdash; Sint Domusstraat 17, Zierikzee</p>

        <?= $this->Flash->render() ?>

        <?php if (empty($basket)): ?>
            <div class="basket-empty">
                <h2>Uw winkelwagen is leeg</h2>
                <p>Voeg platen toe via onze catalogus.</p>
                <a href="<?= $this->Url->build('/') ?>" class="btn-reserve" style="margin-top: 24px; display: inline-block;">
                    Terug naar home
                </a>
            </div>
        <?php else: ?>
            <table class="basket-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Album</th>
                        <th>Prijs</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($basket as $item): ?>
                        <tr>
                            <td style="width: 72px;">
                                <?php if (!empty($item['cover'])): ?>
                                    <img
                                        src="<?= h($this->Url->assetUrl('img/records/images/' . $item['cover'])) ?>"
                                        alt="<?= h($item['name']) ?>"
                                        class="basket-item-cover"
                                    >
                                <?php else: ?>
                                    <div class="basket-item-cover-placeholder"></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= $this->Url->build(['controller' => 'Shop', 'action' => 'record', $item['record_id']]) ?>" class="basket-item-name">
                                    <?= h($item['name']) ?>
                                </a>
                                <span class="basket-item-artist"><?= h($item['artist']) ?></span>
                            </td>
                            <td>
                                <?php if ($item['price'] !== null && $item['price'] !== ''): ?>
                                    &euro;&nbsp;<?= h(number_format((float)$item['price'], 2, ',', '.')) ?>
                                <?php else: ?>
                                    <span style="color:#aaa;">Op aanvraag</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= $this->Form->postLink(
                                    'Verwijder',
                                    ['controller' => 'Basket', 'action' => 'remove', $item['record_id']],
                                    ['class' => 'btn-remove']
                                ) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="basket-total">
                Totaal: <span>&euro;&nbsp;<?= h(number_format($total, 2, ',', '.')) ?></span>
            </div>

            <div class="basket-actions">
                <a href="<?= $this->Url->build('/') ?>" class="btn-basket" style="text-transform: uppercase;">
                    Verder winkelen
                </a>
                <a href="<?= $this->Url->build(['controller' => 'Basket', 'action' => 'checkout']) ?>" class="btn-reserve">
                    Reserveer &rarr;
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
