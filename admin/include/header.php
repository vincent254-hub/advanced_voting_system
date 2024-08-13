<?php
session_start();
require('../connection.php');

// Redirect to login if not logged in
if(empty($_SESSION['admin_id'])){
    header("location:access-denied.php");
    exit();
}

// Retrieve admin details
$result = mysqli_query($conn, "SELECT * FROM administratortable WHERE admin_id = '$_SESSION[admin_id]'");
$row = mysqli_fetch_array($result);
if ($row) {
    $adminId = $row['admin_id'];
    $firstName = $row['first_name'];
    $lastName = $row['last_name'];
    $email = $row['email'];
}

if (isset($_GET['id']) && isset($_POST['update'])) {
    $myId = addslashes($_GET['id']);
    $myFirstName = addslashes($_POST['firstname']);
    $myLastName = addslashes($_POST['lastname']);
    $myEmail = $_POST['email'];

    $sql = mysqli_query($conn, "UPDATE administratortable SET first_name='$myFirstName', last_name='$myLastName', email='$myEmail' WHERE admin_id = '$myId'");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Admin Dashboard - OVS</title>
  
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito|Poppins" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- Header -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="Logo">
        <span class="d-none d-lg-block">OVS</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div>

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle" href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>

        <!-- Expose all links in the navbar -->
        <li class="nav-item mx-2">
          <a class="nav-link" href="candidates.php">
            <i class="bi bi-person"></i> Manage Candidates
          </a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link" href="refresh.php">
            <i class="bi bi-bar-chart"></i> Poll Results
          </a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link" href="positions.php">
            <i class="bi bi-briefcase"></i> Manage Positions
          </a>
        </li>
        

        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo "$firstName $lastName"; ?></span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h2><?php echo "$firstName $lastName"; ?></h2>
              <span>Administrator</span>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item d-flex align-items-center" href="manage-admins.php"><i class="bi bi-person"></i><span>My Profile</span></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item d-flex align-items-center" href="manage-admins.php"><i class="bi bi-gear"></i><span>Account Settings</span></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item d-flex align-items-center" href="#"><i class="bi bi-question-circle"></i><span>Need Help?</span></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item d-flex align-items-center" href="logout.php"><i class="bi bi-box-arrow-right"></i><span>Sign Out</span></a></li>
          </ul>
        </li>

      </ul>
    </nav>
  </header>

  <!-- Include any additional scripts needed -->
  <?php include('include/scripts.php'); ?>

</body>

</html>
