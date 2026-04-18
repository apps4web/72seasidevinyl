Nieuw contactbericht via 72 Seaside Vinyl

Naam: <?= (string)($contact['name'] ?? '') ?>
E-mail: <?= (string)($contact['email'] ?? '') ?>
Verzonden: <?= $submittedAt->i18nFormat('yyyy-MM-dd HH:mm:ss') ?>

Bericht:
<?= (string)($contact['message'] ?? '') ?>
