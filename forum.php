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
    <link rel="stylesheet" href="assets/css/forum.css">
    <link rel="stylesheet" href="assets/css/emoji/emoji.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>

    <?php include_once('navigation/header.php'); ?>

    <!-- Search Bar -->
    <div id="search_bar">
        <div>
            <span class="title" data-translate="K-POP Forum">K-POP Forum</span>
            <img src="assets/images/navbar/chatting.png" alt="Chat">
            <img src="assets/images/navbar/disco.png" alt="Disco">
            <img src="assets/images/navbar/chat.png" alt="Chat">
            <img src="assets/images/navbar/bestfriend.png" alt="Best Friends">
            <img src="assets/images/navbar/music2.png" alt="Music">
        </div>
    </div>

    <?php include_once('navigation/sidebar.php'); ?>

    <!-- Profile Container --> 
    <div class="profile-container">
        <form id="profile-form" action="db_connection/update_profile.php" method="POST" enctype="multipart/form-data">
            <div class="profile">
                <div class="cover-photo">
                    <img src="assets/images/profile/<?php echo htmlspecialchars($row['background_img']); ?>" id="background-picture" alt="Background Image" onclick="openModal('background-picture')">
                    <input type="file" name="upload-background-picture" id="upload-background-picture" accept="assets/images/profile/*">
                    <label for="upload-background-picture" id="upload-background-picture-button"><i class="fas fa-camera"></i></label>
                </div>
                <div class="profile-header">
                    <img src="assets/images/profile/<?php echo htmlspecialchars($row['img']); ?>" id="profile-photo" alt="Profile Photo" onclick="openModal('profile-photo')">
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

    <?php
    // Get the logged-in user's ID
    $user_id = $_SESSION['unique_id'];

    // Query to fetch users who are not yet friends
    $sql = "SELECT u.unique_id, u.fname, u.lname, u.img 
            FROM users u
            WHERE u.unique_id != $user_id
            AND u.unique_id NOT IN (
                SELECT f.friend_unique_id 
                FROM friends f 
                WHERE f.unique_id = $user_id
            )";
    $result = mysqli_query($conn, $sql);
    ?>

    <!-- Friends Bar -->
    <div class="friends-bar-container">  
        <div class="friends-title" data-translate="Friend Recommendation">Friend Recommendation</div>
        
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="friends-bar">
                <div class="friends-info">
                    <img class="friends-img" src="assets/images/profile/<?php echo htmlspecialchars($row['img']); ?>" alt="Profile Picture">
                    <span class="friends-name"><?php echo htmlspecialchars($row['fname'] . " " . $row['lname']); ?></span>
                </div>

                <div class="friends-actions">
                    <!-- Add Friend Form -->
                    <form action="db_connection/friend.php" method="POST" style="display:inline;">
                        <input type="hidden" name="friend_unique_id" value="<?php echo htmlspecialchars($row['unique_id']); ?>">
                        <button type="submit" name="add_friend" class="add-btn">Add <i class="fas fa-user-plus"></i></button>
                    </form>

                    <!-- Remove Friend Form -->
                    <form action="db_connection/friend.php" method="POST" style="display:inline;">
                        <input type="hidden" name="friend_unique_id" value="<?php echo htmlspecialchars($row['unique_id']); ?>">
                        <button type="submit" name="remove_friend" class="remove-btn">Remove <i class="fas fa-user-times"></i></button>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="post-title">
        <h2 data-translate="Select a Room">Select a Room</h2>
        <div class="post-icons">
            <img src="assets/images/navbar/room_icon.png" alt="Room Icon">
        </div>
    </div>

    <!-- Room buttons for groups -->
<div class="room-section">
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

    <!-- Post Area -->
<div class="post-area-container">
    <form action="db_connection/create_post.php" method="POST" enctype="multipart/form-data">
        <div class="post-buttons">
            <h2 data-translate="Upload Post">Upload Post</h2>
            <input type="file" name="post_image" id="upload-post-photo" accept="image/*">
            <label for="upload-post-photo" id="upload-post-photo-button">
                <span data-translate="Upload Photo">Upload Photo</span><i class="fas fa-upload"></i>
            </label>
            <button id="post-button" name="submit" data-translate="Post">Post</button>
        </div>     
        <div class="custom-container">
            <div class="col-12">
                <div class="text-left">
                    <p class="lead emoji-picker-container">
                        <textarea class="form-control textarea-control" name="post_content" rows="3" placeholder="Textarea with emoji image input" data-emojiable="true"></textarea>
                    </p>
                </div>
            </div>   
        </div>

        <!-- Room Selection Dropdown -->
        <div class="form-group">
            <label for="room-select" data-translate="Select Room To Upload Post:">Select Room To Upload Post:</label>
            <select name="room_id" id="room-select" required>
                <option value="" disabled selected data-translate="Select a Room">Select a Room</option>
                <?php 
                // Fetch available rooms from the database
                $room_query = "SELECT room_id, room_name FROM rooms"; 
                $room_result = mysqli_query($conn, $room_query);
                if (mysqli_num_rows($room_result) > 0) {
                    while ($room_row = mysqli_fetch_assoc($room_result)) {
                        $room_id = htmlspecialchars($room_row['room_id']);
                        $room_name = htmlspecialchars($room_row['room_name']);
                        echo "<option value='$room_id'>$room_name</option>";
                    }
                } else {
                    echo "<option value='' disabled>No rooms available</option>";
                }
                ?>
            </select>
        </div>
    </form>
</div>



<!-- Post Bar Container -->
<div class="post-bar-container">
<?php

// Check if the room_id is set in the URL
if (isset($_GET['room_id'])) {
    $room_id = mysqli_real_escape_string($conn, $_GET['room_id']);

    // Fetch the room details
    $room_query = "SELECT room_name, hashtag FROM rooms WHERE room_id = '$room_id'";
    $room_result = mysqli_query($conn, $room_query);

    if (mysqli_num_rows($room_result) > 0) {
        $room_row = mysqli_fetch_assoc($room_result);
        $room_name = $room_row['room_name'];
        $hashtag = $room_row['hashtag'];

        echo '<h2 data-translate="' . htmlspecialchars($room_name) . '">' . htmlspecialchars($room_name) . '</h2>';

        // Assuming $user_id is defined (you might retrieve it from session or another source)
        $user_id = $_SESSION['unique_id']; // or however you obtain the user ID

        // Adjusted Post Query to include user_liked
        $post_query = "SELECT p.*, 
                              u.fname, 
                              u.lname, 
                              u.img,
                              (SELECT COUNT(*) FROM post_likes WHERE post_id = p.post_id AND unique_id = '$user_id') AS user_liked 
                       FROM posts AS p 
                       JOIN users AS u ON p.unique_id = u.unique_id 
                       WHERE p.room_id = '$room_id' 
                       ORDER BY p.post_date DESC";

        // Execute the post query
        $post_result = mysqli_query($conn, $post_query);

        // Process the results
        if (mysqli_num_rows($post_result) > 0) {
            while ($post_row = mysqli_fetch_assoc($post_result)) {
                $post_content = $post_row['post'];
                $post_image = $post_row['post_image'];
                $post_date = $post_row['post_date'];
                $user_name = $post_row['fname'] . ' ' . $post_row['lname'];
                $profile_image = $post_row['img'];
                $got_image = !empty($post_image);
                $user_liked = isset($post_row['user_liked']) && $post_row['user_liked'] > 0; // Safe check
                ?>
                <div class="post-bar">
                    <div class="post-header">
                        <img src="assets/images/profile/<?php echo $profile_image; ?>" id="post-profile-photo">
                        <span class="post-name"><?php echo $user_name; ?></span>
                    </div>
                    <div class="post-content">
                        <p data-translate="<?php echo $post_content; ?>"><?php echo $post_content; ?></p>
                        <?php if ($got_image) { ?>
                            <img src="<?php echo $post_image; ?>" class="post-image" alt="Post Image" onclick="openModal(this)">
                        <?php } ?>
                    </div>
                    <div class="post-footer">
                        <!-- Like button -->
                        <button onclick="likeButton(this)" data-post-id="<?php echo $post_row['post_id']; ?>" class="post-button <?php echo $user_liked ? 'liked' : ''; ?>">
                            <i class="fas fa-heart" style="color: <?php echo $user_liked ? 'red' : ''; ?>"></i> 
                            <span><?php echo $post_row['post_likes']; ?></span>
                        </button>
                        <!-- Comment button -->
                        <button onclick="toggleCommentBox(<?php echo $post_row['post_id']; ?>)" class="post-button">
                            <i class="fas fa-comment"></i> 
                            <span><?php echo $post_row['post_comments']; ?></span>
                        </button>
                        <!-- View Comments button with arrow -->
                        <button onclick="toggleCommentList(<?php echo $post_row['post_id']; ?>)" class="post-button view-comments-button">
                            <span id="view-comments-text-<?php echo $post_row['post_id']; ?>" data-translate="View Comment">View Comments</span>
                            <i id="arrow-icon-<?php echo $post_row['post_id']; ?>" class="fas fa-chevron-down"></i>
                        </button>
                        <!-- Post date -->
                        <span class="post-date"><?php echo $post_date; ?></span>
                    </div>

                    <!-- Comment box -->
                    <div id="comment-box-<?php echo $post_row['post_id']; ?>" class="comment-box" style="display: none;">
                        <p class="lead emoji-picker-container">
                            <textarea id="comment-input-<?php echo $post_row['post_id']; ?>" class="comment-input" placeholder="Type your comment..." data-emojiable="true"></textarea>
                        </p>
                        <button onclick="submitComment(<?php echo $post_row['post_id']; ?>)" class="comment-submit-button">Post</button>
                    </div>

                    <!-- Display comments for the post -->
                    <div id="comment-list-<?php echo $post_row['post_id']; ?>" class="comment-bar-container" style="display: none;">
                        <?php
                        // Fetch comments for the current post
                        $post_id = $post_row['post_id'];
                        $comments_query = "SELECT c.comment_id, c.comment, c.comment_date, u.fname, u.lname, u.img 
                                           FROM post_comments AS c 
                                           JOIN users AS u ON c.unique_id = u.unique_id 
                                           WHERE c.post_id = '$post_id' 
                                           ORDER BY c.comment_date ASC";
                        $comments_result = mysqli_query($conn, $comments_query);

                        if (mysqli_num_rows($comments_result) > 0) {
                            while ($comment_row = mysqli_fetch_assoc($comments_result)) {
                                $comment_content = $comment_row['comment'];
                                $comment_date = $comment_row['comment_date'];
                                $comment_user_name = $comment_row['fname'] . ' ' . $comment_row['lname'];
                                $comment_profile_image = $comment_row['img'];
                        ?>
                        <div class="comment-bar" id="comment-<?php echo $comment_row['comment_id']; ?>">
                            <div class="comment-header">
                                <img src="assets/images/profile/<?php echo $comment_profile_image; ?>" class="comment-profile-photo">
                                <span class="comment-name"><?php echo $comment_user_name; ?></span>
                                <span class="comment-date"><?php echo $comment_date; ?></span>
                            </div>
                            <div class="comment-content">
                                <p><?php echo $comment_content; ?></p>
                            </div>
                        </div> 
                        <?php
                            }
                        } else {
                            echo "<h4>No comments yet.</h4>";
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<h4>No posts found for this room yet.</h4>";
        }
    } else {
        echo "<h4>Room not found!</h4>";
    }
} else {
    echo "<h4>No room selected.</h4>";
}
?>
</div>

</body>
   
    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
    <script src="assets/js/profile.js"></script>

    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Begin emoji-picker JavaScript -->
    <script src="assets/js/emoji/config.js"></script>
    <script src="assets/js/emoji/util.js"></script>
    <script src="assets/js/emoji/jquery.emojiarea.js"></script>
    <script src="assets/js/emoji/emoji-picker.js"></script>
    <!-- End emoji-picker JavaScript -->

    <script>
        $(function() {
            // Initializes and creates emoji set from sprite sheet
            window.emojiPicker = new EmojiPicker({
                emojiable_selector: '[data-emojiable=true]',
                assetsPath: 'assets/images/emoji',
                popupButtonClasses: 'far fa-smile-beam',
                position: 'top-start'
            });
            // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
            // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
            // It can be called as many times as necessary; previously converted input fields will not be converted again
            window.emojiPicker.discover();
        });
    </script>


</html>