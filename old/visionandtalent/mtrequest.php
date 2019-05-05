<?php
include 'db_con.php';
if(isset($_POST['submit']))
{
	$firstname=$_POST['firstname'];
	$lastname=$_POST['lastname'];
	$email=$_POST['email'];
	$phoneno=$_POST['phoneno'];	
	$programname=$_POST['programname'];

	$joseph= mysql_query("INSERT INTO mtrequest(id,firstname,lastname,email,phoneno,programname) values('','$firstname','$lastname','$email','$phoneno','$programname')");
$message= "Dear $firstname Your request was successful we will get back to you shortly with details and fee.";  
  mail($email,"Vision and Talent",$message,"From: Vision And Talent");    
  $mail_request = "learning@visionandtalent.com";
  $request_message = "$firstname $lastname requested for $programname. Email: $email, Phone Number: $phoneno";
  mail($mail_request, "New Request Notification", $request_message);
	if($joseph)
	{
	     echo "";
		 }

		else {echo "<script>alert('REQUEST UNSUCCESSFULL');
		 windows.location.href='mastermind';</script>";}
				
}

?>
<script language="javascript">;
alert("Request sucessful we will get back to you soon");
window.location.href='programs';
</script>';
