<?php
session_start();
require('connection.php');

// Redirect to login if not logged in
if(empty($_SESSION['member_id'])){
    header("location:login.php");
    exit();
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/fontawesome/css/all.min.css">
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- Dashboard Header -->
<header class="bg-primary text-white p-3">
    <div class="container d-flex justify-content-between align-items-center">
        <h1>Voter Dashboard</h1>
        <div>
            <span>Welcome, <?php echo $voter['first_name']; ?> <?php echo $voter['last_name']; ?></span>
            <a href="logout.php" class="btn btn-warning ml-2">Logout</a>
        </div>
    </div>
</header>

<!-- Main Dashboard Content -->
<div class="container my-4">
    <!-- Dashboard Overview -->
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Your Profile</h5>
                    <p><strong>Name:</strong> <?php echo $voter['first_name'] . ' ' . $voter['last_name']; ?></p>
                    <p><strong>Email:</strong> <?php echo $voter['email']; ?></p>
                    <p><strong>Voter ID:</strong> <?php echo $voter['admno']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Voting Status</h5>
                    <?php if($votingOpen): ?>
                        <p>Voting is currently <strong>OPEN</strong></p>
                        <p><strong>Ends at:</strong> <?php echo date('d M Y, H:i', strtotime($end_time)); ?></p>
                    <?php else: ?>
                        <p>Voting is currently <strong>CLOSED</strong></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Voter Turnout</h5>
                    <p><?php echo round($voterTurnout, 2); ?>% of voters have cast their vote.</p>
                    <p><strong>Total Votes Cast:</strong> <?php echo $totalVotes; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Ballot Access -->
    <div class="row my-4">
        <div class="col">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Voting Ballot</h5>
                </div>
                <div class="card-body">
                    <?php if($votingOpen): ?>
                        <p>Click the button below to cast your vote.</p>
                        <a href="ballot.php" class="btn btn-success">Vote Now</a>
                    <?php else: ?>
                        <p>Voting is not open at this time.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Voting History -->
    <div class="row my-4">
        <div class="col">
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
    </div>

    <!-- Support and Help -->
    <div class="row my-4">
        <div class="col">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0">Need Help?</h5>
                </div>
                <div class="card-body">
                    <p>If you have any issues or need assistance, feel free to <a href="contact_support.php">contact our support team</a>.</p>
                    <p>Refer to our <a href="faq.php">FAQs</a> for common questions.</p>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>
