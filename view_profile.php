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
    <link rel="stylesheet" href="assets/css/view_profile.css">
    <link rel="stylesheet" href="assets/css/emoji/emoji.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>

    <?php include_once('navigation/header.php'); ?>
    
    <!-- Search Bar -->
    <div id="search_bar">
        <div>
            <span class="title" data-translate="View Profile">View Profile</span>
            <img src="assets/images/navbar/chatting.png" alt="Wishlist">
            <img src="assets/images/navbar/disco.png" alt="Wishlist">
            <img src="assets/images/navbar/chat.png" alt="Wishlist">
            <img src="assets/images/navbar/bestfriend.png" alt="Wishlist">
            <img src="assets/images/navbar/music2.png" alt="Wishlist">
        </div>
    </div>

    <?php include_once('navigation/sidebar.php'); ?>

    <div class="profile-container">
        <?php
        // Fetch user data based on the user ID passed in the URL or session
        $view_user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : $_SESSION['unique_id']; // Default to logged-in user

        $query = "SELECT fname, lname, gender, dob, country, about_me, img, background_img FROM users WHERE unique_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $view_user_id);
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
            $profile_img = $row['img'];
            $background_img = $row['background_img'];
        } else {
            // Handle user not found case
            echo '<p>User not found.</p>';
            exit;
        }
        ?>

        <div class="profile">
            <div class="cover-photo">
                <img src="assets/images/profile/<?php echo $background_img; ?>" id="background-picture" alt="Background Image">
            </div>
            <div class="profile-header">
                <img src="assets/images/profile/<?php echo $profile_img; ?>" id="profile-photo" alt="Profile Photo">
            </div>
            <div class="profile-info">
                <h2 id="profile-name"><?php echo $fname . " " . $lname; ?></h2>
            </div>
        </div>
    </div>

    <div class="profile-info-container">
        <!-- Left Side: Post Photo Section - Displaying Photos of the Profile Being Viewed -->
        <div class="post-photo-section">
            <h2>Photos by <?php echo $fname; ?></h2>
            <div class="photo-frame">
                <div class="photo-grid">
                    <?php
                    // Fetch photos from the database for the viewed user
                    $query = "SELECT photo_id, photo_url FROM personal_photos WHERE unique_id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('i', $view_user_id); // Use the user ID from the variable
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="photo-cell uploaded-photo">';
                            echo '<img src="' . $row['photo_url'] . '" alt="User Photo">';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No photos available.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Right Side: Personal Information Section -->
        <div class="personal-info-section">
            <h2>Personal Information</h2>
            <form id="personal-info-form" action="db_connection/update_personal_info.php" method="POST">
                <div>
                    <label for="fname"><i class="fas fa-user"></i> First Name:</label>
                    <input type="text" id="fname" name="fname" value="<?php echo $fname; ?>" placeholder="Your First Name" readonly>
                </div>
                <div>
                    <label for="lname"><i class="fas fa-user"></i> Last Name:</label>
                    <input type="text" id="lname" name="lname" value="<?php echo $lname; ?>" placeholder="Your Last Name" readonly>
                </div>
                <div>
                    <label for="gender"><i class="fas fa-venus-mars"></i> Gender:</label>
                    <input type="text" id="gender" value="<?php echo $gender; ?>" readonly>
                </div>
                <div>
                    <label for="dob"><i class="fas fa-calendar-alt"></i> Date of Birth:</label>
                    <input type="text" id="dob" value="<?php echo $dob; ?>" readonly>
                </div>
                <div>
                    <label for="country"><i class="fas fa-globe"></i> Country:</label>
                    <input type="text" id="country" value="<?php echo $country; ?>" readonly>
                </div>
                <div>
                    <label for="about_me"><i class="fas fa-user-edit"></i> About Me:</label>
                    <p class="lead emoji-picker-container">
                        <textarea class="form-control textarea-control" name="about_me" id="about_me" rows="3" placeholder="Textarea with emoji image input" data-emojiable="true" readonly><?php echo $about_me; ?></textarea>
                    </p>
                </div>
                <!-- Back Button -->
                <div style="margin-top: auto; text-align: right; width: 100%;">
                    <button type="button" class="btn btn-secondary mb-3" onclick="window.history.back();">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
</body>
</html>
