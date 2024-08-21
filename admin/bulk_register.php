<?php
require_once('../connection.php');

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
            die('Prepare failed: ' . htmlspecialchars($conn->error));
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
            $password = md5($data[4]);

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
            } else {
                $errorCount++;
            }
        }

        fclose($file);
        $stmt->close();

        // Redirect back to the dashboard with a success message
        header("Location: index.php?success=$successCount&errors=$errorCount");
        exit();
    } else {
        // File is empty or not valid
        header("Location: index.php?error=Invalid file");
        exit();
    }
} else {
    header("Location: index.php?error=No file uploaded");
    exit();
}
?>
