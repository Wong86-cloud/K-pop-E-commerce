<?php
$unique_id = $_SESSION['unique_id']; // Assuming user is logged in and their unique_id is stored in session

// Fetch posts liked by the user
$query = "SELECT p.post_id, p.post, p.post_image, p.post_date, u.fname, u.lname, u.img, p.got_image
          FROM post_likes AS l
          JOIN posts AS p ON l.post_id = p.post_id
          JOIN users AS u ON p.unique_id = u.unique_id
          WHERE l.unique_id = '$unique_id'
          ORDER BY p.post_date DESC";

$result = mysqli_query($conn, $query);

// Check if there are any liked posts
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Variables to store post data
        $post_content = $row['post'];
        $post_image = $row['post_image'];
        $post_date = $row['post_date'];
        $user_name = $row['fname'] . ' ' . $row['lname'];
        $profile_image = $row['img'];
        $got_image = $row['got_image'];
?>
        <div class="post-bar">
            <div class="post-header">
                <img src="assets/images/profile/<?php echo $profile_image; ?>" id="post-profile-photo">
                <span class="post-name"><?php echo $user_name; ?></span>
            </div>
            <div class="post-content">
                <p data-translate="<?php echo $post_content; ?>"><?php echo $post_content; ?></p>
                <?php if ($got_image) { ?>
                    <img src="<?php echo $post_image; ?>" class="post-image" alt="Post Image">
                <?php } ?>
            </div>
            <div class="post-footer">
                <span class="post-date"><?php echo $post_date; ?></span>
            </div>
        </div>
<?php
    }
} else {
    echo "<h4>You haven't liked any posts yet.</h4>";
}
?>
