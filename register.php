<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/bar.css">
    <link rel="stylesheet" href="assets/css/form.css">
</head>

<body>
    
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="assets/images/navbar/logo.png" class="navbar-logo">
                <a class="navbar-brand">KIVORIA</a>
                <div class="dropdown ms-4">
                    <label for="language" class="language-label">
                        <span data-translate="Language">Language</span> |
                    </label>
                    <select name="language" id="language" class="language-selector">
                        <option value="en" data-translate="English">English</option>
                        <option value="ko" data-translate="Korean">Korean</option>
                        <option value="zh-CN" data-translate="Chinese">Chinese</option>
                        <option value="ms" data-translate="Malay">Malay</option>
                    </select>
                </div>
            </div>
        </div>
    </nav>

    <!-- Register Container -->
    <div class="register-form">
        <div class="register-form-container">
            <section class="form register">
                <header>Register</header>
                <form action="db_connection/register_info.php" method="POST" enctype="multipart/form-data">
                    <div class="error-txt"></div>
                    <div class="name-details">
                        <div class="field input">
                            <label>First Name</label>
                            <input type="text" name="fname" placeholder="First Name" required>
                        </div>
                        <div class="field input">
                            <label>Last Name</label>
                            <input type="text" name="lname" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="user-details">
                        <div class="field input">
                            <label>Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="field input">
                            <label>Date of Birth</label>
                            <input type="date" name="dob" required>
                        </div>
                        <div class="field input">
                            <label>Country</label>
                            <select id="country" name="country" class="form-select" required>
                                <option value="China">China</option>
                                <option value="Korea">Korea</option>
                                <option value="Japan">Japan</option>
                                <option value="US">US</option>
                                <option value="UK">UK</option>
                                <option value="Malaysia">Malaysia</option>
                            </select>
                        </div>
                    </div>
                    <div class="user-details">
                        <div class="field input">
                            <label>Country Code</label>
                            <select id="country_code" name="country_code" class="form-select" required>
                                <option value="+1">United States (+1)</option>
                                <option value="+44">United Kingdom (+44)</option>
                                <option value="+86">China (+86)</option>
                                <option value="+81">Japan (+81)</option>
                                <option value="+82">South Korea (+82)</option>
                                <option value="+60">Malaysia (+60)</option>
                            </select>
                        </div>
                        <div class="field input">
                            <label>Handphone Number</label>
                            <input type="text" name="handphone" placeholder="Enter your handphone number" required>
                        </div>
                        <div class="field input">
                            <label>Email Address</label>
                            <input type="email" name="email" placeholder="Enter your email" required>
                        </div>
                    </div>
                    <div class="field input">
                        <label>Address</label>
                        <input type="text" name="address" placeholder="Enter your address" required>
                    </div>
                    <div class="address-details">
                        <div class="field input">
                            <label for="postcode">Postcode</label>
                            <input type="text" id="postcode" name="postcode" placeholder="Postcode" required>
                        </div>
                        <div class="field input">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" placeholder="City" required>
                        </div>
                    </div>
                    <div class="password-details">
                        <div class="field input">
                            <label>Password</label>
                            <input type="password" name="password" class="password" placeholder="Enter your password" required>
                            <div class="password-error" style="color: red; font-size: 14px;"></div> <!-- Error message for password -->
                        </div>
                        <div class="field input">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password"  class="confirmPassword" placeholder="Confirm your password" required>
                            <div class="confirm-password-error" style="color: red; font-size: 14px;"></div> <!-- Error message for confirm password -->
                        </div>
                    </div>
                    <div class="field image">
                        <label>Select Image</label>
                        <input type="file" name="image" required>
                    </div>
                    <div class="field button">
                        <button type="button" class="submitButton">Submit</button>
                    </div>
                </form>
                <div class="link">Already signed up? <a href="login.php">Login now</a></div>
            </section>
        </div>
    </div>

</body>
<script src="assets/js/header/language.js"></script>
<script src="assets/js/forms/form.js"></script>
<script src="assets/js/forms/register.js"></script>
</html>
