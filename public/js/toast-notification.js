    function mostrarToast(mensaje) {
        const toast = document.getElementById('toast-success');
        toast.textContent = mensaje;
        toast.style.right = '1.25rem';
        toast.style.opacity = '1';

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.right = '-100%';
            setTimeout(() => toast.textContent = '', 500);
        }, 4000);
    }