<?php

require('connection.php');
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
    <?php include('include/header.php'); ?>
</head>
<?php include('include/nav.php'); ?>

<body class="contact-page">

    <main class="main">

        <!-- Page Title -->
        <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/contact-page-title-bg.jpg);">
            <div class="container">
                <h1>User Dashboard</h1>
            </div>
        </div><!-- End Page Title -->

        <!-- Contact Section -->
        <section id="contact" class="contact section">

            <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
                <section class="section register d-flex align-items-center justify-content-center py-4">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card my-3 py-5 px-5" id="live-results-content" style="background-color: #f8f9fa; border: 1px solid #e3e3e3; border-radius: 8px;">
                                    <h2 class="text-center" style="font-weight:bold; margin-bottom: 20px;">Live Stream Results</h2>
                                    <!-- live results -->
                                </div>
                                <div class="card-footer text-center" style="background-color: #343a40; color: #fff; padding: 10px 0; font-weight: bold;">
                                    <?php echo (date('Y')); ?> Heroes TVC Decides
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h2 class="text-center my-4" style="font-weight:bold; color: #495057;">Winners</h2>
                                <div class="card my-2 py-3 px-1" id="live-results-winners" style="background-color: #f8f9fa; border: 1px solid #e3e3e3; border-radius: 8px;">
                                    <!-- Live results will be rendered here -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card" style="background-color: #f8f9fa; border: 1px solid #e3e3e3; border-radius: 8px;">
                                    <p class="text-center" style="font-weight:bold; font-size:20px; margin-top: 20px;">Voting Timer Update</p>
                                    <div class="card-body">
                                        <p class="text-center" style="font-weight:bold; font-size:20px;" id="countdown-timer"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card info-card" style="background-color: #f8f9fa; border: 1px solid #e3e3e3; border-radius: 8px;">
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
                </section>
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
                fetch('./admin/fetch_live_results.php')
                    .then(response => response.json())
                    .then(data => renderLiveResults(data))
                    .catch(error => console.error('Error fetching live results:', error));
            }

            fetchLiveResults();
            setInterval(fetchLiveResults, 10000); // Refresh every 10 seconds
        });

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
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    title: function(tooltipItems) {
                                        return positions[tooltipItems[0].dataIndex];
                                    },
                                    label: function(tooltipItem) {
                                        const candidateName = candidateNames[tooltipItem.dataIndex];
                                        const voteCount = voteCounts[tooltipItem.dataIndex];
                                        return candidateName + ': ' + voteCount + ' votes';
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

        document.addEventListener('DOMContentLoaded', function() {
            const countdownTimerElement = document.getElementById('countdown-timer');
            const endTime = <?php echo json_encode($end_time); ?>;
            const countdownInterval = setInterval(updateCountdown, 1000);

            function updateCountdown() {
                const now = new Date().getTime();
                const endTimeDate = new Date(endTime).getTime();
                const timeLeft = endTimeDate - now;

                if (timeLeft <= 0) {
                    clearInterval(countdownInterval);
                    countdownTimerElement.innerHTML = 'Voting Closed';
                    Swal.fire({
                        icon: 'info',
                        title: 'Voting Closed!',
                        text: 'The voting period has ended.',
                        confirmButtonText: 'OK'
                    });
                    setTimeout(function() {
                        location.reload(); // Refresh the page to show results after voting ends
                    }, 2000);
                } else {
                    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                    countdownTimerElement.innerHTML = `${hours}h ${minutes}m ${seconds}s`;
                }
            }
        });
    </script>

</body>

</html>
