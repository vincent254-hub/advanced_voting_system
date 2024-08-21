<?php
require('../connection.php');

if (isset($_POST['position'])) {
    $position = addslashes($_POST['position']);

    $response = ['html' => '', 'labels' => [], 'votes' => []];

    if ($position !== 'select') {
        $results = mysqli_query($conn, "SELECT * FROM candidatestable WHERE candidate_position='$position'");
        $total_votes = 0;

        $html = '<ul class="list-group">';

        while ($row = mysqli_fetch_array($results)) {
            $candidate_name = $row['candidate_name'];
            $candidate_votes = $row['candidate_votes'];
            $total_votes += $candidate_votes;

            $response['labels'][] = $candidate_name;
            $response['votes'][] = $candidate_votes;

            $html .= "<li class='list-group-item'>$candidate_name - $candidate_votes votes</li>";
        }

        $html .= '</ul>';

        $response['html'] = $html;
    } else {
        $response['html'] = '<p class="text-danger">Please select a valid position.</p>';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
