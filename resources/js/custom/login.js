document.addEventListener("DOMContentLoaded", function() {
    const loginText = document.querySelector(".title-text .login");
    const signupText = document.querySelector(".title-text .signup");
    const loginForm = document.querySelector("form.login");
    const signupForm = document.querySelector("form.signup");
    const loginBtn = document.querySelector("label.login");
    const signupBtn = document.querySelector("label.signup");
    const signupLink = document.querySelector("form .signup-link a");

    if (document.querySelector("input#login").checked) {
        loginForm.classList.remove('hidden');
        signupForm.classList.add('hidden');
    } else {
        loginForm.classList.add('hidden');
        signupForm.classList.remove('hidden');
    }

    signupBtn.onclick = () => {
        loginForm.classList.add('hidden');
        signupForm.classList.remove('hidden');
        loginText.classList.remove('active');
        signupText.classList.add('active');
    };

    loginBtn.onclick = () => {
        loginForm.classList.remove('hidden');
        signupForm.classList.add('hidden');
        loginText.classList.add('active');
        signupText.classList.remove('active');
    };

    signupLink.onclick = () => {
        signupBtn.click();
        return false;
    };
});
