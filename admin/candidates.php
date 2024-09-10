<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("include/header.php") ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .card-title {
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .table {
            margin-top: 20px;
        }

        .table thead th {
            background-color: #333;
            color: #fff;
            border: none;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .text-danger, .text-info {
            cursor: pointer;
        }

        .text-danger:hover, .text-info:hover {
            text-decoration: underline;
        }

        .container.text-center {
            margin-top: 20px;
        }

        .poscontainer {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .candidate-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .btn-sm {
            padding: 5px 10px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row">
        <!-- Form for Adding/Editing Candidates -->
        <div class="col-md-3">
            <form name="fmCandidates" id="fmCandidates" action="candids.php" method="post" enctype="multipart/form-data" class="card-body">
                <h5 class="card-title">Manage <span>| Candidates</span></h5>

                <!-- Candidate Name Input -->
                <div class="m-2">
                    <label>Candidate Name</label>
                    <input class="form-control" type="text" name="name" value="<?php echo isset($editCandidate['candidate_name']) ? $editCandidate['candidate_name'] : ''; ?>" required />
                </div>

                <!-- Candidate Position Dropdown -->
                <div class="m-2">
                <?php include('include/candidates.php') ?>
                    <label>Candidate Position</label>
                    <SELECT class="form-control" NAME="position" id="position" required>
                        <OPTION VALUE="select">Select
                        <?php
                        while ($row = mysqli_fetch_array($positions_retrieved)) {
                            $selected = (isset($editCandidate['candidate_position']) && $editCandidate['candidate_position'] == $row['position_name']) ? 'selected' : '';
                            echo "<OPTION VALUE='$row[position_name]' $selected>$row[position_name]</OPTION>";
                        }
                        ?>
                    </SELECT>
                </div>

                <!-- Year of Study Input -->
                <div class="m-2">
                    <label>Candidate Year of Study</label>
                    <input class="form-control" type="text" name="yos" value="<?php echo isset($editCandidate['candidateYOS']) ? $editCandidate['candidateYOS'] : ''; ?>" required />
                </div>

                <!-- Image Upload -->
                <div class="row mb-3">
                    <label for="candidate_img">Image Upload</label>
                    <div class="col-md-8 col-lg-9">
                        <input type="file" class="form-control" id="candidate_img" name="candidate_img" />
                        <?php if (isset($editCandidate['candidate_img']) && !empty($editCandidate['candidate_img'])): ?>
                            <img src="candidate_img/<?php echo $editCandidate['candidate_img']; ?>" class="candidate-image mt-2" />
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Hidden Field for Candidate ID in Edit Mode -->
                <?php if (isset($editCandidate['candidate_id'])): ?>
                    <input type="hidden" name="candidate_id" value="<?php echo $editCandidate['candidate_id']; ?>">
                <?php endif; ?>

                <!-- Submit Button -->
                <div class="container text-center">
                    <input class="btn btn-primary" type="submit" name="Submit" value="<?php echo isset($editCandidate) ? 'Update Candidate' : 'Add Candidate'; ?>" />
                </div>
            </form>
        </div>

        <!-- Table of Existing Candidates -->
        <div class="col-md-9">
            <div class="container">
                <table class="table table-borderless datatable mt-4">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Candidate Name</th>
                            <th scope="col">Candidate Position</th>
                            <th scope="col">Candidate Year Of Study</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once('../connection.php');
                        $result = mysqli_query($conn, "SELECT * FROM candidatestable");
                        while ($row = mysqli_fetch_array($result)) {
                            echo '<tr>';
                            echo '<td><img src="candidate_img/' . $row['candidate_img'] . '" class="candidate-image" /></td>';
                            echo '<td>' . $row['candidate_name'] . '</td>';
                            echo '<td>' . $row['candidate_position'] . '</td>';
                            echo '<td>' . $row['candidateYOS'] . '</td>';
                            echo '<td>
                                    <a href="candidates.php?edit_id=' . $row['candidate_id'] . '" class="text-info">Edit</a> |
                                    <a href="candidates.php?id=' . $row['candidate_id'] . '" class="text-danger">Delete</a>
                                  </td>';
                            echo '</tr>';
                        }
                        mysqli_free_result($result);
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php include("include/scripts.php") ?>
</body>
</html>
