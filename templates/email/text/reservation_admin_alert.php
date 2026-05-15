<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reservation $reservation
 */
?>
NIEUWE RESERVERING #<?= h($reservation->id) ?>


KLANTGEGEVENS
Naam:         <?= h($reservation->name) ?>

E-mail:       <?= h($reservation->email) ?>

<?php if ($reservation->phone): ?>
Telefoon:     <?= h($reservation->phone) ?>

<?php endif; ?>
<?php if ($reservation->note): ?>
Opmerking:    <?= h($reservation->note) ?>

<?php endif; ?>

GERESERVEERDE PLATEN
<?php foreach ($reservation->reservation_items as $item): ?>
- <?= $item->artist ? h($item->artist) . ' – ' : '' ?><?= h($item->name) ?><?= $item->price !== null ? '   € ' . number_format((float)$item->price, 2, ',', '.') : '' ?>

<?php endforeach; ?>
<?php if ($reservation->total !== null): ?>
Totaal: € <?= number_format((float)$reservation->total, 2, ',', '.') ?>

<?php endif; ?>
Ontvangen op: <?= h($reservation->created->format('d-m-Y H:i')) ?>
