<?php
ob_start();
include_once("gallery-conf.pg");
$php = phpversion();
$php = explode('.', $php, 2);

// Set a maximum height and width
$width = $_GET['w'];
$height = $_GET['h'];
		
		$ic=1;
		
		$img = $_GET['img'];
		$ex = explode('.', $img);
		$idx = strtolower(end($ex));
		if($idx == "gif"){
			$imgs[$ic] = $file[$n];
			header("Content-Type: image/gif");
			$type[$ic]="gif";
		$ic++;}
		if($idx == "jpg" || $idx =="jpeg"){
			$imgs[$ic] = $file[$n];
			header("Content-Type: image/jpg");
			$type[$ic]="jpg";
		$ic++;}

$url = $rootdir.$img;

if(@file_exists($width."_".$height."/".$url)){
	file_get_contents($width."_".$height."/".$url);

} else {
	#echo "--55--".file_get_contents("pics/".$img)."--55--"; 	
}

// Get new dimensions
list($width_orig, $height_orig) = getimagesize($url);

if($width == 0) $width = $width_orig;
if($height == 0) $height = $height_orig;

$ratio_orig = $width_orig/$height_orig;

if ($width/$height > $ratio_orig) {
   $width = $height*$ratio_orig;
} else {
   $height = $width/$ratio_orig;
}

switch($type[1]){
case 'jpg': 
	
	// Resample
	$image_p = imagecreatetruecolor($width, $height);
	$image = imagecreatefromjpeg($url);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	
	// Output
	imagejpeg($image_p, null, 100);	
	break;
	
case 'gif':
	
	// Resample
	$image_p = imagecreatetruecolor($width, $height);
	$image = imagecreatefromgif($url);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	
	// Output
	imagegif($image_p, null, 100);
	
	break;
}
## Create the file ##


ob_end_flush();
?>