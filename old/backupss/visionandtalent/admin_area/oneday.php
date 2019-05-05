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
   $onename = $_POST['onename'];
   $subname = $_POST['subname'];
   $coverage = $_POST['coverage'];
   $content = $_POST['content'];
   $name = $_POST['name'];
   mysql_query("INSERT INTO onedayprogram(id,imagename,onename,subname,coverage,content,name) VALUES('','$image_name','$onename','$subname','$coverage','$content','$name')");

   if($image_name==''){
        echo "<script>alert('Please Select an Image')</script>";
        exit();
   }
   else
    move_uploaded_file($image_tmp_name,"oneday_uploads/$image_name");
    header("location:javav.php");
}
?>