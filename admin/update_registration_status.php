<?php
require_once('../connection.php');

// Get the new status from the AJAX request
$newStatus = isset($_POST['registration_status']) ? intval($_POST['registration_status']) : 0;

// Update the registration status in the settings table
$updateQuery = "UPDATE settings SET registration_status = $newStatus WHERE id = 1";
if (mysqli_query($conn, $updateQuery)) {
    echo json_encode(['status' => 'success', 'message' => 'Registration status updated successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update registration status.']);
}
?>
