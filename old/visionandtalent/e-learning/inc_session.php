<?php
include 'db_con.php';
session_start();
if(isset($_SESSION['id']))
{
$userid = ($_SESSION['id']);
$sel= mysql_query("select * from learning where id='$userid'");
while($row=mysql_fetch_array($sel))
{
$login_name=$row['name'];
$company=$row['company'];
$email=$row['email'];
}

}else{
  header("location:login.php");
}
?>