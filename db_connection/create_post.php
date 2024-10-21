<?php
session_start();
include_once('config.php');

if (isset($_POST['submit'])) {
    $post_content = mysqli_real_escape_string($conn, $_POST['post_content']);
    $unique_id = $_SESSION['unique_id']; // Assuming session contains the unique_id

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

    // Insert post into the database
    $sql = "INSERT INTO posts (unique_id, post, post_image, post_comments, post_likes, got_image) 
            VALUES ($unique_id, '$post_content', '$post_image', 0, 0, $got_image)";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: ../forum.php"); // Redirect to profile page after post creation
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
