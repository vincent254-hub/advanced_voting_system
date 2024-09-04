<?php
require_once('../connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $position = $_POST['position'];
    $question = $_POST['question'];
    $weight = $_POST['weight'];

    $sql = "INSERT INTO requirements (position, question, weight) VALUES ('$position', '$question', '$weight')";
    if (mysqli_query($conn, $sql)) {
        echo "Requirement saved successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
