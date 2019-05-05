<!DOCTYPE html>
<html>
  <head>
    <title>Dashboard|Login</title>
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
			                <h6>Sign In</h6>
			                <form action="loginaction.php" method="post" />
			                <input class="form-control" name="email" type="text" placeholder="E-mail address">
			                <input class="form-control" name="password" type="password" placeholder="Password">
			                <div class="action">
			                    <input type="submit" class="btn btn-success submit" value="Log in" name="submit" />
			                </div>                  
			            </div>
			        </div>
</form>
			        <div class="already">
			            <p>Don't have an account yet?</p>
			            <p>Then you are not an admin</p>
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