<!--?php
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
Name: $name <br/--><html><head></head><body>Country Code : $isd <br>
Phone No: $phone <br>
Email: $email <br>
Intrested In: $intrest <br>
UTM_SOURCE : $utm_source <br>
UTM_MEDIUM : $utm_medium <br>
UTM_CAMPIAGN : $utm_campaign <br>
FULL_URL : $fullurl<br>
Time: $ptime
EOF;
}

// new api starts
function _isCurl(){
return function_exists('curl_version');
}

$dataNew = array(
"UID" =&gt; "fourqt",
"PWD" =&gt; "wn9mxO76f34=",
"f" =&gt; "m",
"ISD" =&gt; $isd,
"con" =&gt; $phone,
"email" =&gt; $email,
"name" =&gt; $name,
"url" =&gt; "@url",
"src" =&gt; "Website",
"amob" =&gt; "",
"city" =&gt; "",
"location" =&gt; "",
"ch" =&gt; "MS",
"utm_source" =&gt; $utm_source,
"utm_medium" =&gt; $utm_medium,
"utm_camp" =&gt; $utm_campaign,
);

$parm = http_build_query($dataNew);
$curl = curl_init();

curl_setopt_array($curl, array(
CURLOPT_URL =&gt; 'https://vishalprojects07.realeasy.in/IVR_Inbound.aspx?' . $parm,
CURLOPT_RETURNTRANSFER =&gt; true,
CURLOPT_ENCODING =&gt; '',
CURLOPT_MAXREDIRS =&gt; 10,
CURLOPT_TIMEOUT =&gt; 0,
CURLOPT_FOLLOWLOCATION =&gt; true,
CURLOPT_HTTP_VERSION =&gt; CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST =&gt; 'GET',
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
CURLOPT_URL =&gt; 'https://www.google.com/recaptcha/api/siteverify',
CURLOPT_POST =&gt; true,
CURLOPT_POSTFIELDS =&gt; [
'secret' =&gt; '6LeLkE4pAAAAAKH92z0-XWctGtdxzylLT3nYUjXP',
'response' =&gt; $_POST["token"],
'remoteip' =&gt; $_SERVER['REMOTE_ADDR']
],
CURLOPT_RETURNTRANSFER =&gt; true
]);

$output = curl_exec($ch);
curl_close($ch);

$json = json_decode($output);

if ($json-&gt;success == false) {
echo "Captcha Verification Failed";
} else if ($json-&gt;success == true) {
$mail = new PHPMailer(true);

try {
// Server settings
$mail-&gt;SMTPDebug = SMTP::DEBUG_OFF;
$mail-&gt;isSMTP();
$mail-&gt;Host = 'smtp.office365.com';
$mail-&gt;SMTPAuth = true;
$mail-&gt;Username = 'sales@vishalprojects.com';
$mail-&gt;Password = 'Sa@12345';
$mail-&gt;SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail-&gt;Port = 587;

$mail-&gt;SetFrom("sales@vishalprojects.com", 'Vishal Sanjivini');

//$mail-&gt;AddAddress("server@grank.co.in", 'Vishal Sanjivini');

$mail-&gt;AddAddress('sales@vishalprojects.com', 'Vishal Sanjivini');
$mail-&gt;AddBCC('leadtest@grank.co.in', 'Vishal Sanjivini');
$mail-&gt;AddCC('sandip@grank.co.in', 'Vishal Sanjivini');
$mail-&gt;AddBCC('leadtest.grank@gmail.com', 'Vishal Sanjivini');


$mail-&gt;isHTML(true);    //Set email format to HTML
$mail-&gt;Subject = 'Lead From Vishal sanjivini Website';
$mail-&gt;Body = $data;

$filename = "live_data1.csv";
$f_data= "\r\n"."$name, $email, $phone, $intrest, $utm_source, $utm_medium,$utm_campaign,  $ptime, $isd";
$file = fopen($filename, "a");
fwrite($file,$f_data);
fclose($file);
} catch (Exception $e) {
echo "Message could not be sent 1.<a href="https://vishalprojects.com/vishal-sanjivini/4bhk-luxury-villas-in-tukkuguda-hyderabad">Go to Home Page</a>";
} catch (\Exception $e) {
echo "Message could not be sent 2.<a href="https://vishalprojects.com/vishal-sanjivini/4bhk-luxury-villas-in-tukkuguda-hyderabad/">Go to Home Page</a>";
}

if ($mail-&gt;Send()) {
header("Location:https://vishalprojects.com/vishal-sanjivini/4bhk-luxury-villas-in-tukkuguda-hyderabad/thankyou.php");
}
}
?&gt;</body></html>