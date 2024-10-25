const form = document.querySelector('.login form'),
continueBtn = form.querySelector('.button input'),
errorText = form.querySelector('.error-txt');

let captchaValue = "";

form.onsubmit = (e) => {
    e.preventDefault(); // preventing form from submitting
}

// Captcha
(function() {
    const fonts = ['cursive', 'fantasy', 'monospace', 'sans-serif', 'serif'];

    function generateCaptcha() {
        let value = btoa(Math.random() * 1000000000);
        value = value.substr(0, 4 + Math.random() * 3);
        captchaValue = value;
    }

    function setCaptcha() {
        let html = captchaValue.split('').map((char) => {
            const rotate = -20 + Math.trunc(Math.random() * 30);
            const font = Math.trunc(Math.random() * fonts.length);
            return `<span style="transform:rotate(${rotate}deg);font-family:${fonts[font]}">${char}</span>`;
        }).join('');
        document.querySelector('.form .captcha .preview').innerHTML = html;
    }

    function initCaptcha() {
        document.querySelector('.form .captcha .captcha-refresh')
            .addEventListener('click', function() {
                generateCaptcha();
                setCaptcha();
            });
        generateCaptcha();
        setCaptcha();
    }

    initCaptcha();
})();

continueBtn.onclick = () => {
    let inputCaptchaValue = document.querySelector('.form .captcha .captcha-form input').value;

    // Validate the input captcha value against the generated captcha value
    if (inputCaptchaValue === "") {
        errorText.textContent = "Please enter the captcha.";
        errorText.style.display = "block";
        return; // Stop execution if captcha is not filled
    } else if (inputCaptchaValue !== captchaValue) {
        errorText.textContent = "Invalid captcha.";
        errorText.style.display = "block";
        return; // Stop execution if captcha is incorrect
    }

    // Create XMLHttpRequest object for admin login
    let xhr = new XMLHttpRequest(); // creating XML object
    xhr.open("POST", "db_connection/admin_login_info.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response.trim();
                console.log(data);
                if (data === "success") {
                    location.href = "admin_home.php"; // Redirect to admin home after successful login
                } else {
                    errorText.textContent = data;
                    errorText.style.display = "block";    
                }
            }
        }
    };

    let formData = new FormData(form); // creating new formData object
    xhr.send(formData); // sending form data to PHP
}
