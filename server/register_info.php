<?php
session_start();
include_once('config.php');
// Sanitize user inputs
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Check for empty fields
if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "$email - This email already exists!";
        } else {
            // Check if an image is uploaded
            if (isset($_FILES['image'])) {
                $img_name = $_FILES['image']['name'];
                $img_type = $_FILES['image']['type'];
                $tmp_name = $_FILES['image']['tmp_name'];
                $img_explode = explode('.', $img_name);
                $img_ext = end($img_explode);
    
                $extensions = ['png', 'jpeg', 'jpg'];
                $max_file_size = 2 * 1024 * 1024; // 2MB limit
                
                // Check if image extension and size are valid
                if (in_array($img_ext, $extensions) === true && $_FILES['image']['size'] <= $max_file_size) {
                    $time = time();
                    $new_img_name = $time . $img_name;
    
                    $upload_dir = __DIR__ . "/assets/images/profile/";
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0777, true); // Create the directory if it doesn't exist
                    }

                    // Move uploaded image
                    if (move_uploaded_file($tmp_name, $upload_dir . $new_img_name)) {
                        $status = "Active now";
                        $random_id = rand(time(), 10000000);
                        $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Hash the password
    
                        // Insert user details into database using prepared statements
                        $stmt2 = $conn->prepare("INSERT INTO users (unique_id, fname, lname, email, password, img, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $stmt2->bind_param("issssss", $random_id, $fname, $lname, $email, $hashed_password, $new_img_name, $status);
    
                        if ($stmt2->execute()) {
                            // Fetch user to set session
                            $stmt3 = $conn->prepare("SELECT * FROM users WHERE email = ?");
                            $stmt3->bind_param("s", $email);
                            $stmt3->execute();
                            $result3 = $stmt3->get_result();

                            if ($result3->num_rows > 0) {
                                $row = $result3->fetch_assoc();
                                $_SESSION['unique_id'] = $row['unique_id'];
                                echo "success";
                            }
                        } else {
                            echo "Something went wrong!";
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

