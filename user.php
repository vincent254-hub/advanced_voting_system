
<?php
require('connection.php');

session_start();

if(empty($_SESSION['member_id'])){
 header("location:access-denied.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php @include('include/header.php')?>
  
</head>

<body class="page-portfolio">

  <!-- ======= Header ======= -->
  <?php include('include/nav.php') ?>
  <!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs d-flex align-items-center" style="background-image: url('assets/img/portfolio-header.jpg');">
      <div class="container position-relative d-flex flex-column align-items-center">

        <h2>User area</h2>
        <ol>
          <li><a href="index.html">Home</a></li>
          <li>User area</li>
        </ol>

      </div>
    </div><!-- End Breadcrumbs -->

    <div class="conatiner">
    <div class="card text-center my-4 ml-4 mr-4">
        <div class="card-header">
            <ul class="nav nav-pills card-header-pills">
            <li class="nav-item">
                <a class="nav-link active" href="vote.php">Active Polls</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">View Results</a>
            </li>
            </ul>
        </div>
        <div class="card-body">
          <h5 class="card-title">Hey! Amigo Welcome to OVS platform</h5>
          <p class="card-text">Here, Your vote counts.</p>
          <a href="vote.php" class="btn btn-primary">Vote Now</a>
        </div>
</div>
    </div>


  </main>

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