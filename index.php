<!DOCTYPE html>
<html lang="en">

<head>
  

  <?php include('include/header.php')?>
</head>


<body class="page-index">

  <!-- ======= Header ======= -->
  <?php include('include/nav.php')?>
  <!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center">
    <div class="container">
      <div class="row">
        <div class="col-xl-4">
          <h2 data-aos="fade-up">Free, Credible and Transparent Voting System</h2>
          <blockquote data-aos="fade-up" data-aos-delay="100">
            
          </blockquote>
          <div class="d-flex " data-aos="fade-up" data-aos-delay="100">
          <?php
            if(empty($_SESSION['member_id'])){
            echo'<a href="register.php" class=" btn-get-started m-2"><i class="bi bi-key"></i>Get Started</a>';
            }
            ?>
            <?php
            if(empty($_SESSION['member_id'])){
            echo'<a href="login.php" class=" btn-get-started m-2"><i class="bi bi-droplet-half"></i><span>Login</span></a>';
            }
            ?>
          </div>

        </div>
      </div>
    </div>
  </section><!-- End Hero Section -->

  <main id="main">  

    <!-- ======= Our Services Section ======= -->
    <section id="services-list" class="services-list">
      <div class="container" data-aos="fade-up">

        

         
          
        </div>

      </div>
    </section><!-- End Our Services Section -->

    <!-- ======= Call To Action Section ======= -->
    <section id="call-to-action" class="call-to-action">
      <div class="container" data-aos="fade-up">
        <div class="row justify-content-center">
          <div class="col-lg-6 text-center">
            <h3>Login to Admin Area</h3>
            
            <a class="cta-btn" href="./admin/login.php">Admin Area</a>
          </div>
        </div>

      </div>
    </section><!-- End Call To Action Section -->

    <!-- ======= Features Section ======= -->
    

    

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

        <?php @include('include/footer.php')?>
    
  </footer><!-- End Footer -->
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>