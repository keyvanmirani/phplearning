<?php

// image create tools
$imageInfo = typeAndNamePicker($_GET);
$fontsize = 40;
$fontName = "font/IntelOneMono-Bold.ttf";
$colorText = imagecolorallocate($im, 0, 0, 0);
$imagePath = 'images/' . $imageInfo[2] . '/'. $imageInfo[0];

// image watermark needed
$string = "Agha Omid";

//function for split name and type
function typeAndNamePicker($get_url): array
{
    $pattern = '/^(.*)\.(webp|jpe?g|png)$/';
    $ImageInfo = [];
    preg_match($pattern, $get_url['image'], $ImageInfo);
    return $ImageInfo;
}


// function for creation images by type
function createImage($imagePath,$ImageType){
    header('content-type: image/' . $ImageType);
    switch ($ImageType){
        case 'jpg':
        case 'jpeg':
            $image = imagecreatefromjpeg($imagePath);
            imagejpeg($image);
            break;
        case 'png':
            $image = @imagecreatefrompng($imagePath);
            imagepng($image);
            break;
        case 'webp':
            $image = imagecreatefromwebp($imagePath);
            imagewebp($image);
            break;
        default :
            break;
            
        }
}

// function for watermark creator
function createWatermark($image, $fontName, $offset_x,$offset_y, $watermarkText, $textColor){

}

createImage($imagePath,$imageInfo[2]);
exit;

imagestring($im, $fontsize, $px, 9, $string, $orange);
imagepng($im);
imagedestroy($im);

function saveThumbnail($saveToDir, $imagePath, $imageName, $max_x, $max_y)
{
    preg_match("'^(.*)\.(gif|jpe?g|png)$'i", $imageName, $ext);
    switch (strtolower($ext[2])) {
        case 'jpg':
        case 'jpeg':
            $im   = imagecreatefromjpeg($imagePath);
            break;
        case 'gif':
            $im   = imagecreatefromgif($imagePath);
            break;
        case 'png':
            $im   = imagecreatefrompng($imagePath);
            break;
        default:
            $stop = true;
            break;
    }

    if (!isset($stop)) {
        $x = imagesx($im);
        $y = imagesy($im);

        if (($max_x / $max_y) < ($x / $y)) {
            $save = imagecreatetruecolor($x / ($x / $max_x), $y / ($x / $max_x));
        } else {
            $save = imagecreatetruecolor($x / ($y / $max_y), $y / ($y / $max_y));
        }
        imagecopyresized($save, $im, 0, 0, 0, 0, imagesx($save), imagesy($save), $x, $y);

        imagegif($save, "{$saveToDir}{$ext[1]}.gif");
        imagedestroy($im);
        imagedestroy($save);
    }
}
