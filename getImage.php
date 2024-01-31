<?php
function typePicker($get_url)
{
    $pattern = '/[A-Za-z]+$/';
    $images_type = [];
    preg_match($pattern, $get_url['image'], $images_type);
    return $images_type[0];
}
function namePicker($get_url)
{
    $pattern = '/[^*]+\./';
    $images_names = [];
    preg_match($pattern, $get_url['image'], $images_names);
    return $images_names[0];
}

$image_type = typePicker($_GET);
$image_name = namePicker($_GET);
$font="font/IntelOneMono-Bold.ttf";
$fontsize= 40;
$imageFolder = 'images/' . $image_type . '/';
$images = "$imageFolder$image_name$image_type";
header('content-type: image/'.$image_type); 
$string = "Agha Omid";
$im     = @imagecreatefrompng($images);
$orange = imagecolorallocate($im, 0, 0, 0);
$px     = 24;
imagestring($im, $fontsize, $px, 9, $string, $orange);
imagepng($im);
imagedestroy($im);

