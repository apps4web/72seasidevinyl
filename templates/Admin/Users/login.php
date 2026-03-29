<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Admin Login');
$this->Html->script('admin-login', ['block' => 'scriptBottom']);
?>

<div class="mx-auto w-full max-w-sm">
    <span class="inline-flex items-center rounded-full bg-[#EEF2FF] px-3 py-1 text-xs font-medium text-primary">Admin Area</span>
    <h2 class="mt-4 text-3xl font-bold text-body-dark">Sign In</h2>
    <p class="mt-2 text-sm text-gray-4">Use your administrator account to continue.</p>

    <div class="mt-6">
        <?= $this->Flash->render() ?>
    </div>

    <?= $this->Form->create(null, ['class' => 'mt-6 space-y-5']) ?>

    <div>
        <label class="mb-2.5 block text-sm font-medium text-body-dark">Username</label>
        <?= $this->Form->control('username', [
            'label' => false,
            'required' => true,
            'placeholder' => 'Enter your username',
            'class' => 'w-full rounded border border-stroke bg-gray-1 py-3 px-5 text-sm font-medium text-body-dark outline-none transition focus:border-primary',
        ]) ?>
    </div>

    <div>
        <label class="mb-2.5 block text-sm font-medium text-body-dark">Password</label>
        <div style="position: relative;">
            <?= $this->Form->control('password', [
                'label' => false,
                'required' => true,
                'placeholder' => 'Enter your password',
                'class' => 'w-full rounded border border-stroke bg-gray-1 py-3 px-5 pr-12 text-sm font-medium text-body-dark outline-none transition focus:border-primary',
            ]) ?>
            <button
                type="button"
                data-password-toggle
                aria-label="Show password"
                aria-pressed="false"
                style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); color: #64748b; background: transparent; border: 0; padding: 0; line-height: 1; cursor: pointer;"
            >
                <i class="fa-light fa-eye" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <div class="pt-4">
        <?= $this->Form->button('Sign In to Dashboard', [
            'class' => 'inline-flex w-full items-center justify-center gap-2 rounded bg-primary py-3 px-5 text-sm font-medium text-white hover:bg-opacity-90',
        ]) ?>
    </div>

    <?= $this->Form->end() ?>
</div>
