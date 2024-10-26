<?php
session_start();
include_once('config.php'); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);
    $user_id = $_SESSION['unique_id'];

    // Update order status to "Received"
    $query = "UPDATE orders SET order_status = 'Received' WHERE order_id = ? AND unique_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $order_id, $user_id);
    if ($stmt->execute()) {
        $feedback_message = "<h3>Thank you! Your marks has been submitted successfully.</h3>
                             <p>We appreciate your response and it helps us to track customer's order well.</p>
                             <a href='../order.php' class='btn btn-primary'>Back to Order Page</a>";
    } else {
        echo "Error marking order as received: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Submitted</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/submit_feedback.css">
</head>
<body>
    <div class="submit-feedback-form">
        <section class="submit-feedback-container">
            <img src="../assets/images/navbar/logo.png" class="navbar-logo">
            <a class="navbar-brand">KIVORIA</a>
            <?php echo $feedback_message; ?>
        </section>
    </div>
</body>
</html>