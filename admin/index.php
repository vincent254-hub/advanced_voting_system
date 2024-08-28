<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('include/header.php');
  
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

 ?>
  <script language="JavaScript" src="js/admin.js"></script>
  <style>
    .progress-bar-container {
      margin-bottom: 15px;
    }

    .progress {
      height: 30px;
    }

    @media (max-width: 768px) {
      .progress-bar-container {
        font-size: 14px;
      }

      .progress {
        height: 25px;
      }
    }

    @media (max-width: 576px) {
      .progress-bar-container {
        font-size: 12px;
        display: none; /* Hide progress bars on mobile */
      }

      .progress {
        height: 20px;
      }

      .toast {
        position: fixed;
        bottom: 0;
        right: 0;
        margin: 1em;
        background-color: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 1em;
        border-radius: 0.5em;
        z-index: 1000;
        max-width: 300px;
        width: 100%;
        display: none; /* Hide by default */
      }

      .toast.show {
        display: block;
      }
    }

    .card-title {
      font-size: 18px;
      font-weight: bold;
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

  <!-- end of sidebar -->
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Important Links Card -->
        <div class="col-xxl-3 col-md-3">
          <div class="card info-card">
            <div class="card-body">
              <h5 class="card-title">Important <span>| Links</span></h5>
              <ul class="list-unstyled">
                <li><a class="dropdown-item" href="index.php">Dashboard</a></li>
                <li><a class="dropdown-item" href="positions.php">Candidate Positions</a></li>
                <li><a class="dropdown-item" href="candidates.php">Manage Candidates</a></li>
                <li><a class="dropdown-item" href="refresh.php">Tally Results</a></li>
                <li><a class="dropdown-item" href="manage-admins.php">Manage Account</a></li>
                <li><a class="dropdown-item" href="change-pass.php">Change Password</a></li>
                <?php if (!empty($_SESSION['member_id'])) { echo '<li><a href="logout.php">Logout</a></li>'; } ?>
              </ul>
            </div>
          </div>
        </div><!-- End Important Links Card -->

        <!-- Votes Results Card -->
        <div class="col-xxl-3 col-md-3">
          <div class="card info-card">
            <div class="card-body">
              <h5 class="card-title">Votes <span>| Results</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-person-check"></i>
                </div>
                <div class="ps-3">
                  <p class="m-1 text-center">Voters Count</p>
                  <div class="">                    
                    <?php echo($totalVotes); ?>
                  </div>
                  <span class="text-success small pt-1 fw-bold">8%</span> 
                  <span class="text-muted small pt-2 ps-1">increase</span>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Votes Results Card -->

        <!-- HTVC Comrades Decide Card -->
        <div class="col-xxl-6 col-md-6">
          <div class="card info-card">
            <div class="card-body">
              <h5 class="card-title"><span>| HTVC Comrades Decide</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6><?php echo(date('Y')) ?></h6>
                  <span class="text-danger small pt-1 fw-bold"><?php echo number_format($voterTurnout, 2)?> %</span> 
                  <span class="text-muted small pt-2 ps-1">Turnout</span>
                </div>
                
                <div class="ps-3">
                  <h6><?php echo($totalPositions) ?></h6>                   
                  <span class="text-muted small pt-2 ps-1">Positions</span>
                </div>
                <div class="ps-3">
                  <h6><?php echo($totalCandidates) ?></h6>                   
                  <span class="text-muted small pt-2 ps-1">Candidates</span>
                </div>
                <div class="ps-3">
                  <h6><?php echo($totalVoters) ?></h6>                   
                  <span class="text-muted small pt-2 ps-1">Voters</span>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End HTVC Comrades Decide Card -->

        <!-- Updates Section -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Updates <span>/Today</span></h5>
              <div id=""></div>
              <?php include('async_results.php') ?>
            </div>
          </div>
        </div><!-- End Updates Section -->
        <div class="col-md-3">
            <div class="card">
            <div class="card-body">
                  <h5 class="card-title">Bulk Voter Registration</h5>
                  <form id="bulkRegisterForm" enctype="multipart/form-data">
                      <div class="mb-3">
                          <label for="csvFile" class="form-label">Upload CSV File</label>
                          <input type="file" name="csv_file" id="csvFile" class="form-control" required>
                      </div>
                      <button type="submit" class="btn btn-warning">Register Voters</button>
                  </form>
              </div>
              <div id="bulkRegisterFeedback">

              </div> <!-- Placeholder for feedback messages -->
               
            </div>
            <div class="timer m-1">
                <div class="card">
                  <p class="card-title p-1 text-center">
                    Voting Session
                  </p>
                    <p class="p-0.5 text-center" style="font-weight:bold; font-size:20px;" id="countdown-timer"></p>

                </div>
            </div>
        </div>
      <!-- votimg time configuration -->
        <div class="col-md-3">          
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Voting Time Configuration</h5>
              <form action="set_voting_time.php" method="post">
                <div class="mb-3">
                  <label for="votingStartTime" class="form-label">Voting Start Time</label>
                  <input type="datetime-local" name="start_time" id="votingStartTime" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label for="votingEndTime" class="form-label">Voting End Time</label>
                  <input type="datetime-local" name="end_time" id="votingEndTime" class="form-control" required>
                </div>
                <button type="submit" name="submit" class="btn btn-warning">Set Voting Time</button>
              </form>
            </div>
          </div>
        </div>
        <!-- winners card -->
         <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        Winning Candidates
                    </h4>
                    <div class="" id="live-results-winners">

                    </div>
                </div>
            </div>
         </div>

        
      </div>
      <div class="row">
        <div class="col-md-6">         
            
                <div class="container text-center">
                  
                    <form method="POST">
                    <div class="mb-2 pb-3">
                      <h3 class="text-center">SMTP Mailer Configuration</h3>
                    </div>
                        <div class="row my-2">
                        <div class="col-md-6">
                          <div class="form-label">
                              <label style="font-weight:bold; font-size:20px;">SMTP Host</label>
                          </div>
                          <input type="text" class="form-control" name="smtp_host" value="<?php echo $settings['smtp_host']; ?>">

                        </div>
                        <div class="col-md-6">
                        <div class="form-label">
                          <label style="font-weight:bold; font-size:20px;">SMTP Port</label>
                          </div>
                              <input type="text" class="form-control" name="smtp_port" value="<?php echo $settings['smtp_port']; ?>">
                        </div>
                        </div> 
                        
                        <div class="row my-2">
                            <div class="col-md-6">
                              <div class="form-label">
                                <label style="font-weight:bold; font-size:20px;">SMTP Username</label>
                              </div>
                              <input type="text" class="form-control" name="smtp_username" value="<?php echo $settings['smtp_username']; ?>">
                            </div>
                            <div class="col-md-6">
                            <div class="form-label">
                            <label style="font-weight:bold; font-size:20px;">SMTP Password</label>
                          </div>
                        <input type="password" class="form-control" name="smtp_password" value="<?php echo $settings['smtp_password']; ?>">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-md-6">
                              <div class="form-label">
                                  <label style="font-weight:bold; font-size:20px;">From Email</label>
                                  </div>
                                  <input type="text" class="form-control" name="from_email" value="<?php echo $settings['from_email']; ?>">
                              
                            </div>

                            <div class="col-md-6">
                              <div class="form-label">
                                  <label style="font-weight:bold; font-size:20px;">From Name</label>
                              </div>
                                <input type="text" class="form-control" name="from_name" value="<?php echo $settings['from_name']; ?>">
                            </div>
  
                        </div>
                      <div class="my-2">
                      <input type="submit" name="submit" class="btn btn-warning" value="Save">
                      </div>
                    </form>
                </div>
            
        </div>
        <div class="col-md-6">

            

        </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <div class="">
    <?php include('include/footer.php') ?>
  </div><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- Script for fetching and displaying live results -->
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
                            }else if (votePercentage>=50 && votePercentage < 75){

                                progressBar.style.backgroundColor = 'gold';
                            }else if (votePercentage>= 75){
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
            setInterval(fetchLiveResults, 10000); // Refresh every 10 seconds
        });

          // fetching winners
        document.addEventListener('DOMContentLoaded', function() {
        function fetchWinners() {
            fetch('../fetch_winners.php')
                .then(response => response.json())
                .then(data => renderWinners(data))
                .catch(error => console.error('Error fetching winners:', error));
        }

        function renderWinners(winners) {
            const resultsContainer = document.getElementById('live-results-winners');
            resultsContainer.innerHTML = ''; // Clear previous results

            // Create a single canvas element for the combined chart
            const canvas = document.createElement('canvas');
            canvas.id = 'combined-chart';
            resultsContainer.appendChild(canvas);

            const ctx = canvas.getContext('2d');

            // Prepare the data for the combined bar chart
            const positions = [];
            const candidateNames = [];
            const voteCounts = [];

            for (const position in winners) {
                if (winners.hasOwnProperty(position)) {
                    positions.push(position.replace(/_/g, ' '));
                    candidateNames.push(winners[position].candidateName);
                    voteCounts.push(winners[position].vote_count);
                }
            }

            // Generate a combined bar chart
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: positions,
                    datasets: [{
                        label: 'Vote Count',
                        data: voteCounts,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0 // Ensure no decimal points for vote count
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${candidateNames[context.dataIndex]}: ${context.raw} votes`;
                                }
                            }
                        }
                    }
                }
            });
        }

        fetchWinners();
        setInterval(fetchWinners, 10000); // Refresh every 10 seconds
        });

        // countdown timer

        document.addEventListener('DOMContentLoaded', function() {
        // Get the end time from the PHP variable
        const endTime = new Date('<?php echo $end_time; ?>').getTime();
        const timerElement = document.getElementById('countdown-timer');

            function updateCountdown() {
                const now = new Date().getTime();
                const timeLeft = endTime - now;

                // Calculate days, hours, minutes, and seconds left
                const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                // Display the countdown timer
                if (timeLeft > 0) {
                    timerElement.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                } else {
                    timerElement.textContent = 'Voting has ended.';
                    clearInterval(countdownInterval);
                }
            }

            // Update the countdown every second
            const countdownInterval = setInterval(updateCountdown, 1000);
            updateCountdown(); // Initial call to display the countdown immediately
        });

        // bulk registration
        $(document).ready(function() {
        $('#bulkRegisterForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this); // Create a FormData object with the form data

            $.ajax({
                url: 'bulk_register.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Handle the success response (you can customize this message)
                    $('#bulkRegisterFeedback').html('<div class="alert alert-success">Voters registered successfully.</div>');
                },
                error: function(xhr, status, error) {
                    // Handle the error response
                    $('#bulkRegisterFeedback').html('<div class="alert alert-danger">An error occurred: ' + error + '</div>');
                }
            });
        });
    });


        
            document.addEventListener('DOMContentLoaded', function() {
                const cardFooter = document.querySelector('.card-footer');
                
                // Start the animation when the page loads
                cardFooter.style.animation = 'fadeInOut 5s infinite';

                // Optional: To stop the animation after a certain time
                setTimeout(() => {
                    cardFooter.style.animation = 'none';
                }, 300000); // Stops the animation after 300 seconds
            });




    </script>

<script>
        function sendReply(replyId) {
            // Implement the logic to send a reply to the user
            alert('Send reply functionality for Reply ID: ' + replyId);
        }

        function deleteReply(replyId) {
            if (confirm('Are you sure you want to delete this reply?')) {
                window.location.href = 'delete_reply.php?id=' + replyId;
            }
        }
    </script>



  <!-- Toast HTML for mobile view -->
  <!-- <div id="live-results-toast" class="toast">
    
  </div> -->

</body>

</html>

<style>
     .contact-replies-container {
            margin-top: 20px;
        }

        .reply-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            padding: 15px;
            background-color: #f9f9f9;
        }

        .reply-card h5 {
            font-weight: bold;
        }

        .reply-card p {
            margin: 0;
            padding: 0;
        }

        .reply-card .reply-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .reply-card .reply-header .reply-title {
            font-size: 16px;
            font-weight: bold;
        }

        .reply-card .reply-header .reply-date {
            font-size: 12px;
            color: #777;
        }

        .reply-card .reply-body {
            font-size: 14px;
            margin-top: 10px;
        }

        .reply-card .reply-actions {
            margin-top: 10px;
        }

        .reply-card .reply-actions button {
            margin-right: 10px;
        }
</style>
