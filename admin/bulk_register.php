<?php
require_once('../connection.php');
include('include/header.php');
require '../vendor/autoload.php'; // Load PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Start the session for handling any session variables if needed
session_start();
$date= date('Y');

// setting up mailer details

if(isset($_POST['submit'])) {
    $smtp_host = $_POST['smtp_host'];
    $smtp_port = $_POST['smtp_port'];
    $smtp_username = $_POST['smtp_username'];
    $smtp_password = $_POST['smtp_password'];
    $from_email = $_POST['from_email'];
    $from_name = $_POST['from_name'];
  
    $query = "UPDATE mailer_settings SET smtp_host='$smtp_host', smtp_port='$smtp_port', smtp_username='$smtp_username', smtp_password='$smtp_password', from_email='$from_email', from_name='$from_name' WHERE id=1";
    mysqli_query($conn, $query);
    echo "Settings updated!";
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
  

if (isset($_FILES['csv_file']['name'])) {
    $filename = $_FILES['csv_file']['tmp_name'];

    if ($_FILES['csv_file']['size'] > 0) {
        $file = fopen($filename, "r");
        $rowCount = 0;
        $successCount = 0;
        $errorCount = 0;

        // Prepare an SQL statement for safe insertion
        $stmt = $conn->prepare("INSERT INTO userstable (first_name, last_name, email, admno, password) VALUES (?, ?, ?, ?, ?)");

        if ($stmt === false) {
            $_SESSION['error'] = 'Prepare failed: ' . htmlspecialchars($conn->error);
            header("Location: index.php");
            exit();
        }

        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            $rowCount++;

            if ($rowCount == 1) {
                // Skip the header row
                continue;
            }

            $firstName = addslashes($data[0]);
            $lastName = addslashes($data[1]);
            $email = $data[2];
            $admno = $data[3];
            $password = md5($admno); // Encrypt the password using md5

            // Check if email or admission number already exists
            $emailCheck = mysqli_query($conn, "SELECT * FROM userstable WHERE email='$email'");
            $admnoCheck = mysqli_query($conn, "SELECT * FROM userstable WHERE admno='$admno'");

            if (mysqli_num_rows($emailCheck) > 0 || mysqli_num_rows($admnoCheck) > 0) {
                $errorCount++;
                continue;
            }

            // Bind parameters and execute the statement
            $stmt->bind_param("sssss", $firstName, $lastName, $email, $admno, $password);

            if ($stmt->execute()) {
                $successCount++;

                // Send email to the registered user with their credentials
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->isSMTP();
                    $mail->Host = $settings['smtp_host'];  // Set your SMTP server
                    $mail->SMTPAuth = true;
                    $mail->Username = $settings['smtp_username']; // SMTP username
                    $mail->Password = $settings['smtp_password']; // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                    
                    $mail->Port = $settings['smtp_port'];

                    //Recipients
                    $mail->setFrom($settings['from_email'], 'VK');
                    $mail->addAddress($email, "$firstName $lastName");

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Your Login Credentials for Heroes TVC Online election System';
                    $mail->Body    = "
                        <html>
                        <head>
                            <style>
                                .email-container { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                                .email-header { background-color: #f8f8f8; padding: 20px; text-align: center; }
                                .email-body { padding: 20px; }
                                .email-footer { background-color: #121212; padding: 20px; text-align: center; font-size: 12px; color: #777; }
                                .button { display: inline-block; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px; }
                            </style>
                        </head>
                        <body>
                            <div class='email-container'>
                                <div class='email-header'>
                                    <h2>Welcome to Heroes TVC Electronic Voting System</h2>
                                </div>
                                <div class='email-body'>
                                    <p>Dear $firstName $lastName,</p>
                                    <p>We are pleased to inform you that your account has been successfully created on our platform.</p>
                                    <h3>Here are your login credentials</h3>
                                    <ul>
                                        <li><strong>Email and Admission Number:</strong> $email and $admno</li>
                                        <li><strong>Kindly use your admission number </strong> $admno as your password</li>
                                    </ul>
                                    // <p>For security reasons, we recommend that you change your password immediately after logging in.</p>
                                    <p>To access your account, please click the button below:</p>
                                    <p><a href=`$baseUrl/ovs/login.php` class='button'>Login to Your Account</a></p>
                                    <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
                                    <p>Best regards,</p>
                                    <p>$from_name</p>
                                </div>
                                <div class='email-footer'>
                                    <p>This email was sent by $from_name. If you are not a student at Heroes TVC who's responsible for this account, please contact us immediately.</p>
                                    <p>&copy; $date $from_name. All rights reserved.</p>
                                </div>
                            </div>
                        </body>
                        </html>
                    ";

                    $mail->send();
                } catch (Exception $e) {
                    $_SESSION['error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    header("Location: index.php");
                    exit();
                }
            } else {
                $errorCount++;
            }
        }

        fclose($file);
        $stmt->close();

        // Redirect back to the dashboard with a success message
        $_SESSION['success'] = "Bulk registration completed: $successCount users added, $errorCount errors.";
        header("Location: index.php");
        exit();
    } else {
        // File is empty or not valid
        $_SESSION['error'] = 'Invalid file. Please upload a valid CSV file.';
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION['error'] = 'No file uploaded. Please upload a CSV file.';
    header("Location: index.php");
    exit();
}
?>


