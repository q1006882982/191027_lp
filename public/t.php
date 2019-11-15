<?php
//$font = __DIR__.'/consola.ttf';
//var_dump($font);
//exit;


//width >= font_size*font_cout
$width = 300;
$height = 30;
$font_size = 20;
$font_count = 6;
$pre = 10;
$font_space = (int)(($width-2*$pre)/$font_count);
$font_y = $font_size+2;
$im = imagecreate($width, $height);
$bg= imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);
$font = __DIR__.'/consola.ttf';
$font_code_arr = range(1,6);
//var_dump($font_code_arr);
//exit;

foreach ($font_code_arr as $code_key=>$code) {
    imagettftext($im, $font_size, rand(0,90), ($code_key+1)*$font_space, $font_y, $black, $font, $code);
}

header('Content-Type: image/png');

imagepng($im);
imagedestroy($im);



