<?php

header("Content-Type: image/jpeg");

$root = "gallerypics/";

$border = $root."border.png";
if(!empty($_GET['b'])) $border = $root."border2.png";
$centre = $root."pics/107.jpg";
$orientation = "l";
if(!empty($_GET['c'])) $centre = $root."pics/".$_GET['c'].".jpg";
if(!empty($_GET['o'])) $orientation = $_GET['o'];
$h = 300;
$w = 208;
if(!empty($_GET['h'])) $h = $_GET['h'];
if(!empty($_GET['w'])) $w = $_GET['w'];
if($orientation == "p"){
	$width = $w;
	$height = $h;
} else {
	$width = $h;
	$height = $w;
}

$ex = explode('.', $centre);
$idx = strtolower(end($ex));

list($width_orig, $height_orig) = getimagesize($border);
list($width_orig_c, $height_orig_c) = getimagesize($centre);
$image_p = imagecreatetruecolor($width, $height);
$image_b = imagecreatefrompng($border);
if($idx == "gif") $image_c = imagecreatefromgif($centre);
if($idx == "jpg" || $idx =="jpeg") $image_c = imagecreatefromjpeg($centre);

imagecopyresampled($image_p, $image_c, 0, 0, 0, 0, $width, $height, $width_orig_c, $height_orig_c);
imagecopyresampled($image_p, $image_b, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

imagejpeg($image_p, null, 100);	

?>