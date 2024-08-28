<?php
// user_messages.php (User Dashboard)
include('include/header.php'); // Include your header file
include('connection.php'); // Include your database connection
session_start();

if (empty($_SESSION['member_id'])) {
    header("location:access-denied.php");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['member_id'];

// Handle reply submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reply_message']) && isset($_POST['contact_id'])) {
    $reply_message = htmlspecialchars($_POST['reply_message']);
    $contact_id = (int)$_POST['contact_id'];

    // Insert the user reply into the contact_replies table
    $reply_stmt = $conn->prepare("INSERT INTO contact_replies (contact_id, reply_message, reply_by, reply_date) VALUES (?, ?, 'user', NOW())");
    $reply_stmt->bind_param("is", $contact_id, $reply_message);

    if ($reply_stmt->execute()) {
        // Redirect to avoid form resubmission
        header("Location: user_messages.php?success=1");
        exit();
    } else {
        // Redirect with error if the submission fails
        header("Location: user_messages.php?error=1");
        exit();
    }

    $reply_stmt->close();
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_message_id'])) {
    $delete_message_id = (int)$_POST['delete_message_id'];

    // Mark the message as deleted by the user
    $delete_stmt = $conn->prepare("UPDATE contact_us SET user_deleted = 1 WHERE id = ? AND member_id = ?");
    $delete_stmt->bind_param("ii", $delete_message_id, $user_id);

    if ($delete_stmt->execute()) {
        header("Location: user_messages.php?delete_success=1");
        exit();
    } else {
        header("Location: user_messages.php?delete_error=1");
        exit();
    }

    $delete_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php include('include/header.php');?>

</head>
<?php include('include/nav.php');?>

<body class="contact-page">  

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/contact-page-title-bg.jpg);">
      <div class="container">
        <h1>User Messages</h1>
        
      </div>
    </div><!-- End Page Title -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">

      <div class="row">
                <div class="col-md-12 conversation-container">
                    <div class="" style="max-width:800px;">
                        <div class="card-body">
                            <h5 class="card-title text-center">Messages and Replies</h5>

                            <!-- Display Success or Error Messages -->
                            <?php if (isset($_GET['success'])) : ?>
                                <div class="alert alert-success">Reply sent successfully!</div>
                            <?php elseif (isset($_GET['error'])) : ?>
                                <div class="alert alert-danger">Failed to send your reply. Please try again.</div>
                            <?php elseif (isset($_GET['delete_success'])) : ?>
                                <div class="alert alert-success">Message deleted successfully!</div>
                            <?php elseif (isset($_GET['delete_error'])) : ?>
                                <div class="alert alert-danger">Failed to delete the message. Please try again.</div>
                            <?php endif; ?>

                            <div>
                                <?php
                                // Fetch user's messages from the contacts table, excluding deleted ones
                                $query = "SELECT * FROM contact_us WHERE member_id = ? AND user_deleted = 0 ORDER BY created_at DESC";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $user_id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<div class="message-card">';
                                        echo '<div class="message-header">';
                                        echo '<h5>' . htmlspecialchars($row['subject']) . '</h5>';
                                        echo '<span>' . date('M d, Y h:i A', strtotime($row['created_at'])) . '</span>';

                                        // Delete button
                                        echo '<form action="" method="POST" style="display:inline;">';
                                        echo '<input type="hidden" name="delete_message_id" value="' . $row['id'] . '">';
                                        echo '<button type="submit" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this message?\');">Delete</button>';
                                        echo '</form>';

                                        echo '</div>';
                                        echo '<p><strong>From:</strong> ' . htmlspecialchars($row['name']) . ' (' . htmlspecialchars($row['email']) . ')</p>';
                                        echo '<div class="message-body">';
                                        echo '<p>' . nl2br(htmlspecialchars($row['message'])) . '</p>';
                                        echo '</div>';

                                        // Display replies for this message
                                        $contact_id = $row['id'];
                                        $replies_query = "SELECT * FROM contact_replies WHERE contact_id = ? ORDER BY reply_date ASC";
                                        $replies_stmt = $conn->prepare($replies_query);
                                        $replies_stmt->bind_param("i", $contact_id);
                                        $replies_stmt->execute();
                                        $replies_result = $replies_stmt->get_result();

                                        if ($replies_result->num_rows > 0) {
                                            echo '<div class="replies">';
                                            while ($reply = $replies_result->fetch_assoc()) {
                                                $reply_by = $reply['reply_by'];
                                                $reply_class = $reply_by === 'user' ? 'user-reply' : 'admin-reply';
                                                echo '<div class="reply-card ' . $reply_class . '">';
                                                echo '<p><strong>' . ($reply_by === 'user' ? 'You' : 'Admin') . ':</strong> ' . nl2br(htmlspecialchars($reply['reply_message'])) . '</p>';
                                                echo '<p><small>' . date('M d, Y h:i A', strtotime($reply['reply_date'])) . '</small></p>';
                                                echo '</div>';
                                            }
                                            echo '</div>';
                                        } else {
                                            echo '<p><em>No replies yet.</em></p>';
                                        }

                                        // Reply form for the user
                                        echo '<form action="" method="POST" class="reply-form">';
                                        echo '<input type="hidden" name="contact_id" value="' . $contact_id . '">';
                                        echo '<div class="mb-3">';
                                        echo '<textarea class="form-control" name="reply_message" rows="3" placeholder="Type your reply here..." required></textarea>';
                                        echo '</div>';
                                        echo '<button type="submit" class="btn btn-primary">Send Reply</button>';
                                        echo '</form>';

                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p class="no-messages">No messages found.</p>';
                                }

                                $stmt->close();
                                $conn->close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

      </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <?php include('include/footer.php'); ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>

<style>
    .message-container {
    max-height: 500px; /* Adjust as necessary */
    overflow-y: auto;
    margin-top: 20px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center; /* Center-align the message cards */
    }
        .conversation-container {
            
            overflow-y: auto;
            margin-top: 20px;
            padding: 10px;
            border: none;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center-align the message cards */
        }

        .message-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            padding: 20px;
            background-color: #f9f9f9;
            transition: all 0.3s ease-in-out;
            max-width: 800px; /* Set maximum width for the card */
            width: 100%; /* Ensure it takes the full width up to max-width */
            margin: 0 auto; /* Center the card */
        }

        .message-card:hover {
            background-color: #f1f1f1;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .message-header h5 {
            margin: 0;
            color: #333;
        }

        .message-header span {
            font-size: 0.9em;
            color: #777;
        }

        .message-body {
            margin-top: 15px;
            font-size: 1.1em;
            line-height: 1.5;
        }

        .replies {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 15px;
        }

        .reply-card {
            max-width: 60%;
            padding: 10px;
            border-radius: 8px;
        }

        .reply-card.admin-reply {
            align-self: flex-end;
            background-color: #eef5ff;
            border-left: 3px solid #007bff;
            text-align: left;
        }

        .reply-card.user-reply {
            align-self: flex-start;
            background-color: #e0ffe0;
            border-right: 3px solid #28a745;
            text-align: left;
        }

        .reply-form {
            margin-top: 15px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

    .no-messages {
    font-size: 1.2em;
    color: #777;
    text-align: center;
    padding: 20px;
    background-color: #f1f1f1;
    border-radius: 8px;
    }

    .delete-btn {
    background: none;
    border: none;
    color: red;
    cursor: pointer;
    font-size: 0.9em;
    margin-left: 10px;
    }
   
    .contact {
    background-image: url("./assets/img/contact-bg.png");
    background-position: left center;
    background-repeat: no-repeat;
    position: relative;
    }

    @media (max-width: 640px) {
    .contact {
        background-position: center 50px;
        background-size: contain;
    }
    }

    .contact:before {
    content: "";
    background: color-mix(in srgb, var(--background-color), transparent 30%);
    position: absolute;
    bottom: 0;
    top: 0;
    left: 0;
    right: 0;
    }

    .contact .info-item+.info-item {
    margin-top: 40px;
    }

    .contact .info-item i {
    background: var(--accent-color);
    color: var(--contrast-color);
    font-size: 20px;
    width: 44px;
    height: 44px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50px;
    transition: all 0.3s ease-in-out;
    margin-right: 15px;
    }

    .contact .info-item h3 {
    padding: 0;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 5px;
    }

    .contact .info-item p {
    padding: 0;
    margin-bottom: 0;
    font-size: 14px;
    }

    .contact .php-email-form {
    height: 100%;
    }

    .contact .php-email-form input[type=text],
    .contact .php-email-form input[type=email],
    .contact .php-email-form textarea {
    font-size: 14px;
    padding: 10px 15px;
    box-shadow: none;
    border-radius: 0;
    color: var(--default-color);
    background-color: color-mix(in srgb, var(--background-color), transparent 50%);
    border-color: color-mix(in srgb, var(--default-color), transparent 80%);
    }

    .contact .php-email-form input[type=text]:focus,
    .contact .php-email-form input[type=email]:focus,
    .contact .php-email-form textarea:focus {
    border-color: var(--accent-color);
    }

    .contact .php-email-form input[type=text]::placeholder,
    .contact .php-email-form input[type=email]::placeholder,
    .contact .php-email-form textarea::placeholder {
    color: color-mix(in srgb, var(--default-color), transparent 70%);
    }

    .contact .php-email-form button[type=submit] {
    color: var(--contrast-color);
    background: var(--accent-color);
    border: 0;
    padding: 10px 30px;
    transition: 0.4s;
    border-radius: 50px;
    }

    .contact .php-email-form button[type=submit]:hover {
    background: color-mix(in srgb, var(--accent-color), transparent 20%);
    }

    /*--------------------------------------------------------------
    # Global Page Titles & Breadcrumbs
    --------------------------------------------------------------*/
    .page-title {
    color: var(--default-color);
    background-color: var(--background-color);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    padding: 160px 0 60px 0;
    text-align: center;
    position: relative;
    }

    .page-title:before {
    content: "";
    background-color: color-mix(in srgb, var(--background-color), transparent 40%);
    position: absolute;
    inset: 0;
    }

    .page-title .container {
    position: relative;
    }

    .page-title h1 {
    font-size: 42px;
    font-weight: 700;
    margin-bottom: 10px;
    }

    .page-title .breadcrumbs ol {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    justify-content: center;
    padding: 0;
    margin: 0;
    font-size: 16px;
    font-weight: 400;
    }

    .page-title .breadcrumbs ol li+li {
    padding-left: 10px;
    }

    .page-title .breadcrumbs ol li+li::before {
    content: "/";
    display: inline-block;
    padding-right: 10px;
    color: color-mix(in srgb, var(--default-color), transparent 70%);
    }

    /*--------------------------------------------------------------
    # Global Sections
    --------------------------------------------------------------*/
    section,
    .section {
    color: var(--default-color);
    background-color: var(--background-color);
    padding: 60px 0;
    scroll-margin-top: 100px;
    overflow: clip;
    }

    @media (max-width: 1199px) {

    section,
    .section {
        scroll-margin-top: 66px;
    }
    }
</style>


