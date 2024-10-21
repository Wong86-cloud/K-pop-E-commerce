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
    <link rel="stylesheet" href="assets/css/friends.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>

    <?php include_once('navigation/header.php');?>
    <!--Search Bar-->
    <div id="search_bar">
        <div>
        <span class="title" data-translate="K-POP Friends">K-POP Friends</span>
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
            <div id="menu-buttons" onclick="location.href='about.php'" data-translate="About">About</div>
            <div id="menu-buttons" onclick="location.href='friends.php'" data-translate="Friends">Friends</div>
            <div id="menu-buttons" onclick="location.href='likes.php'" data-translate="Likes">Likes</div>
        </div>
    </div>

    <div class="friend-list-title">
        <h2 data-translate="Friend List">Friend List</h2>
        <div class="friend-icons">
            <img src="assets/images/navbar/friend_icon.png" alt="Wishlist">
            <img src="assets/images/navbar/friend_icon2.png" alt="Wishlist">
        </div>
    </div>
    
    <?php
// Get the logged-in user's ID
$user_id = $_SESSION['unique_id'];

// Query to fetch friends
$sql_friends = "
    SELECT u.unique_id, u.fname, u.lname, u.img 
    FROM users u
    INNER JOIN friends f ON u.unique_id = f.friend_unique_id
    WHERE f.unique_id = $user_id";
$result_friends = mysqli_query($conn, $sql_friends);

// Query to fetch suggestions (users who are not friends yet)
$sql_suggestions = "
    SELECT u.unique_id, u.fname, u.lname, u.img 
    FROM users u
    WHERE u.unique_id != $user_id
    AND u.unique_id NOT IN (
        SELECT f.friend_unique_id 
        FROM friends f 
        WHERE f.unique_id = $user_id
    )";
$result_suggestions = mysqli_query($conn, $sql_suggestions);
?>

<!-- Friends List Table -->
<div class="friend-list-container">
    <table class="friend-list">
        <thead>
            <tr>
                <th>No</th>
                <th>Image</th>
                <th>Name</th>
                <th>View Profile</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php while ($row = mysqli_fetch_assoc($result_friends)) { ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td>
                        <img class="profile-img" src="assets/images/profile/<?php echo $row['img']; ?>" alt="Profile Picture">
                    </td>
                    <td><?php echo $row['fname'] . " " . $row['lname']; ?></td>
                    <td>
                        <a class="view-profile-btn" href="view_profile.php?user_id=<?php echo $row['unique_id']; ?>">View Profile</a>
                    </td>
                    <td class="centered-cell">
                        <!-- Remove Friend Form -->
                        <form action="db_connection/friend.php" method="POST" style="display:inline;">
                            <input type="hidden" name="friend_unique_id" value="<?php echo $row['unique_id']; ?>">
                            <button type="submit" name="remove_friend" class="remove-btn">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="friend-list-title">
    <h2 data-translate="Suggestion List">Suggestion List</h2>
    <div class="friend-icons">
        <img src="assets/images/navbar/suggestion_icon.png" alt="Suggestion Icon 1">
        <img src="assets/images/navbar/suggestion_icon2.png" alt="Suggestion Icon 2">
    </div>
</div>

<!-- Suggestions List Table -->
<div class="suggestion-list-container">
    <table class="suggestion-list">
        <thead>
            <tr>
                <th>No</th>
                <th>Image</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php while ($row = mysqli_fetch_assoc($result_suggestions)) { ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td>
                        <img class="profile-img" src="assets/images/profile/<?php echo $row['img']; ?>" alt="Profile Picture">
                    </td>
                    <td><?php echo $row['fname'] . " " . $row['lname']; ?></td>
                    <td class="centered-cell">
                        <!-- Add Friend Form -->
                        <form action="db_connection/friend.php" method="POST" style="display:inline;">
                            <input type="hidden" name="friend_unique_id" value="<?php echo $row['unique_id']; ?>">
                            <button type="submit" name="add_friend" class="add-btn">Add Friend</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

           
    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
    <script src="assets/js/profile.js"></script>
    

</body>
</html>