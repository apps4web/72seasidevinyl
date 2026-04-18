<?php
/**
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($this->fetch('title')) ?></title>
</head>
<body style="margin:0; padding:0; background:#0c2e31; font-family:Helvetica, Arial, sans-serif; color:#f5f5f0;">
<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background:#0c2e31; padding:24px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width:640px; background:#0e4143; border:1px solid #c9a84c; border-radius:6px; overflow:hidden;">
                <tr>
                    <td align="center" style="padding:24px 20px 14px; background:#0c2e31; border-bottom:1px solid rgba(201,168,76,0.35);">
                        <img src="cid:seaside-logo" alt="72 Seaside Vinyl" width="160" style="display:block; width:160px; height:auto; margin:0 auto 12px;">
                        <div style="font-family:Georgia, 'Times New Roman', serif; color:#e6c96a; font-size:20px; letter-spacing:1px;">72 Seaside Vinyl</div>
                        <div style="color:#93c8cb; font-size:12px; letter-spacing:2px; text-transform:uppercase; margin-top:6px;">Contactformulier</div>
                    </td>
                </tr>
                <tr>
                    <td style="padding:24px 20px;">
                        <?= $this->fetch('content') ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
