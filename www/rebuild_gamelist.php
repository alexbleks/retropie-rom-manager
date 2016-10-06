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
ini_set('max_execution_time', 300); 


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
	$md5File = $file;
	//echo $md5File;
	return md5_file($md5File);
}

$db2 = new MyDB();
$counter = 0;

if (isset($_POST['gen_nes']))
{

	//	echo "Gen nes";x
	
	$fp = fopen("/home/pi/NES/roms/gamelist.xml", 'w');
	fwrite($fp, "<gameList>\n");
		
	if ($handle = opendir('/home/pi/NES/roms/')) {
	    while (false !== ($file = readdir($handle)))
	    {
	        if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'nes')
	        {
		        $md5hash = GetMD5OfFile("NES/roms/" . $file);
				$query = "SELECT * FROM games WHERE md5='".$md5hash."'";
				$result = $db2->query($query);
				while($row = $result->fetchArray())
				{

					fwrite($fp, "<game>\n");
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
					fwrite($fp, "<path>/home/pi/NES/roms/".$file."</path>\n");
					fwrite($fp, "<name>".$GameTitle."</name>\n");
					fwrite($fp, "<desc>".$Desc."</desc>\n");
					fwrite($fp, "<image>/home/pi/NES/roms/".$ImageFile."</image>\n");					
					fwrite($fp, "</game>\n");
					$counter++;
							
				}
		
	        }
	    }
	    closedir($handle);
	}

	fwrite($fp, "</gameList>\n");
	fclose($fp);
}




if (isset($_POST['gen_n64']))
{

	//	echo "Gen nes";x
	
	$fp = fopen("/home/pi/N64/roms/gamelist.xml", 'w');
	fwrite($fp, "<gameList>\n");
		
	if ($handle = opendir('/home/pi/N64/roms/')) {
	    while (false !== ($file = readdir($handle)))
	    {
	        if ($file != "." && $file != ".." &&  (  strtolower(substr($file, strrpos($file, '.') + 1)) == 'z64' || strtolower(substr($file, strrpos($file, '.') + 1) == 'v64' ) || strtolower(substr($file, strrpos($file, '.') + 1)) == 'n64' ))
	        {
		        $md5hash = GetMD5OfFile("N64/roms/" . $file);
				$query = "SELECT * FROM games WHERE md5='".$md5hash."'";
				$result = $db2->query($query);
				while($row = $result->fetchArray())
				{

					fwrite($fp, "<game>\n");
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
					fwrite($fp, "<path>/home/pi/N64/roms/".$file."</path>\n");
					fwrite($fp, "<name>".$GameTitle."</name>\n");
					fwrite($fp, "<desc>".$Desc."</desc>\n");
					fwrite($fp, "<image>/home/pi/N64/roms/".$ImageFile."</image>\n");					
					fwrite($fp, "</game>\n");
					$counter++;
							
				}
		
	        }
	    }
	    closedir($handle);
	}

	fwrite($fp, "</gameList>\n");
	fclose($fp);
}


if (isset($_POST['gen_snes']))
{

	$fp = fopen("/home/pi/SNES/roms/gamelist.xml", 'w');
	fwrite($fp, "<gameList>\n");
		
	if ($handle = opendir('/home/pi/SNES/roms/')) {
	    while (false !== ($file = readdir($handle)))
	    {
	        if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'smc')
	        {
		        $md5hash = GetMD5OfFile("SNES/roms/" . $file);
				$query = "SELECT * FROM games WHERE md5='".$md5hash."'";
				$result = $db2->query($query);
				while($row = $result->fetchArray())
				{

					fwrite($fp, "<game>\n");
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
					fwrite($fp, "<path>/home/pi/SNES/roms/".$file."</path>\n");
					fwrite($fp, "<name>".$GameTitle."</name>\n");
					fwrite($fp, "<desc>".$Desc."</desc>\n");
					fwrite($fp, "<image>/home/pi/SNES/roms/".$ImageFile."</image>\n");					
					fwrite($fp, "</game>\n");
					$counter++;
							
				}
		
	        }
	    }
	    closedir($handle);
	}

	fwrite($fp, "</gameList>\n");
	fclose($fp);
}


if (isset($_POST['gen_gb']))
{

	//	echo "Gen nes";x
	
	$fp = fopen("/home/pi/GAMEBOY/roms/gamelist.xml", 'w');
	fwrite($fp, "<gameList>\n");
		
	if ($handle = opendir('/home/pi/GAMEBOY/roms/')) {
	    while (false !== ($file = readdir($handle)))
	    {
	        if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'gb')
	        {
		        $md5hash = GetMD5OfFile("GAMEBOY/roms/".$file);
				$query = "SELECT * FROM games WHERE md5='".$md5hash."'";
				$result = $db2->query($query);
				while($row = $result->fetchArray())
				{

					fwrite($fp, "<game>\n");
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
					fwrite($fp, "<path>/home/pi/GAMEBOY/roms/".$file."</path>\n");
					fwrite($fp, "<name>".$GameTitle."</name>\n");
					fwrite($fp, "<desc>".$Desc."</desc>\n");
					fwrite($fp, "<image>/home/pi/GAMEBOY/roms/".$ImageFile."</image>\n");					
					fwrite($fp, "</game>\n");
					$counter++;
							
				}
		
	        }
	    }
	    closedir($handle);
	}

	fwrite($fp, "</gameList>\n");
	fclose($fp);
}



if (isset($_POST['gen_gbc']))
{


	//	echo "Gen nes";x
	
	$fp = fopen("/home/pi/GAMEBOY_COLOR/roms/gamelist.xml", 'w');
	fwrite($fp, "<gameList>\n");
		
	if ($handle = opendir('/home/pi/GAMEBOY_COLOR/roms/')) {
	    while (false !== ($file = readdir($handle)))
	    {
	        if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'gbc')
	        {
		        $md5hash = GetMD5OfFile("GAMEBOY_COLOR/roms/" . $file);
				$query = "SELECT * FROM games WHERE md5='".$md5hash."'";
				$result = $db2->query($query);
				while($row = $result->fetchArray())
				{

					fwrite($fp, "<game>\n");
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
					fwrite($fp, "<path>/home/pi/GAMEBOY_COLOR/roms/".$file."</path>\n");
					fwrite($fp, "<name>".$GameTitle."</name>\n");
					fwrite($fp, "<desc>".$Desc."</desc>\n");
					fwrite($fp, "<image>/home/pi/GAMEBOY_COLOR/roms/".$ImageFile."</image>\n");					
					fwrite($fp, "</game>\n");
					$counter++;
							
				}
		
	        }
	    }
	    closedir($handle);
	}

	fwrite($fp, "</gameList>\n");
	fclose($fp);
}

if (isset($_POST['reboot_device']))
{
echo "<meta http-equiv=refresh content=40;url=index.php>";

echo "Rebooting... Refreshing in 40 seconds";
system("sudo reboot");
shell_exec("sudo reboot");

}

?>

<html>
<form action="rebuild_gamelist.php" method="post">
<body bgcolor="black" text="white" link="red" vlink="red">
<title>Rebuild Game list</title>
<title>RetroBox ROM Manager</title>
<h1><center>Generate gamelist</center></h1><br>
<?php include("menu.php"); ?>
<hr>
<center><input type="submit" name="gen_nes" value = "Generate NES Gamelist"><input type="submit" name="gen_snes" value = "Generate SNES Gamelist"><input type="submit" name="gen_gb" value = "Generate Game Boy Gamelist"><input type="submit" name="gen_gbc" value = "Generate Game Boy Color Gamelist">
<input type="submit" name="gen_n64" value = "Generate Nintendo 64 Gamelist">
<br>
Building gamelist might take a few minutes depending on size of database.<br>Do NOT exit your browser until you are returned to this page (it will mess up your gamelist)<br><br>
<br><br>
<?php function printProcess() { /*echo "Building gamelist... Please wait... "; */} function endProcess() { /*echo " DONE!<br><br>"; */} 


?>
<br>
<?php
if ($counter != 0)
{
	echo "Total games added: " . $counter . ". Please press START and select RELOAD to take effect!.";

}

?>
</center></form></html>