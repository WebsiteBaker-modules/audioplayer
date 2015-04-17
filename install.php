<?php

/**
  Module developed for the Open Source Content Management System Website Baker (http://websitebaker.org)
  Copyright (C) 2008, Jason Carncross
  Contact me: jason_carncross@yahoo.com

  This module is free software. You can redistribute it and/or modify it 
  under the terms of the GNU General Public License  - version 2 or later, 
  as published by the Free Software Foundation: http://www.gnu.org/licenses/gpl.html.

  This module is distributed in the hope that it will be useful, 
  but WITHOUT ANY WARRANTY; without even the implied warranty of 
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
  GNU General Public License for more details.
**/

if(defined('WB_URL')) {
// basically loads the $size array

include('info.php');

			
			
	$database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."mod_audioplayer`");
	$mod_create_table = 'CREATE TABLE `'.TABLE_PREFIX.'mod_audioplayer` ( '
					 . '`mp3_id` INT NOT NULL AUTO_INCREMENT,'
					 . '`section_id` INT NOT NULL,'
					 . '`page_id` INT NOT NULL,'
					 . '`position` INT NOT NULL DEFAULT 0,'
					 . '`mp3_name` TEXT NOT NULL,'
					 . '`mp3_file` TEXT NOT NULL,'
					 . '`mp3_title` TEXT NOT NULL,'
					 . '`mp3_author` TEXT NOT NULL,'
					 . '`mp3_thumbnail` TEXT NOT NULL,'
					 . '`mp3_description` TEXT NOT NULL,'
					 . '`mp3_autoplay` BOOL NOT NULL DEFAULT 1,'
					 . '`mp3_visible` BOOL NOT NULL DEFAULT 1,'
					 . '`mp3_active` BOOL NOT NULL DEFAULT 1,'
					 . 'PRIMARY KEY (mp3_id)'
           . ' )';
	$database->query($mod_create_table);
	
	// Insert info into the search table
	// Module query info
	$field_info = array();
	$field_info['page_id'] = 'page_id';
	$field_info = serialize($field_info);
	$database->query("INSERT INTO ".TABLE_PREFIX."search (name,value,extra) VALUES ('module', 'audioplayer', '$field_info')");
	// Query start
	$query_start_code = "SELECT [TP]pages.page_id, [TP]pages.page_title,	[TP]pages.link	FROM [TP]mod_audioplayer, [TP]pages WHERE ";
	$database->query("INSERT INTO ".TABLE_PREFIX."search (name,value,extra) VALUES ('query_start', '$query_start_code', 'audioplayer')");
	// Query body
	$query_body_code = " [TP]pages.page_id = [TP]mod_audioplayer.page_id AND [TP]mod_audioplayer.galtitle [O] \'[W][STRING][W]\' AND [TP]pages.searching = \'1\'
	OR [TP]pages.page_id = [TP]mod_audioplayer.page_id AND [TP]mod_audioplayer.adminname [O] \'[W][STRING][W]\' AND [TP]pages.searching = \'1\'";
	$database->query("INSERT INTO ".TABLE_PREFIX."search (name,value,extra) VALUES ('query_body', '$query_body_code', 'audioplayer')");
	// Query end
	$query_end_code = "";	
	$database->query("INSERT INTO ".TABLE_PREFIX."search (name,value,extra) VALUES ('query_end', '$query_end_code', 'paudioplayer')");
	
	// Insert blank row (there needs to be at least one row for the search to work
	//$database->query("INSERT INTO ".TABLE_PREFIX."mod_audioplayer (page_id,section_id) VALUES ('0','0')");
	
}

?>
