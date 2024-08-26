<?php

$mail->isHTML(true);


$mail->Body = "
    <html>
    <head>
        <style>
            .email-container {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
            }
            .email-header {
                background-color: #f8f8f8;
                padding: 20px;
                text-align: center;
            }
            .email-body {
                padding: 20px;
            }
            .email-footer {
                background-color: #f8f8f8;
                padding: 20px;
                text-align: center;
                font-size: 12px;
                color: #777;
            }
            .button {
                display: inline-block;
                padding: 10px 20px;
                font-size: 16px;
                color: #fff;
                background-color: #007bff;
                text-decoration: none;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class='email-container'>
            <div class='email-header'>
                <h2>Welcome to [Your Organization Name]</h2>
            </div>
            <div class='email-body'>
                <p>Dear $firstName $lastName,</p>
                <p>We are pleased to inform you that your account has been successfully created on our platform.</p>
                <p>Here are your login credentials:</p>
                <ul>
                    <li><strong>Email or Admission Number:</strong> $email or $admno</li>
                    <li><strong>Password:</strong> $admno</li>
                </ul>
                <p>For security reasons, we recommend that you change your password immediately after logging in.</p>
                <p>To access your account, please click the button below:</p>
                <p><a href='[Login URL]' class='button'>Login to Your Account</a></p>
                <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
                <p>Best regards,</p>
                <p>[Your Organization Name]</p>
            </div>
            <div class='email-footer'>
                <p>This email was sent by [Your Organization Name]. If you did not sign up for this account, please contact us immediately.</p>
                <p>&copy; [Year] [Your Organization Name]. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
";

?>
