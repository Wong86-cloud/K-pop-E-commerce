<?php
session_start();
include_once('../db_connection/config.php');

// Query for most liked posts
$mostLikedPostsQuery = "SELECT post_id, post, post_likes FROM posts ORDER BY post_likes DESC LIMIT 10";
$mostLikedPostsResult = mysqli_query($conn, $mostLikedPostsQuery);

// Query for most commented posts
$mostCommentedPostsQuery = "SELECT post_id, post, post_comments FROM posts ORDER BY post_comments DESC LIMIT 10";
$mostCommentedPostsResult = mysqli_query($conn, $mostCommentedPostsQuery);

// Prepare data for most liked posts
$mostLikedPosts = [];
while ($row = mysqli_fetch_assoc($mostLikedPostsResult)) {
    $mostLikedPosts[] = $row;
}

// Prepare data for most commented posts
$mostCommentedPosts = [];
while ($row = mysqli_fetch_assoc($mostCommentedPostsResult)) {
    $mostCommentedPosts[] = $row;
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode([
    'mostLikedPosts' => $mostLikedPosts,
    'mostCommentedPosts' => $mostCommentedPosts,
]);
?>
