<?php
session_start();
include_once('config.php');

// Adding a friend
if (isset($_POST['add_friend'])) {
    $user_id = $_SESSION['unique_id'];
    $friend_user_id = $_POST['friend_unique_id'];

    // Prevent duplicate entries
    $check_friend = "SELECT * FROM friends WHERE unique_id=$user_id AND friend_unique_id=$friend_user_id";
    $check_result = mysqli_query($conn, $check_friend);
    
    if (mysqli_num_rows($check_result) == 0) {
        $sql = "INSERT INTO friends (unique_id, friend_unique_id) VALUES ($user_id, $friend_user_id)";
        mysqli_query($conn, $sql);
    }
    // Redirect to friends.php to show the updated list
    header('Location: ../friends.php');
}

// Removing a friend
if (isset($_POST['remove_friend'])) {
    $user_id = $_SESSION['unique_id'];
    $friend_user_id = $_POST['friend_unique_id'];

    $sql = "DELETE FROM friends WHERE unique_id=$user_id AND friend_unique_id=$friend_user_id";
    mysqli_query($conn, $sql);

    // Redirect to friends.php to show the updated list
    header('Location: ../friends.php');
}

?>
