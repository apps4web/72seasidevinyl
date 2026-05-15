<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Reservation> $reservations
 * @var string $statusFilter
 */
$this->assign('title', 'Reserveringen');

$statusLabels = [
    'pending'   => ['label' => 'Nieuw',      'bg' => 'bg-warning-light',  'text' => 'text-warning'],
    'confirmed' => ['label' => 'Bevestigd',  'bg' => 'bg-primary-light',  'text' => 'text-primary'],
    'picked_up' => ['label' => 'Opgehaald',  'bg' => 'bg-success-light',  'text' => 'text-success'],
    'cancelled' => ['label' => 'Geannuleerd','bg' => 'bg-danger-light',   'text' => 'text-danger'],
];

$filterOptions = [
    ''          => 'Alle',
    'pending'   => 'Nieuw',
    'confirmed' => 'Bevestigd',
    'picked_up' => 'Opgehaald',
    'cancelled' => 'Geannuleerd',
];
?>

<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-body-dark">Reserveringen</h1>
        <p class="text-sm text-gray-4 mt-1">Beheer klantreserveringen</p>
    </div>

    <!-- Status filter tabs -->
    <div class="flex flex-wrap gap-2">
        <?php foreach ($filterOptions as $value => $label): ?>
            <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Reservations', 'action' => 'index', '?' => $value !== '' ? ['status' => $value] : []]) ?>"
               class="inline-flex items-center rounded-full px-3 py-1.5 text-xs font-medium border transition-colors
                      <?= $statusFilter === $value ? 'bg-primary text-white border-primary' : 'bg-white text-body-dark border-stroke hover:bg-gray-2' ?>">
                <?= h($label) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default sm:px-7.5 xl:pb-1">

    <?php if ($reservations->count() === 0): ?>
    <div class="text-center py-16 text-gray-4">
        <i class="fa-solid fa-inbox fa-4x mb-4 text-gray-3 block text-center"></i>
        <p class="text-lg font-medium mb-2">Geen reserveringen gevonden</p>
        <?php if ($statusFilter !== ''): ?>
        <p class="text-sm"><a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Reservations', 'action' => 'index']) ?>" class="text-primary hover:underline">Toon alle reserveringen</a></p>
        <?php endif; ?>
    </div>
    <?php else: ?>

    <div class="max-w-full overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-2 text-left">
                    <th class="py-4 px-4 font-medium text-body-dark">#</th>
                    <th class="min-w-[180px] py-4 px-4 font-medium text-body-dark">Klant</th>
                    <th class="min-w-[200px] py-4 px-4 font-medium text-body-dark">Platen</th>
                    <th class="py-4 px-4 font-medium text-body-dark text-right">Totaal</th>
                    <th class="py-4 px-4 font-medium text-body-dark">
                        <?= $this->Paginator->sort('created', 'Datum') ?>
                    </th>
                    <th class="py-4 px-4 font-medium text-body-dark">Status</th>
                    <th class="py-4 px-4 font-medium text-body-dark">Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                <?php $st = $statusLabels[$reservation->status] ?? ['label' => $reservation->status, 'bg' => 'bg-gray-2', 'text' => 'text-body-dark']; ?>
                <tr class="border-b border-stroke hover:bg-gray-1 align-top">

                    <!-- ID -->
                    <td class="py-3 px-4 text-sm text-gray-4">#<?= h((string)$reservation->id) ?></td>

                    <!-- Customer -->
                    <td class="py-3 px-4">
                        <p class="font-medium text-body-dark text-sm"><?= h($reservation->name) ?></p>
                        <a href="mailto:<?= h($reservation->email) ?>" class="text-xs text-primary hover:underline"><?= h($reservation->email) ?></a>
                        <?php if ($reservation->phone): ?>
                        <p class="text-xs text-gray-4 mt-0.5"><?= h($reservation->phone) ?></p>
                        <?php endif; ?>
                        <?php if ($reservation->note): ?>
                        <p class="text-xs text-gray-4 italic mt-1 max-w-[160px] truncate" title="<?= h($reservation->note) ?>">
                            "<?= h($reservation->note) ?>"
                        </p>
                        <?php endif; ?>
                    </td>

                    <!-- Items -->
                    <td class="py-3 px-4">
                        <?php foreach ($reservation->reservation_items as $item): ?>
                        <div class="text-sm text-body-dark leading-snug">
                            <?php if ($item->artist): ?>
                                <span class="text-gray-4 text-xs"><?= h($item->artist) ?> – </span>
                            <?php endif; ?>
                            <?= h($item->name) ?>
                        </div>
                        <?php endforeach; ?>
                    </td>

                    <!-- Total -->
                    <td class="py-3 px-4 text-sm font-medium text-body-dark text-right whitespace-nowrap">
                        <?php if ($reservation->total !== null): ?>
                            €&nbsp;<?= number_format((float)$reservation->total, 2, ',', '.') ?>
                        <?php else: ?>
                            <span class="text-gray-4">–</span>
                        <?php endif; ?>
                    </td>

                    <!-- Date -->
                    <td class="py-3 px-4 text-sm text-gray-4 whitespace-nowrap">
                        <?= h($reservation->created->format('d-m-Y')) ?><br>
                        <span class="text-xs"><?= h($reservation->created->format('H:i')) ?></span>
                    </td>

                    <!-- Status badge -->
                    <td class="py-3 px-4">
                        <span class="inline-flex rounded-full py-1 px-3 text-xs font-medium <?= $st['bg'] ?> <?= $st['text'] ?>">
                            <?= h($st['label']) ?>
                        </span>
                    </td>

                    <!-- Actions -->
                    <td class="py-3 px-4">
                        <div class="flex flex-col gap-1">
                            <?php if ($reservation->status === 'pending'): ?>
                                <?= $this->Form->postLink('Bevestigen', ['prefix' => 'Admin', 'controller' => 'Reservations', 'action' => 'updateStatus', $reservation->id], ['data' => ['status' => 'confirmed'], 'class' => 'inline-flex justify-center rounded bg-primary py-1 px-3 text-xs font-medium text-white hover:bg-opacity-90']) ?>
                                <?= $this->Form->postLink('Annuleren', ['prefix' => 'Admin', 'controller' => 'Reservations', 'action' => 'updateStatus', $reservation->id], ['data' => ['status' => 'cancelled'], 'confirm' => 'Reservering #' . $reservation->id . ' annuleren?', 'class' => 'inline-flex justify-center rounded border border-danger py-1 px-3 text-xs font-medium text-danger hover:bg-danger-light']) ?>
                            <?php elseif ($reservation->status === 'confirmed'): ?>
                                <?= $this->Form->postLink('Opgehaald', ['prefix' => 'Admin', 'controller' => 'Reservations', 'action' => 'updateStatus', $reservation->id], ['data' => ['status' => 'picked_up'], 'class' => 'inline-flex justify-center rounded py-1 px-3 text-xs font-medium text-white', 'style' => 'background:#218053;']) ?>
                                <?= $this->Form->postLink('Annuleren', ['prefix' => 'Admin', 'controller' => 'Reservations', 'action' => 'updateStatus', $reservation->id], ['data' => ['status' => 'cancelled'], 'confirm' => 'Reservering #' . $reservation->id . ' annuleren?', 'class' => 'inline-flex justify-center rounded border border-danger py-1 px-3 text-xs font-medium text-danger hover:bg-danger-light']) ?>
                            <?php else: ?>
                                <span class="text-xs text-gray-4 italic">–</span>
                            <?php endif; ?>
                        </div>
                    </td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 py-4 px-4">
        <p class="text-sm text-gray-4">
            <?= $this->Paginator->counter(__('Pagina {{page}} van {{pages}}, {{count}} reservering(en) totaal')) ?>
        </p>
        <div class="flex items-center gap-2">
            <?= $this->Paginator->prev('‹ Vorige', ['class' => 'inline-flex items-center rounded border border-stroke bg-white px-3 py-1.5 text-sm font-medium text-body-dark hover:bg-gray-2']) ?>
            <?= $this->Paginator->numbers(['class' => 'inline-flex items-center rounded border border-stroke bg-white px-3 py-1.5 text-sm font-medium text-body-dark hover:bg-gray-2', 'currentClass' => 'inline-flex items-center rounded border border-primary bg-primary px-3 py-1.5 text-sm font-medium text-white']) ?>
            <?= $this->Paginator->next('Volgende ›', ['class' => 'inline-flex items-center rounded border border-stroke bg-white px-3 py-1.5 text-sm font-medium text-body-dark hover:bg-gray-2']) ?>
        </div>
    </div>

    <?php endif; ?>
</div>
