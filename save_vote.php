<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
require('connection.php');


$vote = $_REQUEST['vote'];
$user_id = $_REQUEST['user_id'];
$position = $_REQUEST['position'];

// Check if the user has already voted for this specific position
// $sql = mysqli_query($conn, "SELECT position, voter_id FROM votestable WHERE position='$position' AND voter_id='$user_id'");

$sql = mysqli_query($conn, "SELECT * FROM votestable WHERE voter_id = '$user_id' AND position ='$position'");

if (mysqli_num_rows($sql) > 0) {
    echo "Oops!! You have already voted for the $position position. Try again next season.";
} else {
    // Insert the vote into votestable
    $ins = mysqli_query($conn, "INSERT INTO votestable (voter_id, position, candidateName) VALUES ('$user_id', '$position', '$vote')");
    
    // Update the candidate's vote count
    $updateVotes = mysqli_query($conn, "UPDATE candidatestable SET candidate_votes = candidate_votes + 1 WHERE candidate_name = '$vote'");

    if ($ins && $updateVotes) {
        echo "Congratulations! You just voted for your candidate in the $position position. Wish you victory!";
    } else {
        echo "There was a problem saving your vote. Please try again.";
    }
}

mysqli_close($conn);
?>



