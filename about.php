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
    <link rel="stylesheet" href="assets/css/about.css">
    <link rel="stylesheet" href="assets/css/emoji/emoji.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>

    <?php include_once('navigation/header.php');?>
    <!--Search Bar-->
    <div id="search_bar">
        <div>
            <span class="title" data-translate="K-POP About">K-POP About</span>
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
                    <button type="submit" id="save-changes" data-translate="Save Changes">Save Changes</button>
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

    <?php
    // Fetch user data based on session unique_id
    $query = "SELECT fname, lname, gender, dob, country, about_me FROM users WHERE unique_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $_SESSION['unique_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Assign fetched data to variables
    $fname = htmlspecialchars($row['fname']);
    $lname = htmlspecialchars($row['lname']);
    $gender = $row['gender'];
    $dob = $row['dob'];
    $country = $row['country'];
    $about_me = htmlspecialchars($row['about_me']);
    } else {
    // Set fallback values in case no user data is found
    $fname = '';
    $lname = '';
    $gender = '';
    $dob = '';
    $country = '';
    $about_me = '';
    }
    ?>

    <div class="profile-info-container">
    <!-- Left Side: Post Photo Section -->
    <div class="post-photo-section">
        <h2 data-translate="Your Photos">Your Photos</h2>
        <div class="photo-frame">
            <!-- Add Picture Grid -->
            <div class="photo-grid">
                <?php
                // Fetch photos from the database for the logged-in user
                $query = "SELECT photo_id, photo_url FROM personal_photos WHERE unique_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('i', $_SESSION['unique_id']);  // Assuming unique_id is stored in the session
                $stmt->execute();
                $result = $stmt->get_result();

                $photo_count = 0;
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="photo-cell uploaded-photo">';
                    echo '<img src="' . $row['photo_url'] . '" alt="User Photo">';
                    // Reupload options
                    echo '<div class="photo-options reupload-option">';
                    echo '<form action="db_connection/reupload_personal_photo.php" method="POST" enctype="multipart/form-data">';
                    echo '<label for="reupload-' . $row['photo_id'] . '" class="reupload-label"><i class="fas fa-redo"></i></label>';
                    echo '<input type="file" name="photo" id="reupload-' . $row['photo_id'] . '" class="photo-upload-input" onchange="this.form.submit()">';
                    echo '<input type="hidden" name="photo_id" value="' . $row['photo_id'] . '">';
                    echo '</form>';
                    echo '</div>'; // End of reupload-option

                    // Delete options
                    echo '<div class="photo-options delete-option">';
                    echo '<form action="db_connection/delete_personal_photo.php" method="POST">';
                    echo '<input type="hidden" name="photo_id" value="' . $row['photo_id'] . '">';
                    echo '<button type="submit" class="delete-photo-btn"><i class="fas fa-trash-alt"></i></button>';
                    echo '</form>';
                    echo '</div>'; // End of delete-option
                    echo '</div>';
                    $photo_count++;
                }

                // Add photo upload cells if less than 6 photos exist
                for ($i = $photo_count; $i < 6; $i++) {
                    echo '<div class="photo-cell">';
                    echo '<form id="upload-photo-form-' . $i . '" action="db_connection/upload_personal_photo.php" method="POST" enctype="multipart/form-data">';
                    echo '<label for="upload-' . $i . '" class="add-photo-icon"><i class="fas fa-plus"></i></label>';
                    echo '<input type="file" name="photo" id="upload-' . $i . '" class="photo-upload-input" onchange="this.form.submit()" accept="assets/images/uploads/*">';
                    echo '</form>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Right Side: Personal Information Section -->
    <div class="personal-info-section">
        <h3 data-translate="Personal Information" >Personal Information</h3>
        <form id="personal-info-form" action="db_connection/update_personal_info.php" method="POST">
            <div class="form-group">
                <label for="fname" data-translate="First Name:">First Name:</label>
                <input type="text" id="fname" name="fname" value="<?php echo $fname; ?>" placeholder="Your First Name" required>
            </div>
            <div class="form-group">
                <label for="lname" data-translate="Last Name:">Last Name:</label>
                <input type="text" id="lname" name="lname" value="<?php echo $lname; ?>" placeholder="Your Last Name" required>
            </div>          
            <div class="form-group">
                <label for="gender" data-translate="Gender:">Gender:</label>
                <select name="gender" id="gender">
                    <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo ($gender == 'Other') ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="dob" data-translate="Date of Birth:" >Date of Birth:</label>
                <input type="date" name="dob" id="dob" value="<?php echo $dob; ?>">
            </div>
            <div class="form-group">
                <label for="country" data-translate="Country:">Country:</label>
                <select id="country-region" name="country-region" required>
                    <option value="China" <?php echo ($country === 'China') ? 'selected' : ''; ?>>China</option>
                    <option value="South Korea" <?php echo ($country === 'South Korea') ? 'selected' : ''; ?>>South Korea</option>
                    <option value="Japan" <?php echo ($country === 'Japan') ? 'selected' : ''; ?>>Japan</option>
                    <option value="United States" <?php echo ($country === 'United States') ? 'selected' : ''; ?>>United States</option>
                    <option value="United Kingdom" <?php echo ($country === 'United Kingdom') ? 'selected' : ''; ?>>United Kingdom</option>
                    <option value="Malaysia" <?php echo ($country === 'Malaysia') ? 'selected' : ''; ?>>Malaysia</option>
                </select>
            </div>
            <div>
                <label for="about_me" data-translate="About Me:">About Me:</label>
                <p class="lead emoji-picker-container">
                    <textarea class="form-control textarea-control" name="about_me" id="about_me" rows="3" placeholder="Textarea with emoji image input" data-emojiable="true">
                        <?php echo $about_me; ?>
                    </textarea>
                </p>
            </div>
            <div>
                <button type="submit" class="submit-button">
                    <i class="fas fa-save"></i>
                    <span id="submit-button" data-translate="Update Information">Update Information</span>
                </button>
            </div>
        </form>
    </div>
    </div>
           
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

</body>
</html>