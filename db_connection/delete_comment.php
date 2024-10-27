<?php
session_start();
include('config.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment_id = $_POST['comment_id'];

    // Delete comment
    $query = "DELETE FROM post_comments WHERE comment_id = '$comment_id'";
    if (mysqli_query($conn, $query)) {
        echo "Comment deleted successfully.";
    } else {
        echo "Error deleting comment: " . mysqli_error($conn);
    }
}
header("Location: ../admin_forum.php");
exit;
?>
