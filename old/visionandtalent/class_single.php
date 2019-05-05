<?php
include 'db_con.php';
if(isset($_GET['tk']))
{
 $subname = $_GET['tk'];
 $sql_query="SELECT * FROM classprogram WHERE subname='$subname'";
 $result_set=mysql_query($sql_query);
 $row=mysql_fetch_array($result_set);
}
function formatDate($date) {
    return date('d M Y', strtotime($date));
}
?>
<?php
 if ($subname != $row['subname']){
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
    <meta name="description" content="Discover your talent and potential"/>
<meta name="keywords" content="<?php echo $row['classname'];?>, <?php echo $row['subname'];?>, <?php echo $row['content'];?>, Masterclass program, Advance programs"/>
<meta name="robots" content="nofollow"/>
<meta http-equiv="author" content="Vision and Talent, Paul Uduk, visionandtalent.com"/>
<meta content="no-cache"/>
     <title><?php echo $row['classname'];?> | vision &amp; Talent</title>

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="Discover your talent, visio, mission, vision and talents offers no frill in house. Get started today with us"/>
    <meta property="og:title" content="Vision and Talent" />
    <meta property="og:description" content="Know your company's potential or as an individual. Start today with vision and talent to be well annexed with your buisness, customer relation, sales and management, employee relations etc. Request a free course" />
<meta name="keywords" content="vision, mission, nigeria best business teachers, grow your business, know your customers, how to be well known, make your company profile known"/>
<meta property="og:url" content="<?php echo $_SERVER['REQUEST_URI'] ;?>" />
<meta property="og:site_name" content="Hotjoepost" />
<meta name="og:type" content="article">
<meta name="og:image" content="http://visionandtalent.com/img/customer.JPG">
<meta name="og:site_name" content="BreakingNews">
<meta name="HandheldFriendly" content="True" />
<meta name="MobileOptimized" content="320" />
<meta name="robots" content="all" />
<meta property="article:section" content="Breaking news" />
<meta property="og:image:width" content="650" />
<meta property="og:image:height" content="350" />
<meta content="website" property="og:type">
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:description" content="Know your company's potential or as an individual. Start today with vision and talent to be well annexed with your buisness, customer relation, sales and management, employee relations etc. Request a free course" />
<meta name="twitter:title" content="Vision and Talent" />
<meta name="twitter:site" content="visionandtalent.com" />
<meta name="twitter:image" content="http://visionandtalent.com/img/customer.JPG" />
<meta name="twitter:creator" content="@visionandtalent" />
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
      <h2><?php echo substr($row['classname'], 0, 29);?></h2>
    </section>
    <!--=========== END COURSE BANNER SECTION ================-->

    
    <!--=========== BEGIN COURSE BANNER SECTION ================-->
    <section id="courseArchive">
      <div class="container">
        <div class="row">
          <!-- start course content -->
          <div class="col-lg-8 col-md-8 col-sm-8">
            <div class="courseArchive_content" style="width:600px">              
             <div class="singlecourse_ferimg_area" width="600" height="350">
                
                <div class="singlecourse_bottom">
                  <h2><?php echo $row['classname'];?></h2>
                  
                  
                </div>
             </div>
             <div class="single_course_content"  style="text-align:justify">
               <h4><b><?php echo $row['subname'];?></b></h4>
               <b style="color:#CC0000">OVERVIEW:</b><p><?php echo $row['overview'];?></p>
                <b style="color:#CC0000">CONCEPT:</b><p><?php echo $row['concept'];?></p>
                 <b style="color:#CC0000">OBJECTIVE:</b><p><?php echo $row['objective'];?></p>
               <b style="color:#CC0000">CONTENT:</b><p><?php echo $row['content'];?></p>

               <table class="table table-striped course_table">
                <thead>
                  <tr>          
                    <th style="color:#CC0000">Course Title</th>
                    <th style="color:#CC0000">For whom</th>
                    
					<th style="color:#CC0000">Duration</th>
					
                  </tr>
                </thead>
                <tbody>
                  <tr>          
                    <td><?php echo $row['classname'];?></td>
                    <td><?php echo $row['forwhom'];?></td
                    ><td><?php echo $row['duration'];?></td>
				
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
              <h2 class="title_two">Courses on MasterClass and Other Advance Program</h2>
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
$sel= mysql_query("select * from classprogram ORDER BY id DESC");
while($row=mysql_fetch_array($sel))
{
?>   
                <li>
                  <div class="single_course">
                    <div class="singCourse_content">
                    <h3 class="singCourse_title"><a href="class_single?tk=<?php echo $row['subname']; ?>"><?php echo $row['subname'];?></a></h3>
                     <p class="singCourse_price"><span>Masterclass Program</span></p>
                    <p><?php echo substr($row['content'], 0, 40);?>...</p>
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
