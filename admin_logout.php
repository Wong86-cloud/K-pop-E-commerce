<?php
    session_start();

    if(isset($_SESSION['unique_id'])){
        include_once "db_connection/config.php";
    
        // Use POST instead of GET
        if(isset($_POST['logout'])){
            $logout_id = $_SESSION['unique_id'];
            $status = "Offline now";
    
            // Update the user's status
            $sql = mysqli_query($conn, "UPDATE admins SET status = '{$status}' WHERE unique_id = {$logout_id}");
            if($sql){
                session_unset();
                session_destroy();
                header('location:admin_login.php');
                exit();
            }
        } else {
            header('location:admin_home.php');
            exit();
        }
    } else {
        header('location:admin_login.php');
        exit();
    }  
?>
