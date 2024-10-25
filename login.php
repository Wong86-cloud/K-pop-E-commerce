<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    
    <link rel="stylesheet" href="assets/css/bar.css">

    <link rel="stylesheet" href="assets/css/form.css">

</head>

    <!--Navigation Bar-->
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

    <!-- Login Container -->
    <div class="login-form">
        <div class="login-form-container">
            <section class="form login">
                <header data-translate="Login">Login</header>
                <form action="db_connection/login_info.php" method="POST" enctype="multipart/form-data">
                    <div class="error-txt"></div>
                    <div class="field input">
                        <label data-translate="Email Address">Email Address</label>
                        <input type="text" name="email" placeholder="Enter your email">
                    </div>
                    <div class="field input">
                        <label data-translate="Password">Password</label>
                        <input type="password" name="password" placeholder="Enter your password">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="forgot-password">
                        <a href="forgot_password.php">Forgot Password?</a>
                    </div>
                    <div class="captcha">
                        <label for="captcha-input">Enter captcha</label>
                        <div class="preview"></div>
                        <div class="captcha-form">
                            <input type="text" id="captcha-form" placeholder="Enter captcha text">
                            <button class="captcha-refresh"><i class="fas fa-sync"></i></button>
                        </div>
                    <div class="field button">
                        <input type="submit">
                    </div>
                </form>
                <div class="link">Not yet signed up? <a href="register.php">Signup now</a></div>
            </section>
        </div>
    </div>

</body>
<script src="assets/js/header/language.js"></script>
<script src="assets/js/forms/form.js"></script>
<script src="assets/js/forms/login.js"></script>
</html>