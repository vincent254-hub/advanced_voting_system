<?php

if (isset($_POST['submit'])) {
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Save these times in the database
    $sql = "UPDATE voting_time SET start_time = '$start_time', end_time = '$end_time' WHERE id = 1";
    mysqli_query($conn, $sql);

    echo "<script>
        Swal.fire({
            title: 'Voting time set!',
            text: 'Voting hours have been updated successfully.',
            icon: 'success'
        });
    </script>";

    
}
?>

<?php include('scripts.php')?>