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
     <title>One-Day Program</title>

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   
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
  </head>
  <body>

    <!-- SCROLL TOP BUTTON -->
    <a class="scrollToTop" href="#"></a>
    <!-- END SCROLL TOP BUTTON -->

    <?php include 'inc_header.php';?>

======= BEGIN COURSE BANNER SECTION ================-->
    <section id="imgBanner">
      <h2>One-day programs</h2>
    </section>
    <!--=========== END COURSE BANNER SECTION ================-->
    <div>
<object width="100%" height="800px" data="talent.pdf">
    This browser does not support PDFs. Please download the PDF to view it: <a href="talent.pdf">Download PDF</a>
</object>
     </div>
    <!--=========== END COURSE BANNER SECTION ================-->
        <!--=========== BEGIN WHY US SECTION ================-->

    
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