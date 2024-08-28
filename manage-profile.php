<?php
session_start();
require('connection.php');


if(empty($_SESSION['member_id'])){
 header("location:access-denied.php");
} 

$result=mysqli_query($conn, "SELECT * FROM userstable WHERE member_id = '$_SESSION[member_id]'");
if (mysqli_num_rows($result)<1){
    $result = null;
}
$row = mysqli_fetch_array($result);
if($row)
 {

 $stdId = $row['member_id'];
 $firstName = $row['first_name'];
 $lastName = $row['last_name'];
 $admno = $row['admno'];
 $email = $row['email'];
 }
?>
<?php

if (isset($_POST['update'])){
$myId = addslashes( $_GET['id']);
$myFirstName = addslashes( $_POST['firstname'] ); 
$myLastName = addslashes( $_POST['lastname'] ); 
$myEmail = $_POST['email'];

$sql = mysqli_query($conn,"UPDATE userstable SET first_name='$myFirstName', last_name='$myLastName', email='$myEmail' WHERE member_id = '$myId'" );


 header("Location: manage-profile.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php include('include/header.php');?>

</head>
<?php include('include/nav.php');?>

<body class="contact-page">  

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/contact-page-title-bg.jpg);">
      <div class="container">
        <h1>User Profile</h1>
        
      </div>
    </div><!-- End Page Title -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">

      <div class="row">
    <div class="col-xl-4">

      <div class="card m-2">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

          <img src="https://media.gettyimages.com/id/1300845620/vector/user-icon-flat-isolated-on-white-background-user-symbol-vector-illustration.jpg?s=612x612&w=gi&k=20&c=tC514mTG014_uspJnEeJeKrQDiBY2N9GFYKPqwmtBuo=" alt="Profile" class="rounded-circle" style="width:200px; height:200px">
          <h2 class="d-flex"><?php echo $firstName ?></p> &nbsp;<p><?php echo $lastName ?>
                </h2>
          <p>Voter ID</p>
          <div class="social-links mt-2">
              <p class="text-center">
                <?php echo $admno ?>
              </p>
              <p class="text-center">
                <?php echo $email ?>
              </p>
          </div>
        </div>
      </div>

    </div>

    <div class="col-xl-8">

      <div class="card">
        <div class="card-body pt-3">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered">

            <li class="nav-item">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
            </li>

            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
            </li>

            <!-- <li class="nav-item ">
              <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
            </li> -->

            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
            </li>

          </ul>
          <div class="tab-content pt-2">

            <div class="tab-pane fade show active profile-overview" id="profile-overview">
              <h5 class="card-title">Profile Details</h5>

              <div class="row">
                <div class="col-lg-3 col-md-4 label ">Full Name</div>
                <div class="col-lg-9 col-md-8 d-flex">
                    <p><?php echo $firstName ?></p> &nbsp;<p><?php echo $lastName ?></p>
                </div>
              </div>              
              <div class="row">
                <div class="col-lg-3 col-md-4 label ">Voter Number</div>
                <div class="col-lg-9 col-md-8 d-flex">
                    <p><?php echo $admno ?></p>
                </div>
              </div>              

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Email</div>
                <div class="col-lg-9 col-md-8"><?php echo $email?></div>
              </div>

            </div>

            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

              <!-- Profile Edit Form -->
              <form action="manage-admins.php?id=<?php echo $_SESSION['admin_id']; ?>" method="post" onSubmit="return updateProfile(this)">
                <div class="row mb-3">
                  <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                  <div class="col-md-8 col-lg-9">
                    <img src="https://media.gettyimages.com/id/1300845620/vector/user-icon-flat-isolated-on-white-background-user-symbol-vector-illustration.jpg?s=612x612&w=gi&k=20&c=tC514mTG014_uspJnEeJeKrQDiBY2N9GFYKPqwmtBuo=" alt="Profile" style="height:200px; width:200px; p-1 m-1">
                    <div class="pt-2">
                      <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                      <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="firstName" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                  <div class="col-md-8 col-lg-9">
                    <input type="text" class="form-control"  name="firstname" maxlength="15" value="<?php echo $firstName ?>">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="lastname" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                  <div class="col-md-8 col-lg-9">
                    <input type="text" class="form-control" name="lastname" maxlength="15" value="<?php echo $lastName ?>">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="lastname" class="col-md-4 col-lg-3 col-form-label">Voter Identifier</label>
                  <div class="col-md-8 col-lg-9">
                    <input type="text" class="form-control" name="lastname" maxlength="15" readonly value="<?php echo $admno ?>">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                  <div class="col-md-8 col-lg-9">
                    <input type="text" class="form-control" name="email" maxlength="100" readonly value="<?php echo $email?>">
                  </div>
                </div>

                
                <div class="text-center">
                  <input class="btn btn-warning" type="submit" name="update" value="Update Account">
                </div>
              </form><!-- End Profile Edit Form -->

            </div>

            <div class="tab-pane fade pt-3" id="profile-change-password">
              <!-- Change Password Form -->
              <form action="changepass.php?id=<?php echo $_SESSION['member_id']; ?>" method="post" onSubmit="return updateProfile(this)">

                <div class="row mb-3">
                  <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                  <div class="col-md-8 col-lg-9">
                    <input class="form-control" type="password"  name="oldpass" maxlength="15" value="">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                  <div class="col-md-8 col-lg-9">
                    <input type="password"  name="newpass" maxlength="15" value="" class="form-control" id="newPassword">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                  <div class="col-md-8 col-lg-9">
                    <input type="password" class="form-control" name="confpass" maxlength="15" value="">
                  </div>
                </div>

                <div class="text-center">
                <input class="btn btn-primary" type="submit" name="update" value="Update Account">
                </div>
              </form><!-- End Change Password Form -->

            </div>

          </div><!-- End Bordered Tabs -->

        </div>
      </div>

    </div>
  </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <?php include('include/footer.php'); ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>

<style>
   
    .contact {
    background-image: url("./assets/img/contact-bg.png");
    background-position: left center;
    background-repeat: no-repeat;
    position: relative;
    }

    @media (max-width: 640px) {
    .contact {
        background-position: center 50px;
        background-size: contain;
    }
    }

    .contact:before {
    content: "";
    background: color-mix(in srgb, var(--background-color), transparent 30%);
    position: absolute;
    bottom: 0;
    top: 0;
    left: 0;
    right: 0;
    }

    .contact .info-item+.info-item {
    margin-top: 40px;
    }

    .contact .info-item i {
    background: var(--accent-color);
    color: var(--contrast-color);
    font-size: 20px;
    width: 44px;
    height: 44px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50px;
    transition: all 0.3s ease-in-out;
    margin-right: 15px;
    }

    .contact .info-item h3 {
    padding: 0;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 5px;
    }

    .contact .info-item p {
    padding: 0;
    margin-bottom: 0;
    font-size: 14px;
    }

    .contact .php-email-form {
    height: 100%;
    }

    .contact .php-email-form input[type=text],
    .contact .php-email-form input[type=email],
    .contact .php-email-form textarea {
    font-size: 14px;
    padding: 10px 15px;
    box-shadow: none;
    border-radius: 0;
    color: var(--default-color);
    background-color: color-mix(in srgb, var(--background-color), transparent 50%);
    border-color: color-mix(in srgb, var(--default-color), transparent 80%);
    }

    .contact .php-email-form input[type=text]:focus,
    .contact .php-email-form input[type=email]:focus,
    .contact .php-email-form textarea:focus {
    border-color: var(--accent-color);
    }

    .contact .php-email-form input[type=text]::placeholder,
    .contact .php-email-form input[type=email]::placeholder,
    .contact .php-email-form textarea::placeholder {
    color: color-mix(in srgb, var(--default-color), transparent 70%);
    }

    .contact .php-email-form button[type=submit] {
    color: var(--contrast-color);
    background: var(--accent-color);
    border: 0;
    padding: 10px 30px;
    transition: 0.4s;
    border-radius: 50px;
    }

    .contact .php-email-form button[type=submit]:hover {
    background: color-mix(in srgb, var(--accent-color), transparent 20%);
    }

    /*--------------------------------------------------------------
    # Global Page Titles & Breadcrumbs
    --------------------------------------------------------------*/
    .page-title {
    color: var(--default-color);
    background-color: var(--background-color);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    padding: 160px 0 60px 0;
    text-align: center;
    position: relative;
    }

    .page-title:before {
    content: "";
    background-color: color-mix(in srgb, var(--background-color), transparent 40%);
    position: absolute;
    inset: 0;
    }

    .page-title .container {
    position: relative;
    }

    .page-title h1 {
    font-size: 42px;
    font-weight: 700;
    margin-bottom: 10px;
    }

    .page-title .breadcrumbs ol {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    justify-content: center;
    padding: 0;
    margin: 0;
    font-size: 16px;
    font-weight: 400;
    }

    .page-title .breadcrumbs ol li+li {
    padding-left: 10px;
    }

    .page-title .breadcrumbs ol li+li::before {
    content: "/";
    display: inline-block;
    padding-right: 10px;
    color: color-mix(in srgb, var(--default-color), transparent 70%);
    }

    /*--------------------------------------------------------------
    # Global Sections
    --------------------------------------------------------------*/
    section,
    .section {
    color: var(--default-color);
    background-color: var(--background-color);
    padding: 60px 0;
    scroll-margin-top: 100px;
    overflow: clip;
    }

    @media (max-width: 1199px) {

    section,
    .section {
        scroll-margin-top: 66px;
    }
    }
</style>
