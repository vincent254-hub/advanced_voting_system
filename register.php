<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Register</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <script language="JavaScript" src="js/user.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body>

  <?php
  require_once('connection.php');

    // Fetch the registration status from the database
      $query = mysqli_query($conn, "SELECT registration_status FROM settings WHERE id = 1");
      $statusRow = mysqli_fetch_assoc($query);
      $allowRegistration = $statusRow['registration_status'] == 1;

      if (!$allowRegistration) {
          echo "<script>
              document.addEventListener('DOMContentLoaded', function() {
                  Swal.fire({
                      icon: 'warning',
                      title: 'Registration Disabled',
                      text: 'Self-registration is currently disabled. Please contact the admin.',
                      confirmButtonText: 'OK'
                  }).then(function(){
                  window.location.href = 'index.php';
                });
              });
            </script>";
          exit;
      }

  
  if (isset($_POST['submit'])) {
        $myFirstName = addslashes($_POST['firstname']);
        $myLastName = addslashes($_POST['lastname']);
        $myEmail = $_POST['email'];
        $admno = $_POST['admno'];
        $myPassword = $_POST['password'];

        $newpass = md5($myPassword);

        // Check if email or admno already exists
        $emailCheck = mysqli_query($conn, "SELECT * FROM userstable WHERE email='$myEmail'");
        $admnoCheck = mysqli_query($conn, "SELECT * FROM userstable WHERE admno='$admno'");

        if (mysqli_num_rows($emailCheck) > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Email is already registered. Please try another.']);
            exit;
        } elseif (mysqli_num_rows($admnoCheck) > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Admission number is already registered. Please try another.']);
            exit;
        } else {
            // Insert user into database
            $sql = mysqli_query($conn, "INSERT INTO userstable(first_name, last_name, email, admno, password) 
                    VALUES ('$myFirstName','$myLastName', '$myEmail', '$admno', '$newpass')");
            echo json_encode(['status' => 'success', 'message' => 'Congrats, You have successfully registered for an account on OVS.']);
            header("Location: login.php");
            exit;
        }
    }
 ?>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 d-flex flex-column align-items-center justify-content-center">
            <div class="d-flex justify-content-center py-1">
                <a href="index.php" class=" d-flex align-items-center w-auto" >
                  <img src="assets/img/logo.png" style="height:150px; width:150px;" alt="">                                   
                </a>
              </div>
              <div class="card mb-2">

                <div class="card-body">

                  <div class="pt-4 pb-1">
                    <h5 class="card-title text-center my-0 pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>

                  <form action="register.php" id="registrationForm" method="post" onsubmit="return registerValidate(this)" class="row g-3 needs-validation" novalidate>
                      <div class="container my-3">
                          <div class="row d-flex justify-between">
                        <div class="col-6 my-1">
                            <label for="yourName" class="form-label my-1">First Name</label>
                            <input type='text' class='form-control'  name='firstname' maxlength='15' value='' required>
                            <div class="invalid-feedback">Please, enter your First name!</div>
                          </div>

                          <div class="col-6 my-1 ">
                            <label for="yourName" class="form-label">Last Name</label>
                            <input type='text' class='form-control' name='lastname' maxlength='15' value='' required>
                            <div class="invalid-feedback">Please, enter your First name!</div>
                          </div>
                        </div>

                        <div class="row d-flex my-3">
                        <div class="col-7">
                            <label for="yourEmail" class="form-label">Your Email</label>
                            <input type='email' class='form-control' name='email' maxlength='100' id='email' value='' required>
                            <div class="invalid-feedback">Please enter a valid Email address!</div>
                        </div>

                        <div class="col-5">
                            <label for="yourAdmn" class="form-label">SRN</label>
                            <input type="text" name="admno" class="form-control" id="admno" value='' placeholder="HDIS069-22" required>
                            <div class="invalid-feedback">Please enter a valid SRN number.</div>
                        </div>
                        </div>

                        <div class="row d-flex my-3">
                          <div class="col-6 ">
                            <label for="yourPassword" class="form-label">Password</label>
                            <input type='password' class='form-control' name='password' maxlength='15' value='' required>
                            <div class="invalid-feedback">Please enter your password!</div>
                          </div>

                          <div class="col-6 ">
                            <label for="yourPassword" class="form-label font-bold">Confirm Password</label>
                            <input type='password' class='form-control' name='ConfirmPassword' maxlength='15' value='' required>
                            <div class="invalid-feedback">Please confirm your password!</div>
                          </div>
                        </div>

                        
                        </div>
                        <div class="container text-center">
                          <input class="btn btn-primary w-50 " type='submit' name='submit' value='Register Account'></input>
                        </div>
                        <div class="container text-center py-4">
                          <p class="small mb-0">Already have an account? <a href="login.php">Log in</a></p>
                        </div>
                      </div>
                  </form>

                </div>
              </div>              

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <script>
    // Disable the form from submitting and show a SweetAlert message
    document.getElementById('registrationForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting

        // Show the SweetAlert message
        Swal.fire({
            icon: 'warning',
            title: 'Self Registration Disabled',
            text: 'We do not allow self-registration at the moment. Please contact the admin.',
            confirmButtonText: 'OK'
        });
    });


    $(document).ready(function() {
    $('#email, #admno').blur(function(event) {
        event.preventDefault();
        
        var emailId = $('#email').val();
        var admnoId = $('#admno').val();

        if (emailId !== "" || admnoId !== "") {
            $.ajax({
                url: 'checkuser.php',
                method: 'post',
                data: {
                    email: emailId,
                    admno: admnoId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'error') {
                        $('#result').html(response.message);
                        $('input[type="submit"]').prop('disabled', true);
                    } else {
                        $('#result').html('');
                        $('input[type="submit"]').prop('disabled', false);
                    }
                }
            });
        }
    });
});



  </script>


</body>

</html>