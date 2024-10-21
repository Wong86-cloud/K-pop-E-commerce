<?php
session_start();
include('config.php'); // Include your database connection file

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get comment ID from AJAX request
$comment_id = $_POST['comment_id'];

// Find the post ID associated with the comment
$comment_query = "SELECT post_id FROM post_comments WHERE comment_id = '$comment_id'";
$comment_result = mysqli_query($conn, $comment_query);
$comment_row = mysqli_fetch_assoc($comment_result);
$post_id = $comment_row['post_id'];

// Delete the comment from the database
$delete_comment = "DELETE FROM post_comments WHERE comment_id = '$comment_id'";
if (mysqli_query($conn, $delete_comment)) {
    // Return success response with post ID
    echo json_encode(['success' => true, 'post_id' => $post_id]);
} else {
    // Return error message
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
}
?>
