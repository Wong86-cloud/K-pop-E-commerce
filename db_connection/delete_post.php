<?php
session_start();
include('config.php'); // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];

    // Delete post and associated comments
    $query_delete_post = "DELETE FROM posts WHERE post_id = '$post_id'";
    $query_delete_comments = "DELETE FROM post_comments WHERE post_id = '$post_id'";

    if (mysqli_query($conn, $query_delete_post) && mysqli_query($conn, $query_delete_comments)) {
        echo "Post and associated comments deleted successfully.";
    } else {
        echo "Error deleting post: " . mysqli_error($conn);
    }
}
header("Location: ../admin_forum.php");
exit;
?>
