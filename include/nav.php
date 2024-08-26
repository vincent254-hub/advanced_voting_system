

<header id="header" class="header d-flex align-items-center bg-dark fixed-top   p-0 mb-3">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center">
        
        <h1 class="d-flex align-items-center">OVS</h1>
      </a>

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

      <nav id="navbar" class="navbar navbar-expand-lg navbar-dark bg-dark">
        <ul>
          <li><a href="index.php">Home</a></li>
          
        <?php
          if(!empty($_SESSION['member_id'])){  
           echo'<li><a href="vote.php">Cast Vote</a></li>';
          }else{
            echo'<li><a href="register.php">Register</a></li>';
          }
          ?>
        
          
          <li><a href="manage-profile.php">Profile</a></li>
          <li><a href="voter_dashboard.php" class="">User Dashboard</a></li>          
          <?php
            if(!empty($_SESSION['member_id'])){
                echo'<li><a href="logout.php">Logout</a></li> ';
             }else{
              echo'<li><a href="login.php">Login</a></li>';
             }
      
      ?>
          
        </ul>
      </nav><!-- .navbar -->

    </div>
  </header>
  