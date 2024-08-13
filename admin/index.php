<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('include/header.php') ?>
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

  <!-- ======= Header ======= -->
  <?php include('include/topbar.php') ?>

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
              <p class="card-title text-center">Live Results from all positions</p>
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
        <div class="col-xxl-4 col-md-8">
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
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card">
            <div class="card-body">
              <h5 class="card-title">Votes <span>| Results</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-person-check"></i>
                </div>
                <div class="ps-3">
                  <p class="m-1">Votes Count</p>
                  <div class="container">
                    <?php include('include/countfile.php') ?>
                    <h3><?php echo($totalvotes) ?></h3>
                  </div>
                  <span class="text-success small pt-1 fw-bold">8%</span> 
                  <span class="text-muted small pt-2 ps-1">increase</span>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Votes Results Card -->

        <!-- HTVC Comrades Decide Card -->
        <div class="col-xxl-4 col-xl-12">
          <div class="card info-card">
            <div class="card-body">
              <h5 class="card-title"><span>| HTVC Comrades Decide</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6><?php echo(date('Y')) ?></h6>
                  <span class="text-danger small pt-1 fw-bold">100%</span> 
                  <span class="text-muted small pt-2 ps-1">Turnout</span>
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
              <div id="reportsChart"></div>
              <?php include('refresh.php') ?>
            </div>
          </div>
        </div><!-- End Updates Section -->

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
        const toast = document.getElementById('live-results-toast');
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
              const candidateName = document.createElement('span');
              candidateName.textContent = candidate.candidate_name + ': ' + candidate.votes + ' votes';
              section.appendChild(candidateName);

              const progress = document.createElement('div');
              progress.className = 'progress';
              const progressBar = document.createElement('div');
              progressBar.className = 'progress-bar';
              progressBar.style.width = candidate.votes + '%';
              progressBar.setAttribute('aria-valuenow', candidate.votes);
              progressBar.setAttribute('aria-valuemin', '0');
              progressBar.setAttribute('aria-valuemax', '100');
              progressBar.textContent = candidate.votes + '%';

              progress.appendChild(progressBar);
              section.appendChild(progress);
            });

            sections.push(section);
          }
        }

        if (window.innerWidth <= 576) { // Mobile view
          toast.innerHTML = '';
          sections.forEach((section) => {
            toast.appendChild(section.cloneNode(true)); // Use clone to avoid DOM issues
          });
          toast.classList.add('show');
        } else { // Desktop view
          sections.forEach((section, index) => {
            section.style.display = (index === currentSectionIndex) ? 'block' : 'none';
            liveResultsContent.appendChild(section);
          });

          currentSectionIndex = (currentSectionIndex + 1) % sections.length;
        }
      }

      function fetchLiveResults() {
        fetch('fetch_live_results.php')
          .then(response => response.json())
          .then(data => renderLiveResults(data))
          .catch(error => console.error('Error fetching live results:', error));
      }

      fetchLiveResults();
      setInterval(fetchLiveResults, 10000); // Refresh every 10 seconds

      window.addEventListener('resize', () => {
        if (window.innerWidth <= 576) {
          document.getElementById('live-results-sidebar').style.display = 'none';
        } else {
          document.getElementById('live-results-sidebar').style.display = 'block';
        }
      });
    });
  </script>

  <!-- Toast HTML for mobile view -->
  <div id="live-results-toast" class="toast">
    
  </div>

</body>

</html>
