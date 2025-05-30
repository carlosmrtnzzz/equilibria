document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const tooltip = document.getElementById('password-tooltip');
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const showPasswordIcon = document.getElementById('showPassword');
    const hidePasswordIcon = document.getElementById('hidePassword');
    const showConfirmPasswordIcon = document.getElementById('showConfirmPassword');
    const hideConfirmPasswordIcon = document.getElementById('hideConfirmPassword');

    if (passwordInput && tooltip) {
        // Mostrar/ocultar tooltip
        passwordInput.addEventListener('focus', () => {
            tooltip.classList.remove('hidden');
            setTimeout(() => {
                tooltip.classList.remove('opacity-0', 'scale-95');
            }, 1);
        });

        passwordInput.addEventListener('blur', () => {
            tooltip.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                tooltip.classList.add('hidden');
            }, 200);
        });

        // Validar contraseña en tiempo real
        passwordInput.addEventListener('input', function () {
            const password = this.value;
            validatePassword(password);
        });
    }

    // Toggle para la contraseña
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', () => togglePasswordVisibility(passwordInput, showPasswordIcon, hidePasswordIcon));
    }

    // Toggle para confirmar contraseña
    if (toggleConfirmPassword) {
        const confirmPasswordInput = document.getElementById('password_confirmation');
        toggleConfirmPassword.addEventListener('click', () => togglePasswordVisibility(confirmPasswordInput, showConfirmPasswordIcon, hideConfirmPasswordIcon));
    }
});

function validatePassword(password) {
    const hasUpperCase = /[A-Z]/.test(password);
    const hasLowerCase = /[a-z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const isLongEnough = password.length >= 8;

    updateCheck('uppercase-check', hasUpperCase);
    updateCheck('lowercase-check', hasLowerCase);
    updateCheck('number-check', hasNumber);
    updateCheck('length-check', isLongEnough);
}

function updateCheck(id, isValid) {
    const element = document.getElementById(id);
    if (element) {
        element.textContent = isValid ? '✓' : '✕';
        element.classList.remove(isValid ? 'text-red-400' : 'text-emerald-400');
        element.classList.add(isValid ? 'text-emerald-400' : 'text-red-400');
    }
}

function togglePasswordVisibility(input, showIcon, hideIcon) {
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    input.setAttribute('type', type);
    showIcon.classList.toggle('hidden');
    hideIcon.classList.toggle('hidden');
}