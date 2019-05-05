<?php
include 'db_con.php';
if(isset($_GET['tk']))
{
 $id = $_GET['tk'];
 $sql_query="SELECT * FROM mtprogram WHERE id='$id'";
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
<html lang="en">
  <head>
    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title><?php echo $row['programname'];?> | vision &amp; Talent</title>

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- Favicon -->
    <?php include 'inc_favicon.php';?>

    <!-- CSS
    ================================================== -->       
        <!-- Bootstrap css file-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Font awesome css file-->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!-- Superslide css file-->
    <link rel="stylesheet" href="css/superslides.css">
    <!-- Slick slider css file -->
    <link href="css/slick.css" rel="stylesheet"> 
    <!-- Circle counter cdn css file -->
    <link rel='stylesheet prefetch' href="css/jpulgin.css">  
    <!-- smooth animate css file -->
    <link rel="stylesheet" href="css/animate.css"> 
    <!-- preloader -->
    <link rel="stylesheet" href="css/queryLoader.css" type="text/css" />
    <!-- gallery slider css -->
    <link type="text/css" media="all" rel="stylesheet" href="css/jquery.tosrus.all.css" />    
    <!-- Default Theme css file -->
    <link id="switcher" href="css/themes/default-theme.css" rel="stylesheet">
    <!-- Main structure css file -->
    <link href="style.css" rel="stylesheet">
   
    <!-- Google fonts -->
    <link href="css/googlefontweather.css" rel='stylesheet' type='text/css'>   
    <link href="css/verda.css" rel='stylesheet' type='text/css'>    
 

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<?php include 'inc_favicon.php';?>
  </head>
  <body> 

    <!-- SCROLL TOP BUTTON -->
    <a class="scrollToTop" href="#"></a>
    <!-- END SCROLL TOP BUTTON -->

    <?php include 'inc_header.php';?>
    <!--=========== BEGIN COURSE BANNER SECTION ================-->
    <section id="imgBanner">
      <h2><?php echo substr($row['programname'],0 ,24);?>...</h2>
    </section>
    <!--=========== END COURSE BANNER SECTION ================-->

    
    <!--=========== BEGIN COURSE BANNER SECTION ================-->
    <section id="courseArchive">
      <div class="container">
        <div class="row">
          <!-- start course content -->
          <div class="col-lg-8 col-md-8 col-sm-8">
            <div class="courseArchive_content" style="width:600px">              
             <div class="singlecourse_ferimg_area" style="width:600px">
             
                <div class="singlecourse_bottom">
                  <h2><?php echo $row['programname'];?></h2>
                  
                                  </div>
             </div>
             <div class="single_course_content" style="text-align:justify">
               <h2><?php echo $row['programname'];?></h2>
			   <b style="color:#FF0000">CONCEPT:</b><p><?php echo $row['concept'];?></p>
               <b style="color:#FF0000">CONTENT:</b><p><?php echo $row['content'];?></p>
			   <br><br>
			   <b style="color:#FF0000">OBJECTIVE:</b><p><?php echo $row['objective'];?></p>
               <table class="table table-striped course_table">
                <thead>
                  <tr>          
                    <th style="color:#FF0000">Course Title</th>
                    <th style="color:#FF0000">For whom</th>
                    
					<th style="color:#FF0000">Duration</th>
					
                  </tr>
                </thead>
                <tbody>
                  <tr>          
                    <td><?php echo $row['programname'];?></td>
                    <td><?php echo $row['forwhom'];?></td>
                    <td><?php echo $row['duration'];?></td>
				
                  </tr>
                </tbody>
              </table>
             </div>
             
            </div>
								
					
          </div>
          <!-- End course content -->

  <?php include  'inc_coursesidebar.php';?>
        </div>
      </div>
    </section>
	
 <!--=========== BEGIN OUR COURSES SECTION ================-->
    <section id="ourCourses"  style="background-color:#FFFFFF">
      <div class="container">
       <!-- Our courses titile -->
        <div class="row">
          <div class="col-lg-12 col-md-12"> 
            <div class="title_area">
              <h2 class="title_two">Courses on Mastermind program</h2>
              <span></span> 
            </div>
          </div>
        </div>
        <!-- End Our courses titile -->
        <!-- Start Our courses content -->
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="ourCourse_content">
              <ul class="course_nav">
			  <?php
$sel= mysql_query("select * from mtprogram ORDER BY id DESC");
while($row=mysql_fetch_array($sel))
{
?>   
                <li>
                  <div class="single_course">
                  
                    <div class="singCourse_content">
                    <h3 class="singCourse_title"><a href="mastermind_single?tk=<?php echo $row['id']; ?>"><?php echo $row['programname'];?></a></h3>
                     <p class="singCourse_price"><span>Mastermind Training Program</span></p>
                    <p><?php echo substr($row['content'], 0, 29);?>...</p>
                    </div>
                   
                  </div>
                </li>
                 <?php
				 }
				 ?>          
              </ul>
            </div>
          </div>
        </div>
        <!-- End Our courses content -->
      </div>
    </section>
    <!--=========== END OUR COURSES SECTION ================--> 
    <!--=========== END OUR COURSES SECTION ================--> 

  <?php include 'inc_footer.php' ?>

    <!-- Javascript Files
    ================================================== -->

     <!-- initialize jQuery Library -->
    <script src="js/ajax.jquery.min.js"></script>
    <!-- Preloader js file -->
    <script src="js/queryloader2.min.js" type="text/javascript"></script>
    <!-- For smooth animatin  -->
    <script src="js/wow.min.js"></script>  
    <!-- Bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- slick slider -->
    <script src="js/slick.min.js"></script>
    <!-- superslides slider -->
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.animate-enhanced.min.js"></script>
    <script src="js/jquery.superslides.min.js" type="text/javascript" charset="utf-8"></script>   
    <!-- for circle counter -->
    <script src="js/clickful.min.js"'></script>
    <!-- Gallery slider -->
    <script type="text/javascript" language="javascript" src="js/jquery.tosrus.min.all.js"></script>   
   
    <!-- Custom js-->
    <script src="js/custom.js"></script>

  </body>
</html>
