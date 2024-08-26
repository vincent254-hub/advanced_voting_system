<?php
// require_once('check_voting_time.php');
require('connection.php');

// require_once('check_voting_time.php');

session_start();


    if (empty($_SESSION['member_id'])) {
        header("location:access-denied.php");
    }


$positions = mysqli_query($conn, "SELECT * FROM positionstable");

    // Fetch the active voting period from the database
    $sql = "SELECT end_time FROM voting_time WHERE status = 1 ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $end_time = null;

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $end_time = $row['end_time'];
    }
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>User Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets1/img/favicon.png" rel="icon">
  <link href="assets1/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets1/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets1/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets1/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets1/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets1/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets1/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets1/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets1/css/style.css" rel="stylesheet">
  <script language="JavaScript" src="js/user.js"></script>
  
  
<?php @include('include/header.php') ?>
        
</head>

<body>

        <div class="container">
            <?php @include('include/nav.php') ?>
        </div>
  <?php
  require_once('connection.php');
  
  ?>

  <main>
    <div class="container mt-5">

      <section class="section register d-flex align-items-center justify-content-center py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="container">
                        <h2 class="text-center" style="font-weight:bold">Live stream Results</h2>
                        <div class="card my-3 py-5 px-5" id="live-results-content"> 
                                <!-- live results -->
                        </div>
                        <div class="card-footer">                        
                           <?php echo (date('Y'));?> Heroes TVC Decides
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                <h2 class="text-center my-4" style="font-weight:bold">Winners</h2>                       
                            <div class="card my-2 py-3 px-1" id="live-results-winners" style="background-color:#fffccc;">
                                <!-- Live results will be rendered here -->
                            </div>
                       
                    </div>
                </div>
                                
            </div>
            
        </div>
        <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">                    
                        <p class="text-center" style="font-weight:bold; font-size:20px;">Voting Timer Update</p>                    
                    <div class="card-body">
                        <p class="text-center" style="font-weight:bold; font-size:20px;" id="countdown-timer"></p>
                    </div> 
                </div>                   
            </div>
            <div class="col-md-4">
                <div class="card info-card">
                        <div class="card-body">
                            <h5 class="card-title">Important <span>| Links</span></h5>
                                <ul class="list-unstyled">
                                    <li><a class="dropdown-item" href="voter_dashboard.php">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="manage-profile.php">Voter Profile</a></li>
                                    <li><a class="dropdown-item" href="vote.php">Cast Vote</a></li>
                                    <li><a class="dropdown-item" href="refresh.php">Tally Results</a></li>
                                    <?php if (!empty($_SESSION['member_id'])) { echo '<li><a href="logout.php">Logout</a></li>'; } ?>
                                </ul>
                        </div>
                    </div>
                </div>
            
        </div>
        </div>
    </div>
      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets1/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets1/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets1/vendor/chart.js/chart.min.js"></script>
  <script src="assets1/vendor/echarts/echarts.min.js"></script>
  <script src="assets1/vendor/quill/quill.min.js"></script>
  <script src="assets1/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets1/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets1/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets1/js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  

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
                            candidateName.textContent = candidate.candidate_name;
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
                fetch('./admin/fetch_live_results.php')
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
        fetch('fetch_winners.php')
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
                        timerElement.textContent = `Voting ends in: ${days}d ${hours}h ${minutes}m ${seconds}s`;
                    } else {
                        timerElement.textContent = 'Voting period has ended ';
                        clearInterval(countdownInterval);
                    }
                }

                // Update the countdown every second
                const countdownInterval = setInterval(updateCountdown, 1000);
                updateCountdown(); // Initial call to display the countdown immediately
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



</body>

</html>

<style>
    @keyframes fadeInOut {
        0%, 100% { opacity: 0; }
        50% { opacity: 1; }

        0%, 100% { 
        opacity: 0; 
        color: red; /* Start and end with red */
    }
    25% {
        opacity: 0.5; 
        color: blue; /* Mid-fade change to blue */
    }
    50% { 
        opacity: 1; 
        color: green; /* Fully visible and change to green */
    }
    75% {
        opacity: 0.5;
        color: purple; /* Fading out change to purple */
    }

   

    .card-footer {
        animation: fadeInOut 5s infinite;
        font-weight:bold;
        
    }

    
</style>
