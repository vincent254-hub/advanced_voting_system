<?php 
  session_start();


  if (empty($_SESSION['member_id'])) {
      header("location:access-denied.php");
  }
  
?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php include('include/header.php');?>

</head>
<?php include('include/nav.php');?>

<body class="contact-page">  

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/contact-page-title-bg.jpg);">
      <div class="container">
        <h1>Contact</h1>
        
      </div>
    </div><!-- End Page Title -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-5">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Address</h3>
                <p>13701, Nakuru, 20100</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Call Us</h3>
                <p>+254 792 000 000</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email Us</h3>
                <p>heroestechnical2019@gmail.com</p>
              </div>
            </div><!-- End Info Item -->

          </div>

          <div class="col-lg-7">
            <form action="save_contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="500">
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" required="">
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required="">
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required="">
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" id="message" name="message" rows="6" placeholder="Message" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

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

</body>

</html>

<style>
   
    .contact {
    background-image: url("./assets/img/contact-bg.png");
    background-position: left center;
    background-repeat: no-repeat;
    position: relative;
    }

    @media (max-width: 640px) {
    .contact {
        background-position: center 50px;
        background-size: contain;
    }
    }

    .contact:before {
    content: "";
    background: color-mix(in srgb, var(--background-color), transparent 30%);
    position: absolute;
    bottom: 0;
    top: 0;
    left: 0;
    right: 0;
    }

    .contact .info-item+.info-item {
    margin-top: 40px;
    }

    .contact .info-item i {
    background: var(--accent-color);
    color: var(--contrast-color);
    font-size: 20px;
    width: 44px;
    height: 44px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50px;
    transition: all 0.3s ease-in-out;
    margin-right: 15px;
    }

    .contact .info-item h3 {
    padding: 0;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 5px;
    }

    .contact .info-item p {
    padding: 0;
    margin-bottom: 0;
    font-size: 14px;
    }

    .contact .php-email-form {
    height: 100%;
    }

    .contact .php-email-form input[type=text],
    .contact .php-email-form input[type=email],
    .contact .php-email-form textarea {
    font-size: 14px;
    padding: 10px 15px;
    box-shadow: none;
    border-radius: 0;
    color: var(--default-color);
    background-color: color-mix(in srgb, var(--background-color), transparent 50%);
    border-color: color-mix(in srgb, var(--default-color), transparent 80%);
    }

    .contact .php-email-form input[type=text]:focus,
    .contact .php-email-form input[type=email]:focus,
    .contact .php-email-form textarea:focus {
    border-color: var(--accent-color);
    }

    .contact .php-email-form input[type=text]::placeholder,
    .contact .php-email-form input[type=email]::placeholder,
    .contact .php-email-form textarea::placeholder {
    color: color-mix(in srgb, var(--default-color), transparent 70%);
    }

    .contact .php-email-form button[type=submit] {
    color: var(--contrast-color);
    background: var(--accent-color);
    border: 0;
    padding: 10px 30px;
    transition: 0.4s;
    border-radius: 50px;
    }

    .contact .php-email-form button[type=submit]:hover {
    background: color-mix(in srgb, var(--accent-color), transparent 20%);
    }

    /*--------------------------------------------------------------
    # Global Page Titles & Breadcrumbs
    --------------------------------------------------------------*/
    .page-title {
    color: var(--default-color);
    background-color: var(--background-color);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    padding: 160px 0 60px 0;
    text-align: center;
    position: relative;
    }

    .page-title:before {
    content: "";
    background-color: color-mix(in srgb, var(--background-color), transparent 40%);
    position: absolute;
    inset: 0;
    }

    .page-title .container {
    position: relative;
    }

    .page-title h1 {
    font-size: 42px;
    font-weight: 700;
    margin-bottom: 10px;
    }

    .page-title .breadcrumbs ol {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    justify-content: center;
    padding: 0;
    margin: 0;
    font-size: 16px;
    font-weight: 400;
    }

    .page-title .breadcrumbs ol li+li {
    padding-left: 10px;
    }

    .page-title .breadcrumbs ol li+li::before {
    content: "/";
    display: inline-block;
    padding-right: 10px;
    color: color-mix(in srgb, var(--default-color), transparent 70%);
    }

    /*--------------------------------------------------------------
    # Global Sections
    --------------------------------------------------------------*/
    section,
    .section {
    color: var(--default-color);
    background-color: var(--background-color);
    padding: 60px 0;
    scroll-margin-top: 100px;
    overflow: clip;
    }

    @media (max-width: 1199px) {

    section,
    .section {
        scroll-margin-top: 66px;
    }
    }
</style>
