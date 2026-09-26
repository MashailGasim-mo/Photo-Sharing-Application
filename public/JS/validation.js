document.addEventListener('DOMContentLoaded', function () {
    const registerForm = document.getElementById('registerForm');
    const loginForm = document.getElementById('loginForm');

    if (registerForm) {
        registerForm.addEventListener('submit', function (event) {
            const firstName = registerForm.querySelector('[name="first_name"]');
            const lastName = registerForm.querySelector('[name="last_name"]');
            const email = registerForm.querySelector('[name="email"]');
            const password = registerForm.querySelector('[name="password"]');

            if (
                firstName.value.trim().length < 2 ||
                lastName.value.trim().length < 2 ||
                !email.value.includes('@') ||
                password.value.length < 8
            ) {
                event.preventDefault();
                alert('يرجى إدخال البيانات المطلوبة بشكل صحيح.');
            }
        });
    }

    if (loginForm) {
        loginForm.addEventListener('submit', function (event) {
            const email = loginForm.querySelector('[name="email"]');
            const password = loginForm.querySelector('[name="password"]');

            if (
                !email.value.includes('@') ||
                password.value.trim() === ''
            ) {
                event.preventDefault();
                alert('يرجى إدخال البريد الإلكتروني وكلمة المرور.');
            }
        });
    }
});