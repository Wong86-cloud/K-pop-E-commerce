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
        $issue_message = "<h3>Thank you! Your issue has been submitted successfully.</h3>
        <p>We will fix the problems and reply to you through the e-mail.</p>
        <a href='../order.php' class='btn btn-primary'>Back to Order Page</a>";
    } else {
        echo "Error reporting issue: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Issue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/submit_feedback.css">
</head>
<body>
    <div class="submit-feedback-form">
        <section class="submit-feedback-container">
            <img src="../assets/images/navbar/logo.png" class="navbar-logo">
            <a class="navbar-brand">KIVORIA</a>
            <?php echo $issue_message; ?>
        </section>
    </div>
</body>
</html>