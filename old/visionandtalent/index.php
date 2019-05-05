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
  <meta name="description" content="Discover your talent, visio, mission, vision and talents offers no frill in house. Get started today with us"/>
<meta name="og:image" content="http://visionandtalent.com/img/customer.jpg">
    <meta property="og:title" content="Vision and Talent" />
    <meta property="og:description" content="Know your company's potential or as an individual. Start today with vision and talent to be well annexed with your buisness, customer relation, sales and management, employee relations etc. Request a free course" />
<meta name="keywords" content="vision, mission, nigeria best business teachers, grow your business, know your customers, how to be well known, make your company profile known"/>
<meta property="og:url" content="<?php echo $_SERVER['REQUEST_URI'] ;?>" />
<meta property="og:site_name" content="Hotjoepost" />
<meta name="og:type" content="article">
<meta name="og:site_name" content="visionandtalent">
<meta name="HandheldFriendly" content="True" />
<meta name="MobileOptimized" content="320" />
<meta name="robots" content="all" />
<meta property="article:section" content="Breaking news" />
<meta name="og:image" content="http://visionandtalent.com/img/customer.jpg">
<meta property="og:image:width" content="650" />
<meta property="og:image:height" content="350" />
<meta content="website" property="og:type">
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:description" content="Know your company's potential or as an individual. Start today with vision and talent to be well annexed with your buisness, customer relation, sales and management, employee relations etc. Request a free course" />
<meta name="twitter:title" content="Vision and Talent" />
<meta name="twitter:site" content="visionandtalent.com" />
<meta name="twitter:image" content="http://visionandtalent.com/img/customer.jpg" />
<meta name="twitter:creator" content="@visionandtalent" />
     <title>Knowledge Universe - Vision and Talent</title>

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

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="js/html.js"></script>
      <script src="js/respond.js"></script>
    <![endif]-->
 
  </head>
  <body>    

    <script type="text/javascript">

      $(document).ready(function() {
    setTimeout(function() {
      $('#myModal').modal(200);
    }, 4000000);
});
    </script>

    </head>

    <body>


                <div id="myModal" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header" style="background-color:black; color:white;">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <h3 class="modal-title" style="color:whitesmoke">Request For a Special Project Training</h2>

                </div>

                <div class="modal-body">

                    <p>Fill form</p>
                
                    <form method="post" action="special">

                        <div class="form-group">

                        </div>

                        <div class="form-group">
<div>
                <input type="text" class="form-control" name ="username" placeholder="Your Name" required="" />
              </div><br>
               <div>
                <input type="mail" class="form-control" name ="email" placeholder="Email address" required="" />
              </div><br>
        <div>
                <input type="text" required="" placeholder="Phone number eg 234..." name="phoneno" class="form-control">
              </div><br>
                      <div>
                <input type="text" required="" placeholder="Company name(optional)" name="company" class="form-control">
              </div><br>
			  <div>
			  <input list="d1" type="text" class="form-control" name="spname" placeholder="Select Special Project name(Click or double tap this field)" required="">
   <datalist id="d1">                                   
  <option>VOICE OF THE CUSTOMER </option>
  <option>MYSTERY SHOPPING</option>
  </datalist>
  </div><br>    
<p class="wow fadeInLeftBig animated" style="visibility: visible; animation-name: fadeInLeftBig;">View <a href="programs">other programs</a></p>
                        </div>
                <div class="modal-footer">
   <input type="submit" name="submit" style="float: left" value="Request" class="wpcf7-submit">
      </div>
                        

                    </form>
                </div>

            </div>

        </div>

    </div>
    <!-- SCROLL TOP BUTTON -->
    <a class="scrollToTop" href="#"></a>
    <!-- END SCROLL TOP BUTTON -->
<?php include 'inc_header.php';?>
    <!--=========== BEGIN SLIDER SECTION ================-->
    <section id="slider">
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="slider_area">
            <!-- Start super slider -->
            <div id="slides">
              <ul class="slides-container">                          
                <li>
                  <img src="files/Elegant.jpg" alt="img">
                   <div class="slider_caption">
                    <h2>Mastermind Training Program</h2>
                    <p>Full training on how to manage,lead and many more</p>
                    <a class="slider_btn" href="programs">Learn More</a>
                  </div>
                </li>
                <!-- Start single slider-->
                <li>
                  <img src="files/Close Watch.JPG"  alt="img">
                   <div class="slider_caption slider_right_caption">
                    <h2>Open Program</h2>
					
                    <p>This is a free open ground program,Fully interactive</p>
                    <a class="slider_btn" href="programs">Learn More</a>
                  </div>
                </li>
				
				<!-- Start single slider-->
                <li>
                  <img src="files/black-man-reading.jpg" alt="img">
                   <div class="slider_caption slider_right_caption">
                    <h2>One-day High Imapact Seminar</h2>
                    <p>One-Day high impact seminar for you</p>
                    <a class="slider_btn" href="programs">Learn More</a>
                  </div>
                </li>
				
                <!-- Start single slider-->
                <li>
                  <img src="files/disciples.jpg" alt="img">
                   <div class="slider_caption">
                    <h2>Check Out</h2>
                    <p>our learning inventory</p>
                    <a class="slider_btn" href="learning">Learn More</a>
                  </div>
                </li>
              </ul>
              <nav class="slides-navigation">
                <a href="#" class="next"></a>
                <a href="#" class="prev"></a>              </nav>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--=========== END SLIDER SECTION ================-->

    <!--=========== BEGIN ABOUT US SECTION ================-->
    <section id="aboutUs">
      <div class="container">
        <div class="row">
        <!-- Start about us area -->
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="aboutus_area wow fadeInLeft">
            <h2 class="titile">About Us</h2>
            <p style="text-align:justify">Vision & Talent is a wholly Nigerian company with the VISION to create “a world without ignorance”. Our MISSION is to help “organizations  embrace performance revolution.” We adhere to iron-clad VALUES underwritten with “honour”.</p> 

<p style="text-align:justify">The three-pronged tenets that have helped make us a visible brand gaining reputation for transforming organizations are our ExcellenceMantraTM, AgilityPrincipleTM and GoalFrameworkTM.</p>

<p style="text-align:justify">A seven-man Advisory Board oversees our affairs, and our multidisciplinary faculty of over 25 made up of HR, Leadership, Management, Process, Service, Sales, and Supply Chain experts has cumulative cognate experience of over 480 years.</p> 

          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
          <div class="newsfeed_area wow fadeInRight">
          

            <!-- Tab panes -->
            <div class="tab-content">
              <!-- Start news tab content -->
              <div class="tab-pane fade in active" align="center">
			                
                <img src="img/unique/Knowledge Universe.png" class="img-responsive" height="400" width="400" alt="knowledge">
               <h3 class=""><b>Knowledge Universe</b></h3><div class="title_area">
                    <h2 class="title_two"></h2>
                    <span></span> 
                  </div>
      </div>
      </div>
    </section>
    <!--=========== END ABOUT US SECTION ================--> 

    <!--=========== BEGIN WHY US SECTION ================-->
    <section id="whyUs">
      <!-- Start why us top -->
      <div class="row">        
        <div class="col-lg-12 col-sm-12">
          <div class="whyus_top">
            <div class="container">
              <!-- Why us top titile -->
              <div class="row">
                <div class="col-lg-12 col-md-12"> 
                  <div class="title_area">
                    <h2 class="title_two"> our mastermind programs</h2>
                    <span></span> 
                  </div>
                </div>
              </div>
              <!-- End Why us top titile -->
              <!-- Start Why us top content  -->
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3">
                  <div class="single_whyus_top wow fadeInUp">
                    <div class="whyus_icon" style="background-color:#CC0000">
                      <span class="fa fa-user" aria-hidden="true"></span>
                    </div>
                    <a href="mastermind"><h3>Supervisory</h3></a>
                    <p>Supervisory Management and Leadership</p>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                  <div class="single_whyus_top wow fadeInUp">
                    <div class="whyus_icon" style="background-color:#CC0000">
                      <span class="fa fa-male"></span>
                    </div>
                    <a href="softisues"><h3>Soft Issues</h3></a>
                    <p>Soft Issues in Management</p>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                  <div class="single_whyus_top wow fadeInUp">
                    <div class="whyus_icon" style="background-color:#CC0000">
                      <span class="fa fa-book"></span>
                    </div>
                    <a href="sales"><h3>Sales</h3></a>
                    <p>Sales and Marketing</p>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                  <div class="single_whyus_top wow fadeInUp">
                    <div class="whyus_icon" style="background-color:#CC0000">
                      <span class="fa fa-comments"></span>
                    </div>
                    <a href="class"><h3>Masterclass</h3></a>
                    <p>Master Classes and Other Advanced Programs</p>
                  </div>
                </div>
              </div>
              <!-- End Why us top content  -->
            </div>
          </div>
        </div>        
      </div>
      <!-- End why us top -->


    </section>
    <!--=========== END WHY US SECTION ================-->

    <!--=========== BEGIN OUR COURSES SECTION ================-->
    <section id="ourCourses"  style="background-color:#FFFFFF">
      <div class="container">
       <!-- Our courses titile -->
        <div class="row">
          <div class="col-lg-12 col-md-12"> 
            <div class="title_area">
              <h2 class="title_two">Recent Mastermind Programs</h2>
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
                 
                    <div class="singCourse_content" style="height:200px">
                    <h3 class="singCourse_title"><b><a href="mastermind_single?tk=<?php echo $row['id']; ?>"><?php echo $row['programname'];?></a></b></h3>
					<p><strong style="color: #FF0000">Mastermind Training Program</strong></p>
                    <p><?php echo substr($row['content'], 0, 29);?></p>
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

    

    <!--=========== BEGIN STUDENTS TESTIMONIAL SECTION ================-->
    <section id="studentsTestimonial">
      <div class="container">
       <!-- Our courses titile -->
        <div class="row">
          <div class="col-lg-12 col-md-12"> 
            <div class="title_area">
              <h2 class="title_two">OUR  VALUE PROPOSITION
</h2>
              <span></span> 
            </div>
          </div>
        </div>
        <!-- End Our courses titile -->

        <!-- Start Our courses content -->
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="studentsTestimonial_content">              
              <div class="row">
                <!-- start single student testimonial -->
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="single_stsTestimonial wow fadeInUp">
                    <div class="stsTestimonial_msgbox">
                      <p>EXECUTION 
ADVANTAGE
</p>
                    </div>
                     
 


                    <div class="stsTestimonial_content">
                      <p>Through our</p>                     
                      <span>AgilityPrincipleTM</span><br><br><br><br><br><br>
                      <p>we guarantee unrivalled speed to completion that delights .</p>
                    </div>
                  </div>
                </div>
                <!-- End single student testimonial -->
                <!-- start single student testimonial -->
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="single_stsTestimonial wow fadeInUp">
                    <div class="stsTestimonial_msgbox">
                      <p>EXCELLENCE 
ADVANTAGE
</p>
                    </div>
                    
                    <div class="stsTestimonial_content">
                      <p>Through our</p>                      
                      <span>ExcellenceMantraTM</span><br><br><br><br><br><br>
                      <p>we guarantee unparalleled
service that astounds.</p>
                    </div>
                  </div>
                </div>
                <!-- End single student testimonial -->
				


 


                <!-- start single student testimonial -->
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="single_stsTestimonial wow fadeInUp">
                    <div class="stsTestimonial_msgbox">
                      <p>GOAL  
ADVANTAGE
</p>
                    </div>
                   
                    <div class="stsTestimonial_content">
                      <p>Through our </p>                      
                      <span>GoalFrameworkTM</span><br><br><br><br><br><br>
                      <p>we guarantee
superb outcome at  cost that marvels.</p>
                    </div>
                  </div>
                </div>
                <!-- End single student testimonial -->
              </div>
            </div>
          </div>
        </div>
        <!-- End Our courses content -->
      </div>
    </section>
    <!--=========== END STUDENTS TESTIMONIAL SECTION ================-->    
    
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
