<?php
session_start();
include_once('config.php');

// Capture and sanitize inputs
$email = $_POST['email'];
$password = $_POST['password'];

// Initialize session variables for rate limiting
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
if (!isset($_SESSION['last_attempt_time'])) {
    $_SESSION['last_attempt_time'] = time();
}

// Rate limiting parameters
$max_attempts = 3;
$lockout_time = 60; // Lockout period in seconds (1 minutes)

// Check if the user is currently locked out
if ($_SESSION['login_attempts'] >= $max_attempts) {
    if (time() - $_SESSION['last_attempt_time'] < $lockout_time) {
        echo "You have been temporarily locked out. Please try again in 1 minute.";
        exit;
    } else {
        // Reset attempts after lockout period
        $_SESSION['login_attempts'] = 0;
        $_SESSION['last_attempt_time'] = time();
    }
}

if (!empty($email) && !empty($password)) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Reset login attempts on successful login
            $_SESSION['login_attempts'] = 0;
            $_SESSION['unique_id'] = $row['unique_id'];
            echo "success";
        } else {
            $_SESSION['login_attempts'] += 1;
            $_SESSION['last_attempt_time'] = time();
            echo "Email or Password is incorrect!";
        }
    } else {
        $_SESSION['login_attempts'] += 1;
        $_SESSION['last_attempt_time'] = time();
        echo "Email or Password is incorrect!";
    }
} else {
    echo "All input fields are required!";
}
?>