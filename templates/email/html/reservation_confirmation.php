<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reservation $reservation
 */
?>
<p style="margin:0 0 20px; font-size:16px; color:#f5f5f0; line-height:1.6;">
    Beste <?= h($reservation->name) ?>,
</p>

<p style="margin:0 0 24px; font-size:15px; color:#c0dde0; line-height:1.7;">
    Bedankt voor uw reservering bij 72 Seaside Vinyl! Wij nemen zo spoedig mogelijk contact met u op via
    <span style="color:#e6c96a;"><?= h($reservation->email) ?></span>
    om een afhaaltijd af te spreken.
</p>

<!-- Order summary -->
<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background:#0c2e31; border:1px solid rgba(201,168,76,0.25); border-radius:4px; margin-bottom:24px;">
    <tr>
        <td style="padding:12px 16px; border-bottom:1px solid rgba(201,168,76,0.2);">
            <span style="font-size:11px; text-transform:uppercase; letter-spacing:1.5px; color:#93c8cb;">Uw reservering</span>
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

<!-- Pickup info -->
<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background:rgba(201,168,76,0.08); border-left:3px solid #c9a84c; border-radius:0 4px 4px 0; margin-bottom:24px;">
    <tr>
        <td style="padding:14px 16px;">
            <p style="margin:0 0 6px; font-size:13px; font-weight:bold; color:#e6c96a; text-transform:uppercase; letter-spacing:1px;">Ophalen in de winkel</p>
            <p style="margin:0; font-size:14px; color:#c0dde0; line-height:1.6;">
                Sint Domusstraat 17, Zierikzee<br>
                Betaling bij afhalen. Wij bevestigen een afhaaltijd via e-mail of telefoon.
            </p>
        </td>
    </tr>
</table>

<?php if ($reservation->note): ?>
<p style="margin:0 0 24px; font-size:13px; color:#93c8cb; font-style:italic;">
    Uw opmerking: &ldquo;<?= h($reservation->note) ?>&rdquo;
</p>
<?php endif; ?>

<p style="margin:0; font-size:14px; color:#c0dde0; line-height:1.7;">
    Met vriendelijke groet,<br>
    <strong style="color:#f5f5f0;">72 Seaside Vinyl</strong>
</p>
