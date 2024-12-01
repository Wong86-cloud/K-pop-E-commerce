<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/bar.css">
    <link rel="stylesheet" href="assets/css/profile.css">
    <link rel="stylesheet" href="assets/css/groups.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>

    <?php include_once('navigation/header.php'); ?>
    <!-- Search Bar -->
    <div id="search_bar">
        <div>
            <span class="title" data-translate="K-POP Groups">K-POP Groups</span>
            <img src="assets/images/navbar/chatting.png" alt="Wishlist">
            <img src="assets/images/navbar/disco.png" alt="Wishlist">
            <img src="assets/images/navbar/chat.png" alt="Wishlist">
            <img src="assets/images/navbar/bestfriend.png" alt="Wishlist">
            <img src="assets/images/navbar/music2.png" alt="Wishlist">
        </div>
    </div>
    
    <?php include_once('navigation/sidebar.php'); ?>

    <!-- Profile Container --> 
    <div class="profile-container">
        <form id="profile-form" action="db_connection/update_profile.php" method="POST" enctype="multipart/form-data">
            <div class="profile">
                <div class="cover-photo">
                    <img src="assets/images/profile/<?php echo $row['background_img']; ?>" id="background-picture" alt="Background Image" onclick="openModal('background-picture')">
                    <input type="file" name="upload-background-picture" id="upload-background-picture" accept="assets/images/profile/*">
                    <label for="upload-background-picture" id="upload-background-picture-button"><i class="fas fa-camera"></i></label>
                </div>
                <div class="profile-header">
                    <img src="assets/images/profile/<?php echo $row['img']; ?>" id="profile-photo" alt="Profile Photo" onclick="openModal('profile-photo')">
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
                    <button type="submit" id="save-changes" data-translate="Save Changes">Save Changes</button>
                </div>
            </div>
        </form>
    
        <div class="profile-menu">
            <br>
            <!-- Menu Buttons -->
            <div id="menu-buttons" onclick="location.href='forum.php'" data-translate="Forum">Forum</div>
            <div id="menu-buttons" onclick="location.href='groups.php'" data-translate="Groups">Groups</div>
            <div id="menu-buttons" onclick="location.href='about.php'" data-translate="About">About</div>
            <div id="menu-buttons" onclick="location.href='friends.php'" data-translate="Friends">Friends</div>
            <div id="menu-buttons" onclick="location.href='likes.php'" data-translate="Likes">Likes</div>
        </div>
    </div>

    <div class="group-title">
    <h2 data-translate="Discussion Rooms">Discussion Rooms</h2>
    <div class="group-icons">
        <img src="assets/images/navbar/group_icon.png" alt="Wishlist">
        <img src="assets/images/navbar/group_icon2.png" alt="Wishlist">
    </div>
</div>

<?php
if (isset($_GET['celebrity_hashtag']) && isset($_GET['room_name'])) {
    $room_name = mysqli_real_escape_string($conn, $_GET['room_name']); 
    $hashtag = mysqli_real_escape_string($conn, $_GET['celebrity_hashtag']);
    $unique_id = $_SESSION['unique_id']; // Assuming the user is logged in and unique_id is stored in session

    // Check if the room already exists
    $room_query = "SELECT room_id FROM rooms WHERE hashtag = '$hashtag'";
    $room_result = mysqli_query($conn, $room_query);

    if (mysqli_num_rows($room_result) == 0) {
        // Room doesn't exist, create a new one
        $create_room_query = "INSERT INTO rooms (room_name, hashtag, created_by) VALUES ('$room_name', '$hashtag', '$unique_id')";
        mysqli_query($conn, $create_room_query);
        $room_id = mysqli_insert_id($conn); // Get the ID of the newly created room
    } else {
        // Room exists, retrieve its room_id
        $room_row = mysqli_fetch_assoc($room_result);
        $room_id = $room_row['room_id'];
    }

    // Redirect to the forum with the room_id
    header("Location: forum.php?room_id=$room_id");
    exit();
}
// End output buffering and flush output
ob_end_flush();
?>

<div class="group-list-container">
    <!-- Group creation form -->
    <form action="" method="GET" class="group-form"> <!-- Ensure this is pointing to the correct processing file -->
        <input type="text" name="room_name" placeholder="Enter Room Name" data-translate="Enter Room Name" required> 
        <select name="celebrity_hashtag" required>
            <option value="" disabled selected data-translate="Select a Celebrity">Select a Celebrity</option>
            <option value="#BTS">#BTS</option>
            <option value="#BLACKPINK">#BLACKPINK</option>
            <option value="#AESPA">#AESPA</option>
            <option value="#NEW JEANS">#NEW JEANS</option>
            <!-- Add more options as needed -->
        </select>
        <button type="submit" data-translate="Create or Join Room">Create or Join Room</button>
    </form>

    <!-- Room buttons section -->
    <div class="view-room-section">
        <?php 
        // Fetch unique rooms (groups) created by users
        $room_query = "SELECT room_id, room_name, hashtag FROM rooms"; // Fetch room_id, room_name, and hashtag
        $room_result = mysqli_query($conn, $room_query);
        
        if (mysqli_num_rows($room_result) > 0) {
            while ($room_row = mysqli_fetch_assoc($room_result)) {
                $room_id = htmlspecialchars($room_row['room_id']);
                $room_name = htmlspecialchars($room_row['room_name']);
                $room_hashtag = htmlspecialchars($room_row['hashtag']);
                echo "<a href='forum.php?room_id=$room_id' class='room-button'>$room_name $room_hashtag</a>"; // Show room name with hashtag
            }
        } else {
            echo "<h4>No rooms available yet. Be the first to create one!</h4>";
        }
        ?>
    </div>
</div>


</body>
    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
</html>
