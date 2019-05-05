<?php
if(isset($_POST['submit'])){
$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$to = "pauluduk@gmail.com";

mail($to, $subject, $message, "From: " . $name . $email);
echo "";
}
?>

<script language="javascript">;
alert("Your message has been sent");
window.location.href='contact';
</script>';