<?php
require('../connection.php');

if (isset($_POST['Submit'])){   
    $position = addslashes($_POST['position']);  
    // Fetch candidates and their votes for the selected position
    $results = mysqli_query($conn, "SELECT * FROM candidatestable WHERE candidate_position='$position'");
    $candidates = [];
    $totalvotes = 0;

    while ($row = mysqli_fetch_assoc($results)) {
        $candidates[] = $row;
        $totalvotes += $row['candidate_votes'];
    }
}
?>

<?php
$positions = mysqli_query($conn, "SELECT * FROM positionstable");
session_start();

if(empty($_SESSION['admin_id'])){
    header("location:access-denied.php");
}
?>

<?php if(isset($_POST['Submit'])){ header("Location: index.php"); } ?>

<!-- profiles -->
<!-- profile ends -->
