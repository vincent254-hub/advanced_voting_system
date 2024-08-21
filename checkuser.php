<?php
require_once('connection.php');

if (isset($_POST['email']) || isset($_POST['admno'])) {
    $email = $_POST['email'];
    $admno = $_POST['admno'];

    // Check if email exists
    $emailCheck = mysqli_query($conn, "SELECT * FROM userstable WHERE email='$email'");
    $admnoCheck = mysqli_query($conn, "SELECT * FROM userstable WHERE admno='$admno'");

    if (mysqli_num_rows($emailCheck) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'That Email is already taken']);
    } elseif (mysqli_num_rows($admnoCheck) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'That Admission number is already taken']);
    } else {
        echo json_encode(['status' => 'success']);
    }
}

?>

<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData(this);

        fetch('register.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.message
                });
            } else if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message
                });
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script> -->
