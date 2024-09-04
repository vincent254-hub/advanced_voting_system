<?php
session_start();
require('../connection.php');

// Redirect to login if not logged in
if(empty($_SESSION['admin_id'])){
    header("location:access-denied.php");
    exit();
}

// timer
// Fetch the active voting period from the database
$sql = "SELECT end_time FROM voting_time WHERE status = 1 ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$end_time = null;

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $end_time = $row['end_time'];
}

// voters and turnout

$totalVotersQuery = "SELECT COUNT(*) as totalVoters FROM userstable";
// $votedQuery = "SELECT COUNT(*) as totalVoted FROM votestable";
$candidateQuery = "SELECT COUNT(*) as totalCandidates FROM candidatestable";
$positionQuery = "SELECT COUNT(*) as totalPositions FROM positionstable";
$voteQuery = "SELECT COUNT(DISTINCT voter_id) AS totalVotes FROM votestable";

$totalVotersResult = mysqli_query($conn, $totalVotersQuery);
// $totalVotedResult = mysqli_query($conn, $votedQuery);
$totalCandidateResult = mysqli_query($conn, $candidateQuery);
$totalPositionResult = mysqli_query($conn, $positionQuery);
$totalVotesResult = mysqli_query($conn, $voteQuery);

$totalVoters = mysqli_fetch_assoc($totalVotersResult)['totalVoters'];
// $totalVoted = mysqli_fetch_assoc($totalVotedResult)['totalVoted'];
$totalCandidates = mysqli_fetch_assoc($totalCandidateResult)['totalCandidates'];
$totalPositions = mysqli_fetch_assoc($totalPositionResult)['totalPositions'];
$totalVotes = mysqli_fetch_assoc($totalVotesResult)['totalVotes'];

$voterTurnout = ($totalVotes / $totalVoters) * 100;

$baseUrl = "https://9bc0-197-237-178-181.ngrok-free.app";
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
  <title>Admin Dashboard - Heroes TVC EVS</title>
  
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
  <!-- Include SweetAlert2 library -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>

  <!-- Header -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="d-flex align-items-center">
        <img src="assets/img/logo.png" alt="Logo" style="height:70px; width:70px; padding:5px;">
        <span class="d-none d-lg-block" style="font-weight:bold; font-size:18px; ">HEROES TVC</span>
      </a>
      <i class="bi bi-clock toggle-sidebar-btn" style="margin:10px;font-size:16px;"></i>
    </div>

    

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <!-- Expose all links in the navbar -->
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-list toggle-sidebar-btn"></i>           
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h2 class="margin:5px;"><?php echo "$firstName $lastName"; ?></h2>
              <span>System Admin</span>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item d-flex align-items-center" href="manage-admins.php"><i class="bi bi-person"></i><span>Profile</span></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item d-flex align-items-center" href="candidates.php"><i class="bi bi-people"></i><span>Manage Candidates</span></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item d-flex align-items-center" href="positions.php"><i class="bi bi-person-check"></i><span>Manage Positions</span></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item d-flex align-items-center" href="async_results.php"><i class="bi bi-clock"></i><span>View Results</span></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item d-flex align-items-center" href="contact_replies.php"><i class="bi bi-question-circle"></i><span>Respond to Queries</span></a></li>
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
