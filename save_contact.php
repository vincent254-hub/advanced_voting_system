<?php
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $stmt = $conn->prepare("INSERT INTO contact_us (name, email, subject, message) VALUES (?, ?, ?, ?)");

    if ($stmt === false) {
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Unable to prepare statement.',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(function() {
                window.history.back();
            });
        </script>";
        exit();
    }

    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        echo "<script>
            Swal.fire({
                title: 'Success!',
                text: 'Your message has been sent successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location = 'index.php';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Failed to send your message. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(function() {
                window.history.back();
            });
        </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>
        Swal.fire({
            title: 'Error!',
            text: 'Invalid request method.',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then(function() {
            window.history.back();
        });
    </script>";
}
?>
