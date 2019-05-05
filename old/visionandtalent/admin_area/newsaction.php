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
  header("location:login.php");
}
?>
 <?php
   if(isset($_POST['submit'])){
   $video_name = $_FILES['video']['name'];
   $video_type = $_FILES['video']['type'];
   $video_size = $_FILES['video']['size'];
   $video_tmp_name = $_FILES['video']['tmp_name'];
   $tittle = $_POST['tittle'];
   $aim = $_POST['aim'];
   mysql_query("INSERT INTO evideos (video,tittle,aim) VALUES('$video_name','$tittle','$aim')");

   if($video_name==''){
        echo "<script>alert('Please Select a video')</script>";
        exit();
   }
   else
    move_uploaded_file($video_tmp_name,"evideos/$video_name");
 
}
?>
<script language="javascript">;
alert("Video successfully uploaded");
window.location.href='newsandvideo.php';
</script>';