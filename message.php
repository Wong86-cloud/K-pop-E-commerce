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
    <div id="search_bar">
        <div>
            <span class="title" data-translate="K-POP Message">K-POP Message</span>
            <img src="assets/images/navbar/music.png" alt="Wishlist">
            <img src="assets/images/navbar/disc.jfif" alt="Wishlist">
            <img src="assets/images/navbar/headphones.png" alt="Wishlist">
            <img src="assets/images/navbar/mic.png" alt="Wishlist">
            <img src="assets/images/navbar/love.png" alt="Wishlist">
        </div>
    </div>
    <?php include_once('navigation/sidebar.php'); ?>
    
    <!--Message Container-->
    <div class="users-container">
        <section class="users">
            <header>
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
            if(mysqli_num_rows($sql) > 0){
                $row = mysqli_fetch_assoc($sql);
            }
            ?>
                <div class="content">
                    <img src="assets/images/profile/<?php echo $row['img'] ?>" alt="">
                    <div class="details">
                        <span><?php echo $row['fname'] . " " .$row['lname'] ?></span>
                        <p data-translate="<?php echo $row['status'] ?>"><?php echo $row['status'] ?></p>
                    </div>
                </div> 
            </header>
            <div class="search">
                <span class="text">Select an user to start chat</span>
                <input type="text" data-translate="Search for people" placeholder="Search for people">
                <button><i class="fas fa-search"></i></button>
            </div>       
            <div class="users-list">
            <!--Compare this snippet from server/users.php-->
            </div>
        </section>
    </div>
   
</body>
    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
    <script src="assets/js/message.js"></script>
</html>
