<?php
include 'db_con.php';
if(isset($_POST['email'])){
	
   $email = $_POST['email'];

   $sql = "SELECT * FROM special_project WHERE email='$email'";
    
   $res = mysql_query($sql);

    if($res->num_rows > 0){

       echo "This Email is already in use";
   }
      

}
?>