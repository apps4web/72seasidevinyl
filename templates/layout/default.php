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
    <meta name="description" content="72 Seaside Vinyl – Jouw vinyl platenwinkel in Zierikzee. Nieuwe en tweedehands platen, een passioneel team en een warme sfeer.">
    <title>72 Seaside Vinyl<?= $this->fetch('title') ? ' | ' . $this->fetch('title') : '' ?></title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css(['normalize.min', 'seaside']) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>

<header class="site-header">
    <div class="header-inner">
        <a href="<?= $this->Url->build('/') ?>" class="site-logo">
            <span class="logo-record">&#9899;</span>
            <span class="logo-text">72 Seaside Vinyl</span>
        </a>
        <button class="nav-toggle" aria-label="Menu openen" aria-expanded="false">&#9776;</button>
        <nav class="site-nav" id="site-nav">
            <a href="#home">Home</a>
            <a href="#about">Over Ons</a>
            <a href="#releases">Nieuwste Platen</a>
            <a href="#contact">Contact</a>
        </nav>
    </div>
</header>

<main>
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</main>

<footer class="site-footer">
    <div class="footer-inner">
        <p class="footer-brand">72 Seaside Vinyl &mdash; Zierikzee</p>
        <p class="footer-copy">&copy; <?= date('Y') ?> 72 Seaside Vinyl. Alle rechten voorbehouden.</p>
    </div>
</footer>

<script>
    // Mobile navigation toggle
    var toggle = document.querySelector('.nav-toggle');
    var nav = document.getElementById('site-nav');
    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            var open = nav.classList.toggle('open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }
    // Close nav when a link is clicked on mobile
    nav && nav.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            nav.classList.remove('open');
            toggle && toggle.setAttribute('aria-expanded', 'false');
        });
    });
</script>
<?= $this->fetch('script') ?>
</body>
</html>
