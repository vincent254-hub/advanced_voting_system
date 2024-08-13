<?php
require('../connection.php');

session_start();

if(empty($_SESSION['admin_id'])){
 header("location:access-denied.php");
}
?>
<?php include('scripts.php')?>