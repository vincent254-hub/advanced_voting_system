<?php

include('include/header.php'); // Include your header file
include('../connection.php'); // Include your database connection

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete']) && isset($_POST['delete_contact_id'])) {
    $delete_contact_id = $_POST['delete_contact_id'];

    // Delete replies associated with the contact message
    $delete_replies_query = "DELETE FROM contact_replies WHERE contact_id = ?";
    $stmt = $conn->prepare($delete_replies_query);
    $stmt->bind_param("i", $delete_contact_id);
    $stmt->execute();
    $stmt->close();

    // Delete the contact message
    $delete_message_query = "DELETE FROM contact_us WHERE id = ?";
    $stmt = $conn->prepare($delete_message_query);
    $stmt->bind_param("i", $delete_contact_id);
    if ($stmt->execute()) {
        echo "<script>Swal.fire('Success', 'Message deleted successfully!', 'success');</script>";
    } else {
        echo "<script>Swal.fire('Error', 'Failed to delete message.', 'error');</script>";
    }
    $stmt->close();
}

// Handle reply form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reply']) && isset($_POST['contact_id'])) {
    $contact_id = $_POST['contact_id'];
    $reply_message = $_POST['reply_message'];

    // Insert the reply into the contact_replies table
    $insert_reply = "INSERT INTO contact_replies (contact_id, reply_message) VALUES (?, ?)";
    $stmt = $conn->prepare($insert_reply);
    $stmt->bind_param("is", $contact_id, $reply_message);
    if ($stmt->execute()) {
        echo "<script>Swal.fire('Success', 'Reply sent successfully!', 'success');</script>";
    } else {
        echo "<script>Swal.fire('Error', 'Failed to send reply.', 'error');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .message-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            padding: 15px;
            background-color: #f9f6f7;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .message-header h5 {
            margin: 0;
        }

        .message-body {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <aside id="live-results-sidebar" class="sidebar">
        <ul class="sidebar-nav" id="">
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="bi bi-grid"></i>
                    <span>Live Stream</span>
                </a>

                <div class="col-md-12 my-1" id="live-results-sidebar">
                    <div class="container">
                        <div class="card-body">
                            <p class="card-title text-center text-muted">Live Results from all positions</p>
                            <div id="live-results-content">
                                <!-- Live results will be displayed here -->
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </aside>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Contact Messages</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Contact Messages</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Messages from Contact Form</h5>

                            <?php
                            // Fetch contact messages
                            $query = "SELECT * FROM contact_us ORDER BY created_at DESC";
                            $result = $conn->query($query);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<div class="message-card">';
                                    echo '<div class="message-header">';
                                    echo '<h5>' . htmlspecialchars($row['subject']) . '</h5>';
                                    echo '<span>' . date('M d, Y h:i A', strtotime($row['created_at'])) . '</span>';
                                    echo '</div>';
                                    echo '<p><strong>From:</strong> ' . htmlspecialchars($row['name']) . ' (' . htmlspecialchars($row['email']) . ')</p>';
                                    echo '<div class="message-body">';
                                    echo '<p>' . htmlspecialchars($row['message']) . '</p>';
                                    echo '</div>';

                                    // Display replies if any
                                    $contact_id = $row['id'];
                                    $replies_query = "SELECT * FROM contact_replies WHERE contact_id = $contact_id ORDER BY reply_date ASC";
                                    $replies_result = $conn->query($replies_query);
                                    if ($replies_result->num_rows > 0) {
                                        echo '<div class="replies">';
                                        while ($reply = $replies_result->fetch_assoc()) {
                                            echo '<div class="reply-card">';
                                            echo '<p><strong>Reply:</strong> ' . htmlspecialchars($reply['reply_message']) . '</p>';
                                            echo '<p><small>' . date('M d, Y h:i A', strtotime($reply['reply_date'])) . '</small></p>';
                                            echo '</div>';
                                        }
                                        echo '</div>';
                                    }

                                    // Reply form
                                    echo '
                                        <form method="POST" action="" class="mt-3">
                                            <input type="hidden" name="contact_id" value="' . $row['id'] . '">
                                            <textarea name="reply_message" class="form-control" rows="3" placeholder="Write your reply..." required></textarea>
                                            <button type="submit" name="reply" class="btn btn-warning mt-2">Send Reply</button>
                                        </form>
                                    ';

                                    // Delete button
                                    echo '
                                        <form method="POST" action="" class="mt-3">
                                            <input type="hidden" name="delete_contact_id" value="' . $row['id'] . '">
                                            <button type="submit" name="delete" class="btn btn-danger mt-2">Delete Message</button>
                                        </form>
                                    ';

                                    echo '</div>';
                                }
                            } else {
                                echo '<p>No messages found.</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentSectionIndex = 0;

            function renderLiveResults(data) {
                const liveResultsContent = document.getElementById('live-results-content');
                liveResultsContent.innerHTML = '';

                const sections = [];
                for (const position in data) {
                    if (data.hasOwnProperty(position)) {
                        const section = document.createElement('div');
                        section.className = 'progress-bar-container';

                        const positionHeader = document.createElement('h6');
                        positionHeader.textContent = position.replace(/_/g, ' ');
                        section.appendChild(positionHeader);

                        data[position].forEach(candidate => {
                            const votePercentage = candidate.candidate_votes ? candidate.candidate_votes : 0;
                            const candidateName = document.createElement('span');
                            candidateName.textContent = candidate.candidate_name + ': ' + candidate.vote_count + ' Votes';
                            section.appendChild(candidateName);

                            const progress = document.createElement('div');
                            progress.className = 'progress';
                            const progressBar = document.createElement('div');
                            progressBar.className = 'progress-bar';
                            progressBar.style.width = votePercentage + '%';
                            progressBar.setAttribute('aria-valuenow', votePercentage);
                            progressBar.setAttribute('aria-valuemin', '0');
                            progressBar.setAttribute('aria-valuemax', '100');
                            progressBar.textContent = votePercentage.toFixed(2) + '%';

                            if (votePercentage < 50) {
                                progressBar.style.backgroundColor = 'red';
                            } else if (votePercentage >= 50 && votePercentage < 75) {
                                progressBar.style.backgroundColor = 'gold';
                            } else if (votePercentage >= 75) {
                                progressBar.style.backgroundColor = 'green';
                            }

                            progress.appendChild(progressBar);
                            section.appendChild(progress);
                        });

                        sections.push(section);
                    }
                }

                sections.forEach((section, index) => {
                    section.style.display = (index === currentSectionIndex) ? 'block' : 'none';
                    liveResultsContent.appendChild(section);
                });

                currentSectionIndex = (currentSectionIndex + 1) % sections.length;
            }

            function fetchLiveResults() {
                fetch('./fetch_live_results.php')
                    .then(response => response.json())
                    .then(data => renderLiveResults(data))
                    .catch(error => console.error('Error fetching live results:', error));
            }

            fetchLiveResults();
            setInterval(fetchLiveResults, 1000);
        });
    </script>

    <?php include('include/footer.php'); ?>
</body>

</html>
