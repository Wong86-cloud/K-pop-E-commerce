<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    
    <link rel="stylesheet" href="assets/css/bar.css">

    <link rel="stylesheet" href="assets/css/home.css">

</head>
<body>

    <?php include_once('navigation/header.php'); ?>
    <div id="search_bar">
        <div>
            <span class="title" data-translate="K-POP Home">K-POP Home</span>
            <img src="assets/images/navbar/music.png" alt="Wishlist">
            <img src="assets/images/navbar/disc.jfif" alt="Wishlist">
            <img src="assets/images/navbar/headphones.png" alt="Wishlist">
            <img src="assets/images/navbar/mic.png" alt="Wishlist">
            <img src="assets/images/navbar/love.png" alt="Wishlist">
        </div>
    </div>
    <?php include_once('navigation/sidebar.php'); ?>

    <div class="home-container">
      <section id="home">
          <div id="homeCarousel" class="carousel-container">
              <button class="carousel-slide-btn left-btn" onclick="prevSlideHome()"><i class="fas fa-chevron-left"></i></button>
              <div class="carousel-slides">
                  <div class="carousel-slide">
                      <img src="assets/images/artists/blacpink.jpg" alt="Promotion 1" class="banner-image">
                      <div class="banner-content3">
                          <h1 data-translate="Exclusive Blackpink">Exclusive Blackpink</h1>
                          <h1 data-translate="Merchandise">Merchandise</h1>
                          <p data-translate="Limited-edition items available now!">Limited-edition items available now!</p>
                          <button class="btn shop-btn" onclick="window.location.href='shop.php?celebrity=blackpink'" data-translate="Buy Now">Buy Now</button>
                      </div>
                      <div class="album-cover">
                          <img src="assets/images/shop/album4.jpg" alt="album" class="album-image">
                      </div>
                  </div>
                  <div class="carousel-slide">
                      <img src="assets/images/artists/aespa.jfif" alt="Promotion 2" class="banner-image">
                      <div class="banner-content2">
                          <h1 data-translate="New Arrivals">New Arrivals</h1>
                          <p data-translate="Check out the latest collections from your favorite AESPA group.">Check out the latest collections from your favorite AESPA group.</p>
                          <button class="btn shop-btn" onclick="window.location.href='shop.php?celebrity=aespa'" data-translate="Explore">Explore</button>
                      </div>
                  </div>
              </div>
              <button class="carousel-slide-btn right-btn" onclick="nextSlideHome()"><i class="fas fa-chevron-right"></i></button>
          </div>
      </section>
  </div>

  <!--Brands-->
  <section id="brands">
    <div class="container">
      <h1 data-translate="Collaboration Brand">Collaboration Brand</h1>
      <div class="container d-flex justify-content-between align-items-center">
        <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/images/brands/yg.png">
        <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/images/brands/jyp.png">
        <img class="img-fluid col-lg-2 col-md-6 col-sm-12" src="assets/images/brands/sm.png">
        <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/images/brands/hybe.png">
      </div>
    </div>
  </section>

  <!--Recommended Artist-->
  <section id="recommended-artist">
    <div class="container">
        <h1 data-translate="Recommended Artist">Recommended Artist</h1>
        <div class="artist-carousel">
            <!-- Left Button -->
            <button class="carousel-btn left-btn" onclick="prevSlideArtist()"><i class="fas fa-chevron-left"></i></button>
            <!-- Carousel Inner -->
            <?php $artists = $conn->query("SELECT * FROM artists"); ?>
            <div class="carousel-inner">
              <div class="artist-carousel">
                <?php while($artist = $artists->fetch_assoc()): ?>
                  <div class="artist">
                    <img src="assets/images/artists/<?php echo $artist['image_url'] ?>" alt="">
                    <h4><?php echo $artist['name']; ?></h4>
                    <button class="btn artist-btn" onclick="window.location.href='shop.php?celebrity=<?php echo urlencode($artist['name']); ?>'"data-translate="Shop Now">Shop Now</button>
                  </div>
                <?php endwhile; ?>
              </div>
            </div>

            <!-- Right Button -->
            <button class="carousel-btn right-btn" onclick="nextSlideArtist()"><i class="fas fa-chevron-right"></i></button>
          </div>
    </div>
  </section>

  <!--Footer-->
  <footer class="mt-5 py-5">
    <div class="container">
      <div class="row">
        <div class="footer-one col-lg-3 col-md-6 col-sm-12">
          <img src="assets/images/navbar/logo.png" alt="logo" class="footer-logo">
          <p class="pyb-2" data-translate="KIVORIA will provide the best products for the most affordable prices">
            KIVORIA will provide the best products for the most affordable prices</p>
        </div>
        <div class="footer-two col-lg-3 col-md-6 col-sm-12">
          <h5 class="pb-2">Featured</h5>
          <ul class="text-uppercase">
            <li><a href="home.php" data-translate="Home">Home</a></li>
            <li><a href="shop.php" data-translate="Shop">Shop</a></li>
            <li><a href="wishlist.php" data-translate="Wishlist">Wishlist</a></li>
            <li><a href="delivery.php" data-translate="Delivery">Delivery</a></li>
            <li><a href="message.php" data-translate="Message">Message</a></li>
          </ul>
        </div>
        <div class="footer-three col-lg-3 col-md-6 col-sm-12">
          <h5 class="pb-2" data-translate="Contact Us">Contact Us</h5>
          <div>
             <h6 class="text-uppercase" data-translate="Address">Address</h6>
             <p>1234 Main Street</p>
          </div>
          <div>
            <h6 class="text-uppercase" data-translate="Phone">Phone</h6>
            <p>857 574 9687</p>
          </div>
          <div>
            <h6 class="text-uppercase" data-translate="Email">Email</h6>
            <p>zipzap.customerservice@gmail.com</p>
          </div>
        </div>
        <div class="footer-four col-lg-3 col-md-6 col-sm-12">
          <h5 class="pb-2" data-translate="Instagram">Instagram</h5>
          <div class="row">
            <img src="assets/images/instagram/insta1.png" class="img-fluid w-25 h-100 m-2">
            <img src="assets/images/instagram/insta2.png" class="img-fluid w-25 h-100 m-2">
            <img src="assets/images/instagram/insta3.png" class="img-fluid w-25 h-100 m-2">
            <img src="assets/images/instagram/insta4.jpg" class="img-fluid w-25 h-100 m-2">
            <img src="assets/images/instagram/insta5.png" class="img-fluid w-25 h-100 m-2">
            <img src="assets/images/instagram/insta6.png" class="img-fluid w-25 h-100 m-2">
          </div>
        </div>
   
        <div class="copyright mt-5">
          <div class="container mx-auto">
            <div class="row d-flex align-items-center justify-content-between">
              <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
                <img src="assets/images/footer/payment.png">
              </div>
              <div class="col-lg-3 col-md-5 col-sm-12 mb-4 text-center">
                <p> KIVORIA &copy; 2024 Wong Zi Hao. All Rights Reserved.</p>
              </div>
              <div class="col-lg-3 col-md-5 col-sm-12 mb-4 text-end">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>       
  </footer>


</body>
  <script src="assets/js/header/currency.js"></script>
  <script src="assets/js/header/language.js"></script>
  <script src="assets/js/home.js"></script>
</html>