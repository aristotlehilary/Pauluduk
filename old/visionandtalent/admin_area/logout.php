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
if(session_destroy()) // Destroying All Sessions
{
	?>
<?php
header("Location: login.php"); // Redirecting To Home Page
}
?>