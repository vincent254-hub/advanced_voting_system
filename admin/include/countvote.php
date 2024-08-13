<!-- php scripts -->

<?php
require('../connection.php');
session_start();

// Ensure the admin is logged in
if (empty($_SESSION['admin_id'])) {
    header("location:access-denied.php");
    exit();
}

$candidates = [];
$total_votes = 0;
$error_message = '';

if (isset($_POST['Submit'])) {
    $position = addslashes($_POST['position']);
    
    if ($position !== 'select') {
        // Retrieve all candidates for the selected position
        $results = mysqli_query($conn, "SELECT * FROM candidatestable WHERE candidate_position='$position'");

        if ($results === false) {
            echo "Query Error: " . mysqli_error($conn) . "<br>";
        } else {
            while ($row = mysqli_fetch_array($results)) {
                $candidates[] = $row;
                $total_votes += $row['candidate_votes']; // Sum up the votes
            }

            if (empty($candidates)) {
                $error_message = 'No candidates found for the selected position.';
            }
        }
    } else {
        $error_message = 'Please select a valid position.';
    }
}

// Retrieve positions for the dropdown only once
$positions = mysqli_query($conn, "SELECT * FROM positionstable");

?>

<!-- end of php scripts -->


<html>
<head>
    <script language="JavaScript" src="js/admin.js"></script>
    <style>
        .progress-bar {
            height: 20px;
            background-color: red;
            transition: width 0.3s;
        }
        .progress-bar.yellow {
            background-color: yellow;
        }
        .progress-bar.green {
            background-color: green;
        }

        @media (max-width: 768px) {
            .card {
                max-width: 100%;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .card {
                max-width: 90%;
            }
        }

        @media (min-width: 1025px) {
            .card {
                max-width: 80%;
            }
        }
    </style>
    <!-- Bootstrap CSS (Ensure Bootstrap is included) -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="row">
    <div class="col-md-12">
        <div class="container mt-1">
            <div class="card-body">
                <h5 class="card-title text-center mt-1">Vote Results</h5>    
                <form name="fmNames" id="fmNames" method="post" action="" onSubmit="return positionValidate(this)">
                    <div class="row mb-3">
                        <label>Select Position</label>
                        <select class="form-control" name="position" id="position">
                            <option value="select">select</option>
                            <?php 
                            while ($row = mysqli_fetch_array($positions)) {
                                echo "<option value='$row[position_name]'>$row[position_name]</option>";     
                            }
                            ?>
                        </select>
                        <div class="container text-center">
                            <input class="btn btn-primary m-2" type="submit" name="Submit" value="See Results" />
                        </div>
                    </div>
                </form> 
            </div>

            <div class="container row">
                <?php if (!empty($candidates)): ?>
                    <?php foreach ($candidates as $candidate): ?>
                        <?php
                        $percentage = ($total_votes > 0) ? (100 * round($candidate['candidate_votes'] / $total_votes, 2)) : 0;
                        $progress_class = 'bg-danger';
                        if ($percentage >= 50) {
                            $progress_class = 'bg-success';
                        } elseif ($percentage >= 40) {
                            $progress_class = 'bg-warning';
                        }
                        ?>
                        <div class="col-md-6 col-sm-12 d-flex align-items-stretch">
                            <div class="card border-primary mb-3 m-2 flex-fill">
                                <div class="card-header bg-transparent border-primary">
                                    <?= htmlspecialchars($candidate['candidate_name']) ?>
                                </div>
                                <div class="card-body text-success container py-1 justify-content-center">
                                    <div class="progress">
                                        <div class="progress-bar <?= $progress_class ?>" role="progressbar" style="width: <?= $percentage ?>%;" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-primary text-sm">
                                    <?= $percentage ?>% of <?= $total_votes ?> total votes
                                    <p>Votes Gained: <?= htmlspecialchars($candidate['candidate_votes']) ?></p>
                                    
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p><?= htmlspecialchars($error_message) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
