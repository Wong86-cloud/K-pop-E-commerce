<?php
session_start();
include_once('config.php');

// Debugging: Check if form data and files are being received
echo "<pre>";
print_r($_POST);  // Check POST data
print_r($_FILES); // Check FILES data
echo "</pre>";

// Check if user is logged in
if (!isset($_SESSION['unique_id'])) {
    echo "User not logged in.";
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['unique_id'];

// Initialize image variables
$profile_img = '';
$background_img = '';
$upload_dir = 'assets/images/profile/'; // Folder to store uploaded images

// Fetch existing profile and background images from the database
$sql = "SELECT `img`, `background_img`, `fname`, `lname` FROM `users` WHERE `unique_id` = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $existing_profile_img = $row['img'];
    $existing_background_img = $row['background_img'];
    $existing_fname = $row['fname']; // Store existing first name
    $existing_lname = $row['lname']; // Store existing last name

    $stmt->close();
}

// Handle Profile Image Upload
if (!empty($_FILES['upload-profile-header']['name'])) {
    $profile_img = basename($_FILES['upload-profile-header']['name']);
    $target_file = $upload_dir . $profile_img;

    // Attempt to move uploaded file to the target directory
    if (move_uploaded_file($_FILES['upload-profile-header']['tmp_name'], $target_file)) {
        echo "Profile image uploaded successfully!<br>";
    } else {
        echo "Error uploading profile image.<br>";
    }
} else {
    // Retain the existing profile image if no new image is uploaded
    $profile_img = $existing_profile_img;
}

// Handle Background Image Upload
if (!empty($_FILES['upload-background-picture']['name'])) {
    $background_img = basename($_FILES['upload-background-picture']['name']);
    $target_file = $upload_dir . $background_img;

    // Attempt to move uploaded file to the target directory
    if (move_uploaded_file($_FILES['upload-background-picture']['tmp_name'], $target_file)) {
        echo "Background image uploaded successfully!<br>";
    } else {
        echo "Error uploading background image.<br>";
    }
} else {
    // Retain the existing background image if no new image is uploaded
    $background_img = $existing_background_img;
}

// SQL query to update user profile in the database
$sql = "UPDATE `users` SET 
            `img` = ?, 
            `background_img` = ? 
        WHERE `unique_id` = ?";

if ($stmt = $conn->prepare($sql)) {
    // Bind parameters (strings for profile images and int for user_id)
    $stmt->bind_param('ssi', $profile_img, $background_img, $user_id);

    // Execute the query and check for success or errors
    if ($stmt->execute()) {
        echo "Profile updated successfully in the database!<br>";
    } else {
        // Log any SQL execution errors
        echo "Error executing query: " . $stmt->error . "<br>";
    }
    $stmt->close();
} else {
    // Log preparation errors
    echo "Error preparing statement: " . $conn->error . "<br>";
}

// Redirect back to the profile page or any other page after processing (optional)
header("Location: ../forum.php");
exit();
?>
