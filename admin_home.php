<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/bar.css">
    <link rel="stylesheet" href="assets/css/admin/admin_home.css">
</head>
<body>
    <?php include_once('navigation/admin.php'); ?>

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
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <section class="graph-container">
        <div id="search_bar">
            <div>
                <span class="title">Graphs</span>
                <h2><img src="assets/images/navbar/graph_icon.png" alt="Feedback"></h2>
            </div>
        </div>
        <div class="graph-showcases-container">
            <div class="graph-title">
                <h3>Sales Statistic</h3>
                <h3><img src="assets/images/navbar/sales.png" alt="Sales"></h3>
            </div>
            <div class="graph-question">
                <h6>Average Price of Purchased Products</h6>
                <div style="width: 80%; height:200px; max-width: 600px; margin: auto;">
                    <canvas id="averagePriceChart" width="400" height="200"></canvas>
                </div>
                <h6>Best-Selling Products</h6>
                <div style="width: 80%; height: 200px;; max-width: 600px; margin: auto;">
                    <canvas id="bestSellersChart" width="400" height="200"></canvas>
                </div>
                <h6>Best-Selling Products by Celebrity</h6>
                <div id="bestSellingCelebrities" style="width: 80%; height:200px; max-width: 600px; margin: auto;">
                    <canvas id="bestSellingChart" width="400" height="200"></canvas>
                </div>
            </div>
            <div class="graph-title">
                <h3>Customer Feedback Statistic</h3>
                <h3><img src="assets/images/navbar/feedback2.png" alt="Feedback"></h3>
            </div>

            <!-- Feedback Questions -->
            <?php for ($i = 1; $i <= 8; $i++): ?>
                <div class="graph-question">
                    <h6>Question <?php echo $i; ?>: <?php echo getFeedbackQuestion($i); ?></h6>
                    <div style="width: 40%; height:auto; max-width: 300px; margin:auto;">
                        <canvas id="q<?php echo $i; ?>Chart" width="400" height="200"></canvas>
                    </div>
                </div>
            <?php endfor; ?>

            <div class="graph-title">
                <h3>Most Popular Celebrity</h3>
                <h3><img src="assets/images/navbar/celebrity.png" alt="Celebrity"></h3>
            </div>
            <div class="graph-question">
                <h6>Popularity of Celebrity Hashtags Based on User-Created Rooms</h6>
                <div style="width: 80%; height: 200px;; max-width: 600px; margin: auto;">
                    <canvas id="popularityChart" width="400" height="200"></canvas>
                </div>
                <h6>Most Liked Posts</h6>
                <div style="width: 80%; height: 400px;; max-width: 800px; margin: auto;">
                    <canvas id="likedPostsChart" width="400" height="200"></canvas>
                </div>
                <h6>Most Commented Posts</h6>
                <div style="width: 80%; height: 400px;; max-width: 800px; margin: auto;">
                    <canvas id="commentedPostsChart" width="400" height="200"></canvas>
                </div>
        </div>
        <div class="button-container">
            <button id="generatePDFReportBtn">
                <i class="fas fa-file-pdf"></i> Generate PDF Report
            </button>
        </div>
    </section>
    
    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
    <!-- Graph -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/admin/admin_home.js"></script>
    <!-- Generate PDF Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</body>
</html>

<?php
function getFeedbackQuestion($index) {
    $questions = [
        "How satisfied are you with the overall shopping experience on KIVORIA?",
        "How would you rate the variety of K-pop merchandise available?",
        "Which categories of K-pop products do you frequently purchase?",
        "How easy is it to navigate and find products on our website?",
        "What payment method did you use for your most recent purchase?",
        "Did you face any issues during the checkout process?",
        "Which feature do you find most useful on KIVORIA?",
        "How likely are you to recommend KIVORIA to a friend?"
    ];
    return isset($questions[$index - 1]) ? $questions[$index - 1] : "Question not found.";
}
?>
