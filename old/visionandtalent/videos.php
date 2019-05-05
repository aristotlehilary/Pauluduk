<?php
include 'db_con.php';
function formatDate($date) {
    return date('d M Y', strtotime($date));
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title>Latest videos|Vision and Talent</title>

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
  </head>
  <body>

    <!-- SCROLL TOP BUTTON -->
    <a class="scrollToTop" href="#"></a>
    <!-- END SCROLL TOP BUTTON -->

    <?php include 'inc_header.php';?>

    <!--=========== BEGIN COURSE BANNER SECTION ================-->
    <section id="imgBanner">
      <h2>latest videos</h2>
    </section>
    <!--=========== END COURSE BANNER SECTION ================-->
    
    <!--=========== BEGIN COURSE BANNER SECTION ================-->
    <section id="courseArchive">
      <div class="container">
        <div class="row">
          <!-- start course content -->
          <div class="col-lg-8 col-md-8 col-sm-8">
            <div class="courseArchive_content">
              <!-- start blog archive  -->
              <div class="row">
			  
			    <?php
$sel= mysql_query("select * from videos ORDER BY id DESC");
while($row=mysql_fetch_array($sel))
{
?> 
			  
                <!-- start single blog archive -->
                <div class="col-lg-12 col-12 col-sm-12">
                  <div class="single_blog_archive wow fadeInUp" style="width:550px">
                    <div class="blogimg_container">
                     <iframe width="550" height="300" src="<?php echo $row['videolink'];?>" frameborder="0" allowfullscreen></iframe> 
                    </div>
                    <h4 class="blog_title" style="color:#CC0000"><a href="<?php echo $row['videolink'];?>"><b><?php echo $row['videoname'];?></b></a></h4>
                    <div class="blog_commentbox">
                      <p><i class="fa fa-clock-o"></i>Time: <?php echo formatDate($row['date']); ?></p>
                      <p><i class="fa fa-map-marker"></i>Location: Paul uduk on youtube</p>                      
                    </div>
                    <p class="blog_summary" style="color:#CC0000"><?php echo @$row['videotags'];?></p>
                    <a class="blog_readmore" href="<?php echo $row['videolink'];?>">Watch on youtube</a>
                  </div>
                </div>
				<?php
				}
				?>
				
                <!-- End single blog archive -->
                
              </div>
            </div>
          </div>
          <!-- End course content -->

            <?php include  'inc_coursesidebar.php';?>
            </div>
          </div>
          <!-- start course archive sidebar -->
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