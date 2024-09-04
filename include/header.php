
<title>Heroes TVC EVS</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href="assets/css/main.css" rel="stylesheet">
  <!-- <link href="./style.css" rel="stylesheet"> -->
  <!-- <link href="css/user_styles.css" rel="stylesheet" type="text/css" /> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script language="JavaScript" src="js/user.js"></script>
  
  
  <script>
    // JavaScript to check every 30 seconds if voting is still open
    setInterval(function() {
        $.ajax({
            url: 'check_voting_time.php',
            success: function(response) {
                if (response.includes('Voting Session Closed')) {
                    Swal.fire({
                        title: 'Voting Closed',
                        text: 'Voting has ended. You can no longer cast your vote.',
                        icon: 'error'
                    }).then(function() {
                        window.location = 'voter_dashboard.php';
                    });
                } else if (response.includes('Voting is Active')) {
                    // Voting is still active, allow user actions or updates as needed
                    console.log('Voting is still active');
                } 
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error',
                    text: 'Unable to check the voting status. Please try again later.',
                    icon: 'error'
                });
            }
        });
    }, 30000); // Check every 30 seconds
</script>
