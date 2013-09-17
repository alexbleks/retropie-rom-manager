<?php
/*

	RetroBox ROM Manager v0.1
	Copyright (c) 2013 Alexander Blohmé <alexander.blohme@gmail.com>

	This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.


*/

error_reporting(E_ALL);
ini_set('display_errors','On');
ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');


function resizeToVariable($sourceImage,$newHeight,$newWidth,$destImage)
{
    list($width,$height) = getimagesize($sourceImage);
    $img = imagecreatefromjpeg($sourceImage);
    // create a new temporary image
    $tmp_img = imagecreatetruecolor($newHeight,$newWidth);
    // copy and resize old image into new image
    imagecopyresized( $tmp_img, $img, 0, 0, 0, 0,$newHeight,$newWidth, $width, $height );
    // use output buffering to capture outputted image stream
    ob_start();
    imagejpeg($tmp_img);
    $i = ob_get_clean(); 
    // Save file
    $fp = fopen ($destImage,'w');
    fwrite ($fp, $i);
    fclose ($fp);
}

function resize_image_max($image,$max_width,$max_height) {
   $ImageSize = getimagesize($image);
   $ImageWidth =$ImageSize[0];
   $ImageHeight = $ImageSize[1];

   echo $image . " inside resize func.<br>";
   //    $w = imagesx($image); //current width
   // $h = imagesy($image); //current height

    $w = $ImageSize[0]; //current width
    $h = $ImageSize[1]; //current height


    if ((!$w) || (!$h)) { $GLOBALS['errors'][] = 'Image couldn\'t be resized because it wasn\'t a valid image.'; return false; }

    if (($w <= $max_width) && ($h <= $max_height)) { echo "no resize needed"; return $image; } //no resizing needed
    
    //try max width first...
  /*  $ratio = $max_width / $w;
    $new_w = $max_width;
    $new_h = $h * $ratio;
    
    //if that didn't work
    if ($new_h > $max_height) {
        $ratio = $max_height / $h;
        $new_h = $max_height;
        $new_w = $w * $ratio;
    }*/
        $orgImage = imagecreatefromjpeg($image);

    $new_image = imagecreatetruecolor ($max_width, $max_height);
  //  imagecopyresampled($new_image,$orgImage, 0, 0, 0, 0, $new_w, $new_h, $w, $h);
      imagecopyresampled($new_image,$orgImage, 0, 0, 0, 0, $max_width, $max_height, $w, $h);
    
    return $new_image;
}


$md5hash = $_GET['hash'];

$GameTitle = "";
$doChanges = false;
class MyDB extends SQLite3
{
	function __construct()
	{
		$this->open('file.db');
	}
	function __destruct()
	{
		$this->close();
	}
}
	$db2 = new MyDB();

if (isset($_POST["update_nes_game"]))
{	
	

	//echo "Update nes game";
			$exec = "UPDATE games SET image_file='" . $_POST['imagefile'] . "',game_title=\"".$_POST['gametitle']."\",desc=\"".$_POST['desc']."\",release_date=\"".$_POST['releasedate']."\",developer=\"".$_POST['developer']."\",publisher=\"".$_POST['publisher']."\",players=\"".$_POST['players']."\",genre=\"".$_POST['genre']."\",console=\"".$_POST['console']."\"         WHERE md5='". $md5hash ."'";
		$go = $db2->exec($exec);
		$doChanges = true;

}


if (isset($_POST["uploadImage"]))
{
	echo "Upload clicked!";
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
  /*  echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";*/

    if (file_exists("GAMEBOY_COLOR/roms/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "GAMEBOY_COLOR/roms/" . $_FILES["file"]["name"]);
	
		$exec = "UPDATE games SET image_file='" . $_FILES["file"]["name"] . "' WHERE md5='". $md5hash ."'";
		$go = $db2->exec($exec);
		$doChanges = true;
		
		
		// resize Image
		$ImageFileName = "GAMEBOY_COLOR/roms/".$_FILES["file"]["name"];
		$ImageSize = getimagesize($ImageFileName);
		$ImageWidth =$ImageSize[0];
		$ImageHeight = $ImageSize[1];
	
		//        height = int((float(img.size[1])*float(maxWidth/float(img.size[0]))))
       // img.resize((maxWidth,height), Image.ANTIALIAS).save(output)
		$newWidth = 500;	// 400 for NES, 500 for SNES & GB covers
		
		$newHeight =  (((float)$ImageHeight*(float)$newWidth/(float)$ImageWidth));
		
		//resize_image_max($ImageFileName,$newWidth,$newHeight);
		resizeToVariable($ImageFileName,$newWidth, $newHeight, $ImageFileName);
		
		
      }
    }
  }
else
  {
  echo "Invalid file";
  }
}



$db = new MyDB();
$query = "SELECT * FROM games WHERE md5='".$md5hash."'";
$result = $db->query($query);
$counter = 0;
while($row = $result->fetchArray())
{
	$counter++;
	$id = $row[0];
	$GameTitle = $row[1];
	$ImageFile = $row[2];
	$Desc = $row[4];
	$ReleaseDate = $row[3];
	$Developer = $row[6];
	$Publisher = $row[7];
	$Genre = $row[8];
	$Players = $row[10];
	$Console = $row[11];

}

if ($counter == 0)
{
	$Console = "Game Boy Color";
	// it does not exist in DB, create it!
	$exec = 'INSERT INTO games (game_title,md5,console) VALUES ("No Title Yet","'. $md5hash .'", "Game Boy Color")';					
	$go = $db->exec($exec);

	
$GameTitle = "No Title Yet";
$ImageFile = "";
$Desc = "";
$ReleaseDate = "";
$Developer = "";
$Publisher = "";
$Players = "";
$Genre = "";


$query = "SELECT * FROM games WHERE md5='".$md5hash."'";
$result = $db->query($query);

while($row = $result->fetchArray())
{
	$id = $row[0];
}


}




?>
<html>
<head>
<style>
body 
{
background-size: 100% auto;
background-image:url('gameboy_color_bg.jpg');
background-repeat:no-repeat;
background-attachment:fixed;
}
</style>
</head>
<body bgcolor="black" text="black" link="red" vlink="darkred">
<form action="gameboy_color_view.php?hash=<?php echo $md5hash; ?>" method="post" enctype="multipart/form-data">
<title>RetroBox ROM Manager</title>
<h1><center><font color=white>Game Boy Color</font></center></h1><br>
<center><a href="nes.php">Nintendo Entertainment System</a> | <a href="snes.php">Super Nintendo</a> | <a href="gameboy.php">Game Boy</a> | <a href="gameboy_color.php">Game Boy Color</a> | <a href="rebuild_gamelist.php">Rebuild Gamelist</a> | <a href="settings.php">Settings</a>
<br></center>
<hr>
<center><h2><?php echo "<font color=white>" . $GameTitle . "</font>"; ?></h2></center>
<center><?php 
if ($doChanges == true)
{
echo "<font color=yellow>Game saved! Remember to Click 'Rebuild Gamelist.xml' to take effect on EmulationStation</font><br><br>"; 
}
 ?></center>
<?php

	$ImgPathFile = "/GAMEBOY_COLOR/roms/".$ImageFile;

?>

<center>

<table>
<tr>
<td>
<img src=<?php echo $ImgPathFile;  ?>></img>
</td>
<td>
<table bgcolor="#C9F549">
	<tr>
		<td>Game title</td>
		<td><input type="text" name="gametitle" value="<?php echo $GameTitle; ?>"></td>
	</tr>
	<tr>
		<td>Image file:</td>
		<td><input type="text" name="imagefile" value="<?php echo $ImageFile; ?>">
	
<input type="file" name="file" id="file">
<input type="submit" name="uploadImage" value="Upload Image">
</td>
	</tr>
	<tr>
		<td>Description:</td>
		<td><textarea name="desc" rows=10 cols=32><?php echo $Desc; ?></textarea></td>
	</tr>
	<tr>
		<td>Release Date:</td>
		<td><input type="text" name="releasedate" value="<?php echo $ReleaseDate; ?>"></td>
	</tr>
	<tr>
		<td>Developer:</td>
		<td><input type="text" name="developer" value="<?php echo $Developer; ?>"></td>
	</tr>
	<tr>
		<td>Publisher:</td>
		<td><input type="text" name="publisher" value="<?php echo $Publisher; ?>"></td>
	</tr>
	<tr>
		<td>Genre</td>
		<td><input type="text" name="genre" value="<?php echo $Genre; ?>"></td>
	</tr>
		<tr>
		<td>Players:</td>
		<td><input type="text" name="players" value="<?php echo $Players; ?>"></td>
	</tr>
		<tr>
		<td>Console</td>
		<td><input type="text" name="console" value="<?php echo $Console; ?>"></td>
	</tr>
		</tr>
		<tr>
		<td><input type="submit" name="update_nes_game" value="Update Game"></td>
	</tr>
</table>
</td>
</tr>
</table>

</center>
<br><br>
<?php

function GetMD5OfFile($file)
{
	$md5File = "/GAMEBOY_COLOR/roms/" . $file;
	//echo $md5File;
	return md5_file($md5File);
}

/*
if ($handle = opendir('/home/pi/NES/roms/')) {
    while (false !== ($file = readdir($handle)))
    {
        if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'nes')
        {
		printf("<li><a href=nes_view.php?hash=%s>%s</a>", GetMD5OfFile($file),$file);
            //$thelist .= '<li><a href="'.$file.'">'.$file.'</a></li>';
        }
    }
    closedir($handle);
}*/
?>
</form>
</html>
