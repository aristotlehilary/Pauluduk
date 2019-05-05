<?php
include 'db_con.php';
session_start();
if(isset($_POST['submit']))
{
    $mailid=$_POST['email'];
    $rpassword=$_POST['rpassword'];
    $hash_pass=md5($rpassword);

    $select=mysql_query("select * from learning where email='$mailid' and rpassword='$hash_pass=md5'");

    while($row=mysql_fetch_array($select)){
    if($row>0)
{
$userid=$row['id'];
$_SESSION['id']=$userid;
header("location:index.php");
}
else{
    echo 'invalid login details';
}
}
}
?>
Incorrect Login Details. <a href="../index">Return to home</a>