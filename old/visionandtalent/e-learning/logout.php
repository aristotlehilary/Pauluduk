<?php
include 'inc_session.php';
if(session_destroy()) // Destroying All Sessions
{
header("Location: login.php"); // Redirecting To Home Page
}
?>