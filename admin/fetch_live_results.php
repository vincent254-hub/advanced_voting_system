<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../connection.php');

// Fetch the latest vote counts for all positions
$query = "SELECT positionstable.position_name, candidatestable.candidate_name, candidatestable.candidate_votes 
          FROM candidatestable 
          JOIN positionstable ON candidatestable.candidate_position = positionstable.position_name 
          ORDER BY positionstable.position_name ASC";

$result = mysqli_query($conn, $query);

$positions = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $positions[$row['position_name']][] = [
            'candidate_name' => $row['candidate_name'],
            'votes' => $row['candidate_votes']
        ];
    }
}

echo json_encode($positions);
?>
