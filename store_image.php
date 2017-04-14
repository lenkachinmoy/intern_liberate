<?php
$host = 'localhost';
$user = 'root';
$pass = ' ';

mysql_connect($host, $user);

mysql_select_db('breakout');

$upload_image=$_FILES["myimage"]["name"];

//$folder="upload/";

move_uploaded_file($_FILES["myimage"]["tmp_name"], /*"$folder".*/$_FILES["myimage"]["name"]);

$original=/*"$folder".*/$_FILES["myimage"]["name"];
$edited=/*"$folder".*/"edited_".$_FILES["myimage"]["name"];
$file = "edited_".$_FILES["myimage"]["name"];

$file_edited=/*"$folder".*/"edited_".$_FILES["myimage"]["name"];

$shrink_edited=/*"$folder".*/"shrink_edited_".$_FILES["myimage"]["name"];
//edit
$filename = $original;

//copy
copy($filename,$edited);

//getting image height width

list($width, $height) = getimagesize($file);
$x = $width;
$y = $height;
$fontsize = 200;
$insert_text = 'A sample String';
$xPosition = (($x/2)-((imagefontwidth($fontsize)*strlen($insert_text))/2));
$yPosition = (($y/2)-(imagefontheight($fontsize)/2));
// Content type

$jpg_image = imagecreatefromjpeg($file );
$text_color = imagecolorallocate($jpg_image, 233, 14, 91);
imagestring($jpg_image, $fontsize, $xPosition, $yPosition,  $insert_text, $text_color);
header('Content-Type: image/jpeg');
// Output the image
imagejpeg($jpg_image, $file_edited);


/*  resizing */

// File and new size

$percent = 0.5;

// Content type
header('Content-Type: image/jpeg');

// Get new sizes
list($width, $height) = getimagesize($file_edited);
$newwidth = $width * $percent;
$newheight = $height * $percent;

// Load
$thumb = imagecreatetruecolor($newwidth, $newheight);
$source = imagecreatefromjpeg($file_edited);

// Resize
imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

// Output
imagejpeg($thumb);
imagejpeg($thumb, $shrink_edited);


$insert_path_q=sprintf("INSERT INTO intern_table VALUES('%s','%s')",$original,$shrink_edited);

$var=mysql_query($insert_path_q);
?>