<?php
session_start();
include_once "config.php";

$group_id = $_POST['group_id'];
$unique_id = $_SESSION['unique_id'];

// Check if the user is already a member
$check_membership_query = "SELECT * FROM group_members WHERE group_id = '$group_id' AND unique_id = '$unique_id'";
$membership_result = mysqli_query($conn, $check_membership_query);

if (mysqli_num_rows($membership_result) == 0) {
    // Add user to group
    $query = "INSERT INTO group_members (group_id, unique_id) VALUES ('$group_id', '$unique_id')";
    mysqli_query($conn, $query);
}

header("Location: ../groups.php"); // Redirect back to the groups page
?>
