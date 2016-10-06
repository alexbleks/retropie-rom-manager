<?php
/*

	RetroBox ROM Manager v0.1
	Copyright (c) 2013 Alexander Blohm� <alexander.blohme@gmail.com>

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
<form action="snes_upload.php" method="post" enctype="multipart/form-data">
<body bgcolor="black" text="white" link="yellow" vlink="yellow">
<title>RetroBox ROM Manager</title>
<h1><center>Super Nintendo</center></h1><br>
<?php include("menu.php"); ?>
<hr>

<input type="file" name="file" id="file">
<input type="submit" name="uploadRom" value="Upload SNES ROM">
</form>
<br>
Select by alphabet:  [<a href ="snes.php?alphabet=all">All</a>]  [<a href ="snes.php?alphabet=1">123</a>] [<a href ="snes.php?alphabet=a">A</a>] [<a href ="snes.php?alphabet=b">B</a>] [<a href ="snes.php?alphabet=C">C</a>] [<a href ="snes.php?alphabet=d">D</a>] [<a href ="snes.php?alphabet=E">E</a>] [<a href ="snes.php?alphabet=F">F</a>] [<a href ="snes.php?alphabet=G">G</a>] [<a href ="snes.php?alphabet=h">H</a>] [<a href ="snes.php?alphabet=I">I</a>] [<a href ="snes.php?alphabet=J">J</a>] [<a href ="snes.php?alphabet=K">K</a>] [<a href ="snes.php?alphabet=L">L</a>] [<a href ="snes.php?alphabet=M">M</a>] [<a href ="snes.php?alphabet=N">N</a>] [<a href ="snes.php?alphabet=O">O</a>] [<a href ="snes.php?alphabet=P">P</a>] [<a href ="snes.php?alphabet=Q">Q</a>] [<a href ="snes.php?alphabet=R">R</a>] [<a href ="snes.php?alphabet=S">S</a>] [<a href ="snes.php?alphabet=T">T</a>] [<a href ="snes.php?alphabet=U">U</a>] [<a href ="snes.php?alphabet=V">V</a>] [<a href ="snes.php?alphabet=W">W</a>] [<a href ="snes.php?alphabet=X">X</a>] [<a href ="snes.php?alphabet=Y">Y</a>] [<a href ="snes.php?alphabet=Z">Z</a>]
<br><br>
<?php

$page = $_GET['alphabet'];

function GetMD5OfFile($file)
{
	$md5File = "/home/pi/SNES/roms/" . $file;
	//echo $md5File;
	return md5_file($md5File);
}

printf("<table><tr><td>ROM Name</td><td>Has database info?</td></tr>");

if ($handle = opendir('/home/pi/SNES/roms/')) {
    while (false !== ($file = readdir($handle)))
    {
        if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'smc' && ($file[0] == strtoupper($page) || $file[0] == strtolower($page) || $page == "all"))
		{
			
			printf("<tr><td><li><a href=snes_view.php?hash=%s>%s</a></td>", GetMD5OfFile($file), $file); printf("<td>");
			$query = "SELECT * FROM games WHERE md5='".GetMD5OfFile($file)."'";
			$result = $db2->query($query);
			/*if ($result != null)
			{
				printf("<img src=ok.png></img>");
			}
			else
			{
				printf("<img src=not.png></img>");
			}*/
			$counter = 0;
			while ($row = $result->fetchArray())
			{
				$counter++;
		
			}
			if ($counter == 0)
			{
				printf("<img src=not.png></img>");
			}	
			else
			{
				printf("<img src=ok.png></img>");
			}
			

						$fstr = preg_replace('".smc"', '.srm', $file);
			$full_path = "SNES/roms/" . $fstr;
			if (file_exists($full_path))
			{
				printf("</td><td><a href=\"%s\">Download Save Game</a> | <a href=\"upload_save.php?filename=%s&console=SNES\">Restore Save Game</a></td></tr>", $full_path,$file);
			}
			else
			{
				printf("</td><td><a href=\"upload_save.php?filename=%s&console=SNES\">Restore Save Game</a></td></tr>",$file);
			}
            //$thelist .= '<li><a href="'.$file.'">'.$file.'</a></li>';

        }
    }
    closedir($handle);
}
printf("</table>");
?>
</html>
