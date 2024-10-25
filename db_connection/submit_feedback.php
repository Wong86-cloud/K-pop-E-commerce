<?php
session_start();
include_once('config.php');

// Get the unique_id from the session
$unique_id = $_SESSION['unique_id'];

// Retrieve form data from POST request
$q1 = isset($_POST['q1']) ? $_POST['q1'] : null;
$q2 = isset($_POST['q2']) ? $_POST['q2'] : null;
$q3 = isset($_POST['q3']) ? implode(", ", $_POST['q3']) : null;
$q4 = isset($_POST['q4']) ? $_POST['q4'] : null;
$q5 = isset($_POST['q5']) ? $_POST['q5'] : null;
$q6 = isset($_POST['q6']) ? $_POST['q6'] : null;
$q7 = isset($_POST['q7']) ? implode(", ", $_POST['q7']) : null;
$q8 = isset($_POST['q8']) ? $_POST['q8'] : null;

// Check if feedback already exists for the user
$checkFeedbackSql = "SELECT COUNT(*) FROM feedback WHERE unique_id = '$unique_id'";
$result = $conn->query($checkFeedbackSql);
$row = $result->fetch_row();

if ($row[0] > 0) {
    // Feedback already submitted
    $feedback_message = "<h3>You have already submitted your feedback.</h3>
                         <p>Thank you for your response!</p>
                         <a href='../home.php' class='btn btn-primary'>Back to Home Page</a>";
} else {
    // Prepare SQL statement to insert the feedback data
    $sql = "INSERT INTO feedback (unique_id, question_1, question_2, question_3, question_4, question_5, question_6, question_7, question_8) 
            VALUES ('$unique_id', '$q1', '$q2', '$q3', '$q4', '$q5', '$q6', '$q7', '$q8')";

    // Execute the SQL query and check if data was inserted successfully
    if ($conn->query($sql) === TRUE) {
        $feedback_message = "<h3>Thank you! Your feedback has been submitted successfully.</h3>
                             <p>We appreciate your response and it helps us improve our platform.</p>
                             <a href='../home.php' class='btn btn-primary'>Back to Feedback Form</a>";
    } else {
        $feedback_message = "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Close the database connection
$conn->close();
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
