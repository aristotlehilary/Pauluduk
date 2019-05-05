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
    
<script src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/samples/js/sample.js"></script>

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
	  				<h3><?php
  $result0 = mysql_query(" SELECT COUNT(programname) FROM mtprogram");
  $row0 = mysql_fetch_array($result0);  
  echo $count0= $row0[0];
?> Mastermind programs</h3><h4><a  class="btn btn-default" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>Add</a></h4>
			  			</div>
	  				</div>
					
<!-- Modal form - Advance Programs -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="color: whitesmoke; background-color:#00CCFF">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title" >Add Master Mind Training Programs</h3>
      </div>
      <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
              <form method="post" action="mtprogram" enctype="multipart/form-data">
      <div class="modal-body">
      <div>Program image
                <input type="file" class="form-control" name ="imagename" placeholder="Please input the program image" required="" />
              </div><br>
              <div>
                <input type="text" class="form-control" name ="programname" placeholder="Mastermind Name(not more than 94 charcters)" required="" maxlength="94" />
              </div><br>
               <div>
                <input type="text" class="form-control" name ="programsubname" placeholder="Sub-program Name" required="" />
              </div><br>
			  <div>
                <textarea id="editor" required="" placeholder="Program concept" name="concept" class="form-control col-md-7 col-xs-12"></textarea>
              </div><br><br>

        <div>
                <textarea id="" required="" placeholder="Program objective" name="objective" class="form-control col-md-7 col-xs-12"></textarea>
              </div><br><br>
        <div>
        content
                <textarea id="" required="" placeholder="Program content" name="content" class="form-control col-md-7 col-xs-12"></textarea>
              </div><br>
              <div>
                <input type="text" class="form-control" name ="forwhom" placeholder="For Whom" />
              </div><br>
        <div>
                <input type="text" class="form-control" name ="duration" placeholder="Duration eg,3-4 days" />
                <input type="hidden" class="form-control" name ="name" placeholder="" value="<?php echo $login_name ;?>" />

              </div><br>
        
                <div>
                    <button class="btn btn-success submit " name ="submit" style="float: left;background-color:#00CCFF">Add</button>
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
  $result0 = mysql_query(" SELECT COUNT(opname) FROM openprogram");
  $row0 = mysql_fetch_array($result0);  
  echo $count0= $row0[0];
?> Open programs</h3><h4><a  class="btn btn-default" data-toggle="modal" data-target="#myodal"><i class="fa fa-plus"></i>Add</a></h4>
              </div>
            </div>
          
<!-- Modal form - open Programs -->
<div id="myodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="color: whitesmoke; background-color:#00CCFF">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title" >Add Open Programs</h3>
      </div>
              <form method="post" action="open.php" enctype="multipart/form-data">
      <div class="modal-body">
	   <div>Program image
                <input type="file" class="form-control" name ="imagename" placeholder="Please input the program image" required="" />
              </div><br>
              <div>
                <input type="text" class="form-control" name ="opname" placeholder="Open program name (not more than 94 characters)" required="" maxlength="94" />
              </div><br>
               <div>
                <input type="text" class="form-control" name ="subname" placeholder="Sub-program Name" required="" />
              </div><br>
        <div>
               <input required="" placeholder="Program's venue" name="objective" class="form-control">
              </div><br>
        <div>
                <input required="" placeholder="Fees" name="content" class="form-control">
              </div><br>
              <div>
                <input type="text" class="form-control" name ="forwhom" placeholder="For Whom (optional)" />
              </div><br>
        <div>
                <input type="text" class="form-control" name ="duration" placeholder="Duration eg,3-4 days" />
				<input type="hidden" class="form-control" name="name" placeholder="" required="" value="<?php echo $login_name;?>" />
              </div><br>
       
                <div>
                    <button class="btn btn-success submit " name ="submit" style="float: left;background-color:#00CCFF">Add</button>
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
 <!-- /end of Modal form - Add open programs -->

  <div class="col-md-10">

          <div class="row">
            <h3><?php
  $result0 = mysql_query(" SELECT COUNT(classname) FROM classprogram");
  $row0 = mysql_fetch_array($result0);  
  echo $count0= $row0[0];
?> Master classes and other programs</h3><h4><a  class="btn btn-default" data-toggle="modal" data-target="#myMdal"><i class="fa fa-plus"></i>Add</a></h4>
              </div>
            </div>

            <div id="myMdal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="color: whitesmoke; background-color:#00CCFF">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title" >Add Master Classes And Other Programs</h3>
      </div>
              <form method="post" action="class.php" enctype="multipart/form-data">
      <div class="modal-body">
	  <div>Program image
                <input type="file" class="form-control" name ="imagename" placeholder="Please input the program image" required="" />
              </div><br>
              <div>
                <input type="text" class="form-control" name ="classname" placeholder="Master Classes And Other Program Name (not more than 94 characters)" maxlength="94" required="" />
              </div><br>
               <div>
                <input type="text" class="form-control" name ="subname" placeholder="Sub-program Name" required="" />
              </div><br>
        <div>
                <textarea id="textarea" required="" placeholder="Program Overview" name="overview" class="form-control col-md-7 col-xs-12"></textarea>
              </div><br>
        <div>
                <textarea id="textarea" required="" placeholder="Program Concept" name="concept" class="form-control col-md-7 col-xs-12"></textarea>
              </div><br>
         <div>
                <textarea id="textarea" required="" placeholder="Objectives" name="objective" class="form-control col-md-7 col-xs-12"></textarea>
              </div><br>
			   <div>
                <textarea id="editor" required="" placeholder="Program content" name="content" class="form-control col-md-7 col-xs-12"></textarea>
              </div><br>
              <div>
                <input type="text" class="form-control" name ="forwhom" placeholder="For Whom" />
              </div><br>
        <div>
                <input type="text" class="form-control" name ="duration" placeholder="Duration eg,3-4 days" />
             <input type="hidden" value="<?php echo $login_name;?>" class="form-control" name="name" placeholder="" />
              </div><br>
        
                <div>
                    <button class="btn btn-success submit " name ="submit" style="float: left;background-color:#00CCFF">Add</button>
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
 <!-- /end of Modal form - Add master classes programs -->

 <div class="col-md-10">

          <div class="row">
            <h3><?php
  $result0 = mysql_query(" SELECT COUNT(onename) FROM onedayprogram");
  $row0 = mysql_fetch_array($result0);  
  echo $count0= $row0[0];
?> One-Day high impact program</h3><h4><a  class="btn btn-default" data-toggle="modal" data-target="#mymod"><i class="fa fa-plus"></i>Add</a></h4>
              </div>
            </div>
			
<!-- Modal form - high impact Programs -->
<div id="mymod" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="color: whitesmoke; background-color:#00CCFF">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title" >Add One-Day High Impact Seminar</h3>
      </div>
              <form method="post" action="oneday.php" enctype="multipart/form-data">
      <div class="modal-body">
	   <div>Program image
                <input type="file" class="form-control" name ="imagename" placeholder="Please input the program image" required="" />
              </div><br>
              <div>
                <input type="text" class="form-control" name ="onename" placeholder="One-Day High Program Name (not more than 94 characters)" required="" maxlength="94" />
              </div><br>
               <div>
                <input type="text" class="form-control" name ="subname" placeholder="Sub-program Name" required="" />
              </div><br>
			  <div>
                <input type="text" class="form-control" name ="coverage" placeholder="Program coverage" required="" />
              </div><br>
        <div>
                <textarea id="textarea" required="" placeholder="Program content" name="content" class="form-control col-md-7 col-xs-12"></textarea>
				<input type="hidden" class="form-control" name ="name" placeholder="" value="<?php echo $login_name;?> " required="" />
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
 <!-- /end of Modal form - Add master classes programs -->
 
 


</div>
</div>
	  				

	  			

	  		<!--  Page content -->
	

    <?php include 'inc_footer.php' ;?>

    <script>
  initSample();
</script>

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