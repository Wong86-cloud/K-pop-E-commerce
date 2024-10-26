<?php
session_start();
include_once('config.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);
    $user_id = $_SESSION['unique_id'];
    $issue_description = $_POST['issue_description'];
    $issue_image = null;

    // Handle image upload
    if (!empty($_FILES['issue_image']['name'])) {
        $target_dir = "assets/images/uploads/";
        $target_file = $target_dir . basename($_FILES["issue_image"]["name"]);
        if (move_uploaded_file($_FILES["issue_image"]["tmp_name"], $target_file)) {
            $issue_image = basename($_FILES["issue_image"]["name"]);
        }
    }

    // Insert the report into the database
    $query = "INSERT INTO order_issues (order_id, user_id, issue_description, issue_image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiss", $order_id, $user_id, $issue_description, $issue_image);
    if ($stmt->execute()) {
        echo "Issue reported successfully.";
    } else {
        echo "Error reporting issue: " . $stmt->error;
    }
}
?>
