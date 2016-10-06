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

?>
<html>
<head>
<style>
body 
{
background-size: 100% auto;
background-image:url('snes_bg.jpeg');
background-repeat:no-repeat;
background-attachment:fixed;
}
</style>
</head>
<body bgcolor="black" text="white" link="red" vlink="darkred">
<title>RetroBox ROM Manager</title>
<h1><center>Game Boy</center></h1><br>
<?php include("menu.php"); ?>
<hr>
<?php
ini_set('display_errors','On');
error_reporting(E_ALL);


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

function GetMD5OfFile($file)
{
	$md5File = "/home/pi/SNES/roms/" . $file;
	//echo $md5File;
	return md5_file($md5File);
}


$MD5HASH;
function CheckIfExistInDB($filename)
{
	$db2 = new MyDB();

	$UploadedFileMD5 = md5_file("SNES/roms/".$filename);
	$MD5HASH = md5_file("SNES/roms/".$filename);
	$query = "SELECT * FROM games WHERE md5='".$UploadedFileMD5."'";
	$result = $db2->query($query);
	$counter = 0;
	while($row = $result->fetchArray())
	{	$counter++;
		
	}
	if ($counter == 0)
	{
			return false;
	}
	else
	{
		
		return true;
	}
	
	return true;
}
$CONTINUE = false;
$NEW_FILENAME;

	$allowedExts = array("smc");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);

	if ( in_array($extension, $allowedExts))
	{
	  	if ($_FILES["file"]["error"] > 0)
		{
			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		}
		else
		{
	  
				if (file_exists("SNES/roms/" . $_FILES["file"]["name"]))
				{
					echo $_FILES["file"]["name"] . " already exists. ";
				}
				else
				{
				
						move_uploaded_file($_FILES["file"]["tmp_name"],"SNES/roms/" . $_FILES["file"]["name"]);
						$CONTINUE = true;
						$NEW_FILENAME = $_FILES["file"]["name"];
					
					
					if (CheckIfExistInDB($_FILES["file"]["name"]) == false)
					{
							$NEW_FILENAME = $_FILES["file"]["name"];
				
						//// this game is NOT in the database, create a md5hash tag with game_title named as filename
							$db3 = new MyDB();
							//$exec = "SELECT * FROM games";
							$exec = 'INSERT INTO games (game_title,md5,console) VALUES ("' . $_FILES["file"]["name"] . '","'.GetMD5OfFile($_FILES["file"]["name"]).'","Super Nintendo (SNES)")';
					
				
							$go = $db3->exec($exec);
							printf("Game ROM copied and added to Database <a href=snes_view.php?hash=%s>Go HERE to edit game information</a>",GetMD5OfFile($NEW_FILENAME));
					}
					else
					{
						
						printf("Game ROM copied and created <a href=snes_view.php?hash=%s>Go HERE to edit game information</a>",GetMD5OfFile($NEW_FILENAME));
					}
				}	
		}	  
		
	}
	else
	{
	  	echo "Invalid file";
	}

?>
