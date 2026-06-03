// public/js/script.js
document.addEventListener('DOMContentLoaded', function() {
    // Password Toggle Logic
    const toggleButtons = document.querySelectorAll('[id^="togglePassword"]');
    toggleButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const inputGroup = this.closest('.input-group');
            const passwordInput = inputGroup.querySelector('input');
            const eyeIcon = this.querySelector('i');
            if (passwordInput && eyeIcon) {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                eyeIcon.classList.toggle('bi-eye');
                eyeIcon.classList.toggle('bi-eye-slash');
            }
        });
    });

    // Sidebar & Overlay Logic
    const sidebarCollapse = document.querySelector('#sidebarCollapse');
    const sidebar = document.querySelector('#sidebar');
    const overlay = document.querySelector('.overlay');

    function toggleSidebar() {
        sidebar.classList.toggle('active');
        if (window.innerWidth <= 768) {
            overlay.classList.toggle('active');
        }
    }

    if (sidebarCollapse && sidebar && overlay) {
        sidebarCollapse.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
    }

    // Auto-hide sidebar on window resize if needed
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            if (sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
            if (overlay.classList.contains('active')) {
                overlay.classList.remove('active');
            }
        }
    });
});
