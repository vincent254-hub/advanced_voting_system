<?php
require('../connection.php');
session_start();

// Ensure the admin is logged in
if (empty($_SESSION['admin_id'])) {
    header("location:access-denied.php");
    exit();
}

// Retrieve positions for the dropdown
$positions = mysqli_query($conn, "SELECT * FROM positionstable");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>View Poll Results</title>
    <!-- Include your CSS files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #343a40;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }

        .form-select {
            border-radius: 5px;
            box-shadow: none;
            transition: border-color 0.3s ease-in-out;
        }

        .form-select:focus {
            border-color: #17a2b8;
            box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.25);
        }

        #results {
            margin-top: 30px;
        }

        .list-group-item {
            border: none;
            padding: 15px 20px;
            background: #f1f1f1;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        .list-group-item:hover {
            background-color: #e2e6ea;
        }

        .text-warning, .text-danger {
            font-weight: 500;
        }

        .chart-container {
            margin: auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                
                    <h2><i class="bi bi-bar-chart-fill me-2"></i>Select a Position to View Results</h2>
                    <form id="positionForm">
                        <div class="mb-3">
                            <label for="position" class="form-label">Position</label>
                            <select class="form-select" id="position" name="position">
                                <option value="select">Select a position</option>
                                <?php while ($row = mysqli_fetch_array($positions)) { ?>
                                    <option value="<?php echo $row['position_name']; ?>"><?php echo $row['position_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                    </form>

                    <div id="results">

                    </div>
                
            </div>
            <div class="col-md-6">
                
                    <div class="chart-container">
                        <canvas id="voteChart" style="width: 50px; height: 50px;">

                        </canvas>
                    </div>
                
            </div>
        </div>
    </div>

    <!-- Include necessary JS files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#position').change(function () {
                var position = $(this).val();
                
                if (position !== 'select') {
                    $.ajax({
                        url: 'fetch_results.php',
                        type: 'POST',
                        data: { position: position },
                        success: function (data) {
                            $('#results').html(data);
                        },
                        error: function () {
                            $('#results').html('<p class="text-danger">An error occurred while fetching the results.</p>');
                        }
                    });
                } else {
                    $('#results').html('<p class="text-danger">Please select a valid position.</p>');
                }
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- chart -->
    <script>
        $(document).ready(function () {
    var voteChart; // Global variable for chart instance

    $('#position').change(function () {
        var position = $(this).val();
        
        if (position !== 'select') {
            $.ajax({
                url: 'fetch_results.php',
                type: 'POST',
                data: { position: position },
                dataType: 'json', // Ensure the response is treated as JSON
                success: function (data) {
                    $('#results').html(data.html); // Display the HTML content

                    // Check if a chart instance already exists and destroy it before creating a new one
                    if (voteChart) {
                        voteChart.destroy();
                    }

                    // Get the canvas context for Chart.js
                    var ctx = document.getElementById('voteChart').getContext('2d');

                    // Create a new chart with the data received
                    voteChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: '# of Votes',
                                data: data.votes,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.label + ': ' + tooltipItem.raw + ' votes';
                                        }
                                    }
                                }
                            }
                        }
                    });
                },
                error: function () {
                    $('#results').html('<p class="text-danger">An error occurred while fetching the results.</p>');
                }
            });
        } else {
            $('#results').html('<p class="text-danger">Please select a valid position.</p>');
        }
    });
});

    </script>
</body>

</html>
