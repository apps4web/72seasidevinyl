<?php
/**
 * Admin layout using TailAdmin design.
 *
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>72 Seaside Vinyl – Admin<?= $this->fetch('title') ? ' | ' . $this->fetch('title') : '' ?></title>
    <?= $this->Html->meta('icon') ?>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- TailAdmin compiled CSS (built from resources/css/admin.css via npm run build:css) -->
    <?= $this->Html->css('admin') ?>
    <!-- Font Awesome Pro -->
    <?= $this->Html->css('all.min') ?>
    <?php $this->Html->script('https://code.jquery.com/jquery-3.7.1.min.js', ['block' => 'scriptBottom']); ?>

    <!-- Alpine.js for interactive sidebar/dropdowns -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#F1F5F9] font-sans antialiased" x-data="{ sidebarOpen: false }">

<!-- ============================================================
     SIDEBAR
     ============================================================ -->
<aside
    class="fixed left-0 top-0 z-50 flex h-screen w-64 flex-col overflow-y-hidden bg-sidebar duration-300 ease-linear lg:translate-x-0"
    :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }"
>
    <!-- Sidebar header / logo -->
    <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6">
        <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Dashboard', 'action' => 'index']) ?>"
           class="flex items-center gap-3">
            <img src="<?= $this->Url->image('logo-72-seaside-vinyl.png') ?>"
                 alt="72 Seaside Vinyl"
                 class="h-10 w-auto object-contain">
        </a>
        <!-- Close button (mobile) -->
        <button @click="sidebarOpen = false" class="block lg:hidden text-bodydark">
            <i class="fa-solid fa-xmark w-5 h-5"></i>
        </button>
    </div>

    <!-- Sidebar navigation -->
    <div class="flex flex-col overflow-y-auto duration-300 ease-linear">
        <nav class="mt-4 px-4 py-4">
            <!-- Menu label -->
            <div>
                <h3 class="mb-4 ml-4 text-sm font-semibold text-bodydark2 uppercase tracking-widest">Menu</h3>
                <ul class="mb-6 flex flex-col gap-1.5">

                    <!-- Dashboard -->
                    <li class="sidebar-menu-item <?= $this->request->getParam('controller') === 'Dashboard' ? 'active' : '' ?>">
                        <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Dashboard', 'action' => 'index']) ?>"
                           class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-sidebar-hover">
                            <i class="fa-solid fa-gauge-high w-5 text-center"></i>
                            Dashboard
                        </a>
                    </li>

                    <!-- Records -->
                    <li class="sidebar-menu-item <?= $this->request->getParam('controller') === 'Records' ? 'active' : '' ?>">
                        <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'Records', 'action' => 'index']) ?>"
                           class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-sidebar-hover">
                            <i class="fa-solid fa-compact-disc w-5 text-center"></i>
                            Records
                        </a>
                    </li>

                    <!-- Releases -->
                    <li class="sidebar-menu-item <?= $this->request->getParam('controller') === 'Releases' ? 'active' : '' ?>">
                        <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Releases', 'action' => 'index']) ?>"
                           class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-sidebar-hover">
                            <i class="fa-solid fa-record-vinyl w-5 text-center"></i>
                            Vinyl Releases
                        </a>
                    </li>

                </ul>
            </div>

            <!-- Other -->
            <div>
                <h3 class="mb-4 ml-4 text-sm font-semibold text-bodydark2 uppercase tracking-widest">Other</h3>
                <ul class="mb-6 flex flex-col gap-1.5">

                    <!-- View website -->
                    <li class="sidebar-menu-item">
                        <a href="<?= $this->Url->build('/') ?>"
                           target="_blank"
                           class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-sidebar-hover">
                            <i class="fa-solid fa-arrow-up-right-from-square w-5 text-center"></i>
                            View Website
                        </a>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</aside>
<!-- END SIDEBAR -->

<!-- ============================================================
     MAIN CONTENT AREA
     ============================================================ -->
<div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden lg:ml-64">

    <!-- Top header bar -->
    <header class="sticky top-0 z-40 flex w-full bg-white shadow-md">
        <div class="flex flex-grow items-center justify-between px-4 py-4 shadow-2 md:px-6 2xl:px-11">

            <!-- Hamburger / mobile sidebar toggle -->
            <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
                <button @click="sidebarOpen = !sidebarOpen"
                        class="block rounded-sm border border-stroke bg-white p-1.5 shadow-sm">
                    <i class="fa-solid fa-bars w-5 h-5 text-center"></i>
                </button>
            </div>

            <!-- Breadcrumb / page title -->
            <div class="hidden sm:block">
                <nav>
                    <ol class="flex items-center gap-2">
                        <li>
                            <a class="font-medium text-gray-4 hover:text-primary" href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Dashboard', 'action' => 'index']) ?>">Admin /</a>
                        </li>
                        <?php if ($this->fetch('title')): ?>
                        <li class="font-medium text-primary"><?= h($this->fetch('title')) ?></li>
                        <?php endif; ?>
                    </ol>
                </nav>
            </div>

            <!-- Right side: flash messages indicator + user info -->
            <div class="flex items-center gap-3 2xsm:gap-7">
                <?= $this->Form->postLink(
                    'Logout',
                    ['prefix' => 'Admin', 'controller' => 'Users', 'action' => 'logout'],
                    ['class' => 'text-sm font-medium text-gray-4 hover:text-primary']
                ) ?>
                <div class="flex items-center gap-2">
                    <span class="hidden sm:block text-sm font-medium text-body-dark">72 Seaside Vinyl</span>
                    <span class="h-8 w-8 rounded-full bg-primary flex items-center justify-center text-white font-bold text-sm">72</span>
                </div>
            </div>

        </div>
    </header>
    <!-- END header -->

    <!-- Page content -->
    <main class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>

</div>
<!-- END main content area -->

<?= $this->fetch('scriptBottom') ?>
<?= $this->fetch('script') ?>
</body>
</html>
