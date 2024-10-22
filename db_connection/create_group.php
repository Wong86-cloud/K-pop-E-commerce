<?php
session_start();
include_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $group_name = mysqli_real_escape_string($conn, $_POST['group_name']);
    $celebrity_hashtag = mysqli_real_escape_string($conn, $_POST['celebrity_hashtag']);
    $creator_id = $_SESSION['unique_id']; // Assuming the creator's ID is stored in session

    // Validate celebrity hashtag
    $allowed_hashtags = ['#BTS', '#Blackpink', '#Twice']; // Add more as needed
    if (in_array($celebrity_hashtag, $allowed_hashtags)) {
        // Insert group into database
        $query = "INSERT INTO groups (group_name, creator_id, celebrity_hashtag) 
                  VALUES ('$group_name', '$creator_id', '$celebrity_hashtag')";
        mysqli_query($conn, $query);
        header("Location: group.php?group_id=" . mysqli_insert_id($conn)); // Redirect to group page
    } else {
        echo "Invalid hashtag! Please select from the allowed hashtags.";
    }
}
?>
