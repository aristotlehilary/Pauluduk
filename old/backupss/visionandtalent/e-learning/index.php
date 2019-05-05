<?php include 'inc_session.php';?>
<?php include 'db_con.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Dashboard | Vision and Talent</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/fullcalendar.css" />
<link rel="stylesheet" href="css/matrix-style.css" />
<link rel="stylesheet" href="css/matrix-media.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<?php include 'top_header.php';?>

<?php include 'inc_sidebar.php';?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
  </div>
  <div  class="quick-actions_homepage">
     <ul class="quick-actions">

         <?php
  $result0 = mysql_query(" SELECT COUNT(tittle) FROM evideos");
  $row0 = mysql_fetch_array($result0);  
 
?>
        <li class="bg_lb"> <a href="explore"> <i class="icon-dashboard"></i> <span class="label label-important"><?php  echo $count0= $row0[0];?></span>Explore </a> </li>
        <li class="bg_lo"> <a href="cert"> <i class="icon-th"></i> Your Certificates</a></li>
         <li class="bg_lb"> <a href="explore"> <i class="icon-dashboard"></i>New</a> </li>

      </ul>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      
     
       
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box widget-calendar">
          <div class="widget-title"> <span class="icon"><i class="icon-calendar"></i></span>
            <h5>Calendar</h5>
            <div class="buttons"> <a id="add-event" data-toggle="modal" href="#modal-add-event" class="btn btn-inverse btn-mini"><i class="icon-plus icon-white"></i> Add new event</a>
              <div class="modal hide" id="modal-add-event">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">×</button>
                  <h3>Add a new event</h3>
                </div>
                <div class="modal-body">
                  <p>Enter event name:</p>
                  <p>
                    <input id="event-name" type="text" />
                  </p>
                </div>
                <div class="modal-footer"> <a href="#" class="btn" data-dismiss="modal">Cancel</a> <a href="#" id="add-event-submit" class="btn btn-primary">Add event</a> </div>
              </div>
            </div>
          </div>
          <div class="widget-content">
            <div class="panel-left">
              <div id="fullcalendar"></div>
            </div>
            <div id="external-events" class="panel-right">
              <div class="panel-title">
                <h5>Drag Events to the calander</h5>
              </div>
              <div class="panel-content">
                <div class="external-event ui-draggable label label-inverse">My Event 1</div>
                <div class="external-event ui-draggable label label-inverse">My Event 2</div>
                <div class="external-event ui-draggable label label-inverse">My Event 3</div>
                <div class="external-event ui-draggable label label-inverse">My Event 4</div>
                <div class="external-event ui-draggable label label-inverse">My Event 5</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Footer-part-->
<?php include 'inc_footer.php';?>
<!--end-Footer-part-->
<script src="js/excanvas.min.js"></script> 
<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.flot.min.js"></script> 
<script src="js/jquery.flot.resize.min.js"></script> 
<script src="js/jquery.peity.min.js"></script> 
<script src="js/matrix.js"></script> 
<script src="js/fullcalendar.min.js"></script> 
<script src="js/matrix.calendar.js"></script> 
<script src="js/matrix.chat.js"></script> 
<script src="js/jquery.validate.js"></script> 
<script src="js/matrix.form_validation.js"></script> 
<script src="js/jquery.wizard.js"></script> 
<script src="js/jquery.uniform.js"></script> 
<script src="js/select2.min.js"></script> 
<script src="js/matrix.popover.js"></script> 
<script src="js/jquery.dataTables.min.js"></script> 
<script src="js/matrix.tables.js"></script> 
<script src="js/matrix.interface.js"></script> 
<script type="text/javascript">
  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:
  function goPage (newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {
      
          // if url is "-", it is this page -- reset the menu:
          if (newURL == "-" ) {
              resetMenu();            
          } 
          // else, send page to designated URL            
          else {  
            document.location.href = newURL;
          }
      }
  }

// resets the menu selection upon entry to this page:
function resetMenu() {
   document.gomenu.selector.selectedIndex = 2;
}
</script>
</body>
</html>
