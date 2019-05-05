<?php include 'inc_session.php';?>
<?php include 'db_con.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Your search result</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/uniform.css" />
<link rel="stylesheet" href="css/select2.css" />
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
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Your search results</a> </div>
    <h1>Your search results</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Data table</h5>
          </div>
          <?php
              //php search database
              $query = $_GET['query']; 
    // gets value sent over search form
     
    $min_length = 3;
    // you can set minimum length of the query if you want
     
    if(strlen($query) >= $min_length){ // if query length is more or equal minimum length then
         
        $query = htmlspecialchars($query); 
        // changes characters used in html to their equivalents, for example: < to &gt;
         
        $query = mysql_real_escape_string($query);
        // makes sure nobody uses SQL injection
         
        $raw_results = mysql_query("SELECT * FROM evideos
            WHERE (`tittle` LIKE '%".$query."%') OR (`aim` LIKE '%".$query."%') OR (`id` LIKE '%".$query."%')") or die(mysql_error());
             
        // * means articlesthat it selects all fields, you can also write: `id`, `title`, `text`
        //  is the name of our table
         
        // '%$query%' is what we're looking for, % means anything, for example if $query is Hello
        // it will match "hello", "Hello man", "gogohello", if you want exact match use `title`='$query'
        // or if you want to match just full word so "gogohello" is out use '% $query %' ...OR ... '$query %' ... OR ... '% $query'
         ?>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
              <tr>
           
                  <th>Tittle</th>
                  <th>What you will learn</th>
                 
                  <th>View</th>
                </tr>
              </thead>
              <tbody>
              <?php if(mysql_num_rows($raw_results) > 0){ // if one or more rows are returned do following
             
            while($results = mysql_fetch_array($raw_results)){
            // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop
                ?>
                <tr class="gradeU">
          
                  <td><?php echo $results['tittle'];?></td>
                 
                  <td><?php echo $results['aim'];?></td>
                  <td><a href="Videos?vid=<?php echo $results['id'];?>"><center>View</center></a></td>
                </tr>
                <?php
              }
                ?>
                <?php
              }
              else{ // if there is no matching rows do following
              ?>
                 <h2><p><?php echo "oops no result for $query" ;?></p></h2>
               <center><p style="color: red; font-size: 14px"><a href="index">Return to your dashboard if you wish</a></p></center>
                     <br></p>
              <?php
              }
              ?>
              <?php
               }
    else{ // if query length is less than minimum
        echo "Minimum length is ".$min_length;
    }

              ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'inc_footer.php';?>
<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.uniform.js"></script> 
<script src="js/select2.min.js"></script> 
<script src="js/jquery.dataTables.min.js"></script> 
<script src="js/matrix.js"></script> 
<script src="js/matrix.tables.js"></script>
</body>
</html>
