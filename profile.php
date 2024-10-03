<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    
    <link rel="stylesheet" href="assets/css/bar.css">

    <link rel="stylesheet" href="assets/css/profile.css">

</head>
<body>

    <?php include_once('navigation/header.php'); ?>
    <!--Search Bar-->
    <div id="search_bar">
        <div>
            <span class="forum-title" data-translate="K-POP Forum">K-POP Forum</span>
            <input type="text" id="search_box" data-translate="Search for people" placeholder="Search for people">
            <button id="search_button"><i class="fas fa-search"></i></button>
        </div>
    </div>
    <?php include_once('navigation/sidebar.php'); ?>

    <!--Profile Container-->
    <div class="profile-container">
        <div class="profile">
            <div class="cover-photo">
                <img src="assets/images/profile/ella_background.png" id="background-picture">
                <input type="file" id="upload-background-picture">
                <label for="upload-background-picture" id="upload-background-picture-button"><i class="fas fa-camera"></i></label>
            </div>
            <div class="profile-header">
                <img src="assets/images/profile/<?php echo $row['img'] ?>" id="profile-photo" alt="Profile Photo">
                <input type="file" id="upload-profile-header">
                <label for="upload-profile-header" id="upload-profile-header-button"><i class="fas fa-camera"></i></label>
            </div>
            <!-- Modal Structure -->
            <div id="image-modal" class="modal">
                <span class="close">&times;</span>
                <img class="modal-content" id="modal-image">
            </div>
            <div class="profile-info">
                <input type="text" id="profile-name" value="<?php echo $row['fname'] . " " .$row['lname'] ?>" placeholder="Enter Name">
                <button id="save-changes">Save Changes</button>
            </div>
        </div>

        <div class="profile-menu">
            <br>
            <!--Menu Buttons-->
            <div id="menu-buttons" onclick="location.href='timeline.php'" data-translate="Timeline">Timeline</div>
            <div id="menu-buttons" data-translate="About">About</div>
            <div id="menu-buttons" data-translate="Friends">Friends</div>
            <div id="menu-buttons" data-translate="Photos">Photos</div>
            <div id="menu-buttons" data-translate="Groups">Groups</div>
        </div>
    </div>

    <!--Friends Bar-->
    <div class="friends-bar-container">  
        <div class="friends-title" data-translate="Friends">Friends</div>
        <div class="friends-bar">
            <img class="friends-img" src="assets/images/profile/gawon.jpg">
            <span class="friends-name">Lee Gawon</span>
        </div>
        <div class="friends-bar">
            <img class="friends-img" src="assets/images/profile/sooin.jpg">
            <span class="friends-name">Kim Sooin</span>
        </div>
        <div class="friends-bar">
            <img class="friends-img" src="assets/images/profile/anna.jpg">
            <span class="friends-name">Tanaka Anna</span>
        </div>
    </div>

    <!--Post Area-->
    <div class="post-area-container">
        <textarea placeholder="What's on your mind?" data-translate="What's on your mind?"></textarea>
        <div class="post-buttons">
            <input type="file" id="upload-post-photo">
            <label for="upload-post-photo"  id="upload-post-photo-button">
                <span data-translate="Upload Photo">Upload Photo</span><i class="fas fa-upload"></i></label>
            <button id="post-button" data-translate="Post">Post</button>
        </div>
    </div>

    <!--Post Bar-->
    <div class="post-bar-container">
        <div class="post-bar">
            <div class="post-header">
                <img src="assets/images/profile/ella.jpg" id="post-profile-photo">
                <span class="post-name">Ella Gross</span>
            </div>
            <div class="post-content">
                <p>I remember nothing but the destination I was heading to. Which is why I just got here.</p>
            </div>
            <div class="post-footer">
                <button onclick="likeButton(this)" id="like-button" class="post-button"><i class="fas fa-heart"></i></button>
                <button onclick="commentButton()" id="comment-button" class="post-button"><i class="fas fa-comment"></i></button>
                <button onclick="shareButton()" id="share-button" class="post-button"><i class="fas fa-share"></i></button>
                <span class="post-date">August 21 2024</span>
            </div>
        </div>
        <div class="post-bar">
            <div class="post-header">
                <img src="assets/images/profile/gawon.jpg" id="post-profile-photo">
                <span class="post-name">Lee Gawon</span>
            </div>
            <div class="post-content">
                <p>If I were to choose between the two, I already know my answer.</p>
            </div>
            <div class="post-footer">
                <button onclick="likeButton(this)" id="like-button" class="post-button"><i class="fas fa-heart"></i></button>
                <button onclick="commentButton()" id="comment-button" class="post-button"><i class="fas fa-comment"></i></button>
                <button onclick="shareButton()" id="share-button" class="post-button"><i class="fas fa-share"></i></button>
                <span class="post-date">August 23 2024</span>
            </div>
        </div>
        <div class="post-bar">
            <div class="post-header">
                <img src="assets/images/profile/sooin.jpg" id="post-profile-photo">
                <span class="post-name">Kim Sooin</span>
            </div>
            <div class="post-content">
                <p>I think we are friends.</p>
            </div>
            <div class="post-footer">
                <button onclick="likeButton(this)" id="like-button" class="post-button"><i class="fas fa-heart"></i></button>
                <button onclick="commentButton()" id="comment-button" class="post-button"><i class="fas fa-comment"></i></button>
                <button onclick="shareButton()" id="share-button" class="post-button"><i class="fas fa-share"></i></button>
                <span class="post-date">August 25 2024</span>
            </div>
        </div>
    </div>
           
    <script src="assets/js/language.js"></script>

    <script src="assets/js/currency.js"></script>

    <script src="assets/js/profile.js"></script>

    <script src="assets/js/modal.js"></script>

    <script src="assets/js/button.js"></script>

</body>
</html>