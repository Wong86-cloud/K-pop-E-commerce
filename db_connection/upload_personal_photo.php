<?php
session_start();
include_once('config.php');

// Check if a file is uploaded
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $unique_id = $_SESSION['unique_id']; // Assuming the user is logged in and you have a session with the unique ID
    $target_dir = "../assets/images/uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an actual image
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check !== false) {
        // Move file to target directory
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // Insert photo information into the database
            $stmt = $conn->prepare("INSERT INTO personal_photos (unique_id, photo_url) VALUES (?, ?)");
            $relative_path = str_replace("../", "", $target_file); // Store the relative path in a variable
            $stmt->bind_param("is", $unique_id, $relative_path); // Pass the variable instead
            if ($stmt->execute()) {
                echo "The file ". htmlspecialchars( basename( $_FILES["photo"]["name"])). " has been uploaded.";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
} else {
    echo "No file uploaded or there was an error.";
}

header("Location: ../about.php");
exit();
?>
