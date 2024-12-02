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
$lockout_time = 30; // Lockout period in seconds (30 seconds)

// Check if the user is currently locked out
if ($_SESSION['login_attempts'] >= $max_attempts) {
    if (time() - $_SESSION['last_attempt_time'] < $lockout_time) {
        echo "You have been temporarily locked out. Please try again after 30 seconds.";
        exit;
    } else {
        // Reset attempts after lockout period
        $_SESSION['login_attempts'] = 0;
        $_SESSION['last_attempt_time'] = time();
    }
}

// Check if the email and password fields are not empty
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

            // Update the 'status' column to 'Active now'
            $updateStatus = $conn->prepare("UPDATE users SET status = 'Active now' WHERE unique_id = ?");
            $updateStatus->bind_param("s", $row['unique_id']);
            $updateStatus->execute();

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
