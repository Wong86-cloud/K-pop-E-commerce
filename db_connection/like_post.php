<?php
session_start();
include('config.php');

$post_id = $_POST['post_id'];
$unique_id = $_SESSION['unique_id']; // User's unique ID from the session

// Check if the user has already liked the post
$query = $conn->prepare("SELECT * FROM post_likes WHERE post_id = ? AND unique_id = ?");
$query->bind_param("ii", $post_id, $unique_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    // User has already liked the post, so we "unlike" it
    $delete_query = $conn->prepare("DELETE FROM post_likes WHERE post_id = ? AND unique_id = ?");
    $delete_query->bind_param("ii", $post_id, $unique_id);
    
    if ($delete_query->execute()) {
        // Decrease the like count in the posts table
        $update_post = $conn->prepare("UPDATE posts SET post_likes = post_likes - 1 WHERE post_id = ?");
        $update_post->bind_param("i", $post_id);
        $update_post->execute();

        echo json_encode(['status' => 'unliked']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Unable to unlike the post.']);
    }
} else {
    // User has not liked the post yet, so we "like" it
    $insert_query = $conn->prepare("INSERT INTO post_likes (post_id, unique_id) VALUES (?, ?)");
    $insert_query->bind_param("ii", $post_id, $unique_id);
    
    if ($insert_query->execute()) {
        // Increase the like count in the posts table
        $update_post = $conn->prepare("UPDATE posts SET post_likes = post_likes + 1 WHERE post_id = ?");
        $update_post->bind_param("i", $post_id);
        $update_post->execute();

        echo json_encode(['status' => 'liked']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Unable to like the post.']);
    }
}
?>
