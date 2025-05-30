@if (session('success') || session('error') || session('info'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @if (session('success'))
                mostrarToast(@json(session('success')), 'success');
            @endif
            @if (session('error'))
                mostrarToast(@json(session('error')), 'error');
            @endif
            @if (session('info'))
                mostrarToast(@json(session('info')), 'info');
            @endif
            });
    </script>
@endif