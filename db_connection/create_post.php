<?php
session_start();
include_once('config.php');

if (isset($_POST['submit'])) {
    // Get the post content and room selection from the form
    $post_content = mysqli_real_escape_string($conn, $_POST['post_content']);
    $room_id = mysqli_real_escape_string($conn, $_POST['room_id']); // Get the selected room ID
    $unique_id = $_SESSION['unique_id']; // Assuming session contains the unique_id of the user

    // Ensure the upload directory exists
    $target_dir = "assets/images/uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create directory if it doesn't exist
    }

    // Handle post image upload
    $post_image = '';
    $got_image = 0;
    if (isset($_FILES['post_image']) && $_FILES['post_image']['size'] > 0) {
        $post_image = $target_dir . basename($_FILES["post_image"]["name"]);
        
        // Check if the file was successfully moved
        if (move_uploaded_file($_FILES["post_image"]["tmp_name"], $post_image)) {
            $got_image = 1;
        } else {
            echo "Error uploading the image.";
            exit();
        }
    }

    // Insert post into the database with the selected room ID
    $sql = "INSERT INTO posts (unique_id, room_id, post, post_image, post_comments, post_likes, got_image, post_date) 
            VALUES ($unique_id, $room_id, '$post_content', '$post_image', 0, 0, $got_image, NOW())";
    
    if (mysqli_query($conn, $sql)) {
        // Redirect to the specific room's forum page after post creation
        header("Location: ../forum.php?room_id=" . $room_id); 
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
