<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/bar.css">
    <link rel="stylesheet" href="assets/css/admin/admin_order.css">
</head>
<body>
    <?php include_once('navigation/admin.php'); ?>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="assets/images/navbar/logo.png" class="navbar-logo">
                <a class="navbar-brand">KIVORIA</a>
                <h5 class="navbar-admin">Admin</h5>
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
                <li><a href="admin_order.php"><i class="fas fa-shopping-bag"></i><span data-translate="Order Issues">Order</span></a></li>
                <li><a href="admin_forum.php"><i class="fas fa-icons"></i><span data-translate="Edit Forum">Edit Forum</span></a></li>
            </ul>
        </div>
    </div>

<!-- Main Content -->
<section class="edit-order-container">
    <div id="search_bar">
        <div>
            <span class="title" data-translate="View Order Issues">View Order Issues</span>
            <h2><img src="assets/images/navbar/order_icon.png" alt="Feedback"></h2>
        </div>
    </div>

<div class="product-showcases-container"> 
<?php
if (isset($_GET['message'])) {
    echo "<div class='success-message'>" . htmlspecialchars($_GET['message']) . "</div>";
} elseif (isset($_GET['error'])) {
    echo "<div class='error-message'>" . htmlspecialchars($_GET['error']) . "</div>";
}
?>  
  
<?php
$query = "SELECT oi.issue_id, o.order_id, oi.issue_description, oi.issue_image, u.fname, u.lname, oi.created_at 
          FROM order_issues oi 
          JOIN orders o ON oi.order_id = o.order_id 
          JOIN users u ON oi.user_id = u.unique_id";

$result = $conn->query($query);
?>
<table>
    <thead>
        <tr>
            <th data-translate="Order ID">Order ID</th>
            <th data-translate="User">User</th>
            <th data-translate="Issue Description">Issue Description</th>
            <th data-translate="Issue Image">Issue Image</th>
            <th data-translate="Date Reported">Date Reported</th>
            <th data-translate="Actions">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($issue = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($issue['order_id']); ?></td>
                <td><?php echo htmlspecialchars($issue['fname'] . ' ' . $issue['lname']); ?></td>
                <td data-translate="<?php echo htmlspecialchars($issue['issue_description']); ?>"><?php echo htmlspecialchars($issue['issue_description']); ?></td>
                <td><img src="assets/images/uploads/<?php echo htmlspecialchars($issue['issue_image']); ?>" width="100"></td>
                <td><?php echo htmlspecialchars($issue['created_at']); ?></td>
                <td>
                    <form method="POST" action="db_connection/resolve_issue.php">
                        <input type="hidden" name="issue_id" value="<?php echo $issue['issue_id']; ?>">
                        <button type="submit" class="btn btn-primary" data-translate="Resolve">Resolve</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

    </div>
</section>

    
    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>

</body>
</html>

