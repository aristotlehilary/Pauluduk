 <?php
include("db_con.php");
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
  header("location:../404.php");
}
?>
 <?php
                    if(isset($_POST['submit'])){
   $image_name = $_FILES['imagename']['name'];
   $image_type = $_FILES['imagename']['type'];
   $image_size = $_FILES['imagename']['size'];
   $image_tmp_name = $_FILES['imagename']['tmp_name'];
   $programname = $_POST['programname'];
   $programsubname = $_POST['programsubname'];
   $concept = $_POST['concept'];
   $objective = $_POST['objective'];
   $content = $_POST['content'];
   $forwhom = $_POST['forwhom'];
   $duration = $_POST['duration'];
   $name = $_POST['name'];
   mysql_query("INSERT INTO mtprogram(id,imagename,programname,programsubname,concept,objective,content,forwhom,duration,name) VALUES('','$image_name','$programname','$programsubname','$concept','$objective','$content','$forwhom','$duration','$name')");

   if($image_name==''){
        echo "<script>alert('Please Select an Image')</script>";
        exit();
   }
   else
    move_uploaded_file($image_tmp_name,"mastermind_uploads/$image_name");
    header("location:javva.php");
}
?>