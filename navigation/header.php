<?php
    session_start();
    if(!isset($_SESSION['unique_id'])){
        header('location:login.php');
    }
?>

<!--Navigation Bar-->
<nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!--Logo and Name-->
            <div class="d-flex align-items-center">
                <img src="assets/images/navbar/logo.png" class="navbar-logo">
                <a class="navbar-brand">KIVORIA</a>
                
                <!-- Language Selector -->
                <div class="dropdown ms-4 me-2">
                    <label for="language" class="language-label">
                        <span data-translate="Language">Language</span> |</label></label>
                    <select name="language" id="language" class="language-selector">
                        <option value="en" data-translate="English">English</option>
                        <option value="ko" data-translate="Korean">Korean</option>
                        <option value="zh-CN" data-translate="Chinese">Chinese</option>
                        <option value="ms" data-translate="Malay">Malay</option>
                    </select>
                </div>

                <!-- Currency Selector -->
                <div class="dropdown ms-4 me-2">
                    <label for="currency" class="currency-label">
                        <span data-translate="Currency">Currency</span> |</label>
                    <select name="currency" id="currency" class="currency-selector">
                        <option value="USD" data-translate="US Dollar (USD)">US Dollar (USD)</option>
                        <option value="EUR" data-translate="Euro (Euro)">Euro (EUR)</option>
                        <option value="KRW" data-translate="Korean Won (KRW)">Korean Won (KRW)</option>
                        <option value="CNY" data-translate="Chinese Yuan (CNY)">Chinese Yuan (CNY)</option>
                        <option value="MYR" data-translate="Malaysian Ringgit (MYR)">Malaysian Ringgit (MYR)</option>
                    </select>
                </div>
            </div>

             <!-- Navbar Options -->
            <div class="navbar-options ms-auto" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-translate="Notifications">Notifications</span>
                            <i class="far fa-bell"></i>     
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">
                            <span data-translate="Cart">Cart</span>
                            <i class="fas fa-cart-arrow-down"></i>
                        </a>
                    </li>
                    <form method="POST" action="logout.php">
                        <button type="logout" name="logout" class="nav-link">
                        <span data-translate="Log Out">Log Out</span>
                        <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>

                    </li>
                </ul>
            </div>
        </div>
    </nav>
