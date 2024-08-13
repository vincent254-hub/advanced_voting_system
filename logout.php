<?php
session_start();
?>

<?php
session_destroy();
?>


<!DOCTYPE html>
<html lang="en">
<head>
<?php @include('include/header.php')?>
<link href="style.css" rel="stylesheet">
</head>
<body>

<?php include('include/nav.php')?>
    <div class="row">
        <div class="col-md-12">
            <div class="container m-4 " style="align-items: center; display:flex;">
                <p><?php echo('<p class="contents"> You have successfully logged out. Thank you!!</p>')?></p>

                <a class="btn btn-success my-5 m-4" href="login.php">Login To Vote</a>
                <a href="./register.php"><p>register here!!</p></a>
            </div>            
        </div>
    </div>

    <div class="col-md-12">
        
        <footer id="footer" class="footer">

            <?php @include('include/footer.php')?>
    
        </footer>
       
    </div>
</body>
</html>