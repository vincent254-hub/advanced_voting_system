<?php
require_once('connection.php');

session_start();


if (empty($_SESSION['member_id'])) {
    header("location:access-denied.php");
}


//retrieving smtp settinngs
  
$result = mysqli_query($conn, "SELECT * FROM mailer_settings WHERE id=1");
$settings = mysqli_fetch_assoc($result);

if($settings){
  $smtp_id = $settings['id'];
  $smtp_host = $settings['smtp_host'];
  $smtp_port = $settings['smtp_port'];
  $smtp_password = $settings['smtp_password'];
  $smtp_username = $settings['smtp_username'];
  $from_email = $settings['from_email'];
  $from_name = $settings['from_name'];

}
require 'vendor/autoload.php'; // Make sure PHPMailer is autoloaded

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['member_id'];
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $stmt = $conn->prepare("INSERT INTO contact_us (member_id, name, email, subject, message) VALUES (?,?, ?, ?, ?)");

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

    $stmt->bind_param("issss", $user_id, $name, $email, $subject, $message);

    if ($stmt->execute()) {
        // Send email after successful database insertion
        $mail = new PHPMailer(true);

        try {
            // SMTP server settings
            $mail->isSMTP();
            $mail->Host = $settings['smtp_host'];  // Set your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = $settings['smtp_username']; // SMTP username
            $mail->Password = $settings['smtp_password']; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                    
            $mail->Port = $settings['smtp_port'];

            // Sender and recipient settings
            $mail->setFrom($email, $name); // Replace with your email and name
            $mail->addAddress($smtp_username); // Replace with the recipient's email

            // Email content settings
            $mail->isHTML(true);
            $mail->Subject = 'New Contact Form Submission';
            $mail->Body = "
                <h3>New Contact Form Submission</h3>
                <p><strong>Name:</strong> {$name}</p>
                <p><strong>Email:</strong> {$email}</p>
                <p><strong>Subject:</strong> {$subject}</p>
                <p><strong>Message:</strong><br>{$message}</p>
            ";

            $mail->send();

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
        } catch (Exception $e) {
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to send your message. Mailer Error: {$mail->ErrorInfo}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.history.back();
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Failed to save your message. Please try again.',
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
