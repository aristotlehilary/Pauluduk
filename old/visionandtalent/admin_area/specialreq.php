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
<?php
function formatDate($date) {
    return date('d M Y g:i a', strtotime($date));
}
?>
<?php
// delete condition

if(isset($_GET['delete_id']))

{

$delete_query="DELETE FROM classrequest WHERE id=".$_GET['delete_id'];

mysql_query($delete_query);

header("Location:$_SERVER[PHP_SELF]");

}

// delete condition

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Dashboard Table|Vision & Talent</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery UI -->
    <link href="https://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" rel="stylesheet" media="screen">
<script type="text/javascript">

function edt_id(id)

{

if(confirm('Sure to edit?'))

{

  window.location.href='edit-bar?edit_id='+id;

}

}

function delete_id(id)

{

if(confirm('Are you sure to delete?'))

{

  window.location.href='masterclassreq.php?delete_id='+id;

}

}

function details_id(id)

{

if(confirm('Are you sure to view student details ?'))

{

  window.location.href='student_details.php?details_id='+id;

}

}

</script>
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
  	  <?php include 'inc_header.php' ;?>
	

    <div class="page-content">
    	<div class="row">
		  <?php include 'sidebar.php' ;?>
		  <div class="col-md-10">

		  	<div class="row">
  				<div class="col-md-6">
  					<div class="content-box-large" style="width:900px">
		  				<div class="panel-heading">
							<div class="panel-title">Special project request</div>
							
							<div class="panel-options">
								<a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
								<a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
							</div>
						</div>
		  			
		  				<div class="panel-body">
		  					<table class="table table-hover" style="width:800px">
				              <thead>
				                <tr>
				                  <th>S/N</th>
				                  <th>User Name</th>
								  <th>Phone no</th>
				                  <th>Emails</th>
								  <th>Company name(optional)</th>
								  <th>Delete req</th>
				                </tr>				              </thead>
				              <tbody>
							  					   <?php
$sel= mysql_query("select * from special_project ORDER BY id DESC LIMIT 100");
$sn = 1;
while($row=mysql_fetch_array($sel))
{
?>
				                <tr>
				                  <td><?php echo $sn ;?></td>
				                  <td><?php echo $row['username'];?></td>
				                
							      <td><?php echo $row['phoneno'];?></td>
				                  <td><a href="emailto.php?emails=<?php echo $row['email'];?>"><?php echo $row['email'];?></a></td>
								 
								  <td><?php echo $row['company'];?></td>
								  <td><a href="javascript:delete_id('<?php echo $row['id']; ?>')">Del</a></td>
								 <?php
								$sn++;
								}
								?>
				              </tbody>
				            </table>				            </table>
		  				</div>
		  			</div>
  				</div>
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
