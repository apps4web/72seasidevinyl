<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reservation $reservation
 */
?>
<p style="margin:0 0 6px; font-size:11px; text-transform:uppercase; letter-spacing:1.5px; color:#93c8cb;">Nieuwe reservering ontvangen</p>
<p style="margin:0 0 24px; font-size:22px; font-family:Georgia, serif; color:#e6c96a;">
    <?= h($reservation->name) ?>
</p>

<!-- Customer details -->
<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background:#0c2e31; border:1px solid rgba(201,168,76,0.25); border-radius:4px; margin-bottom:24px;">
    <tr>
        <td style="padding:10px 16px; border-bottom:1px solid rgba(201,168,76,0.15);">
            <span style="font-size:11px; text-transform:uppercase; letter-spacing:1.5px; color:#93c8cb;">Klantgegevens</span>
        </td>
    </tr>
    <tr>
        <td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.05);">
            <span style="font-size:12px; color:#93c8cb; display:block; margin-bottom:2px;">Naam</span>
            <span style="font-size:14px; color:#f5f5f0;"><?= h($reservation->name) ?></span>
        </td>
    </tr>
    <tr>
        <td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.05);">
            <span style="font-size:12px; color:#93c8cb; display:block; margin-bottom:2px;">E-mailadres</span>
            <a href="mailto:<?= h($reservation->email) ?>" style="font-size:14px; color:#c9a84c;"><?= h($reservation->email) ?></a>
        </td>
    </tr>
    <?php if ($reservation->phone): ?>
    <tr>
        <td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.05);">
            <span style="font-size:12px; color:#93c8cb; display:block; margin-bottom:2px;">Telefoon</span>
            <a href="tel:<?= h($reservation->phone) ?>" style="font-size:14px; color:#c9a84c;"><?= h($reservation->phone) ?></a>
        </td>
    </tr>
    <?php endif; ?>
    <?php if ($reservation->note): ?>
    <tr>
        <td style="padding:12px 16px;">
            <span style="font-size:12px; color:#93c8cb; display:block; margin-bottom:2px;">Opmerking</span>
            <span style="font-size:14px; color:#f5f5f0; font-style:italic;"><?= h($reservation->note) ?></span>
        </td>
    </tr>
    <?php endif; ?>
</table>

<!-- Items -->
<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background:#0c2e31; border:1px solid rgba(201,168,76,0.25); border-radius:4px; margin-bottom:24px;">
    <tr>
        <td style="padding:10px 16px; border-bottom:1px solid rgba(201,168,76,0.15);">
            <span style="font-size:11px; text-transform:uppercase; letter-spacing:1.5px; color:#93c8cb;">Gereserveerde platen</span>
        </td>
    </tr>
    <?php foreach ($reservation->reservation_items as $item): ?>
    <tr>
        <td style="padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.05);">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td style="font-size:14px; color:#f5f5f0;">
                        <?php if ($item->artist): ?>
                            <span style="color:#93c8cb; font-size:12px;"><?= h($item->artist) ?></span><br>
                        <?php endif; ?>
                        <strong><?= h($item->name) ?></strong>
                    </td>
                    <td align="right" style="font-size:14px; color:#c9a84c; font-weight:bold; white-space:nowrap; padding-left:12px;">
                        <?php if ($item->price !== null): ?>
                            &euro;&nbsp;<?= h(number_format((float)$item->price, 2, ',', '.')) ?>
                        <?php else: ?>
                            <span style="color:#93c8cb;">Op aanvraag</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php if ($reservation->total !== null): ?>
    <tr>
        <td style="padding:12px 16px;">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td style="font-size:14px; color:#c0dde0; font-weight:bold;">Totaal</td>
                    <td align="right" style="font-size:16px; color:#e6c96a; font-weight:bold;">&euro;&nbsp;<?= h(number_format((float)$reservation->total, 2, ',', '.')) ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <?php endif; ?>
</table>

<p style="margin:0; font-size:13px; color:#93c8cb; text-align:center;">
    Reservering #<?= h($reservation->id) ?> &mdash; ontvangen op <?= h($reservation->created->format('d-m-Y H:i')) ?>
</p>
