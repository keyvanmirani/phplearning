<?php

// image create tools
$imageInfo = typeAndNamePicker($_GET);
$fontSize = 40;
$fontName = "font/IntelOneMono-Bold.ttf";
$imagePath = 'images/' . $imageInfo[2] . '/' . $imageInfo[0];
$image = createImage($imagePath, $imageInfo[2]);
$thumbPercent = 0.5;

// stamp needed
$width = 100;
$height = 70;
$stampText = "Agha Omid";
$textColor = imagecolorallocate($image, 255, 255, 255);

//function for split name and type
function typeAndNamePicker($get_url): array
{
    $pattern = '/^(.*)\.(webp|jpe?g|png)$/';
    $ImageInfo = [];
    preg_match($pattern, $get_url['image'], $ImageInfo);
    return $ImageInfo;
}

// function for creation images by type
function createImage($imagePath, $imageType)
{
    switch ($imageType) {
        case 'jpg':
        case 'jpeg':
            return imagecreatefromjpeg($imagePath);
            break;
        case 'png':
            return imagecreatefrompng($imagePath);
            break;
        case 'webp':
            return imagecreatefromwebp($imagePath);
            break;
        default:
            return false;
    }
}

// function for create Stamp
function createStamp($image, $stampText, $textColor, $fontSize, $offset_x, $offset_y)
{
    imagestring($image, $fontSize, $offset_x, $offset_y, $stampText, $textColor);
    return $image;
}

// function for create thumbnail
function createThumbnail($imagePath,$image, $thumbPercent)
{
    list($width, $height) = getimagesize($imagePath);
    $newWidth = $width * $thumbPercent;
    $newHeight = $height * $thumbPercent;
    $thumb = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresized($thumb, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    return $thumb;
}

if ($image !== false) {
    // Add the stamp
    $imageThumb = createThumbnail($imagePath,$image,$thumbPercent);
    $imageWithStamp = createStamp($image, $stampText, $textColor, $fontSize, 10, 10);

    // Save or output the modified image
    header('Content-type: ' . $imageInfo[2]);
    imagejpeg($imageWithStamp);
    imagejpeg($imageThumb, 'images/thumbnail/' . $imageInfo[1] . '-thumb.jpg');
    imagejpeg($imageWithStamp, 'images/stamped/' . $imageInfo[1] . '-stamped.jpg');
    imagedestroy($image);
    imagedestroy($imageWithStamp);
    imagedestroy($imageThumb);
} else {
    echo 'Failed to load image.';
}
