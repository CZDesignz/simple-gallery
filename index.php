<?php

/* ~~~~~~~~~~~~~~~~~ Changelog ~~~~~~~~~~~~~~~~~

# 01-09-2008

- Support for photo captions started to be written.
* Instructions added within the gallery.

# 05-07-2008

* Script now works as a multi album gallery through the use of folders

# 29-11-2006

* PHP Version Support fixed
	- This now looks at the version
	
# 27-11-2006

* Script written

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/* -- Stop Direct Viewing -- */ if(!isset($pg)) header("location: ./index.htm");

include_once("gallery-conf.pg");
$dir = $rootdir.$_GET['gal']."/";

/* ~~~~~~~~ Settings You Need To Change ~~~~~~~~ */

// Stylesheet Settings //

echo "<style type=\"text/css\">";
	/*body	{font-family: arial; font-size: 12px}*/
	echo "
	h1		{font-size: 18px; text-align: center;}
	#content a		{color: #6633cc; text-decoration: none;}
</style>";

// General Settings //

$pglim = 2; 	# Change this number to however many pics you want per page
$links = 0; 	# Change To 1 to just see links instead otherwise leave as 0 to see the pics and set to 2 the see the links with the pics
$title = "Powered By: Bobs Image Viewer"; # Specify Your Title Here

// Image Sizeing //

$width = 135; 	# Change to specify a value otherwise leave as 0 to see full size
$height = 135; 	# Change to specify a value otherwise leave as 0 to see full size

// Page Numbering //

$top = 1;		# Change this to 1 to turn on 0 for off
$bottom = 1;	# Change this to 1 to turn on 0 for off

// Table Settings //

# These settings will overide the general settings, sorri :D #

$table = 1; 	# Set to 1 to have a table otherwise leave as 0
$cols = 4;		# Define the amount of cols you want
$rows = 4;		# Define the amount of rows you want

/* ~~~~~~~~ Bobs quick written script ~~~~~~~~ */

switch($_GET['show']){

default:

# PHP Fix #

$php = phpversion();
$php = explode('.', $php, 2);

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

# Some Settings #

$n=0;
$ic=1;

# Get Folders #

while($img = $file[$n]){
$ex = explode('.', $img);
$idx = strtolower(end($ex));
if($idx != "" && $idx != "db"){
$fol[$ic] = $file[$n];
$max++;
$ic++;}
$n++;
}

if ($table !=0){
	$pglim = $ic+1;
}

$n=1;
$limit=1;
$max=0;

$n=$limit;

if($table != 0){
	?>
	<div align="center">Please click on an album below to view the pictures.</div><br />
	<table border="0" width="100%">
		<tr><td align="center"><?php
	$tcol=1;
	$trow=1;
}

while($img = $fol[$n] AND $n<($limit + $pglim)){
	$img=$fol[$n];

	$imglink=$root."pics/album/".$img."/".$n.".jpg";

	if($n <= ($limit + $pglim)){
		if($table != 0){
			echo "<a href=\"gallery/".$fol[$n].".htm\"><img src=\"$imglink\" border=\"0\"><br /><br />".str_replace("_", " ", $fol[$n])."</a><br /><br />";
			if($tcol == $cols){
				echo "</td></tr><tr><td align=\"center\">";
				$tcol = 1; $trow = $trow + 1;
			}else{
				echo "</td><td align=\"center\">";
				$tcol = $tcol + 1;
			}
		}else{
			echo "<a href=\"gallery/".$fol[$n].".htm\"><img src=\"$imglink\" border=\"0\"><br />".str_replace("_", " ", $fol[$n])."</a>";
		}
	}
$n++;
}
if($table != 0){echo "</table>";}


/*echo "Choose a set of pictures to view below:<br /><br /><ul>";
while($n < ($ic)){
	echo "<li><a href=\"gallery/".$fol[$n].".htm\"><img src=\"pics/album/".$fol[$n]."/".$n.".jpg\">".str_replace("_", " ", $fol[$n])."</a></li>";
	echo "pics/album/".$fol[$n];
	$n++;
}
echo "</ul>";*/

break;

case 'pics':

# PHP Fix #

$php = phpversion();
$php = explode('.', $php, 2);

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

break;}

# Hide Any Errors #

error_reporting(0);

# Work out viewing mode #

if ($table !=0){
	$pglim = $cols * $rows;
}

# Some Settings #

$n=0;
$ic=1;
$max=0;

# Grab Just The Images #

while($img = $file[$n]){
$ex = explode('.', $img);
$idx = strtolower(end($ex));
if($idx == "gif" || $idx == "jpg" || $idx =="jpeg" || $idx =="bmp"){
$pic[$ic] = $file[$n];
$max++;
$ic++;}
$n++;
}

$maxpg = $max/$pglim + 1;

# Top Page Numbers #

if($top != 0){
echo "<div align=\"center\"><br />Goto Page: <a href=\"".$root."gallery/".$_GET[gal].".htm\">1</a>";
if($maxpg >= 1){
$num=2;
while($num < $maxpg){
if(((($num-1)*$pglim)+1) == $_GET['num']){ echo "<b>"; }
echo " | <a href=\"".$root."gallery/".$_GET[gal]."-".(($num-1)*$pglim+1).".htm\">$num</a>";
if(((($num-1)*$pglim)+1) == $_GET['num']){ echo "</b>"; }
$num++;}}
echo"</div><br />";}

# Display Images #

if(empty($_GET['num'])){$limit=1; }else{ $limit = $_GET['num'];}
$n=$limit;
if($table != 0){
	?>
	<div align="center">Please click on a picture below to see it bigger.</div><br />
	<table border="0" width="100%">
		<tr><td align="center"><?php
	$tcol=1;
	$trow=1;
}
while($img = $pic[$n] AND $n<($limit + $pglim)){
$img=$_GET['gal']."/".$pic[$n];

$imglink=$root."pics/thumb/$img";

if($n <= ($limit + $pglim)){
if($links != 1){
	if($table != 0){
		echo "<a href=\"".$root."gallery/show/".$img."\" target=\"_newtab\"><img src=\"$imglink\" border=\"0\"><br />"; 
		if($links==2){ echo "$img<br />";}
		echo "</a>";
		if($tcol == $cols){
			echo "</td></tr><tr><td align=\"center\">";
			$tcol = 1; $trow = $trow + 1;
		}else{
			echo "</td><td align=\"center\">";
			$tcol = $tcol + 1;
		}}else{
			echo "<a href=\"".$root."gallery/show/".$img."\" target=\"_newtab\"><img src=\"$imglink\" border=\"0\" alt=\"\"><br />";
			if($links==2){ echo "$img<br />";}
			echo "</a>";
		}
	}
if($links == 1){echo "<a href=\"".$root."gallery/show/".$img."\">$img</a><br />";}
}
$n++;
}
if($table != 0){echo "</table>";}

# Bottom Page Numbers #

if($bottom != 0){
echo "<div align=\"center\"><br />Goto Page: <a href=\"".$root."gallery/".$_GET[gal].".htm\">1</a>";
if($maxpg >= 1){
$num=2;
while($num < $maxpg){
if(((($num-1)*$pglim)+1) == $_GET['num']){ echo "<b>"; }
echo " | <a href=\"".$root."gallery/".$_GET[gal]."-".(($num-1)*$pglim+1).".htm\">$num</a>";
if(((($num-1)*$pglim)+1) == $_GET['num']){ echo "</b>"; }
$num++;}}
echo"</div>";}

echo "
<body>
</html>";

break;

## Show Images in a new page ##

case 'img':

$size = 0;

$imgurl = $dir.$_GET['img'];

$cap = $_SERVER{'DOCUMENT_ROOT'}.$root.$rootdir.$_GET['img'].".txt";

	echo "<div align=\"center\"><img src=\"".$root."pics/$_GET[img]\" border=\"0\" alt=\"\"></div>";

if(@file_exists($cap)){
	echo "<br /><div align=\"center\">".@nl2br(@file_get_contents($cap))."</div>";
} else {
	echo "<br />";
}

	echo "<br /><div align=\"center\"><a href=\"../../".$_GET['gal']."/\">Back To Gallery</a></div>";

break;

}

?><div style="clear:both; height: 10px;"></div>