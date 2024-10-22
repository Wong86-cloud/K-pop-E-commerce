<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    
    <link rel="stylesheet" href="assets/css/bar.css">

    <link rel="stylesheet" href="assets/css/form.css">

</head>
<body>
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

    <!-- Forgot Password Container -->
    <div class="forgot-password-form">
        <div class="forgot-password-form-container">
            <section class="form forgot-password">
                <header>Forgot Password</header>
                    <form action="db_connection/reset_password.php" method="POST" enctype="multipart/form-data">
                        <div class="error-txt"></div>
                        <div class="field input">
                            <label>Email Address</label>
                            <input type="text" name="email" placeholder="Enter your email">
                        </div>
                        <div class="field input">
                            <label>New Password</label>
                            <input type="password" name="password" class="reset-password" placeholder="Enter your password" required>
                            <div class="new-password-error" style="color: red; font-size: 14px;"></div> <!-- Error message for password -->
                        </div>
                        <div class="field input">
                            <label>Confirm New Password</label>
                            <input type="password" name="confirm_password"  class="confirm-reset-Password" placeholder="Confirm your password" required>
                            <div class="confirm-new-password-error" style="color: red; font-size: 14px;"></div> <!-- Error message for confirm password -->
                        </div>
                        <div class="field button">
                            <input type="submit">
                        </div>
                    </form>
            </section>
        </div>
    </div>
</body>
<script src="assets/js/header/language.js"></script>
<script src="assets/js/forms/forgot_password.js"></script>
</html>
