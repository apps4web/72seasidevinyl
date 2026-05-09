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
<div class="flash-message flash-message--error" role="alert" onclick="this.classList.add('flash-message--hidden');">
    <i class="fa-solid fa-triangle-exclamation flash-message-icon" aria-hidden="true"></i>
    <span class="flash-message-text"><?= $message ?></span>
    <button type="button" class="flash-message-close" aria-label="Sluiten">&times;</button>
</div>
