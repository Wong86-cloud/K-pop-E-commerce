<?php
session_start();
include_once('config.php');

// Capture and sanitize inputs
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];

// Initialize session variables for rate limiting
if (!isset($_SESSION['admin_login_attempts'])) {
    $_SESSION['admin_login_attempts'] = 0;
}
if (!isset($_SESSION['last_attempt_time'])) {
    $_SESSION['last_attempt_time'] = time();
}

// Rate limiting parameters
$max_attempts = 3;
$lockout_time = 60; // Lockout period in seconds (1 minutes)

// Check if the user is currently locked out
if ($_SESSION['admin_login_attempts'] >= $max_attempts) {
    if (time() - $_SESSION['last_attempt_time'] < $lockout_time) {
        echo "You have been temporarily locked out. Please try again in 1 minute.";
        exit;
    } else {
        // Reset attempts after lockout period
        $_SESSION['admin_login_attempts'] = 0;
        $_SESSION['last_attempt_time'] = time();
    }
}

if (!empty($email) && !empty($password)) {
    // Use prepared statements to protect against SQL injection
    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $admin_pass = $row['password'];

        if (password_verify($password, $admin_pass)) {
            // Reset login attempts on successful login
            $_SESSION['admin_login_attempts'] = 0;

            // Update admin status
            $status = "Active now";
            $update_stmt = $conn->prepare("UPDATE admins SET status = ? WHERE unique_id = ?");
            $update_stmt->bind_param("si", $status, $row['unique_id']);
            if ($update_stmt->execute()) {
                $_SESSION['unique_id'] = $row['unique_id'];
                echo "success";
            } else {
                echo "Something went wrong. Please try again!";
            }
        } else {
            // Increment login attempt count and set time of last attempt
            $_SESSION['admin_login_attempts'] += 1;
            $_SESSION['last_attempt_time'] = time();
            echo "Email or Password is incorrect!";
        }
    } else {
        // Increment login attempt count and set time of last attempt
        $_SESSION['admin_login_attempts'] += 1;
        $_SESSION['last_attempt_time'] = time();
        echo "This email does not exist!";
    }
} else {
    echo "All input fields are required!";
}
?>
