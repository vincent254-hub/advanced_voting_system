<?php

require('connection.php');
session_start();
if (empty($_SESSION['member_id'])) {
    header("location:access-denied.php");
}

// Fetch voter details
$voter_id = $_SESSION['member_id'];
$query = "SELECT * FROM userstable WHERE member_id = '$voter_id'";
$result = mysqli_query($conn, $query);
$voter = mysqli_fetch_assoc($result);

// Fetch voting status
$votingStatusQuery = "SELECT * FROM voting_time WHERE status = 1 ORDER BY id DESC LIMIT 1";
$votingStatusResult = mysqli_query($conn, $votingStatusQuery);
$votingStatus = mysqli_fetch_assoc($votingStatusResult);
$end_time = $votingStatus ? $votingStatus['end_time'] : null;
$votingOpen = $votingStatus ? true : false;

// Calculate voter turnout
$totalVotesQuery = "SELECT COUNT(DISTINCT voter_id) AS totalVotes FROM votestable";
$totalVotersQuery = "SELECT COUNT(*) as totalVoters FROM userstable";
$totalVotesResult = mysqli_query($conn, $totalVotesQuery);
$totalVotersResult = mysqli_query($conn, $totalVotersQuery);

$totalVotes = mysqli_fetch_assoc($totalVotesResult)['totalVotes'];
$totalVoters = mysqli_fetch_assoc($totalVotersResult)['totalVoters'];
$voterTurnout = $totalVotes ? ($totalVotes / $totalVoters) * 100 : 0;

// Fetch voting history
$votingHistoryQuery = "SELECT 
                        p.position_name, 
                        c.candidate_name, 
                        v.position, 
                        v.candidateName,
                        v.vote_date, 
                        v.id AS vote_id 
                    FROM votestable v
                    JOIN candidatestable c ON v.candidateName = c.candidate_name
                    JOIN positionstable p ON v.position = p.position_name
                    WHERE v.voter_id = '$voter_id'";
$votingHistoryResult = mysqli_query($conn, $votingHistoryQuery);


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
<?php include('include/header.php');?>

</head>


<body class="contact-page">  
<?php include('include/nav.php');?>


<main class="main">
    <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/contact-page-title-bg.jpg);">
        <div class="container">
            <h1>User Dashboard</h1>
        </div>
    </div>

    <section id="contact" class="contact section">
        <div class="mx-2 position-relative" data-aos="fade-up" data-aos-delay="100">
            <div class="container">
                <span>Welcome, <?php echo $voter['first_name']; ?> <?php echo $voter['last_name']; ?></span>
                <a href="logout.php" class="btn btn-warning" style="margin-left: 150px;">Logout</a>
            </div>
        </div>    
    </section>
    <div class="container">
        <div class="align-items-center justify-content-center py-4">
                <div class="row my-4">
                    <div class="col-md-4">
                        <div class="card my-4">
                            <div class="card-header bg-dark text-white">
                                <h5 class="card-title mb-0 text-center">Profile</h5>
                            </div>
                            <div class="card-body">                        
                            
                                <p><strong>Name:</strong><?php echo $voter['first_name']. ' '. $voter['last_name']; ?></p>
                                <p><strong>Email:</strong> <?php echo $voter['email']; ?></p>
                                <p><strong>Voter ID:</strong> <?php echo $voter['admno']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card my-4" style="border: 1px solid #e3e3e3; border-radius: 8px;"> 
                            <div class="card-header bg-dark text-white text-center">
                                <h5 class="card-title mb-0">Voting Session</h5>
                            </div>                   
                                <!-- <p class="text-center" style="font-weight:bold; font-size:20px; margin-top: 20px;">Voting Timer Update</p>                     -->
                            <div class="card-body">
                                <p class="text-center" style="font-weight:bold; font-size:20px;" id="countdown-timer"></p>
                            </div> 
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card my-4">
                                <div class="card-header bg-dark text-white">
                                    <h5 class="card-title mb-0 text-center">Voter Turnout</h5>
                                </div>
                            <div class="card-body">                                
                                <p><?php echo round($voterTurnout, 2); ?>% of voters have cast their vote.</p>
                                <p><strong>Total Votes Cast:</strong> <?php echo $totalVotes; ?></p>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-md-4">
                        <h5 class="text-center" style="font-weight:bold;">Live stream Results</h5>
                        <div class="card my-4 py-5 px-5" id="live-results-content">

                        </div>
                        <div class="card-footer">                        
                                <?php echo (date('Y'));?> Heroes TVC Decides
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h5 class="card-title text-center"><?php echo(date('Y')); ?> Ballot</h5>
                        <div class="card my-4">
                                
                                <div class="card-body">
                                <?php if($votingOpen): ?>
                                    <p>Click the button below to cast your vote.</p>
                                    <a href="vote.php" class="btn btn-success">Vote Now</a>
                                <?php else: ?>
                                    <p>Voting Closed</p>
                                <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        
                    </div>
                </div>            
                <div class="row my-4">
                    <div class="col-md-6">
                    <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="card-title mb-0">Voting History</h5>
                </div>
                <div class="card-body">
                    <?php if(mysqli_num_rows($votingHistoryResult) > 0): ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Position</th>
                                    <th>Candidate</th>
                                    <th>Vote Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($history = mysqli_fetch_assoc($votingHistoryResult)): ?>
                                    <tr>
                                        <td><?php echo $history['position_name']; ?></td>
                                        <td><?php echo $history['candidate_name']; ?></td>
                                        <td><?php echo date('d M Y, H:i', strtotime($history['vote_date'])); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>You have not voted yet.</p>
                    <?php endif; ?>
                </div>
            </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-danger text-white">
                                <h5 class="card-title mb-0">Need Help?</h5>
                            </div>
                            <div class="card-body">
                                <p>If you have any issues or need assistance, feel free to <a href="contact.php">contact our support team</a>.</p>
                                <p>Refer to our <a href="faq.php">FAQs</a> for common questions.</p>
                            </div>
                        </div>
                    </div>
                    
                </div>            
            </div>
        </div>
    </div>
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
