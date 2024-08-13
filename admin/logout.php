
<?
session_start();
header("location:login.php");
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('include/header.php') ?>

</head>

<body>

  <main>
    <div class="container">

      <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <p class="m-5 text-danger"> You just Logged out!!</p>
        <h2>Thank you for using OVS. Welcome Back again!!</h2>
        <div class="container text-center d-flex">
        <a class="btn m-3" href="login.php">Back to Login</a>
        <a class="btn m-3 " href="../index.php">Voter Area</a>
        </div>
        <img src="assets/img/not-found.svg" class="img-fluid py-5" alt="">
        <div class="credits">
          
          Designed by <a href="#">Kits</a>
        </div>
      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>