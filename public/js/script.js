// public/js/script.js
document.addEventListener('DOMContentLoaded', function() {
    // Cari semua tombol toggle password (untuk mendukung multiple field jika ada)
    const toggleButtons = document.querySelectorAll('[id^="togglePassword"]');
    
    toggleButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Cari input password yang berada dalam satu group (input-group)
            const inputGroup = this.closest('.input-group');
            const passwordInput = inputGroup.querySelector('input');
            const eyeIcon = this.querySelector('i');

            if (passwordInput && eyeIcon) {
                // Toggle tipe input
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                
                // Toggle class icon
                eyeIcon.classList.toggle('bi-eye');
                eyeIcon.classList.toggle('bi-eye-slash');
            }
        });
    });
});
