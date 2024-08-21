<?php
require('connection.php');

if(isset($_POST['position'])) {
    $position = addslashes($_POST['position']);
    $result = mysqli_query($conn, "SELECT * FROM candidatestable WHERE candidate_position= '$position'");

    while($row = mysqli_fetch_array($result)) {
        echo "<div class='candidate-card' onClick='confirmVote(\"" . $row['candidate_name'] . "\")'";
        // echo "<img src='./admin/candidate_img/" . $row['candidate_img'] . " ' alt='avatar'>";
        echo"<ul> <img  src='./admin/candidate_img/" . $row['candidate_img'] . "'/></ul>";
        echo "<h5>" . $row['candidate_name'] . "</h5>";
        echo "<p>" . $row['candidate_position'] . "</p>";
        echo "<h5>" . $row['candidateYOS'] . "</h5>";
        echo "</div>";
    }
    mysqli_free_result($result);
    mysqli_close($conn);
}