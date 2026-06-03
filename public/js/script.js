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

    // Login Loading Animation
    const loginForm = document.querySelector('#loginForm');
    const loginBtn = document.querySelector('#loginBtn');
    const loginSpinner = document.querySelector('#loginSpinner');
    const loginText = document.querySelector('#loginText');

    if (loginForm && loginBtn) {
        loginForm.addEventListener('submit', function() {
            // Show spinner and change text immediately
            if (loginSpinner) loginSpinner.classList.remove('d-none');
            if (loginText) loginText.innerText = ' Memproses...';
            
            // Disable button after a very short delay to ensure form data is sent
            setTimeout(() => {
                loginBtn.disabled = true;
            }, 50);
        });
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
