
<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);

require('../connection.php');

if (empty($_SESSION['admin_id'])) {
    header("location:access-denied.php");
}

// Retrieve existing candidates
$result = mysqli_query($conn, "SELECT * FROM candidatestable");
if (mysqli_num_rows($result) < 1) {
    $result = null;
}

// Retrieve positions
$positions_retrieved = mysqli_query($conn, "SELECT * FROM positionstable");

// Handle form submission
if (isset($_POST['Submit'])) {
    $newCandidateName = addslashes($_POST['name']);
    $newCandidatePosition = addslashes($_POST['position']);
    $newCandidateYearofStudy = addslashes($_POST['yos']);
    $candidate_img = $_FILES["candidate_img"]["name"];

    if ($_POST['Submit'] == 'Add Candidate') {
        // Add new candidate logic
        move_uploaded_file($_FILES["candidate_img"]["tmp_name"], "candidate_img/" . $_FILES["candidate_img"]["name"]);

        $sql = mysqli_query($conn, "INSERT INTO candidatestable(candidate_name, candidate_position, candidate_img, candidateYOS) 
        VALUES ('$newCandidateName','$newCandidatePosition','$candidate_img', '$newCandidateYearofStudy')");

        header("Location: candidates.php");
    } elseif ($_POST['Submit'] == 'Update Candidate') {
        // Update candidate logic
        $candidateId = $_POST['candidate_id'];
        
        // Update image only if a new image is uploaded
        if (!empty($candidate_img)) {
            move_uploaded_file($_FILES["candidate_img"]["tmp_name"], "candidate_img/" . $_FILES["candidate_img"]["name"]);
            $updateQuery = "UPDATE candidatestable SET candidate_name='$newCandidateName', candidate_position='$newCandidatePosition', candidate_img='$candidate_img', candidateYOS='$newCandidateYearofStudy' WHERE candidate_id='$candidateId'";
        } else {
            $updateQuery = "UPDATE candidatestable SET candidate_name='$newCandidateName', candidate_position='$newCandidatePosition', candidateYOS='$newCandidateYearofStudy' WHERE candidate_id='$candidateId'";
        }
        
        mysqli_query($conn, $updateQuery);
        header("Location: candidates.php");
    }
}

// Handle delete
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "DELETE FROM candidatestable WHERE candidate_id='$id'");
    header("Location: candidates.php");
}

// Handle edit
$editCandidate = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $editResult = mysqli_query($conn, "SELECT * FROM candidatestable WHERE candidate_id='$edit_id'");
    $editCandidate = mysqli_fetch_assoc($editResult);
}
?>
