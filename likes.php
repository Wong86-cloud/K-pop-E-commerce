<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/bar.css">
    <link rel="stylesheet" href="assets/css/profile.css">
    <link rel="stylesheet" href="assets/css/likes.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>

    <?php include_once('navigation/header.php');?>
    <!--Search Bar-->
    <div id="search_bar">
        <div>
            <span class="title" data-translate="K-POP Likes">K-POP Likes</span>
            <img src="assets/images/navbar/chatting.png" alt="Wishlist">
            <img src="assets/images/navbar/disco.png" alt="Wishlist">
            <img src="assets/images/navbar/chat.png" alt="Wishlist">
            <img src="assets/images/navbar/bestfriend.png" alt="Wishlist">
            <img src="assets/images/navbar/music2.png" alt="Wishlist">
        </div>
    </div>
    <?php 
    include_once('navigation/sidebar.php');  
    ?>

    <!--Profile Container--> 
    <div class="profile-container">
        <form id="profile-form" action="db_connection/update_profile.php" method="POST" enctype="multipart/form-data">
            <div class="profile">
                <div class="cover-photo">
                    <img src="assets/images/profile/<?php echo $row['background_img'] ?>" id="background-picture" alt="Background Image" onclick="openModal('background-picture')">
                    <input type="file" name="upload-background-picture" id="upload-background-picture" accept="assets/images/profile/*">
                    <label for="upload-background-picture" id="upload-background-picture-button"><i class="fas fa-camera"></i></label>
                </div>
                <div class="profile-header">
                    <img src="assets/images/profile/<?php echo $row['img'] ?>" id="profile-photo" alt="Profile Photo" onclick="openModal('profile-photo')">
                    <input type="file" name="upload-profile-header" id="upload-profile-header" accept="assets/images/profile/*">
                    <label for="upload-profile-header" id="upload-profile-header-button"><i class="fas fa-camera"></i></label>
                </div>
                <!-- Image Modal -->
                <div id="image-modal" class="modal">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <img class="modal-content" id="modal-image">
                    <div id="caption"></div>
                </div>
                <div class="profile-info">
                    <div class="discussion-profile-name" id="profile-name"><?php echo htmlspecialchars($row['fname'] . " " . $row['lname']); ?></div>
                </div>
                <div class="save-button">
                    <button type="submit" id="save-changes">Save Changes</button>
                </div>
            </div>
        </form>
    
        <div class="profile-menu">
            <br>
            <!--Menu Buttons-->
            <div id="menu-buttons" onclick="location.href='forum.php'" data-translate="Forum">Forum</div>
            <div id="menu-buttons" onclick="location.href='groups.php'" data-translate="Groups">Groups</div>
            <div id="menu-buttons" onclick="location.href='about.php'" data-translate="About">About</div>
            <div id="menu-buttons" onclick="location.href='friends.php'" data-translate="Friends">Friends</div>
            <div id="menu-buttons" onclick="location.href='likes.php'" data-translate="Likes">Likes</div>
        </div>
    </div>

    <div class="like-title">
        <h2 data-translate="Like Post">Like Post</h2>
        <div class="like-icons">
            <img src="assets/images/navbar/love_icon2.png" alt="Wishlist">
            <img src="assets/images/navbar/love_icon.png" alt="Wishlist">
        </div>
    </div>


    <!--Post Bar Container-->
    <div class="like-post-container">
        <?php include ('db_connection/fetch_liked_posts.php'); ?>
    </div>

           
    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
    <script src="assets/js/profile.js"></script>
    

</body>
</html>