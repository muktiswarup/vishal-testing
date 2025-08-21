<?php

error_reporting(E_ALL);
ini_set('display_errors', 0);


require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


if($_POST['lname']!=NULL){ $name=$_POST['lname']; }
if($_POST['lemail']!=NULL){ $email=$_POST['lemail']; }
if($_POST['lccode']!=NULL){ $country=$_POST['lccode']; }
if($_POST['lphone']!=NULL){ $mobile=$_POST['lphone']; }
if($_POST['linterest']!=NULL){ $interest=$_POST['linterest']; }
if($_POST['utm_source']!=NULL){ $utm_source=$_POST['utm_source']; }
if($_POST['utm_campaign']!=NULL){ $utm_campaign=$_POST['utm_campaign']; }
if($_POST['fullurl']!=NULL){ $fullurl=$_POST['fullurl']; }


if ($email != NULL || $email != '' || $mobile != NULL || $mobile != '') {
date_default_timezone_set("Asia/Kolkata");

$subject = 'Enquiry for Vishal';

$message = "<!DOCTYPE HTML>
<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

<meta name='viewport' content='width=device-width; initial-scale=1.0; maximum-scale=1.0;'>
<title>Email Template</title>
<style type='text/css'>
body {
width: 100%;
background-color: #EFEFEF;
margin: 0;
padding: 0;
-webkit-font-smoothing: antialiased;
}
html {
width: 100%;
}
table {
font-size: 14px;
border: 0;
}
@media only screen and (max-width: 640px) {
.header-bg {
width: 440px !important;
height: 10px !important;
}
.main-header {
line-height: 28px !important;
}
.main-subheader {
line-height: 28px !important;
}
.container {
width: 440px !important;
}
.container-middle {
width: 420px !important;
}
.mainContent {
width: 400px !important;
}
.main-image {
width: 400px !important;
height: auto !important;
}
.banner {
width: 400px !important;
height: auto !important;
}
.section-item {
width: 400px !important;
}
.section-img {
width: 400px !important;
height: auto !important;
}
.prefooter-header {
padding: 0 10px !important;
line-height: 24px !important;
}
.prefooter-subheader {
padding: 0 10px !important;
line-height: 24px !important;
}
.top-bottom-bg {
width: 420px !important;
height: auto !important;
}
}

@media only screen and (max-width: 479px) {

.header-bg {
width: 280px !important;
height: 10px !important;
}
.top-header-left {
width: 260px !important;
text-align: center !important;
}
.top-header-right {
width: 260px !important;
}
.main-header {
line-height: 28px !important;
text-align: center !important;
}
.main-subheader {
line-height: 28px !important;
text-align: center !important;
}

.logo {
width: 260px !important;
}
.nav {
width: 260px !important;
}
.container {
width: 280px !important;
}
.container-middle {
width: 260px !important;
}
.mainContent {
width: 240px !important;
}
.main-image {
width: 240px !important;
height: auto !important;
}
.banner {
width: 240px !important;
height: auto !important;
}

.section-item {
width: 240px !important;
}
.section-img {
width: 240px !important;
height: auto !important;
}

.prefooter-header {
padding: 0 10px !important;
line-height: 28px !important;
}
.prefooter-subheader {
padding: 0 10px !important;
line-height: 28px !important;
}

.top-bottom-bg {
width: 260px !important;
height: auto !important;
}
}

</style>
</head>

<body leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td height='20'></td>
</tr>
<tr>
<td>
<table border='0' width='560' align='center' cellpadding='0' cellspacing='0' class='container-middle'>
<tr>
<td>
<table border='0' align='left' cellpadding='0' cellspacing='0' class='top-header-left'>
<tr>
<td align='center'>
<table border='0' cellpadding='0' cellspacing='0' class='date'>
<tr>
<td>
<img editable='true' mc:edit='icon1' style='display: block;' src='http://www.mrcreativedemo.com/verified_enquiry/img/grank-logo.png' alt='icon 1' />
</td>
</tr>
</table>
</td>
</tr>
</table>
<table border='0' align='right' cellpadding='0' cellspacing='0' class='top-header-right'>
<tr>
<td align='center'>
<table border='0' cellpadding='0' cellspacing='0' align='center' class='tel'>
<tr>
<td>
&nbsp;
</td>
<td>&nbsp;&nbsp;</td>
<td mc:edit='tel' style='color: #fefefe; font-size: 11px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;'>
<singleline>
<img editable='true' mc:edit='icon1' style='display: block;' src='http://www.mrcreativedemo.com/verified_enquiry/img/google-partner-logo.jpg' alt='icon 1' />
</singleline>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td height='10'></td>
</tr>
<tr>
<td width='100%' align='center' valign='top'>
<table border='0' width='600' cellpadding='0' cellspacing='0' align='center' class='container' bgcolor='ffffff'>
<tr>
<td><img style='display: block;' src='http://www.mrcreativedemo.com/verified_enquiry/img/top-header-bg.png' alt='' class='header-bg' /></td>
</tr>
<tr bgcolor='2780cb'>
<td height='5'></td>
</tr>
<tr bgcolor='2780cb'>
<td align='center'>
<table border='0' width='560' align='center' cellpadding='0' cellspacing='0' class='container-middle'>
<tr>
<td>
<table border='0' align='left' cellpadding='0' cellspacing='0' class='top-header-left'>
<tr>
<td align='center'>
<table border='0' cellpadding='0' cellspacing='0' class='date'>
<tr>
<td>
<img editable='true' mc:edit='icon1' width='13' style='display: block;' src='http://www.mrcreativedemo.com/verified_enquiry/img/icon-cal.png' alt='icon 1' />
</td>
<td>&nbsp;&nbsp;</td>
<td mc:edit='date' style='color: #fefefe; font-size: 11px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;'>
<singleline>
".date('d l')."
</singleline>
</td>
</tr>
</table>
</td>
</tr>
</table>
<table border='0' align='right' cellpadding='0' cellspacing='0' class='top-header-right'>
<tr>
<td align='center'>
<table border='0' cellpadding='0' cellspacing='0' align='center' class='tel'>
<tr>
<td>
&nbsp;
</td>
<td>&nbsp;&nbsp;</td>
<td mc:edit='tel' style='color: #fefefe; font-size: 11px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;'>
<singleline>
".date('F Y')."
</singleline>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
<tr bgcolor='2780cb'>
<td height='10'></td>
</tr>
</table>

<table width='600' border='0' cellpadding='0' cellspacing='0' align='center' class='container' bgcolor='ffffff'>
<tr bgcolor='ffffff'>
<td height='40'></td>
</tr>

</table>
</td>
</tr>
<tr bgcolor='ffffff'>
<td height='40' style='text-align:center;'> Enquiry for Vishal</td>
</tr>
<tr>
<td>
<table border='0' width='560' align='center' cellpadding='0' cellspacing='0' class='container-middle'>
<tr>
<td align='center'><img style='display: block;' width='560' height='auto' src='http://www.mrcreativedemo.com/verified_enquiry//img/top-rounded-bg.png' alt='' class='top-bottom-bg' /></td>
</tr>
<tr bgcolor='ffffff'>
<td height='7'></td>
</tr>
<tr bgcolor='ffffff'>
<td height='20'></td>
</tr>
<tr bgcolor='ffffff'>
<td>
<table width='528' border='0' align='center' cellpadding='0' cellspacing='0' class='mainContent'>

<tr>
<td mc:edit='subtitle1' class='main-subheader' style='color: #555; font-size: 13px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;'>
<multiline>
<i>Name : ".$name."</i>
</multiline>
</td>
</tr>

<tr>
<td height='20'></td>
</tr>
<tr>
<td mc:edit='subtitle1' class='main-subheader' style='color: #555; font-size: 13px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;'>
<multiline>
<i>Email: ".$email."</i>
</multiline>
</td>
</tr>

<tr>
<td height='20'></td>
</tr>

<tr>
<td mc:edit='subtitle1' class='main-subheader' style='color: #555; font-size: 13px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;'>
<multiline>
<i>Country Code: ".$country."</i>
</multiline>
</td>
</tr>

<tr>
<td height='20'></td>
</tr>

<tr>
<td mc:edit='subtitle1' class='main-subheader' style='color: #555; font-size: 13px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;'>
<multiline>
<i>Phone: ".$mobile."</i>
</multiline>
</td>
</tr>

<tr>
<td height='20'></td>
</tr>

<tr>
<td mc:edit='subtitle1' class='main-subheader' style='color: #555; font-size: 13px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;'>
<multiline>
<i>InterestedIn: ".$interest."</i>
</multiline>
</td>
</tr>

<tr>
<td height='20'></td>
</tr>


<tr>
<td mc:edit='subtitle1' class='main-subheader' style='color: #555; font-size: 13px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;'>
<multiline>
<i>UTM Source: ".$utm_source."</i>
</multiline>
</td>
</tr>

<tr>
<td height='20'></td>
</tr>

<tr>
<td mc:edit='subtitle1' class='main-subheader' style='color: #555; font-size: 13px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;'>
<multiline>
<i>UTM Campaign: ".$utm_campaign."</i>
</multiline>
</td>
</tr>

<tr>
<td height='20'></td>
</tr>

<tr>
<td mc:edit='subtitle1' class='main-subheader' style='color: #555; font-size: 13px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;'>
<multiline>
<i>Full URL: ".$fullurl."</i>
</multiline>
</td>
</tr>

<tr>
<td height='20'></td>
</tr>


</table>
</td>
</tr>
<tr bgcolor='ffffff'>
<td height='25'></td>
</tr>
<tr>
<td align='center'><img style='display: block;' width='560' height='auto' src='http://www.mrcreativedemo.com/verified_enquiry/img/bottom-rounded-bg.png' alt='' class='top-bottom-bg' /></td>
</tr>
<tr bgcolor='2780cb'>
<td height='14'></td>
</tr>
<tr bgcolor='2780cb'>
<td mc:edit='copy3' align='center' style='color: #eee; font-size: 10px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;'>
<multiline>
Copyright ".date('Y')." . All Rights Reserved
</multiline>
</td>
</tr>
<tr>
<td><img style='display: block;' src='http://www.mrcreativedemo.com/verified_enquiry/img/bottom-footer-bg.png' alt='' class='header-bg' /></td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td height='30'></td>
</tr>
</table>

</body>
</html>";


$response = $_POST["token"];
$ch = curl_init();

curl_setopt_array($ch, [
CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
CURLOPT_POST => true,
CURLOPT_POSTFIELDS => [
'secret' => '6LeLkE4pAAAAAKH92z0-XWctGtdxzylLT3nYUjXP',
'response' => $_POST["token"],
'remoteip' => $_SERVER['REMOTE_ADDR']
],
CURLOPT_RETURNTRANSFER => true
]);

$output = curl_exec($ch);
curl_close($ch);

$json = json_decode($output);

if ($json->success == false) {
echo "Captcha Verification Failed";
} else if ($json->success == true) {


$mail = new PHPMailer(true);

try {

// Server settings
$mail->SMTPDebug = SMTP::DEBUG_OFF;
$mail->isSMTP();
$mail->Host = 'smtp.office365.com';
$mail->SMTPAuth = true;
$mail->Username = 'sales@vishalprojects.com';
$mail->Password = 'Sa@12345';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;


$mail->Subject = $subject;
$mail->Body = $message;
$mail->SetFrom("sales@vishalprojects.com", 'Vishal Sanjivini');


$mail->AddAddress('server@grank.co.in', 'Vishal Sanjivini');

/*$mail->AddAddress('sales@vishalprojects.com', 'Vishal Sanjivini');
$mail->AddBCC('leadtest@grank.co.in', 'Vishal Sanjivini');
$mail->AddBCC('sandip@grank.co.in', 'Vishal Sanjivini');*/


$mail->isHTML(true);


if ($mail->send()) 
{
header('Location: https://vishalprojects.com/vishal-sanjivini/4bhk-luxury-villas-in-tukkuguda-hyderabad/thankyou.php?email=' .$email);
} 

else 
{
echo "Email Not Sent!!. Please try again";
}

} 

catch (Exception $e) 
{
echo "Email could not be sent. Error: " . $mail->ErrorInfo;
}

} 

else 
{
echo "Email or Phone Number is empty";
}

}



?>
