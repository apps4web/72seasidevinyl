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

    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary:   '#3C50E0',
                        secondary: '#80CAEE',
                        'body-dark': '#1C2434',
                        'sidebar':   '#1C2434',
                        'sidebar-hover': '#333A48',
                        'bodydark':  '#AEB7C0',
                        'bodydark1': '#DEE4EE',
                        'bodydark2': '#8A99AF',
                        stroke:     '#E2E8F0',
                        'gray-1':   '#F9FAFB',
                        'gray-2':   '#F3F4F6',
                        'gray-3':   '#E5E7EB',
                        'gray-4':   '#6B7280',
                        success:    '#219653',
                        warning:    '#FFA70B',
                        danger:     '#D34053',
                        'danger-light': '#FFE8EA',
                        'success-light': '#E1F4EB',
                        'warning-light': '#FFF5D9',
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
                    },
                }
            }
        }
    </script>

    <!-- Alpine.js for interactive sidebar/dropdowns -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>

    <style>
        [x-cloak] { display: none !important; }
        .sidebar-menu-item.active > a {
            background-color: #3C50E0;
            color: #ffffff;
        }
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
            <span class="text-2xl">&#9899;</span>
            <div>
                <span class="block text-lg font-bold text-white leading-tight">72 Seaside</span>
                <span class="block text-xs text-bodydark2 leading-tight">Vinyl &mdash; Admin</span>
            </div>
        </a>
        <!-- Close button (mobile) -->
        <button @click="sidebarOpen = false" class="block lg:hidden text-bodydark">
            <svg class="w-5 h-5 fill-current" viewBox="0 0 320 512">
                <path d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"/>
            </svg>
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
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 512 512">
                                <path d="M0 0h192v192H0zm0 0M320 0h192v192H320zm0 0M0 320h192v192H0zm0 0" opacity=".3"/>
                                <path d="M320 320h192v192H320zm0 0"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>

                    <!-- Releases -->
                    <li class="sidebar-menu-item <?= $this->request->getParam('controller') === 'Releases' ? 'active' : '' ?>">
                        <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Releases', 'action' => 'index']) ?>"
                           class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-sidebar-hover">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 512 512">
                                <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm0-384c-101.7 0-184 82.3-184 184S154.3 440 256 440s184-82.3 184-184S357.7 72 256 72zm0 328c-79.4 0-144-64.6-144-144S176.6 112 256 112s144 64.6 144 144-64.6 144-144 144zm0-232c-48.6 0-88 39.4-88 88s39.4 88 88 88 88-39.4 88-88-39.4-88-88-88zm0 128c-22.1 0-40-17.9-40-40s17.9-40 40-40 40 17.9 40 40-17.9 40-40 40z"/>
                            </svg>
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
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 512 512">
                                <path d="M432 320H400a16 16 0 0 0-16 16V448H64V128H208a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16H48A48 48 0 0 0 0 112V464a48 48 0 0 0 48 48H400a48 48 0 0 0 48-48V336A16 16 0 0 0 432 320ZM488 0h-128c-21.4 0-32.1 25.9-17 41l35.7 35.7L135 320.4a24 24 0 0 0 0 34L157 356a24 24 0 0 0 34 0L435.3 133.3 471 169c15 15 41 4.5 41-17V24A24 24 0 0 0 488 0Z"/>
                            </svg>
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
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 512 512">
                        <path d="M32 96h448a32 32 0 0 0 0-64H32a32 32 0 0 0 0 64zm448 128H32a32 32 0 0 0 0 64h448a32 32 0 0 0 0-64zm0 192H32a32 32 0 0 0 0 64h448a32 32 0 0 0 0-64z"/>
                    </svg>
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

<?= $this->fetch('script') ?>
</body>
</html>
