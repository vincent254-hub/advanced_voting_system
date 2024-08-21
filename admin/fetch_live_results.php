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


$positions = mysqli_query($conn, "SELECT * FROM positionstable");
$data= [];

while ($position = mysqli_fetch_array($positions)) {
    $position_name = $position['position_name'];

    $total_votes_query = mysqli_query($conn, "SELECT SUM(candidate_votes) as total_votes FROM candidatestable WHERE candidate_position='$position_name'");
    $total_votes_row = mysqli_fetch_assoc($total_votes_query);
    $total_votes = $total_votes_row['total_votes'];

    if($total_votes > 0 ) {
        $candidate_query = mysqli_query($conn, "SELECT candidate_name, candidate_votes FROM candidatestable WHERE candidate_position='$position_name'");
        
        $candidates = [];

        while ($candidate = mysqli_fetch_array($candidate_query)){
            $voteCount = $candidate['candidate_votes'];
            $vote_percentage = ($candidate['candidate_votes'] / $total_votes) * 100;

            $candidates[] = [
                'candidate_name' => $candidate['candidate_name'],
                'candidate_votes' => $vote_percentage,
                //actual votecount for individual candidate
                'vote_count'=> $voteCount
            ];
        }
        $data[$position_name] = $candidates;

    }else{
        $data[$position_name] = [];
    }
}

echo json_encode($data);
mysqli_free_result($positions);
mysqli_close($conn);


?>
