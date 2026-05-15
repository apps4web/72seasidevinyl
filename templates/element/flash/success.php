<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div
    role="status"
    x-data="{ show: true }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-x-4"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 translate-x-4"
    x-init="setTimeout(() => show = false, 5000)"
    class="flash-message flash-message--success flex items-start gap-3 rounded-lg border-l-4 border-success bg-success-light px-4 py-3 shadow-lg w-80"
>
    <i class="flash-message-icon fa-solid fa-circle-check text-success text-base mt-0.5 flex-shrink-0" aria-hidden="true"></i>
    <span class="flash-message-text text-sm font-medium text-body-dark flex-1"><?= $message ?></span>
    <button type="button" @click="show = false" class="flash-message-close text-gray-4 hover:text-body-dark flex-shrink-0 text-xl leading-none -mt-0.5" aria-label="Sluiten">&times;</button>
</div>
