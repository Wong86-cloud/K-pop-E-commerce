<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    
    <link rel="stylesheet" href="assets/css/bar.css">

    <link rel="stylesheet" href="assets/css/message.css">

</head>
<body>

    <?php include_once('navigation/header.php'); ?>
    <?php include_once('navigation/sidebar.php'); ?>
    
    <!--Message Container-->
    <div class="message-container">
        <section class="users-content">
            <header>
                <?php
                include_once('server/config.php');
                $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
                $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
                if(mysqli_num_rows($sql) > 0){
                    $row = mysqli_fetch_assoc($sql);
                }
                ?>
                <a href="message.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <div class="content">
                    <img src="assets/images/profile/<?php echo $row['img'] ?>" alt="">
                    <div class="details">
                        <span><?php echo $row['fname'] . " " .$row['lname'] ?></span>
                        <p><?php echo $row['status'] ?></p>
                    </div>
                </div> 
            </header>
            <div class="chat-box">
            <!--Compare this snippet from server/get_chat.php-->
            </div>
            <form action="#" class="typing-area" autocomlete="off">
                <input type="text" name="outgoing_id" value="<?php echo $_SESSION['unique_id']?>" hidden>
                <input type="text" name="incoming_id" value="<?php echo $user_id?>" hidden>
                <input type="text" name="message" class="input-field" placeholder="Type a message here...">
                <button><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>
   
</body>
    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
    <script src="assets/js/chat.js"></script>
</html>