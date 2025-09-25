<?php


include 'config.php';

error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;

if($post)
{

$name = stripslashes($_POST['name']);
$email = trim($_POST['email']);
$phone = stripslashes($_POST['phone']);
$msg_subject = stripslashes($_POST['msg_subject']);
$message = stripslashes($_POST['message']);

$header = 'From: ' . $mail . " \r\n";
$header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
$header .= "Mime-Version: 1.0 \r\n";
$header .= "Content-Type: text/plain";

$error = '';



if(!$error)
{
$mail = mail(WEBMASTER_EMAIL, $msg_subject, $message,$header);


   
if($mail)
{ 
    header('Location: https://volante.com.ar/');


}

} 


}
?>


