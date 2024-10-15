<?php
session_start();
$conn = mysqli_connect("127.0.0.1", "root", "", "kpop_e-commerce");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
$outgoing_id = $_SESSION['unique_id'];
$SearchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
$output = "";

$sql = mysqli_query($conn, "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND (fname LIKE '%{$SearchTerm}%' OR lname LIKE '%{$SearchTerm}%')");
if(mysqli_num_rows($sql) > 0){
    while($row = mysqli_fetch_assoc($sql)){
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']} 
                OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id}  
                OR outgoing_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        
        if($row2 !== null){
            $result = $row2['msg'];
            //trim message if word are more than 28
            (strlen($result) > 28) ? $msg = substr($result, 0, 28) : $msg = $result;
            ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
        } else {
            $result = "No message available";
            $msg = $result;
            $you = "";
        }

        //check if user is online or offline
        ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
        $output .= '<a href="chat.php?user_id='.$row['unique_id'].'">
                    <div class="content">
                    <img src="assets/images/profile/' . $row['img'] .'" alt="">
                    <div class="details">
                        <span>'. $row['fname'] . " " .$row['lname'].'</span>
                        <p>'. $you . $msg .'</p>
                    </div>
                    </div>
                    <div class="status-dot '.$offline.'"><i class="fas fa-circle"></i></div>
                    </a>';
    }
}else{
    $output .= "No user found related to your search term";
}
echo $output;

?>