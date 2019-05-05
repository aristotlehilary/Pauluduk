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

<!DOCTYPE html>
<html>
  <head>
    <title>Add programs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery UI -->
    

    <!-- Bootstrap -->
   
    <!-- styles -->
    <link href="css/styles.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="vendors/form-helpers/css/bootstrap-formhelpers.min.css" rel="stylesheet">
    <link href="vendors/select/bootstrap-select.min.css" rel="stylesheet">
    <link href="vendors/tags/css/bootstrap-tags.css" rel="stylesheet">

    <link href="css/forms.css" rel="stylesheet">

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
		  			</div>
	  				</div>

            <div class="col-md-10">

          <div class="row">
            <h3><?php
  $result0 = mysql_query(" SELECT COUNT(video) FROM evideos");
  $row0 = mysql_fetch_array($result0);  
  echo $count0= $row0[0];
?> Add videos to E-learning</h3><h4><a  class="btn btn-default" data-toggle="modal" data-target="#myMdal"><i class="fa fa-plus"></i>Add</a></h4>
              </div>
            </div>
<!-- Modal form - Advance Programs -->
<div id="myMdal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="color: whitesmoke; background-color:#00CCFF">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title" >Add videos to e-learning</h3>
      </div>
              <form method="post" action="newsaction" enctype="multipart/form-data">
      <div class="modal-body">
      
              <div>
                <input type="file" class="form-control" name="video" placeholder="Please include a picture" required="" />
              </div><br>
               <div>
                <input type="text" class="form-control" name ="tittle" placeholder="Video Tittle" required="" />
              </div><br>
			   <div>
                <input type="" name="aim" placeholder="Aim and Objective" class="form-control col-md-7 col-xs-12"></textarea>
              </div><br>
        
                <div>
                    <button class="btn btn-success submit " name="submit" style="float: left;background-color:#00CCFF">Add</button>
                  </div>
                <div class="clearfix"></div>
              <div class="separator">

                  <a data-toggle="modal" data-target="#myModal1" href="#"></a>
                <div class="clearfix"></div>
               
              </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal" style="background-color:#00CCFF">Dismiss</button>
      </div>
            </form>
    </div>
  </div>
</div>
 <!-- /end of Modal form - Add openprograms -->


          
          

  <div class="col-md-10">

          <div class="row">
            <h3><?php
  $result0 = mysql_query(" SELECT COUNT(videoname) FROM videos");
  $row0 = mysql_fetch_array($result0);  
  echo $count0= $row0[0];
?> Add video to website</h3><h4><a  class="btn btn-default" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>Add</a></h4>
              </div>
            </div>

 <!-- Modal form - videos -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="color: whitesmoke; background-color:#00CCFF">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title" >Add a Youtube video embeded link</h3><h5> *note this won't work if its not embeded correctly</h5>
      </div>
              <form method="post" action="vidaction">
      <div class="modal-body">
      
              <div>
                <input type="text" class="form-control" name ="videolink" placeholder="Paste youtube embedment link eg https://www.youtube.com/embed/Hc928InwP0w" required="" />
              </div><br>
               <div>
                <input type="text" class="form-control" name ="videoname" placeholder="Video name" required="" />
              </div><br>
			  <div>
                <input type="text" class="form-control" name ="videotags" placeholder="Video tags(this is apparently optional)" />
              </div><br>
        <div>
                <input type="hidden" class="form-control" name ="name" placeholder="" value="<?php echo $login_name ;?>" />

              </div><br>
        
                <div>
                    <button class="btn btn-success submit " name="submit" style="float: left;background-color:#00CCFF">Add</button>
                  </div>
                <div class="clearfix"></div>
              <div class="separator">

                  <a data-toggle="modal" data-target="#myModal1" href="#"></a>
                <div class="clearfix"></div>
               
              </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal" style="background-color:#00CCFF">Dismiss</button>
      </div>
            </form>
    </div>
  </div>
</div>
 <!-- /end of Modal form - Add videos -->

 


</div>
</div>
	  				

	  			

	  		<!--  Page content -->
	

    <?php include 'inc_footer.php' ;?>

    

    <script src="vendors/form-helpers/js/bootstrap-formhelpers.min.js"></script>
	
	<script src="../js/jquery.js"></script>
	
	<script src="../js/bootstrap.min.js"></script>
	
    <script src="vendors/select/bootstrap-select.min.js"></script>

    <script src="vendors/tags/js/bootstrap-tags.min.js"></script>

    <script src="vendors/mask/jquery.maskedinput.min.js"></script>

    <script src="vendors/moment/moment.min.js"></script>

    <script src="vendors/wizard/jquery.bootstrap.wizard.min.js"></script>

     <!-- bootstrap-datetimepicker -->
     <link href="vendors/bootstrap-datetimepicker/datetimepicker.css" rel="stylesheet">
     <script src="vendors/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script> 


<script src="js/custom.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/forms.js"></script>
  </body>
</html>