document.addEventListener('DOMContentLoaded', function () {
    var toggleButton = document.querySelector('[data-password-toggle]');
    var passwordInput = document.getElementById('password');

    if (!toggleButton || !passwordInput) {
        return;
    }

    var icon = toggleButton.querySelector('i');

    toggleButton.addEventListener('click', function () {
        var isPasswordVisible = passwordInput.type === 'text';

        passwordInput.type = isPasswordVisible ? 'password' : 'text';
        toggleButton.setAttribute('aria-label', isPasswordVisible ? 'Show password' : 'Hide password');
        toggleButton.setAttribute('aria-pressed', isPasswordVisible ? 'false' : 'true');

        if (icon) {
            icon.className = isPasswordVisible ? 'fa-light fa-eye' : 'fa-light fa-eye-slash';
        }
    });
});