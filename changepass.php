<?php
session_start();
require('connection.php');


if(empty($_SESSION['member_id'])){
 header("location:access-denied.php");
} 

$result=mysqli_query($con, "SELECT * FROM userstable WHERE member_id = '$_SESSION[member_id]'");
if (mysqli_num_rows($result)<1){
    $result = null;
}
$row = mysqli_fetch_array($result);
if($row)
 {

 $stdId = $row['member_id']; 
  $encpass= $row['password'];
}
?>
<?php

if (isset($_POST['changepass'])){
$myId =  $_REQUEST['id'];
$oldpass = md5($_POST['oldpass']);
$newpass = $_POST['newpass'];
$conpass = $_POST['conpass'];
if($encpass == $oldpass)
{
  if($newpass == $conpass)
  {
    $newpassword = md5($newpass); 
    $sql = mysqli_query($conn,"UPDATE userstable SET password='$newpassword' WHERE member_id = '$myId'" );
    echo "<script>alert('Password Change')</script>";
  }
  else
  {
    echo "<script>alert('Oops! passwords didnt match try again')</script>";
  }

}
else
{
    echo "<script>alert('Old password not match')</script>";
}



}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php include('include/header.php')?> 
<script language="JavaScript" src="js/user.js"></script> 

 
</head>

<body class="page-services">

  <!-- ======= Header ======= -->
  <?php include('include/nav.php')?>
  <!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs d-flex align-items-center" style="background-image: url('assets/img/services-header.jpg');">
      <div class="container position-relative d-flex flex-column align-items-center">

        <h2>Change Password</h2>
        <ol>
          <li><a href="index.php">Home</a></li>
          <li>Change Password</li>
        </ol>

      </div>
    </div><!-- End Breadcrumbs -->

    <!-- ======= Our Services Section ======= -->
    <section id="services-list" class="services-list">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Manage Password</h2>

        </div>

        <div class="row gy-5 d-flex">

          <div class="col-lg-4 col-md-6 service-item " data-aos="fade-up" data-aos-delay="100">
            
          </div>
          <!-- End Service Item -->

          <div class="col-lg-4 col-md-6 service-item " data-aos="fade-up" data-aos-delay="200">
          <div class="container ">
              <form action="changepass.php?id=<?php echo $_SESSION['member_id']; ?>" method="post">
                      <div class="form-group">
                        <label class="m-2" for="Old Password">Old Password</label>
                        <input type="password" class="form-control" value='' name="oldpass" placeholder="old password">                        
                      </div>

                      <div class="form-group">
                        <label class="m-2" for="New Password">New Password</label>
                        <input type="password" class="form-control" value='' name="newpass" placeholder="new password">                        
                      </div>

                      <div class="form-group">
                        <label class="m-2" for="Confirm password">Confirm Password</label>
                        <input type="password" class="form-control" name="conpass" placeholder="Confirm Password">
                      </div>
                      
                      <input type="submit" name="changepass" value="Update Profile" class="btn btn-primary m-2"></input>
              </form>
            </div>            
            
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="300">
            
            
          </div><!-- End Service Item -->

          
        </div>

      </div>
    
    

  </main><!-- End #main -->

  
  <!-- footer -->
  <footer id="footer" class="footer">
      <?php @include('include/footer.php')?>
  </footer>
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