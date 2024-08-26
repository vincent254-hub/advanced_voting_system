<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
include('../connection.php');

if (isset($_POST['submit'])) {
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    if (!empty($start_time) && !empty($end_time)) {
        // Deactivate any previously active voting periods
        $deactivate_sql = "UPDATE voting_time SET status = 0 WHERE status = 1";
        mysqli_query($conn, $deactivate_sql);

        // Insert or update the voting time record
        $stmt = $conn->prepare("INSERT INTO voting_time (start_time, end_time, status) VALUES (?, ?, 1)
                                ON DUPLICATE KEY UPDATE start_time = VALUES(start_time), end_time = VALUES(end_time), status = 1");

        $stmt->bind_param("ss", $start_time, $end_time);

        if ($stmt->execute()) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Voting time set!',
                        text: 'Voting hours have been updated successfully.',
                        icon: 'success'
                    }).then(function() {
                        window.location = 'index.php';
                    });
                });
            </script>";
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to update voting hours. Please try again.',
                        icon: 'error'
                    });
                });
            </script>";
        }

        $stmt->close();
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Both start time and end time are required.',
                    icon: 'error'
                });
            });
        </script>";
    }
}


// Close the database connection
$conn->close();
?>
