<?php include 'inc_session.php';?>
<?php include 'db_con.php';

if(isset($_GET['vid']))
{
 $id = $_GET['vid'];
 $sql_query="SELECT * FROM evideos WHERE id='$id'";
 $result_set=mysql_query($sql_query);
 $row=mysql_fetch_array($result_set);
}
function formatDate($date) {
    return date('d M Y', strtotime($date));
}
?>
<?php
 if ($id != $row['id']){
  ?>

  <?php
 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $row['tittle'];?></title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/matrix-style.css" />
<link rel="stylesheet" href="css/matrix-media.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>
<?php include 'top_header.php';?>

<?php include 'inc_sidebar.php';?>


<!--main-container-part-->
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="explore" title="Back" class="tip-bottom"><i class="icon-home"></i> Back</a> <a href="#" class="current"><?php echo $row['tittle'];?></a> </div>
    <h1><?php echo $row['tittle'];?></h1>
  </div>
  <div class="container-fluid">
   
       

              <video controls autoplay loop preload="auto" poster="img/chairman.JPG"  height="70%" width="70%">
              <source src="../admin_area/evideos/<?php echo $row['video'];?>" type='video/mp4' />
              <source src="../admin_area/evideos/<?php echo $row['video'];?>.webm" type='video/webm' />
              <source src="../admin_area/evideos/<?php echo $row['video'];?>.ogg" type='video/ogg codecs="theora, vorbis' /> 
              </video>

      
      </div>

           <div class="span4">
       
        <h3><center><a href="certificate?vid=<?php echo $row['id'];?>">Get Certified</a></center></h3>
    
      </div>
      <div class="span4">

      </div>
    </div>
  </div>
</div>
<!--main-container-part-->

<!--Footer-part-->
<?php include 'inc_footer.php';?>
<!--end-Footer-part-->
<script src="js/jquery.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/matrix.js"></script>
</body>
</html>
