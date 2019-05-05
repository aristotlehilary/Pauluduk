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
<html>
<head>
	<title><?php echo $login_name;?></title>
</head>
<body>
<center>
<table border="0" cellspacing="10" cellpadding="2" background="../img/certificate.png">
	<tr>
		<td align="center">
		<img src="../img/spacer.gif" width="415" height="3"><br>
		<h1><?php echo  $company ;?></h1>
		
		In recognition of successfully completing the course:<br>
		<strong><?php echo $row['tittle'];?></strong>
		
		<h2>
			<?php echo  $login_name ;?><br>
			
		</h2>
		
		<i>is hereby awarded this</i>
		
		<h3>Certificate of Completion</h3>
						
		<i>Given this day, <?php echo date("d M Y g:i a") ;?><br>
		<img src="../img/spacer.gif" width="415" height="20">

		</td>
	</tr>
</table>
<button onclick="myFunction()">Print</button>

<script>
function myFunction() {
    window.print();
}
</script>
</center>
</body>
</html>