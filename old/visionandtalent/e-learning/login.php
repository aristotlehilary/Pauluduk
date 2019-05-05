<?php include 'db_con.php';?>
<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>E-learning Login</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="css/matrix-login.css" />
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
        <?php include '../inc_favicon.php';?>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

    </head>
    <body>
        <div id="loginbox">            
            <form id="loginform" action="loginaction" method="post" class="form-vertical">
				 <div class="control-group normal_text"> <h3>Login To Your E-learning Portal</h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"> </i></span><input type="email" name="email" placeholder="E-mail" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input type="password" name="rpassword" placeholder="Password" />
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span>
                    <span class="pull-right"><input type="submit" name="submit" value="Login" class="btn btn-success" /></a></span>
                </div>
            </form>



            <form id="recoverform" method="post" action="forgot.php" class="form-vertical">
				<p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover a password.</p>
				 
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lo"><i class="icon-envelope"></i></span>
                          
                            <input type="text" name="email" placeholder="E-mail address" />
                          
                        </div>
                    </div>
               
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a></span>
                    <span class="pull-right"><input type="submit" name="submit" value="Recover" class="btn btn-info"/></a></span>

                </div>
            </form>
        </div>
        
        <script src="js/jquery.min.js"></script>  
        <script src="js/matrix.login.js"></script> 
    </body>

</html>

