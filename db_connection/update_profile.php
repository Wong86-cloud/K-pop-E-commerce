<?php
session_start();
include_once('db_connection/config.php');

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

// Extract form data from POST
$fname = isset($_POST['profile-name']) ? $_POST['profile-name'] : '';
$lname = isset($_POST['profile-lastname']) ? $_POST['profile-lastname'] : '';
$user_id = $_SESSION['unique_id'];

// Initialize image variables
$profile_img = '';
$background_img = '';
$upload_dir = 'assets/images/profile/'; // Folder to store uploaded images

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
}

// SQL query to update user profile in the database
$sql = "UPDATE `users` SET 
            `fname` = ?, 
            `lname` = ?, 
            `img` = ?, 
            `background_img` = ? 
        WHERE `unique_id` = ?";

if ($stmt = $conn->prepare($sql)) {
    // Bind parameters (strings for names, profile images, background image, and int for user_id)
    $stmt->bind_param('ssssi', $fname, $lname, $profile_img, $background_img, $user_id);

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
header("Location: profile.php");
exit();

?>
