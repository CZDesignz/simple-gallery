<?php
ob_start();

#/* -- Stop Direct Viewing -- */ if(!isset($pg)) header("location: ./index.htm");

include_once("gallery-conf.pg");
$dir = $rootdir.$_GET['gal']."/";

$php = phpversion();
$php = explode('.', $php, 2);

// Set a maximum height and width
$width = $_GET['w'];
$height = $_GET['h'];

	switch($php[0]){

		case 4:
		case 3:
		
			$dh  = opendir($dir);
			while (false !== ($filename = readdir($dh))) {
			   $file[] = $filename;
			}

			break;

		default:
			
			$file = scandir($dir);
			
			break;
	}

	$ic=1;
	$n=1;

	while($img = $file[$n]){
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
	$n++;}


	$num = rand(1,count($imgs)-1);


#echo "$imgs[$num] - $type";
$url = $dir.$imgs[$num];

// Get new dimensions
list($width_orig, $height_orig) = getimagesize($url);

$ratio_orig = $width_orig/$height_orig;

if ($width/$height > $ratio_orig) {
   $width = $height*$ratio_orig;
} else {
   $height = $width/$ratio_orig;
}




switch($type[$num]){
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

ob_end_flush();
?>