<?php
session_start();
include_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unique_id = $_SESSION['unique_id']; // Assuming the user is logged in and you have their unique ID
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $country = mysqli_real_escape_string($conn, $_POST['country-region']);
    $about_me = mysqli_real_escape_string($conn, $_POST['about_me']);

    // Update the database with the new personal info
    $query = "UPDATE users SET fname = ?, lname = ?, gender = ?, dob = ?, country = ?, about_me = ? WHERE unique_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssssi', $fname, $lname, $gender, $dob, $country, $about_me, $unique_id);

    if ($stmt->execute()) {
        echo "Personal information updated successfully!";
    } else {
        echo "Error updating information: " . $stmt->error;
    }
}

header("Location: ../about.php");
exit();
?>
