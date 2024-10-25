const form = document.querySelector('.forgot-password form'),
      continueBtn = form.querySelector('input[type="submit"]'),
      errorText = form.querySelector('.new-password-error'),
      passwordField = form.querySelector('.reset-password'),
      confirmPasswordField = form.querySelector('.confirm-reset-Password'),
      confirmPasswordError = document.querySelector('.confirm-new-password-error');

// Prevent form submission until validation is complete
form.onsubmit = (e) => {
    e.preventDefault();
}

continueBtn.onclick = () => {
    const password = passwordField.value;
    const confirmPassword = confirmPasswordField.value;

    // Reset error messages
    errorText.textContent = '';
    confirmPasswordError.textContent = '';

    // Validate password matching
    if (password !== confirmPassword) {
        confirmPasswordError.textContent = "Passwords do not match";
        return; // Stop if passwords don't match
    }

    // Password validation rules
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;
    
    if (!passwordRegex.test(password)) {
        errorText.textContent = "Password must be at least 8 characters, include uppercase, lowercase, number, and special character.";
        return; // Stop if password doesn't meet requirements
    }

    // If everything is fine, send the form data
    let xhr = new XMLHttpRequest(); // Create XMLHttpRequest object
    xhr.open("POST", "db_connection/admin_reset_password.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response.trim();
                if(data === "success"){
                    location.href = "admin_login.php"; // Redirect on success
                } else {
                    errorText.textContent = data; // Display error message
                    errorText.style.display = "block";    
                }
            }
        }
    }

    let formData = new FormData(form); // Create new FormData object
    xhr.send(formData); // Send form data to PHP
}

// Live feedback for password validation
passwordField.oninput = () => {
    const password = passwordField.value;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;

    if (!passwordRegex.test(password)) {
        errorText.textContent = "Password must be at least 8 characters, include uppercase, lowercase, number, and special character.";
    } else {
        errorText.textContent = ''; // Clear the error if password is valid
    }
}

confirmPasswordField.oninput = () => {
    const password = passwordField.value;
    const confirmPassword = confirmPasswordField.value;

    if (password !== confirmPassword) {
        confirmPasswordError.textContent = "Passwords do not match";
    } else {
        confirmPasswordError.textContent = ''; // Clear the error if passwords match
    }
}
