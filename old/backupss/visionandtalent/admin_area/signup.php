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

<?php include("db_con.php");
$msg='';
?>
<?php
if(isset($_POST['submit']))
{
	$username=$_POST['name'];
	$pass=$_POST['password'];
	$hash_password=md5($pass);
	$rpass=$_POST['rpassword'];	
	 $mailid=$_POST['email'];

	$joseph= mysql_query("INSERT INTO users(id,name,password,rpassword,email) values('','$username','$hash_password','$hash_password=md5','$mailid')");

	if($joseph)
	{
	     header("location:login.php");}

		else{$msg="invalid registration";}
				
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>sign-up form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
  <body class="login-bg">
    <?php include 'inc_header.php' ;?>

	<div class="page-content container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-wrapper">
			        <div class="box">
			            <div class="content-wrap">
			                <h6>Sign Up New User</h6>
							<form method="post" action="">
			                <input class="form-control" name="name" type="text" placeholder="Name">
			                <input class="form-control" type="password" name="password" placeholder="Password">
			                <input class="form-control" type="password" name="rpassword" placeholder="Confirm Password">
							<input class="form-control" type="email" name="email" placeholder="E-mail">
			                <div class="action">
			                    <input type="submit" class="btn btn-success submit" value="submit" name="submit" />
			                </div>                
			            </div>
			        </div>
                            </form>
			        <div class="already">
			            <p>Have an account already?</p>
			            <a href="login.php">Login</a>
			        </div>
			    </div>
			</div>
		</div>
	</div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>