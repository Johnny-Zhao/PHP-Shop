<?php
$filename="des_big.jpg";
$src_image=imagecreatefromjpeg($filename);
list($src_w,$src_h)=getimagesize($filename);
//缩放比
$scale=0.5;
//ceil() 函数向上舍入为最接近的整数。
$dst_w=ceil($src_w*$scale);
$dst_h=ceil($src_h*$scale);
$dst_image=imagecreatetruecolor($dst_w,$dst_h);
imagecopyresampled($dst_image, $src_image, 0,0,0,0, $dst_w,$dst_h,$src_w, $src_h);
header("content-type:image/jpeg");
imagejpeg($dst_image,"uploads/".$filename);
imagedestroy($src_image);
imagedestroy($dst_image);

