<?php
/**
 * @var \App\View\AppView $this
 * @var array $basket
 * @var float $total
 */
$this->assign('title', 'Reserveren');
?>

<div class="shop-page">
    <div class="checkout-wrap">

        <h1 class="checkout-title">Reservering plaatsen</h1>
        <p class="checkout-subtitle">Vul uw gegevens in en wij nemen zo snel mogelijk contact met u op.</p>

        <?= $this->Flash->render() ?>

        <!-- Order summary -->
        <div class="checkout-summary">
            <p class="checkout-summary-title">Uw bestelling</p>
            <?php foreach ($basket as $item): ?>
                <div class="checkout-summary-item">
                    <span><?= h($item['artist']) ?> &ndash; <?= h($item['name']) ?></span>
                    <span>
                        <?php if ($item['price'] !== null && $item['price'] !== ''): ?>
                            &euro;&nbsp;<?= h(number_format((float)$item['price'], 2, ',', '.')) ?>
                        <?php else: ?>
                            &mdash;
                        <?php endif; ?>
                    </span>
                </div>
            <?php endforeach; ?>
            <div class="checkout-summary-total">
                <span>Totaal</span>
                <span>&euro;&nbsp;<?= h(number_format($total, 2, ',', '.')) ?></span>
            </div>
        </div>

        <div class="checkout-pickup-note">
            <strong>Ophalen in de winkel</strong><br>
            Sint Domusstraat 17, Zierikzee &mdash; betaling bij afhalen. Na uw reservering nemen wij contact met u op om een afhaaltijd af te spreken.
        </div>

        <?= $this->Form->create(null, ['url' => ['controller' => 'Basket', 'action' => 'checkout'], 'novalidate' => true]) ?>

            <div class="shop-form-group">
                <label for="name">Naam <span style="color:#c62828;">*</span></label>
                <input type="text" id="name" name="name" value="<?= h($this->request->getData('name')) ?>" autocomplete="name" required>
            </div>

            <div class="shop-form-group">
                <label for="email">E-mailadres <span style="color:#c62828;">*</span></label>
                <input type="email" id="email" name="email" value="<?= h($this->request->getData('email')) ?>" autocomplete="email" required>
            </div>

            <div class="shop-form-group">
                <label for="phone">Telefoonnummer <span style="color:#aaa; font-weight:400;">(optioneel)</span></label>
                <input type="tel" id="phone" name="phone" value="<?= h($this->request->getData('phone')) ?>" autocomplete="tel">
            </div>

            <div class="shop-form-group">
                <label for="note">Opmerking <span style="color:#aaa; font-weight:400;">(optioneel)</span></label>
                <textarea id="note" name="note"><?= h($this->request->getData('note')) ?></textarea>
            </div>

            <div class="basket-actions" style="margin-top: 8px;">
                <a href="<?= $this->Url->build(['controller' => 'Basket', 'action' => 'view']) ?>" class="btn-basket">
                    &larr; Terug
                </a>
                <?= $this->Form->button('Reservering bevestigen', ['class' => 'btn-reserve', 'type' => 'submit']) ?>
            </div>

        <?= $this->Form->end() ?>
    </div>
</div>
