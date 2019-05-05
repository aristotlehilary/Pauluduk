<?php
include 'db_con.php';
function formatDate($date) {
    return date('d M Y', strtotime($date));
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title>vision&talent|Open program</title>

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->

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
      <h2>Open program</h2>
    </section>
    <!--=========== END COURSE BANNER SECTION ================-->
    
    <!--=========== BEGIN COURSE BANNER SECTION ================-->
    <section id="courseArchive">
      <div class="container">
        <div class="row">
          <!-- start course content -->
          <div class="col-lg-8 col-md-8 col-sm-8">
            <div class="courseArchive_content">
              <div class="row">
                <!-- start single course -->
				<?php
$sel= mysql_query("select * from openprogram ORDER BY id DESC");
while($row=mysql_fetch_array($sel))
{
?>             
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="single_course wow fadeInUp">
                    <div class="singCourse_imgarea">
                      <img src="admin_area/open_uploads/<?php echo $row['imagename'];?>" width="100%" height="250px" />
                      <div class="mask">                         
                        <a href="open_single?tk=<?php echo $row['id']; ?>" class="course_more" style="background-color:#CC0000">View Course</a>
                      </div>
                    </div>
                    <div class="singCourse_content" style="height:200px">
                    <h3 class="singCourse_title"><a href=""><a href="open_single?tk=<?php echo $row['id']; ?>"><?php echo $row['opname'];?></a></a></h3>
                    <p class="singCourse_price"><span>Open program</span> </p>
                    
                    </div>
                  
                  </div>
                </div>
				<?php
					}
					?>
                <!-- End single course -->
               
              </div>
              <!-- start previous & next button -->
           
            </div>
          </div>
          <!-- End course content -->

  <?php include  'inc_coursesidebar.php';?>
        </div>
      </div>        
      </div>
    </section>
    <!--=========== END COURSE BANNER SECTION ================-->
    
   <?php include 'inc_footer.php';?>

  
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