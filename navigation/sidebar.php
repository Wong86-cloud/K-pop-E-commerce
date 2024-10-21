<?php
    $conn = mysqli_connect("127.0.0.1", "root", "", "kpop_e-commerce");

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
    if(mysqli_num_rows($sql) > 0){
        $row = mysqli_fetch_assoc($sql);
    }
?>
    <!--Side Bar-->
    <div class="sidebar-container">  
        <div class="sidebar">
            <span class="sidebar-title" data-translate="Profile">Profile</span>
            <a href="forum.php">
            <div class="personal-profile">
                <img src="assets/images/profile/<?php echo $row['img'] ?>" id="sidebar-profile-photo" alt="Profile Photo">
                <span class="profile-name"><?php echo $row['fname'] . " " .$row['lname'] ?></span>
            </div>
            </a>
            <ul class="sidebar-menu">
                <li><a href="home.php"><i class="fas fa-home"></i><span data-translate="Home">Home</span></a></li>
                <li><a href="shop.php"><i class="fas fa-store"></i><span data-translate="Shop">Shop</span></a></li>
                <li><a href="wishlist.php"><i class="fas fa-heart"></i><span data-translate="Wishlist">Wishlist</span></a></li>
                <li><a href="order.php"><i class="fas fa-shopping-bag"></i><span data-translate="Order">Order</span></a></li>
                <li><a href="message.php"><i class="fas fa-envelope"></i><span data-translate="Message">Message</span></a></li>
            </ul>
        </div>
    </div>