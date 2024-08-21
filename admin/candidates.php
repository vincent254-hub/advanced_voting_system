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
            background-color: #ccc9cc;
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

        .text-danger {
            color: #dc3545;
        }

        .text-danger:hover {
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
    </style>
</head>
<body>

<div class="container py-5">
<div class="row">
    <div class="col-md-5">
        <form name="fmCandidates" id="fmCandidates" action="candidates.php" method="post" enctype="multipart/form-data" onsubmit="return candidateValidate(this)" class="card-body">
                <h5 class="card-title">Manage <span>| Candidates</span></h5>                  

                    <div class="">
                        <div class="align-items-center">
                            <div class="m-2">
                                <label>Candidate Name</label>
                                <input class="form-control" type="text" name="name" />
                            </div>
                            <div class="m-2">
                                <label>Candidate Position</label>
                                <?php include('include/candidates.php') ?>
                                <SELECT class="form-control" NAME="position" id="position">
                                    <OPTION VALUE="select">select
                                    <?php
                                    while ($row = mysqli_fetch_array($positions_retrieved)) {
                                        echo "<OPTION VALUE=$row[position_name]>$row[position_name]";
                                    }
                                    ?>
                                </SELECT>
                            </div>
                            <div class="m-2">
                                <label>Candidate Year of Study</label>
                                <input class="form-control" type="text" name="yos" />
                            </div>
                            <div class="row mb-3">
                                <label for="candidate_img">Image Upload </label>
                                <div class="col-md-8 col-lg-9">
                                    <input type="file" class="form-control" id="candidate_img" name="candidate_img"
                                    value="<?php echo($row['candidate_img']); ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="container text-center">
                            <input class="btn btn-primary" type="submit" name="Submit" value="Add Candidate" />
                        </div>
                </div>
            </form>
    </div>
    <div class="col-md-7">
        <div class="container">
        <table class="table table-borderless datatable mt-4">
                <thead>
                    <tr>
                        <th scope="col">Image</th>
                        <th scope="col">Candidate ID</th>
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
                        echo'<td>'   .$row['candidate_img'] .'</td>';
                        echo '<td>' . $row['candidate_id'] . '</td>';
                        echo '<td>' . $row['candidate_name'] . '</td>';
                        echo '<td>' . $row['candidate_position'] . '</td>';                        
                        echo '<td>' . $row['candidateYOS'] . '</td>';                        
                        echo '<td><a class="text-danger" href="candidates.php?id=' . $row['candidate_id'] . '">Delete</a></td>';
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

<?php include("include/scripts.php") ?>
</body>
</html>
