<?php
require_once('connection.php');

if (isset($_POST['email']) || isset($_POST['admno'])) {
    $email = $_POST['email'];
    $admno = $_POST['admno'];

    // Check if email exists
    $emailCheck = mysqli_query($conn, "SELECT * FROM userstable WHERE email='$email'");
    $admnoCheck = mysqli_query($conn, "SELECT * FROM userstable WHERE admno='$admno'");

    if (mysqli_num_rows($emailCheck) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'That Email is already taken']);
    } elseif (mysqli_num_rows($admnoCheck) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'That Admission number is already taken']);
    } else {
        echo json_encode(['status' => 'success']);
    }
}

?>

