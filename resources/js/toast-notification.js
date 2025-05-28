function mostrarToast(mensaje, tipo = 'success') {
    const colores = {
        success: 'bg-green-500/90 border-green-400/30',
        error: 'bg-red-500/90 border-red-400/30',
        info: 'bg-blue-500/90 border-blue-400/30'
    };

    const iconos = {
        success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>',
        error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>',
        info: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/>
`
    };

    const anterior = document.getElementById('toast');
    if (anterior) anterior.remove();

    const toast = document.createElement('div');
    toast.id = 'toast';
    toast.className = `fixed top-33 right-[-100%] z-[9999] text-white px-6 py-4 rounded-2xl shadow-2xl transition-all duration-500 ease-out flex items-center gap-3 ${colores[tipo]}`;
    toast.innerHTML = `
        <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${iconos[tipo]}
            </svg>
        </div>
        <span class="font-medium">${mensaje}</span>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.right = '1.25rem';
    }, 100);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.right = '-100%';
        setTimeout(() => toast.remove(), 500);
    }, 4000);
}

window.mostrarToast = mostrarToast;