<?php
// check_voting_time file
$current_time = new DateTime();

$sql = "SELECT * FROM voting_time WHERE id = 1";
$result = mysqli_query($conn, $sql);
$voting_time = mysqli_fetch_assoc($result);

$start_time = new DateTime($voting_time['start_time']);
$end_time = new DateTime($voting_time['end_time']);

if ($current_time < $start_time || $current_time > $end_time) {
    echo "<script>
        Swal.fire({
            title: 'Voting Closed',
            text: 'Voting is currently closed. Please try again during the voting hours.',
            icon: 'error'
        }).then(function() {
            window.location = 'login.php';
        });
    </script>";
    exit();
}
