const form = document.querySelector('.register form'),
      continueBtn = form.querySelector('.submitButton'),
      errorText = form.querySelector('.error-txt'),
      passwordField = document.querySelector('.password'),
      confirmPasswordField = document.querySelector('.confirmPassword'),
      passwordError = document.querySelector('.password-error'),
      confirmPasswordError = document.querySelector('.confirm-password-error');

form.onsubmit = (e) => {
    e.preventDefault(); // Prevent form from submitting until validation is done
}

continueBtn.onclick = () => {
    // Get values from the form
    const password = passwordField.value;
    const confirmPassword = confirmPasswordField.value;
    const fields = form.querySelectorAll('input[required], select[required]'); // All required fields

    // Reset error messages
    passwordError.textContent = '';
    confirmPasswordError.textContent = '';

    // Check if all required fields are filled
    let allFieldsFilled = true;
    fields.forEach(field => {
        if (field.value === "") {
            allFieldsFilled = false;
            errorText.textContent = "Please fill all the fields";
            errorText.style.display = "block";
        }
    });

    if (!allFieldsFilled) return; // Stop execution if not all fields are filled

    // Validate password matching
    if (password !== confirmPassword) {
        confirmPasswordError.textContent = "Passwords do not match";
        return; // Stop execution if passwords do not match
    }

    // Password validation rules
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;
    
    if (!passwordRegex.test(password)) {
        passwordError.textContent = "Password must be at least 8 characters, include uppercase, lowercase, number, and special character.";
        return; // Stop execution if password doesn't meet requirements
    }

    // If everything is fine, send the form data
    let xhr = new XMLHttpRequest(); // Creating XML object
    xhr.open("POST", "db_connection/admin_register_info.php", true); // Change the action to admin_register_info.php
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response.trim();
                if(data === "success"){
                    location.href = "admin_home.php"; // Redirect to admin home page on success
                } else {
                    errorText.textContent = data; // Display error message
                    errorText.style.display = "block";    
                }
            }
        }
    }
    
    let formData = new FormData(form); // Creating new formData object
    xhr.send(formData); // Sending form data to php    
}

// Live feedback for password validation as the user types
passwordField.oninput = () => {
    const password = passwordField.value;

    // Password validation rules
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;

    if (!passwordRegex.test(password)) {
        passwordError.textContent = "Password must be at least 8 characters, include uppercase, lowercase, number, and special character.";
    } else {
        passwordError.textContent = ''; // Clear the error if password is valid
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
