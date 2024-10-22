<?php
session_start();
include_once ('config.php'); // Include your database connection file

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate input
    if (empty($email) || empty($password) || empty($confirmPassword)) {
        echo "All fields are required!";
        exit();
    }

    if ($password !== $confirmPassword) {
        echo "Passwords do not match!";
        exit();
    }

    // Password validation rules
    $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/';

    if (!preg_match($passwordRegex, $password)) {
        echo "Password must be at least 8 characters, include uppercase, lowercase, number, and special character.";
        exit();
    }

    // Check if the email exists in the database
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($query) > 0) {
        // Email exists, proceed to update password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

        // Update the password in the database
        $updateQuery = mysqli_query($conn, "UPDATE users SET password = '$hashedPassword' WHERE email = '$email'");

        if ($updateQuery) {
            echo "success"; // Password updated successfully
        } else {
            echo "Something went wrong while updating your password. Please try again!";
        }
    } else {
        echo "Email not found!";
    }
} else {
    echo "Invalid request method.";
}
?>
