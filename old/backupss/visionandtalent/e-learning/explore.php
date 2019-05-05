<?php include 'inc_session.php';?>
<?php include 'db_con.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>E-learning Videos-Visiona and Talent</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/uniform.css" />
<link rel="stylesheet" href="css/select2.css" />
<link rel="stylesheet" href="css/matrix-style.css" />
<link rel="stylesheet" href="css/matrix-media.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<?php include 'top_header.php';?>
<?php include 'inc_sidebar.php';?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Explore</a> </div>
    <h1>Videos</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Videos</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>

                <tr>
                <th>S/N</th>
                  <th>Tittle</th>
                  <th>What you will learn</th>
                 
                  <th>View</th>
                </tr>
              </thead>
              <tbody>
               <?php
$sel= mysql_query("select * from evideos order by id DESC");
$sn = 1;
while($row=mysql_fetch_array($sel))  
{
?> 
                <tr class="gradeU">
                <td><?php echo $sn;?></td>
                  <td><?php echo $row['tittle'];?></td>
                 
                  <td><?php echo $row['aim'];?></td>
                  <td><a href="Videos?vid=<?php echo $row['id'];?>"><center>View</center></a></td>
                </tr>
<?php
$sn++;
}
?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'inc_footer.php';?>
<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.uniform.js"></script> 
<script src="js/select2.min.js"></script> 
<script src="js/jquery.dataTables.min.js"></script> 
<script src="js/matrix.js"></script> 
<script src="js/matrix.tables.js"></script>
</body>
</html>
