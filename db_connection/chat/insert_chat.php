<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    $conn = mysqli_connect("127.0.0.1", "root", "", "kpop_e-commerce");

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);

    // Fetch outgoing user picture
    $sql = "SELECT img FROM users WHERE unique_id = {$outgoing_id}";
    $result = mysqli_query($conn, $sql);
    $outgoing_user = mysqli_fetch_assoc($result);
    $outgoing_user_pic = $outgoing_user['img'];

    // Fetch incoming user picture
    $sql = "SELECT img FROM users WHERE unique_id = {$incoming_id}";
    $result = mysqli_query($conn, $sql);
    $incoming_user = mysqli_fetch_assoc($result);
    $incoming_user_pic = $incoming_user['img'];
    $output = "";

    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $file_path = '';

    // Handle file upload
    if (isset($_FILES['attachment']['name']) && $_FILES['attachment']['name'] != "") {
        $file_name = $_FILES['attachment']['name'];
        $file_tmp = $_FILES['attachment']['tmp_name'];
        $upload_dir = 'assets/images/uploads/';
        $file_path = $upload_dir . basename($file_name);
        
        // Validate file type
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

        if (in_array($file_extension, $allowed_extensions) && move_uploaded_file($file_tmp, $file_path)) {
            echo "File uploaded successfully";
        } else {
            echo "Invalid file type. Only JPG, PNG, GIF, and PDF are allowed.";
            exit();
        }
    }

    // Insert message into the database
    if (!empty($message) || !empty($file_path)) {
        $stmt = $conn->prepare("INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, file) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("iiss", $incoming_id, $outgoing_id, $message, $file_path);
            if (!$stmt->execute()) {
                echo "Error executing query: " . $stmt->error; // Debugging line
            }
        } else {
            echo "Error preparing statement: " . $conn->error; // Debugging line
        }
    }
    
} else {
    header('location:  ../login.php');
}
?>
