<?php
session_start();
require('../connection.php');

if(empty($_SESSION['admin_id'])){
 header("location:access-denied.php");
} 

$result=mysqli_query($conn,"SELECT * FROM candidatestable");
if (mysqli_num_rows($result)<1){
    $result = null;
}
?>
<?php

$positions_retrieved=mysqli_query($conn, "SELECT * FROM positionstable");

?>
<?php

if (isset($_POST['Submit']))
{

$newCandidateName = addslashes( $_POST['name'] ); 
$newCandidatePosition = addslashes( $_POST['position'] ); 

$sql = mysqli_query($conn, "INSERT INTO candidatestable(candidate_name,candidate_position) VALUES ('$newCandidateName','$newCandidatePosition')" );


 header("Location: index.php");
}
?>
<?php

 if (isset($_GET['id']))
 {
 
 $id = $_GET['id'];
 
 
 $result = mysqli_query($conn, "DELETE FROM candidatestable WHERE candidate_id='$id'"); 
 header("Location: candidates.php");
 }
 else
   
?>