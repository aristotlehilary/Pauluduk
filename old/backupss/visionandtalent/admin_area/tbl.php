<?php
include 'db_con.php';
session_start();
if(isset($_SESSION['id']))
{
  $userid = ($_SESSION['id']);
  
$sel= mysql_query("select * from users where id='$userid'");
while($row=mysql_fetch_array($sel))
{
$login_name=$row['name'];


}


}else{
  header("location:login.php");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Dashboard Table|Vision & Talent</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery UI -->
    <link href="https://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" rel="stylesheet" media="screen">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="css/styles.css" rel="stylesheet">
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <?php include 'inc_header.php';?>
    <div class="page-content">
      <div class="row">
      <?php include 'sidebar.php' ;?>
      <div class="col-md-10">

          <div class="row">
            <h3><a href="mastermindp"><?php
  $result0 = mysql_query(" SELECT COUNT(programname) FROM mtprogram");
  $row0 = mysql_fetch_array($result0);  
  echo $count0= $row0[0];
?> Mastermind programs</a></h3>
              </div>
            </div>
          <br><br>
<div class="col-md-10">
<br><br>
          <div class="row">
               <h3><a href="openp"><?php
  $result0 = mysql_query(" SELECT COUNT(opname) FROM openprogram");
  $row0 = mysql_fetch_array($result0);  
  echo $count0= $row0[0];
?> Open programs</a></h3>
              </div>
            </div>
            <div class="col-md-10">
<br><br>
          <div class="row">
            <h3><a href="classp"><?php
  $result0 = mysql_query(" SELECT COUNT(classname) FROM classprogram");
  $row0 = mysql_fetch_array($result0);  
  echo $count0= $row0[0];
?> Masterclass</a></h3>
              </div>
            </div>
            <div class="col-md-10">
<br><br>
          <div class="row">
            <h3><a href="onedayp"><?php
  $result0 = mysql_query(" SELECT COUNT(onename) FROM onedayprogram");
  $row0 = mysql_fetch_array($result0);  
  echo $count0= $row0[0];
?> One-Day High Impact Program</a></h3>
              </div>
            </div>
          </div>
          </div>

    <?php include 'inc_footer.php' ;?>
  
      <link href="vendors/datatables/dataTables.bootstrap.css" rel="stylesheet" media="screen">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="vendors/datatables/js/jquery.dataTables.min.js"></script>

    <script src="vendors/datatables/dataTables.bootstrap.js"></script>

    <script src="js/custom.js"></script>
    <script src="js/tables.js"></script>
  </body>
</html>