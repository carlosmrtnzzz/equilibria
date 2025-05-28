@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            mostrarToast(@json(session('success')), 'success');
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            mostrarToast(@json(session('error')), 'error');
        });
    </script>
@endif

@if (session('info'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            mostrarToast(@json(session('info')), 'info');
        });
    </script>
@endif
