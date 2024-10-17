<?php 
session_start();
include_once('config.php');

if (isset($_SESSION['unique_id'])) {
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

    $sql = "SELECT messages.*, 
               u1.img AS outgoing_user_pic, 
               u2.img AS incoming_user_pic
        FROM messages 
        LEFT JOIN users AS u1 ON u1.unique_id = messages.outgoing_msg_id
        LEFT JOIN users AS u2 ON u2.unique_id = messages.incoming_msg_id
        WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
        OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) 
        ORDER BY msg_id";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            // Determine if the message is outgoing or incoming
            $chatClass = ($row['outgoing_msg_id'] === $outgoing_id) ? "outgoing" : "incoming";
        
            // Use the correct profile picture based on the message sender
            if ($chatClass === "incoming") {
                $profilePic = $incoming_user_pic; // Get the incoming user picture
            } else {
                $profilePic = $outgoing_user_pic; // Get the outgoing user picture
            }
        
            // Create the chat output with the profile picture
            $output .= '<div class="chat ' . $chatClass . '">
                        <div class="profile-pic-container">
                            <img src="assets/images/profile/' . $profilePic . '" alt="Profile Picture" class="profile-pic">
                        </div>
                        <div class="details">
                            <p>' . $row['msg'];
        

            // If there's an attachment, handle different file types
            if (!empty($row['file'])) {
                $file_extension = pathinfo($row['file'], PATHINFO_EXTENSION);
    
                // If the file is an image, display it inline
                if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $output .= '<img src="'.$row['file'].'" alt="Image" class="chat-image" onclick="openModal(this.src)">';
    
                // If the file is a PDF, display a download link inline
                } elseif ($file_extension == 'pdf') {
                    $output .= '<a href="'.$row['file'].'" target="_blank" class="pdf-link">
                                <i class="fas fa-file-pdf" style="font-size: 24px; color: red;"></i> View/Download PDF
                                </a>';
                }
            }

            $output .= '</p></div></div>'; // Close the <p> and details div
        }
        echo $output;
    }
} else {
    header('location:  ../login.php');
}
?>
