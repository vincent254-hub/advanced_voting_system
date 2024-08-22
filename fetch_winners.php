<?php
include('connection.php');

// Fetch the voting results
$sql = "SELECT position, candidateName, COUNT(*) as vote_count 
        FROM votestable 
        GROUP BY position, candidateName
        ORDER BY position, vote_count DESC";

$result = mysqli_query($conn, $sql);

$winners = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $position = $row['position'];

        // If the position doesn't exist in winners, add it with the current candidate as the leading one
        if (!isset($winners[$position])) {
            $winners[$position] = $row;
        }
    }
}

// Return the winners as JSON
echo json_encode($winners);

mysqli_close($conn);
?>
