<?php
session_start();  // Start the session

// Destroy the session
session_unset();
session_destroy();

// Redirect to login page with a success message
header("Location: login.php?logout=success");
exit();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('include/header.php') ?>
  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      Swal.fire({
        title: 'Logged Out!',
        text: 'You have been successfully logged out. Thank you for using OVS!',
        icon: 'success',
        confirmButtonText: 'Back to Login',
        onClose: () => {
          window.location.href = 'admin/login.php'; // Redirect to login page after closing the alert
        }
      });
    });
  </script>

</body>

</html>
