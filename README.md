retrobox-rom-manager
====================

A easy way to handle your ROMS over HTTP on a raspberry (RetroPie).
It uses a internal database with over 2000 pre-defined games with cover, info, release date, etc.
When you upload a ROM from the HTTP page it will recognize it from its MD5 hash (US roms only) 
and automagically generate your gamelist 100%..

You can also remove and edit games and game information, upload new images.

If you upload a ROM which isnt recognized in the DB you will simply be asked to upload a picture and write some info
about the game, then add & gamelist is updated!

And by the way; You can also export your saves to your computer! AND RESTORE!


It currently supports; NES, SNES, GAMEBOY, GAMEBOY COLOR.



How to install:

YOU SHOULD HAVE ATLEST OVER 1GB AVAILABLE FREE SPACE (Lots of cover images that need to be decompressed)

First run sudo SETUP.sh
If you already have roms installed them move em into their respective console folders (e.g: /home/pi/NES/roms)
/home/pi/SNES/roms
/home/pi/GAMEBOY/roms, etc...

Remember to click Generate gamelist in manager web page after copyign is done.

