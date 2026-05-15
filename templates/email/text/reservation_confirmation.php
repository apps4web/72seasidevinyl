<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reservation $reservation
 */
?>
Beste <?= h($reservation->name) ?>,

Bedankt voor uw reservering bij 72 Seaside Vinyl! Wij nemen zo spoedig mogelijk contact met u op via <?= h($reservation->email) ?> om een afhaaltijd af te spreken.

UW RESERVERING
<?php foreach ($reservation->reservation_items as $item): ?>
- <?= $item->artist ? h($item->artist) . ' – ' : '' ?><?= h($item->name) ?><?= $item->price !== null ? '   € ' . number_format((float)$item->price, 2, ',', '.') : '' ?>

<?php endforeach; ?>
<?php if ($reservation->total !== null): ?>
Totaal: € <?= number_format((float)$reservation->total, 2, ',', '.') ?>

<?php endif; ?>
OPHALEN IN DE WINKEL
Sint Domusstraat 17, Zierikzee
Betaling bij afhalen. Wij bevestigen een afhaaltijd via e-mail of telefoon.
<?php if ($reservation->note): ?>

Uw opmerking: "<?= h($reservation->note) ?>"
<?php endif; ?>

Met vriendelijke groet,
72 Seaside Vinyl
