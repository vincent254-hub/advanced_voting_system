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
$newCandidateYearofStudy = addslashes( $_POST['yos'] );
$candidate_img=$_FILES["candidate_img"]["name"];
move_uploaded_file($_FILES["candidate_img"]["tmp_name"],"candidate_img/".$_FILES["candidate_img"]["name"]);
 

$sql = mysqli_query($conn, "INSERT INTO candidatestable(candidate_name,candidate_position, candidate_img, candidateYOS) VALUES ('$newCandidateName','$newCandidatePosition','$candidate_img', '$newCandidateYearofStudy')" );


header("Location: candidates.php");
}
?>
<?php

 if (isset($_GET['id']))
 {
 
 $id = $_GET['id'];
 
 
 $result = mysqli_query($conn, "DELETE FROM candidatestable WHERE candidate_id='$id'"); 
 
 }
 header("Location: candidates.php");
   
?>