<?php
include 'db_con.php';
if(isset($_POST['submit']))
{
	$videolink=$_POST['videolink'];
	$videoname=$_POST['videoname'];
	$videotags=$_POST['videotags'];
	$name=$_POST['name'];	
	
	$joseph= mysql_query("INSERT INTO videos(id,videolink,videoname,videotags,name) values('','$videolink','$videoname','$videotags','$name')");

	if($joseph)
	{
	     echo "";
		 }

		else {echo "<script>alert('UPLOAD UNSUCCESSFULL');
		 windows.location.href='';</script>";}
				
}

?>
<script language="javascript">;
alert("Video successfully uploaded");
window.location.href='newsandvideo.php';
</script>';

