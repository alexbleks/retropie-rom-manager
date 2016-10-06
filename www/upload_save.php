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

$FILENAME = $_GET['filename'];
$CONSOLE = $_GET['console'];
$fullConsoleName;

if ($CONSOLE == "NES")
{
	$fullConsoleName = "Nintendo Entertainment System";
}
else if ($CONSOLE == "SNES")
{
	$fullConsoleName = "Super Nintendo (SNES)";
}
else if ($CONSOLE == "GAMEBOY")
{
	$fullConsoleName = "Game Boy";
}
else if ($CONSOLE == "GAMEBOY_COLOR")
{
	$fullConsoleName == "Game Boy Color";
}

if (isset($_POST['uploadSaveGame']))
{
	$allowedExts = array("srm");
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
	  
				
				
						$CONTINUE = true;

						if ($CONSOLE == "NES") { $fstr = preg_replace('".nes"', '.srm', $FILENAME);  }
						if ($CONSOLE == "SNES") { $fstr = preg_replace('".smc"', '.srm', $FILENAME);  }
						if ($CONSOLE == "GAMEBOY") { $fstr = preg_replace('".gb"', '.srm', $FILENAME);  }
						if ($CONSOLE == "GAMEBOY_COLOR") { $fstr = preg_replace('".gbc"', '.srm', $FILENAME);  }


						move_uploaded_file($_FILES["file"]["tmp_name"],$CONSOLE."/roms/" . $fstr);
						
						echo "Save Game restored!";
					
		}	  
		
	}
	else
	{
	  	echo "This is not a save game file!";
	}
}
?>
<html>
<form action="upload_save.php?console=<?php echo $CONSOLE ?>&filename=<?php echo $FILENAME; ?>" method="post" enctype="multipart/form-data">

<body bgcolor="black" text="white" link="red" vlink="red">
<title>Restore Save Gamet</title>
<title>RetroBox ROM Manager</title>
<h1><center>Restore Save Game</center></h1><br>
<?php include("menu.php"); ?>
<hr>
<br>
<center><h3><?php echo "Restore '<font color=green>" . $FILENAME . "</font>' ".$fullConsoleName." save game"; ?></h3></center>
<center>
Select a SRM file <input type="file" name="file" id="file">
<input type="submit" name="uploadSaveGame" value="Restore Save">
</center>