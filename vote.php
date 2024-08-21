<?php
require('connection.php');

require_once('check_voting_time.php');

session_start();


if (empty($_SESSION['member_id'])) {
    header("location:access-denied.php");
}

$positions = mysqli_query($conn, "SELECT * FROM positionstable");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        .candidate-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            margin: 8px;
            width: 200px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            background-color: #fffcce;
        }

        .live-card {
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin: 8px;
            width: 400px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fefefe;
        }

        .input-card {
            padding: 16px;
            margin: 10px;
            width: 400px;
            align-items: center;
            text-align: center;
        }

        .candidate-card img {
            max-width: 100%;
            border-radius: 50%;
            margin-bottom: 8px;
            padding: 10px;
        }

        .candidate-card h5 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .candidate-card p {
            margin: 8px;
            background-color: #fcfcfc;
            border-radius: 5px;
            padding: 3px;
            font-size: 15px;
        }

        .candidate-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
    </style>
    <?php @include('include/header.php') ?>
</head>

<body>
    
        <div class="container">
            <?php @include('include/nav.php') ?>
        </div>
    

    <div class="container my-5 pt-4" id="page">
        <div class="container">
            <h1>Active Polls</h1>
        </div>
        <div class="refresh container my-4"></div>
        <div class="row">
            <div class="container">
                <div class="col-md-12">

                    <div class="container input-card" id="container">
                        <div class="container">
                            <form name="fmNames" id="fmNames" method="post" action="" onSubmit="return positionValidate(this)">
                                <label>Select Position to Vote for</label>
                                <SELECT NAME="position" class="form-control my-5 mx-3" id="position" onchange="loadCandidates(this.value)">
                                    <OPTION VALUE="select">Select Position</OPTION>
                                    <?php 
                                        while ($row = mysqli_fetch_array($positions)) {
                                            echo "<OPTION VALUE='$row[position_name]'>$row[position_name]</OPTION>";
                                        }
                                    ?>
                                </SELECT>
                                <input type="hidden" class="form-control" id="hidden" value="<?php echo $_SESSION['member_id']; ?>" />
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="container">
                            <div class="candidate-grid h-10" id="candidate-grid">
                                <!-- async candidates -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <marquee width="100%" behavior="alternate"><h3 style="text-align:center">Live Results</h3></marquee>
                        <div class="card mx-auto items-center mb-5 p-5 live-card">
                            <div class="" id="live-results-content">
                                <!-- live reslts streaming -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <center><span id="error"></span></center>
        </div>
    </div>
    <div class="col-md-12">
        <footer id="footer" class="footer">
            <?php @include('include/footer.php') ?>
        </footer>
    </div>
    </div>

    <script type="text/javascript">
        function loadCandidates(position) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "fetch_candidates.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status == 200) {
                    document.getElementById('candidate-grid').innerHTML = xhr.responseText;
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was a problem loading candidates.',
                        icon: 'error'
                    });
                }
            };
            xhr.send("position=" + position);
        }

        function confirmVote(candidate) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are voting for " + candidate,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, vote!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var pos = document.getElementById("position").value;
                    var id = document.getElementById("hidden").value;
                    castVote(candidate, id, pos);
                }
            });
        }

        function castVote(candidate, user_id, position) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "save_vote.php?vote=" + candidate + "&user_id=" + user_id + "&position=" + position, true);
            xhr.onload = function () {
                if (xhr.status == 200) {
                    Swal.fire({
                        title: 'Success!',
                        text: xhr.responseText,
                        icon: 'success'
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was a problem processing your vote.',
                        icon: 'error'
                    });
                }
            };
            xhr.send();
        }
    </script>

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
                fetch('./admin/fetch_live_results.php')
                    .then(response => response.json())
                    .then(data => renderLiveResults(data))
                    .catch(error => console.error('Error fetching live results:', error));
            }

            fetchLiveResults();
            setInterval(fetchLiveResults, 10000); // Refresh every 10 seconds

           
        });
    </script>
    
</body>

</html>
