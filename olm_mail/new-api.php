<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set("Asia/Calcutta");

if ($_POST['lsubmit']." "==' ' || $_POST['lsubmit'] == 'submit') {
$name = $_POST['lname']." ";
$email = $_POST['lemail']." ";
$phone = $_POST['lphone']." ";
$intrest = $_POST['linterest']." ";
$utm_source = $_POST['utm_source']." ";
$utm_medium = $_POST['utm_medium']." ";
$utm_campaign = $_POST['utm_campaign']." ";
$fullurl = $_POST['fullurl']." ";
$ptime = date('d/m/Y H:i:s')." ";
$isd = $_POST['lccode']." ";

$data = <<<EOF
Name: $name <br/>
Country Code : $isd <br/>
Phone No: $phone <br/>
Email: $email <br/>
Intrested In: $intrest <br/>
UTM_SOURCE : $utm_source <br/>
UTM_MEDIUM : $utm_medium <br/>
UTM_CAMPIAGN : $utm_campaign <br/>
FULL_URL : $fullurl<br/>
Time: $ptime
EOF;
}

// new api starts
function _isCurl(){
return function_exists('curl_version');
}

$dataNew = array(
"UID" => "fourqt",
"PWD" => "wn9mxO76f34=",
"f" => "m",
"ISD" => $isd,
"con" => $phone,
"email" => $email,
"name" => $name,
"url" => "@url",
"src" => "Website",
"amob" => "",
"city" => "",
"location" => "",
"ch" => "MS",
"utm_source" => $utm_source,
"utm_medium" => $utm_medium,
"utm_camp" => $utm_campaign,
);

$parm = http_build_query($dataNew);
$curl = curl_init();

curl_setopt_array($curl, array(
CURLOPT_URL => 'https://vishalprojects07.realeasy.in/IVR_Inbound.aspx?' . $parm,
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);

// new api ends

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

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

$mail->SetFrom("sales@vishalprojects.com", 'Vishal Sanjivini');

//$mail->AddAddress("server@grank.co.in", 'Vishal Sanjivini');

$mail->AddAddress('sales@vishalprojects.com', 'Vishal Sanjivini');
$mail->AddBCC('leadtest@grank.co.in', 'Vishal Sanjivini');
$mail->AddCC('sandip@grank.co.in', 'Vishal Sanjivini');
$mail->AddBCC('leadtest.grank@gmail.com', 'Vishal Sanjivini');


$mail->isHTML(true);    //Set email format to HTML
$mail->Subject = 'Lead From Vishal sanjivini Website';
$mail->Body = $data;

$filename = "live_data1.csv";
$f_data= "\r\n"."$name, $email, $phone, $intrest, $utm_source, $utm_medium,$utm_campaign,  $ptime, $isd";
$file = fopen($filename, "a");
fwrite($file,$f_data);
fclose($file);
} catch (Exception $e) {
echo "Message could not be sent 1.<a href='https://vishalprojects.com/vishal-sanjivini/4bhk-luxury-villas-in-tukkuguda-hyderabad'>Go to Home Page</a>";
} catch (\Exception $e) {
echo "Message could not be sent 2.<a href='https://vishalprojects.com/vishal-sanjivini/4bhk-luxury-villas-in-tukkuguda-hyderabad/'>Go to Home Page</a>";
}

if ($mail->Send()) {
header("Location:https://vishalprojects.com/vishal-sanjivini/4bhk-luxury-villas-in-tukkuguda-hyderabad/thankyou.php");
}
}
?>