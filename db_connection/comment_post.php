<?php
session_start();
include('config.php'); // Include your database connection file

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get post ID and comment text from AJAX request
$post_id = $_POST['post_id'];
$unique_id = $_SESSION['unique_id'];
$comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8'); // Sanitize input

// Insert the comment into the post_comments table
$insert_comment = "INSERT INTO post_comments (post_id, unique_id, comment) VALUES ('$post_id', '$unique_id', '$comment')";
if (mysqli_query($conn, $insert_comment)) {
    
    // After successfully inserting the comment, update the post_comments count in the posts table
    $update_post_comments_count = "UPDATE posts SET post_comments = post_comments + 1 WHERE post_id = '$post_id'";
    if (mysqli_query($conn, $update_post_comments_count)) {
        
        // Fetch user details for the comment
        $user_query = "SELECT fname, lname, img FROM users WHERE unique_id = '$unique_id'";
        $user_result = mysqli_query($conn, $user_query);
        $user = mysqli_fetch_assoc($user_result);
        $user_name = $user['fname'] . ' ' . $user['lname'];
        $profile_image = $user['img'];

        // Get the current timestamp for the comment
        $comment_date = date('Y-m-d H:i:s');
        $comment_id = mysqli_insert_id($conn); // Get the ID of the newly inserted comment

        // Return JSON response with success and comment details
        echo json_encode([
            'success' => true,
            'comment_id' => $comment_id,
            'comment' => $comment,
            'comment_date' => $comment_date,
            'user_name' => $user_name,
            'profile_image' => $profile_image
        ]);
    } else {
        // Return error if updating post_comments failed
        echo json_encode(['success' => false, 'error' => 'Failed to update comment count in posts table.']);
    }

} else {
    // Return error if inserting the comment failed
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
}
?>
