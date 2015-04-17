<?php

/**
  Module developed for the Open Source Content Management System Website Baker (http://websitebaker.org)
  Copyright (C) 2008, Jason Carncross
  Contact me: jason_carncross@yahoo.com

  LICENCE TERMS:
  This module is free software. You can redistribute it and/or modify it 
  under the terms of the GNU General Public License  - version 2 or later, 
  as published by the Free Software Foundation: http://www.gnu.org/licenses/gpl.html.
  // another good choice may be the Creative Commons Licence, see http://creativecommons.org/ for details

  DISCLAIMER:
  This module is distributed in the hope that it will be useful, 
  but WITHOUT ANY WARRANTY; without even the implied warranty of 
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
  GNU General Public License for more details.

 -----------------------------------------------------------------------------------------
 MP3 Audio Player module for Website Baker v2.6.x (http://www.websitebaker.org)
  The audio Player module allows for the uploading and playback of mp3 audio files
 -----------------------------------------------------------------------------------------
	DEVELOPMENT HISTORY:
	
	 v0.40  (Ruud Eisinga, August 2012)
	 + Changed MP3 player to open source version: > http://flash-mp3-player.net/
	 + Tooltip now CSS driven, No javascript anymore

	 v0.30  (Ruud Eisinga, August 2012)
	 + Small bugfixes
	 + Added ordering of MP3 files 

	 v0.20  (Kim Kahns/Oliver Bethke; 04 November, 2008)
	 + Replaced swf player
	 + Included frontend.css and frontend.css admin-editor
	 + backend error reducing
	 + frontview now conform to w3c standards
	 
	 v0.10  (Jason Carncross; 23 Apr, 2008)
	 + Started the module
 -----------------------------------------------------------------------------------------
**/

$module_directory = 'audioplayer';
$module_name = 'MP3 Audio Player';
$module_type = 'page';
$module_function = 'page';
$module_version = '0.40';
$module_platform = '2.70';
$module_author = 'Jason Carncross, Kim Kahns, Oliver Bethke, Ruud Eisinga';
$module_license = 'GNU General Public License';
$module_description = 'This module provides the ability to upload and play .mp3 audio files';
?>