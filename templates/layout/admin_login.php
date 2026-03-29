<?php
/**
 * TailAdmin-style layout for admin authentication pages.
 *
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>72 Seaside Vinyl - Admin<?= $this->fetch('title') ? ' | ' . $this->fetch('title') : '' ?></title>
    <?= $this->Html->meta('icon') ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <?= $this->Html->css('admin') ?>
    <?= $this->Html->css('all.min') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body class="bg-[#F1F5F9] font-sans antialiased">
    <main class="min-h-screen flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-5xl grid grid-cols-1 overflow-hidden rounded-sm border border-stroke bg-white shadow-default lg:grid-cols-2">
            <div class="hidden lg:flex flex-col justify-between bg-sidebar p-10 text-bodydark1">
                <div>
                    <a href="<?= $this->Url->build('/') ?>" class="inline-flex items-center gap-3">
                        <img src="<?= $this->Url->image('logo-72-seaside-vinyl.png') ?>" alt="72 Seaside Vinyl" class="h-12 w-auto object-contain">
                    </a>
                    <h1 class="mt-10 text-3xl font-semibold text-white leading-tight">Welcome back to your CMS</h1>
                    <p class="mt-4 text-sm text-bodydark2">Sign in to manage releases, artists, and your storefront content.</p>
                </div>
                <p class="text-xs text-bodydark2">72 Seaside Vinyl - Zierikzee</p>
            </div>

            <section class="p-7 sm:p-10">
                <?= $this->fetch('content') ?>
            </section>
        </div>
    </main>

    <?= $this->fetch('scriptBottom') ?>
    <?= $this->fetch('script') ?>
</body>
</html>
