<?php
/**
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="72 Seaside Vinyl is een platenwinkel voor liefhebbers van vinylplaten, lp&rsquo;s en muziek. Ontdek klassieke albums, nieuwe vinyl releases en bijzondere platen voor verzamelaars.">
    <title>72 Seaside vinyl plantenwinkel Zierikzee<?= $this->fetch('title') ? ' | ' . $this->fetch('title') : '' ?></title>
    <link rel="icon" type="image/svg+xml" href="<?= $this->Url->assetUrl('favicon.svg') ?>">
    <link rel="alternate icon" href="<?= $this->Url->assetUrl('favicon.ico') ?>">
    <?= $this->Html->css(['normalize.min', 'seaside', 'all.min']) ?>
    <?php $this->Html->script('https://code.jquery.com/jquery-3.7.1.min.js', ['block' => 'scriptBottom']); ?>
    <?php $this->Html->script('site', ['block' => 'scriptBottom']); ?>
    <?= $this->fetch('meta') ?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-H2R30EN9F0"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-H2R30EN9F0');
    </script>
    <?= $this->fetch('css') ?>
</head>
<body>
<?php $onePagerBaseUrl = $this->Url->build('/'); ?>

<header class="site-header">
    <div class="header-inner">
        <a href="<?= $this->Url->build('/') ?>" class="site-logo">
            <?= $this->Html->image('logo-72-seaside-vinyl.png', ['alt' => '72 Seaside Vinyl', 'class' => 'logo-img']) ?>
        </a>
        <button class="nav-toggle" aria-label="Menu openen" aria-expanded="false">&#9776;</button>
        <nav class="site-nav" id="site-nav">
            <a href="<?= $onePagerBaseUrl ?>#home">Home</a>
            <a href="<?= $onePagerBaseUrl ?>#about">Over Ons</a>
            <a href="<?= $onePagerBaseUrl ?>#releases">New Releases</a>
            <a href="<?= $onePagerBaseUrl ?>#contact">Contact</a>
            <?php
            $basketItems = (array)($this->request->getSession()->read('Basket') ?? []);
            $basketCount = count($basketItems);
            ?>
            <a href="<?= $this->Url->build(['controller' => 'Basket', 'action' => 'view']) ?>" class="basket-nav-link" aria-label="Winkelwagen (<?= $basketCount ?> <?= $basketCount === 1 ? 'item' : 'items' ?>)">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <?php if ($basketCount > 0): ?>
                    <span class="basket-count-badge"><?= $basketCount ?></span>
                <?php endif; ?>
            </a>
        </nav>
    </div>
</header>

<main>
    <?= $this->fetch('content') ?>
</main>

<footer class="site-footer">
    <div class="footer-inner">
        <p class="footer-brand">72 Seaside Vinyl &mdash; Zierikzee</p>
        <p class="footer-copy">&copy; <?= date('Y') ?> 72 Seaside Vinyl. Alle rechten voorbehouden.</p>
    </div>
</footer>
<?= $this->fetch('scriptBottom') ?>
<?= $this->fetch('script') ?>
</body>
</html>
