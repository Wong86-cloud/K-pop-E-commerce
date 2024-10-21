<?php
session_start();
include_once('config.php');

// Check if a file is uploaded
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $photo_id = $_POST['photo_id']; // Get the photo ID from the form
    $unique_id = $_SESSION['unique_id']; // Ensure the user is logged in
    $target_dir = "../assets/images/uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an actual image
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check !== false) {
        // Move the new file to the target directory
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // Update the photo information in the database
            $stmt = $conn->prepare("UPDATE personal_photos SET photo_url = ? WHERE photo_id = ? AND unique_id = ?");
            $relative_path = str_replace("../", "", $target_file); // Store the relative path
            $stmt->bind_param("sii", $relative_path, $photo_id, $unique_id);
            if ($stmt->execute()) {
                echo "The file ". htmlspecialchars(basename($_FILES["photo"]["name"])) . " has been reuploaded.";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Sorry, there was an error reuploading your file.";
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
