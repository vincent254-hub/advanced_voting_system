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

    // Validate that both start_time and end_time are set
    if (!empty($start_time) && !empty($end_time)) {
        // Check if there's already a voting time record
        $check_sql = "SELECT id FROM voting_time WHERE id = 1";
        $result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($result) > 0) {
            // If the record exists, update it
            $stmt = $conn->prepare("UPDATE voting_time SET start_time = ?, end_time = ? WHERE id = 1");
        } else {
            // If no record exists, insert a new one
            $stmt = $conn->prepare("INSERT INTO voting_time (start_time, end_time) VALUES (?, ?)");
        }

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
            // Output SQL error if the query fails
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to update voting hours. Please try again. SQL Error: " . $stmt->error . "',
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
