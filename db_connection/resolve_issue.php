<?php
session_start();
include_once('config.php');

// Check if the form was submitted with an issue ID
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['issue_id'])) {
    $issue_id = $_POST['issue_id'];

    // Update the issue status to resolved in the database
    $query = "UPDATE order_issues SET status = 'resolved' WHERE issue_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $issue_id);
    
    if ($stmt->execute()) {
        // Redirect back to the main issues page with a success message
        header("Location: ../admin_order.php?message=Issue resolved successfully");
        exit;
    } else {
        // If there was an error, display it
        echo "Error: Could not resolve the issue.";
    }
} else {
    // Redirect if the issue ID was not provided
    header("Location: ../admin_order.php?error=No issue ID provided");
    exit;
}
?>
