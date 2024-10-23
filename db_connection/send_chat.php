<?php
session_start();
include_once('config.php');

// Set header to return JSON
header('Content-Type: application/json');

// Ensure the user is logged in
if (isset($_SESSION['unique_id'])) {
    $outgoing_id = $_SESSION['unique_id'];

    // Check if incoming_id and message are set in the POST request
    if (isset($_POST['incoming_id']) && isset($_POST['message'])) {
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        $attachment = null;

        // Handle file upload (if needed)
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['attachment']['tmp_name'];
            $fileName = $_FILES['attachment']['name'];
            $fileSize = $_FILES['attachment']['size'];
            $fileType = $_FILES['attachment']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // Define allowed file types and max size
            $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'gif', 'pdf');
            $maxFileSize = 5 * 1024 * 1024; // 5 MB

            // Check if the file type is allowed and size is within limits
            if (in_array($fileExtension, $allowedfileExtensions) && $fileSize <= $maxFileSize) {
                $newFileName = basename($fileName); // Use the original file name
                $uploadFileDir = 'assets/images/uploads/'; // Directory to save files
                $dest_path = $uploadFileDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $attachment = $dest_path; // Save the path to the attachment
                } else {
                    echo json_encode(["status" => "error", "message" => "There was an error moving the uploaded file."]);
                    exit;
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid file type or file size too large."]);
                exit; // Stop further processing if the file is invalid
            }
        }

        // Insert message into the database
        $sql = "INSERT INTO messages (outgoing_msg_id, incoming_msg_id, msg, file) VALUES ('$outgoing_id', '$incoming_id', '$message', '$attachment')";
        
        // After inserting the message into the database
if (mysqli_query($conn, $sql)) {
    echo json_encode(['status' => 'success', 'incomingId' => $incoming_id]); // Return the incoming ID
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error sending message: ' . mysqli_error($conn)]);
}

    } else {
        echo json_encode(["status" => "error", "message" => "Incoming ID or message not set."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
}
?>
