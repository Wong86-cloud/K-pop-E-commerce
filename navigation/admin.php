<?php
    session_start();
    ob_start();
    // Ensure that the user is logged in and the unique_id is set
    if (isset($_SESSION['unique_id'])) {
        $unique_id = $_SESSION['unique_id'];
    } else {
    // Handle the case where the user is not logged in (redirect or show an error)
        die("User not logged in.");
    }

    $conn = mysqli_connect("127.0.0.1", "root", "", "kpop_e-commerce");

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    
    $sql = mysqli_query($conn, "SELECT * FROM admins WHERE unique_id = {$_SESSION['unique_id']}");
    if(mysqli_num_rows($sql) > 0){
        $row = mysqli_fetch_assoc($sql);
    }
?>