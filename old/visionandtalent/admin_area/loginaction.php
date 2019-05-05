<script language="javascript">;
alert("invalid login details");
window.location.href='../home';
</script>'; 
<a href=""
<?php session_start();
function checkinjection($input){

	if (get_magic_quotes_gpc()){

		# code...
		$input = stripcslashes($input);
	}

	return mysql_real_escape_string($input);
}
?>

<?php include('db_con.php');
?>
<?php
if(isset($_POST['submit']))
{
	$mailid=checkinjection($_POST['email']);
	$password=$_POST['password'];
	$hash_pass=md5($password);
	$select=mysql_query
	("select * from users where email='$mailid' and password=
	'$hash_pass'");
	while($row=mysql_fetch_array($select)){
	if($row>0)
{
$uid=$row['id'];
$_SESSION['id']=$uid;

header("location:newsandvideo.php");


}
else{
	echo '<script language="javascript">';
echo 'alert("invalid login details")';
echo '</script>';
}
}
}
?>