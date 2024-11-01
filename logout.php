<?php
    session_start();

    if(isset($_SESSION['unique_id'])){
        include_once "db_connection/config.php";
    
        // Use POST instead of GET
        if(isset($_POST['logout'])){
            $logout_id = $_SESSION['unique_id'];
            $status = "Offline now";
    
            // Update the user's status
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$logout_id}");
            if($sql){
                session_unset();
                session_destroy();
                header('location:login.php');
                exit();
            }
        } else {
            header('location:home.php');
            exit();
        }
    } else {
        header('location:login.php');
        exit();
    }
?>
