document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll(".input-group-text").forEach((eyeIcon) => {
        eyeIcon.addEventListener('click', function() {

            let passwordInput = this.parentElement.querySelector('input');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.querySelector('i').classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                passwordInput.type = 'password';
                this.querySelector('i').classList.replace('bi-eye', 'bi-eye-slash');
            }
        });
    });
});
