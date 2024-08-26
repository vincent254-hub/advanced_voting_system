<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set the default time zone
date_default_timezone_set('Africa/Nairobi'); // Adjust to your correct time zone

// Include the database connection file
include('connection.php');

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$current_time = new DateTime();

// Fetch the active voting period
$sql = "SELECT * FROM voting_time WHERE status = 1 ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$voting_time = mysqli_fetch_assoc($result);

if ($voting_time) {
    $start_time = new DateTime($voting_time['start_time']);
    $end_time = new DateTime($voting_time['end_time']);

    // Check if start_time and end_time are valid
    if ($start_time === false || $end_time === false) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Invalid voting times. Please contact the administrator.',
                    icon: 'error'
                }).then(function() {
                    window.location = 'index.php';
                });
            });
        </script>";
        exit();
    }

    // Check if the current time is within the voting period
    if ($current_time >= $start_time && $current_time <= $end_time) {
        // Voting is currently active
        echo "Voting is active.";
    } else {
        // Voting is closed based on time
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Voting Closed',
                    text: 'Voting is currently closed. Please try again during the voting hours.',
                    icon: 'error'
                }).then(function() {
                    window.location = 'voter_dashboard.php';
                });
            });
        </script>";
        exit();
    }
} else {
    // No active voting period found
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Error!',
                text: 'No active voting period found. Please try again later.',
                icon: 'error'
            }).then(function() {
                window.location = 'index.php';
            });
        });
    </script>";
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
