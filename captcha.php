<?php

error_reporting(0);
session_start();

function getRandomWord($len = 6) {
    $word = array_merge(range('0', '9'), range('A', 'Z'));
    shuffle($word);
    return substr(implode($word), 0, $len);
}

$ranStr = getRandomWord();
$_SESSION["captchacode"] = $ranStr;
$height = 35; //CAPTCHA image height
$width = 150; //CAPTCHA image width
$font_size = 24;
$image_p = imagecreate($width, $height);
$graybg = imagecolorallocate($image_p, 245, 245, 245);
$textcolor = imagecolorallocate($image_p, 34, 34, 34);
imagefttext($image_p, $font_size, -2, 15, 26, $textcolor, 'font/font8.ttf', $ranStr);
imagepng($image_p);
