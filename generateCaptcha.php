<?php
session_start();
header("Content-Type: image/jpeg");
function createRandomcode(int $number){
  $character = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $randomStr = '';
  for ($i=0; $i < $number ; $i++) { 
    $randomStr .= $character[random_int( 0, strlen($character)-1 )];
  }
  return $randomStr;
}
$generated = createRandomcode(5);
$key = $_GET['key'];
$_SESSION['verification_code'] = $_SESSION['verification_code'] ?? [];
$_SESSION['verification_code'][$key] = $generated;

$width = 200;
$height = 100;
$font = '/font/IntelOneMono-Bold.ttf';
$image = imagecreate($width,$height);
$background = imagecolorallocate($image, 0, 153, 0);
$text_color = imagecolorallocate($image, 255, 255, 255);
// imagestring($image,14,5, 5,$generated,$text_color);
imagettftext($image,30,20,50,80,$text_color,$font,$generated);
imageline($image,20, 70, 180, 20,$text_color);
imageline($image,30, 80, 180, 30,$text_color);

imagejpeg($image);
// header('Content-Disposition: attachment; filename="newcaptcha.jpeg"');
imagedestroy($image);