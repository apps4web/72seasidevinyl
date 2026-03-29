<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Admin Login');
?>

<div class="mx-auto mt-16 max-w-md rounded-lg border border-stroke bg-white p-8 shadow-default">
    <h1 class="mb-2 text-2xl font-bold text-body-dark">CMS Login</h1>
    <p class="mb-6 text-sm text-gray-4">Sign in to access the admin dashboard.</p>

    <?= $this->Form->create(null, ['class' => 'space-y-5']) ?>

    <div>
        <label class="mb-2 block text-sm font-medium text-body-dark">Username</label>
        <?= $this->Form->control('username', [
            'label' => false,
            'required' => true,
            'class' => 'w-full rounded border border-stroke bg-gray-1 px-4 py-3 text-sm outline-none focus:border-primary',
        ]) ?>
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-body-dark">Password</label>
        <?= $this->Form->control('password', [
            'label' => false,
            'required' => true,
            'class' => 'w-full rounded border border-stroke bg-gray-1 px-4 py-3 text-sm outline-none focus:border-primary',
        ]) ?>
    </div>

    <?= $this->Form->button('Sign In', [
        'class' => 'w-full rounded bg-primary px-4 py-3 text-sm font-medium text-white hover:bg-opacity-90',
    ]) ?>

    <?= $this->Form->end() ?>
</div>
