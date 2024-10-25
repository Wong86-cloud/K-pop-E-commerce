<?php
session_start();
include_once('config.php');

// Sanitize admin inputs
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$gender = mysqli_real_escape_string($conn, $_POST['gender']);
$admin_work_code = mysqli_real_escape_string($conn, trim($_POST['admin_work_code']));

// Check for empty required fields
if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT email FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "$email - This email already exists!";
        } else {
            // Handle image upload
            if (isset($_FILES['image'])) {
                $img_name = $_FILES['image']['name'];
                $img_type = $_FILES['image']['type'];
                $tmp_name = $_FILES['image']['tmp_name'];
                $img_explode = explode('.', $img_name);
                $img_ext = strtolower(end($img_explode)); // Get the file extension

                $extensions = ['png', 'jpeg', 'jpg'];
                $max_file_size = 2 * 1024 * 1024; // 2MB limit

                // Validate image extension and size
                if (in_array($img_ext, $extensions) && $_FILES['image']['size'] <= $max_file_size) {
                    $original_img_name = pathinfo($img_name, PATHINFO_FILENAME);
                    $new_img_name = $original_img_name . '.' . $img_ext;

                    $upload_dir = __DIR__ . "/assets/images/profile/";
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0777, true); // Create directory if not exists
                    }

                    // Move uploaded image
                    if (move_uploaded_file($tmp_name, $upload_dir . $new_img_name)) {
                        $random_id = rand(time(), 10000000);
                        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                        // Insert admin details into the database
                        $stmt2 = $conn->prepare("INSERT INTO admins (unique_id, fname, lname, gender, email, admin_work_code, password, img) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt2->bind_param("issssiss", $random_id, $fname, $lname, $gender, $email, $admin_work_code, $hashed_password, $new_img_name);

                        if ($stmt2->execute()) {
                            $_SESSION['unique_id'] = $random_id; // Set session variable
                            echo "success"; // Return success response
                        } else {
                            echo "Something went wrong during registration!";
                        }
                    } else {
                        echo "Failed to upload image!";
                    }
                } else {
                    echo "Please select a valid image file under 2MB!";
                }
            } else {
                echo "Please upload an image!";
            }
        }
    } else {
        echo "$email - Please enter a valid email address!";
    }
} else {
    echo "All input fields are required!";
}
?>
