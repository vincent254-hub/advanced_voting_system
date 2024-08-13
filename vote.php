<?php
require('connection.php');

session_start();
if(empty($_SESSION['member_id'])){
 header("location:access-denied.php");
}

?>
<?php
$positions=mysqli_query($conn, "SELECT * FROM positionstable");
?> 
<?php
   
 if (isset($_POST['Submit']))
 {
 
 $position = addslashes( $_POST['position'] ); 
 
 
 $result = mysqli_query($conn,"SELECT * FROM candidatestable WHERE candidate_position='$position'");
 
 
 }
 else
 
  
?>
<html>
<head>
<?php @include('include/header.php')?>

   <link rel="stylesheet" href="style.css">
   <script language="JavaScript" src="js/user.js"></script>
</head>
<body>

<div class="col-md-12">
    <div class="container">
        <?php @include('include/nav.php') ?>
    </div>

</div>
<div class="container" id="page">
<div class="container">

  <h1>Active Polls</h1>
  
</div>
<div class="container my-4">
</div>
<div class="row">
  <div class="col-md-12">
  <div class="container " style="display: flex; align-items:center" id="container">

<div class="card">
  <div class="card-title">
    <h4 class="text-center">Select Candidate</h4>
  </div>
  <div class="card-body">
      <form name="fmNames" id="fmNames" method="post" action="vote.php" onSubmit="return positionValidate(this)">

          
          <SELECT NAME="position" class="form-control"  id="position" onclick="getPosition(this.value)">
          <OPTION VALUE="select">select
          <?php 

          while ($row=mysqli_fetch_array($positions)){
          echo "<OPTION VALUE=$row[position_name]>$row[position_name]"; 

          }
          ?>
          </SELECT>
          <input type="hidden" class="form-control" id="hidden" value="<?php echo $_SESSION['member_id']; ?>" /></td>
          <input type="hidden" id="str" value="<?php echo $_REQUEST['position']; ?>" />
          <input class="btn btn-primary my-2" type="submit" name="Submit" value="See Candidates" />

    </form> 
  </div>
</div>

<div class="container ml-5 p-5" style="display: flex;">
      <form>
   
        <div class="container ">
          <div class="card">
            <div class="card-title">
            <h3 class="text-center">Candidates Availed </h3>
            </div>

            <div class="card-body">
            <div class="container text-center">
            <?php

                    if (isset($_POST['Submit']))
                    {
                    while ($row=mysqli_fetch_array($result)){
                    echo "<div class='container' style='display:flex'>";
                    echo "<ul>" . $row['candidate_name']."</ul>";
                    echo "<ul><input type='radio' name='vote' value='$row[candidate_name]' onclick='getVote(this.value)' /></ul>";
                    echo "</div>";
                    }
                    mysqli_free_result($result);
                    mysqli_close($conn);

                    }
                    else{
                      echo'There are no candidates for the selected position';
                    }

            ?>
            </div>
            </div>
          </div>

          
        </div>

            

    </form>
</div>
  </div>
</div>
<div class="row">
  <div class="col-lg1">
    <div class="container">
    <marquee width="100%" behavior="alternate">  
    <p class="text-warning">Disclaimer!! You're Required to vote once. Choose wisely... </p>
    </marquee>
    </div>
  </div>
</div>


</div>
<div class="col-md-12">
        
        <footer id="footer" class="footer">

            <?php @include('include/footer.php')?>
    
        </footer>
       
    </div>
</div>
</body>
<script type="text/javascript">
function getVote(int)
{
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

	if(confirm("are you sure you want to vote for "+int))
	{
  var pos=document.getElementById("str").value;
  var id=document.getElementById("hidden").value;
  xmlhttp.open("GET","save.php?vote="+int+"&user_id="+id+"&position="+pos,true);
  xmlhttp.send();

  xmlhttp.onreadystatechange =function()
{
	if(xmlhttp.readyState ==1 && xmlhttp.status==200)
	{
  
	document.getElementById("error").innerHTML=xmlhttp.responseText;
	}
}

  }
	else
	{
	alert("Choose another candidate ");
	}
	
}

function getPosition(String)
{
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

xmlhttp.open("GET","vote.php?position="+String,true);
xmlhttp.send();
}
</script>
<script type="text/javascript">
$(document).ready(function(){
   var j = jQuery.noConflict();
    j(document).ready(function()
    {
        j(".refresh").everyTime(1000,function(i){
            j.ajax({
              url: "admin/refresh.php",
              cache: false,
              success: function(html){
                j(".refresh").html(html);
              }
            })
        })
        
    });
   j('.refresh').css({color:"green"});
});
</script>
</html>