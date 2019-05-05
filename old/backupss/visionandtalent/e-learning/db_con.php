<?php
$conn=mysql_connect('pauludukcom.ipagemysql.com','akadan1','damond123$');
if(!$conn)
{
	die("could not connect".mysql_error());
	}
else{mysql_select_db("db_vision",$conn);
}
?>