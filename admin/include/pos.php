<?php
session_start();
require('../connection.php');

if(empty($_SESSION['admin_id'])){
 header("location:access-denied.php");
}

$result = mysqli_query($conn, "SELECT * FROM positionstable");
if (mysqli_num_rows($result)<1){
    $result = null;
}
?>
<?php

if (isset($_POST['Submit']))
{

$newPosition = addslashes( $_POST['position'] );

    $sql = mysqli_query($conn, "INSERT INTO positionstable (position_name) VALUES ('$newPosition')");


 header("Location: positions.php");
}
?>
<?php

 if (isset($_GET['id']))
 {
 
 $id = $_GET['id'];


    $result = mysqli_query($conn, "DELETE FROM positionstable WHERE position_id='$id'");
 
 
 
 }
 else
 
    
?>