<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
include('connection.php');

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$current_time = new DateTime();

// Fetch the voting start and end times from the database
$sql = "SELECT * FROM voting_time WHERE id = 3";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$voting_time = mysqli_fetch_assoc($result);


if ($voting_time) {
    $start_time = new DateTime($voting_time['start_time']);
    $end_time = new DateTime($voting_time['end_time']);

    // Check if the current time is outside of the voting period
    if ($current_time < $start_time || $current_time > $end_time) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11' />";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Voting time set!',
                    text: 'Voting hours have been updated successfully.',
                    icon: 'success'
                }).then(function() {
                    window.location = 'vote.php';
                });
            });
        </script>";
        exit();
    }
} else {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to fetch voting time from the database.',
                icon: 'error'
            }).then(function() {
                window.location = 'index.php';
            });
        });
    </script>";
    exit();
}
?>
