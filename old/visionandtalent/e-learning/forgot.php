<?php
include 'db_con.php';

$sel= mysql_query("select * from learning");
while($row=mysql_fetch_array($sel))
{
$mailid=$row['email'];
}
if(isset($_POST['submit'])){
	# code...
    //check if email exists

    $email_check = mysql_query("SELECT * FROM learning WHERE email='".$mailid."'");
    $count = mysql_num_rows($email_check);

    if ($count != 0) {
    	# code...generate new password

    	$random = rand(72891,   92729);
    	$new_password = $random;


    	//create a copy of the new password
    	$email_password = $new_password;


    	//encrypt the new password
    	$new_password=md5($new_password);


    	//update the db
    	mysql_query("UPDATE users SET password='". $new_password."' WHERE email='".$mailid."'");
    	//send the new password to users
    	$subject = "Login Information";
    	$message = "Your password has been changed to $email_password";
 
    	mail($mailid, $subject, $message, "From: VisionandTalent Administrator");
    	echo "Your new password has been emailed to you."; 
    }
    else {
    	echo "This email does not exist.";
    }
}
?>