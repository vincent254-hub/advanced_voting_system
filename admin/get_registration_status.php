<?php
require_once('../connection.php');

// Fetch current registration status from the settings table
$query = mysqli_query($conn, "SELECT registration_status FROM settings WHERE id = 1");
$statusRow = mysqli_fetch_assoc($query);

if ($statusRow) {
    echo json_encode(['registration_status' => $statusRow['registration_status']]);
} else {
    echo json_encode(['registration_status' => 0]); // Default to disabled if not found
}
?>
