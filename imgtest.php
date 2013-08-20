<?php
require 'class.phpmailer.php';

$string = wordwrap($_REQUEST["body"], 50, "\n", false);
echo $string;

$width  = imagefontwidth($font) * strlen($string);
$height = imagefontheight($font);

$image = imagecreatetruecolor (800, 1000);
$white = imagecolorallocate ($image,255,255,255);
$black = imagecolorallocate ($image,0,0,0);
imagefill($image,0,0,$white);

$filename = preg_replace('/:/', '_', $_REQUEST['exp']);
$filename .= substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 7);
$filename .= ".png";

imagettftext ($image, 20, 0, 6, 21, $black, "arial.ttf", $string);

//imagestring ($image,$font,0,0,$string,$black);

imagepng ($image, $filename);
imagedestroy($image);

echo "Filename: $filename <br>";
$msg = "<img src='http://sdemail-kingshu.rhcloud.com/$filename'/>";

$mail = new PHPMailer();
$mail->SetFrom('kmedhi@purdue.edu', 'Krishnabh Medhi');
$mail->AddAddress($_REQUEST['to']);
$mail->Subject = $_REQUEST['sub'];
$mail->MsgHTML($msg);
$mail->AltBody = 'Please allow Display Images to view message';

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent to ".$_REQUEST['to'];
}
?>

