const form = document.querySelector('.login form');
const continueBtn = form.querySelector('.button input');
const errorText = form.querySelector('.error-txt');
let captchaValue = "";

form.onsubmit = (e) => {
    e.preventDefault(); // Prevent form from submitting
}

// Captcha generation and validation
(function() {
    const fonts = ['cursive', 'fantasy', 'monospace', 'sans-serif', 'serif'];

    function generateCaptcha() {
        // Generate a 4-digit numeric captcha
        let value = Math.floor(1000 + Math.random() * 9000).toString();
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

    if (inputCaptchaValue === "") {
        errorText.textContent = "Please enter the captcha.";
        errorText.style.display = "block";
        return;
    } else if (inputCaptchaValue !== captchaValue) {
        errorText.textContent = "Invalid captcha.";
        errorText.style.display = "block";
        return;
    }

    // Send login data via AJAX
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "db_connection/login_info.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response.trim();
                if (data == "success") {
                    location.href = "home.php";
                } else {
                    errorText.textContent = data;
                    errorText.style.display = "block";
                }
            }
        }
    };
    let formData = new FormData(form);
    xhr.send(formData);
}
