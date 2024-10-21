<?php
session_start();
include_once('config.php');

if (isset($_POST['photo_id'])) {
    $photo_id = $_POST['photo_id'];
    $unique_id = $_SESSION['unique_id'];

    // Delete the record from the database
    $stmt = $conn->prepare("DELETE FROM personal_photos WHERE photo_id = ? AND unique_id = ?");
    $stmt->bind_param("ii", $photo_id, $unique_id);
    
    if ($stmt->execute()) {
        // Optionally, you can set a success message in the session
        $_SESSION['success_message'] = "Photo removed from your profile.";
    } else {
        $_SESSION['error_message'] = "Error deleting the photo from the database: " . $stmt->error;
    }
} else {
    $_SESSION['error_message'] = "No photo ID provided.";
}

// Redirect back to the about page
header("Location: ../about.php");
exit();
?>
