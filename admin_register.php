<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>
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
                <h5 class="navbar-admin">Admin</h5>
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

    <!-- Admin Register Container -->
    <div class="register-admin-form">
        <div class="register-form-container">
            <section class="form register">
                <header data-translate="Admin Register">Admin Register</header>
                <form action="db_connection/admin_register_info.php" method="POST" enctype="multipart/form-data">
                    <div class="error-txt"></div>
                    <div class="name-details">
                        <div class="field input">
                            <label data-translate="First Name">First Name</label>
                            <input type="text" name="fname" placeholder="First Name" required>
                        </div>
                        <div class="field input">
                            <label data-translate="Last Name">Last Name</label>
                            <input type="text" name="lname" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="field input">
                        <label data-translate="Gender">Gender</label>
                        <select name="gender" class="form-select" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="field input">
                        <label data-translate="Email Address">Email Address</label>
                        <input type="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="field input">
                        <label data-translate="Admin Work Code">Admin Work Code</label>
                        <input type="text" name="admin_work_code" placeholder="Enter your admin work code" required>
                    </div>
                    <div class="field image">
                        <label data-translate="Select Image">Select Image</label>
                        <input type="file" name="image" required>
                    </div>
                    <div class="password-details">
                        <div class="field input">
                            <label data-translate="Password">Password</label>
                            <input type="password" name="password" class="password" placeholder="Enter your password" required>
                            <div class="password-error" style="color: red; font-size: 14px;"></div> 
                        </div>
                        <div class="field input">
                            <label data-translate="Confirm Password">Confirm Password</label>
                            <input type="password" name="confirm_password" class="confirmPassword" placeholder="Confirm your password" required>
                            <div class="confirm-password-error" style="color: red; font-size: 14px;"></div>
                        </div>
                    </div>
                    <div class="field button">
                        <button type="submit" class="submitButton">Submit</button>
                    </div>
                </form>
                <div class="link">Already registered? <a href="admin_login.php" data-translate="Login now">Login now</a></div>
            </section>
        </div>
    </div>

</body>
<script src="assets/js/header/language.js"></script>
<script src="assets/js/forms/form.js"></script>
<script src="assets/js/forms/admin_register.js"></script>
</html>
