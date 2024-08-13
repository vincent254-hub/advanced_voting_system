<!DOCTYPE html>
<html >
<head>
<?php include("include/header.php") ?>
</head>
<body>
<div class="row">
    <div class="col-lg-12">
        <div class="container text-center m-5">
            <h3>Invalid Credentials</h3>
        </div>       
        
</div>
<?php
ini_set ("display_errors", "1");
error_reporting(E_ALL);

ob_start();
session_start();
require('connection.php');



$myusername=$_POST['myusername'];
$mypassword=$_POST['mypassword'];

$encrypted_mypassword=md5($mypassword); 

$myusername = stripslashes($myusername);


$sql=mysqli_query($conn, "SELECT * FROM userstable WHERE email='$myusername' and password='$encrypted_mypassword'");


$count=mysqli_num_rows($sql);


if($count==1){

$user = mysqli_fetch_assoc($sql);
$_SESSION['member_id'] = $user['member_id'];
header("location:user.php");
}

else {
echo "<div class='text-center mt-4'> <p class='text-center text-danger '>Wrong Username or Password</p><br>Return to <a class='btn btn-primary' href=\"login.php\">login</a> </div>";

}

ob_end_flush();

?> 
</div>

</div>
    </div>
</div>

        </div>
    </div>
</div>
<body>


</body>
</html>