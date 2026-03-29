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
<div class="message error flex items-center justify-between rounded-sm border border-[#D34053] bg-[#FFE8EA] py-3 px-4 mb-4 text-sm text-[#D34053]" onclick="this.classList.add('hidden');" role="alert">
    <span><?= $message ?></span>
    <button class="ml-4 text-lg font-bold leading-none opacity-60 hover:opacity-100">&times;</button>
</div>
