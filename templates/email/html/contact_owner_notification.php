<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, mixed> $contact
 * @var \Cake\I18n\FrozenTime $submittedAt
 */
?>
<?php $this->assign('title', 'Nieuw contactbericht'); ?>
<h1 style="margin:0 0 14px; font-family:Georgia, 'Times New Roman', serif; font-size:28px; color:#e6c96a; line-height:1.2;">Nieuw contactbericht</h1>
<p style="margin:0 0 18px; color:#93c8cb;">Er is een nieuw bericht verzonden via het contactformulier op de website.</p>

<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="border-collapse:collapse; background:#155f64; border:1px solid rgba(201,168,76,0.25);">
    <tr>
        <td style="padding:10px 12px; width:130px; color:#93c8cb; border-bottom:1px solid rgba(201,168,76,0.2);">Naam</td>
        <td style="padding:10px 12px; color:#f5f5f0; border-bottom:1px solid rgba(201,168,76,0.2);"><?= h((string)($contact['name'] ?? '')) ?></td>
    </tr>
    <tr>
        <td style="padding:10px 12px; width:130px; color:#93c8cb; border-bottom:1px solid rgba(201,168,76,0.2);">E-mail</td>
        <td style="padding:10px 12px; color:#f5f5f0; border-bottom:1px solid rgba(201,168,76,0.2);"><?= h((string)($contact['email'] ?? '')) ?></td>
    </tr>
    <tr>
        <td style="padding:10px 12px; width:130px; color:#93c8cb; border-bottom:1px solid rgba(201,168,76,0.2);">Verzonden</td>
        <td style="padding:10px 12px; color:#f5f5f0; border-bottom:1px solid rgba(201,168,76,0.2);"><?= h($submittedAt->i18nFormat('yyyy-MM-dd HH:mm:ss')) ?></td>
    </tr>
    <tr>
        <td style="padding:12px; width:130px; color:#93c8cb; vertical-align:top;">Bericht</td>
        <td style="padding:12px; color:#f5f5f0; white-space:pre-line;"><?= nl2br(h((string)($contact['message'] ?? ''))) ?></td>
    </tr>
</table>
