<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Forum Monitoring</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/bar.css">
    <link rel="stylesheet" href="assets/css/admin/admin_forum.css">
</head>
<body>
<?php 
include_once('navigation/admin.php'); 

// Fetch all posts
$query_posts = "SELECT posts.*, users.fname, users.lname FROM posts 
                JOIN users ON posts.unique_id = users.unique_id";
$result_posts = mysqli_query($conn, $query_posts);

// Fetch all comments
$query_comments = "SELECT post_comments.*, users.fname, users.lname, posts.post 
                   FROM post_comments 
                   JOIN users ON post_comments.unique_id = users.unique_id 
                   JOIN posts ON post_comments.post_id = posts.post_id";
$result_comments = mysqli_query($conn, $query_comments);
?>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="assets/images/navbar/logo.png" class="navbar-logo">
                <a class="navbar-brand">KIVORIA</a>
                <h5 class="navbar-admin" >Admin</h5>
                <div class="dropdown ms-4 me-2">
                    <label for="language" class="language-label">
                        <span data-translate="Language">Language</span> |
                    </label>
                    <select name="language" id="language" class="language-selector">
                        <option value="en" data-translate="English">English</option>
                        <option value="ko" data-translate="Korean">Korean</option>
                        <option value="zh-CN" data-translate="Chinese">Chinese</option>
                        <option value="ms" data-translate="Malay">Malay</option>
                    </select>
                </div>
            </div>
            <div class="navbar-options ms-auto" id="navbarNav">
                <ul class="navbar-nav">
                    <form method="POST" action="admin_logout.php">
                        <button type="logout" name="logout" class="nav-link">
                        <span data-translate="Log Out">Log Out</span>
                        <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Side Bar -->
    <div class="sidebar-container">  
        <div class="sidebar">
            <span class="sidebar-title" data-translate="Profile">Profile</span>
            <a href="admin_forum.php">
                <div class="personal-profile">
                    <img src="assets/images/profile/<?php echo $row['img'] ?>" id="sidebar-profile-photo" alt="Profile Photo">
                    <span class="profile-name"><?php echo $row['fname'] . " " .$row['lname'] ?></span>
                </div>
            </a>
            <ul class="sidebar-menu">
                <li><a href="admin_home.php"><i class="fas fa-chart-line"></i><span data-translate="Graph">Graph</span></a></li>
                <li><a href="admin_order.php"><i class="fas fa-shopping-bag"></i><span data-translate="Order">Order</span></a></li>
                <li><a href="admin_forum.php"><i class="fas fa-icons"></i><span data-translate="Forum">Forum</span></a></li>
            </ul>
        </div>
    </div>

    <section class="forum-container">
    <div id="search_bar">
        <div>
            <span class="title" data-translate="Delete Forum">Delete Forum</span>
            <h2><img src="assets/images/navbar/forum_icon.png" alt="Feedback"></h2>
        </div>
    </div>
    <div class="forum-showcases-container">
        <!-- Forum Post Section -->
        <div class="forum-title">
            <h3 data-translate="Forum Post">Forum Post</h3>
            <h3><img src="assets/images/navbar/post.png" alt="Celebrity"></h3>
        </div>
        <div class="table-wrapper">
            <table border="1">
                <tr>
                    <th>Post ID</th>
                    <th>User</th>
                    <th>Content</th>
                    <th>Image</th>
                    <th>Comments</th>
                    <th>Likes</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                <?php while ($post = mysqli_fetch_assoc($result_posts)) { ?>
                <tr>
                    <td><?php echo $post['post_id']; ?></td>
                    <td><?php echo $post['fname'] . " " . $post['lname']; ?></td>
                    <td><?php echo $post['post']; ?></td>
                    <td><?php echo $post['post_image'] ? "<img src='" . $post['post_image'] . "' width='100'>" : "No Image"; ?></td>
                    <td><?php echo $post['post_comments']; ?></td>
                    <td><?php echo $post['post_likes']; ?></td>
                    <td><?php echo $post['post_date']; ?></td>
                    <td>
                        <form method="POST" action="db_connection/delete_post.php">
                            <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
        
        <!-- Forum Comment Section -->
        <div class="forum-title">
            <h3 data-translate="Forum Comment">Forum Comment</h3>
            <h3><img src="assets/images/navbar/post_comment.png" alt="Celebrity"></h3>
        </div>
        <div class="table-wrapper">
            <table border="1">
                <tr>
                    <th>Comment ID</th>
                    <th>Post</th>
                    <th>User</th>
                    <th>Comment</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                <?php while ($comment = mysqli_fetch_assoc($result_comments)) { ?>
                <tr>
                    <td><?php echo $comment['comment_id']; ?></td>
                    <td><?php echo $comment['post']; ?></td>
                    <td><?php echo $comment['fname'] . " " . $comment['lname']; ?></td>
                    <td><?php echo $comment['comment']; ?></td>
                    <td><?php echo $comment['comment_date']; ?></td>
                    <td>
                        <form method="POST" action="db_connection/delete_comment.php">
                            <input type="hidden" name="comment_id" value="<?php echo $comment['comment_id']; ?>">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this comment?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</section>


</body>
    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
</html>