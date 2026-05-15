<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reservation $reservation
 */
$this->assign('title', 'Reservering bevestigd');
?>

<div class="shop-page">
    <div class="confirm-wrap">

        <div class="confirm-icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        </div>

        <h1 class="confirm-title">Bedankt voor uw reservering!</h1>
        <p class="confirm-text">
            Beste <?= h($reservation->name) ?>,<br><br>
            Wij hebben uw reservering ontvangen en nemen zo spoedig mogelijk contact met u op via
            <strong><?= h($reservation->email) ?></strong> om een afhaaltijd af te spreken.
        </p>

        <div class="checkout-summary" style="text-align: left; margin-bottom: 40px;">
            <p class="checkout-summary-title">Gereserveerde platen</p>
            <?php foreach ($reservation->reservation_items as $item): ?>
                <div class="checkout-summary-item">
                    <span>
                        <?php if ($item->artist): ?>
                            <?= h($item->artist) ?> &ndash;
                        <?php endif; ?>
                        <?= h($item->name) ?>
                    </span>
                    <span>
                        <?php if ($item->price !== null && $item->price !== ''): ?>
                            &euro;&nbsp;<?= h(number_format((float)$item->price, 2, ',', '.')) ?>
                        <?php else: ?>
                            &mdash;
                        <?php endif; ?>
                    </span>
                </div>
            <?php endforeach; ?>
            <?php if ($reservation->total !== null): ?>
            <div class="checkout-summary-total">
                <span>Totaal</span>
                <span>&euro;&nbsp;<?= h(number_format((float)$reservation->total, 2, ',', '.')) ?></span>
            </div>
            <?php endif; ?>
        </div>

        <div class="checkout-pickup-note" style="text-align: left; margin-bottom: 40px;">
            <strong>Ophalen</strong><br>
            Sint Domusstraat 17, Zierikzee &mdash; betaling bij afhalen.
        </div>

        <a href="<?= $this->Url->build('/') ?>" class="btn-reserve">
            Terug naar home
        </a>
    </div>
</div>
