#!/bin/bash
clear
echo "INSTALLING RETROBOX ROM MANAGER V0.1 BETA!"
echo "Apt-getting apache2,php5,php5-sqlite,php5gd,unzip"
apt-get install apache2 php5 php5-sqlite php5-gd unzip
echo "Creating folder structures..."
mkdir /home/pi/SNES/
mkdir /home/pi/SNES/roms/
mkdir /home/pi/NES/
mkdir /home/pi/NES/roms
mkdir /home/pi/GAMEBOY
mkdir /home/pi/GAMEBOY/roms
mkdir /home/pi/GAMEBOY_COLOR
mkdir /home/pi/GAMEBOY_COLOR/roms
echo "Moving images to each folder..."
mv imgs/NES.z* /home/pi/NES/roms/
mv imgs/SNES.z* /home/pi/SNES/roms/
mv imgs/GB.zip /home/pi/GAMEBOY/roms/
mv imgs/GBC.zip /home/pi/GAMEBOY_COLOR/roms/
unzip /home/pi/NES/roms/NES.zip
unzip /home/pi/SNES/roms/SNES.zip
unzip /home/pi/GAMEBOY/roms/GB.zip
unzip /home/pi/GAMEBOY_COLOR/roms/GBC.zip
echo "Cleaning up zip files..."
rm /home/pi/NES/roms/NES.z*
rm /home/pi/SNES/roms/SNES.z*
rm /home/pi/GAMEBOY/roms/GB.z*
rm /home/pi/GAMEBOY_COLOR/roms/GBC.z*
echo "Copying apache config files..."
cp apache/000-default /etc/apache2/sites-enabled
echo "Copying database file..."
cp db/file.db /home/pi/
echo "Copying web files..."
cp www/* /home/pi/
echo "Setting permissions..."
chmod -R 777 /home/pi/

echo "Done! Open http://your_raspberry_ip/ to manage your roms."
echo "Also, you can copy roms over to /home/pi/<console_title>/roms folder via FTP, etc"
echo "Remember to edit emulationstation system config file to your new rom location"
echo "Please restart"