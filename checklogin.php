<!DOCTYPE html>
<html>
<head>
    <?php include("include/header.php") ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="row">
        <div class="col-lg-12">
            <div class="container text-center m-5">
                <h3>Please Wait...</h3>
            </div>       
        </div>
    </div>

<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);

ob_start();
session_start();
require('connection.php');

$myusername = $_POST['myusername'];
$mypassword = $_POST['mypassword'];

$myusername = stripslashes($myusername);
$encrypted_mypassword = md5($mypassword);
// $mypassword = stripslashes($mypassword);

// Search for the user using either email or admission number
$sql = mysqli_query($conn, "SELECT * FROM userstable WHERE (email='$myusername' OR admno='$myusername') AND password='$encrypted_mypassword'");
$count = mysqli_num_rows($sql);

if ($count == 1) {
    $user = mysqli_fetch_assoc($sql);
    $_SESSION['member_id'] = $user['member_id'];
    echo "<script>
            Swal.fire({
                title: 'Login Successful!',
                text: 'You are being redirected to the voting page.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'vote.php';
                }
            });
          </script>";
} else {
    echo "<script>
            Swal.fire({
                title: 'Login Failed',
                text: 'Wrong Username or Password',
                icon: 'error',
                confirmButtonText: 'Retry'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'login.php';
                }
            });
          </script>";
}

ob_end_flush();
?>

</body>
</html>
