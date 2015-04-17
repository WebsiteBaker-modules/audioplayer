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

require('../../config.php');
include('info.php');
// Get ID
if (isset($_GET['mp3_id']) AND is_numeric($_GET['mp3_id'])) {
  $id = $_GET['mp3_id'];
} else {
  header("Location: ".ADMIN_URL."/pages/index.php");
}

// Include WB admin wrapper script
$update_when_modified = true; // Tells script to update when this page was last updated
require(WB_PATH.'/modules/admin.php');


// Get post details
$query_details = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_audioplayer WHERE mp3_id = '$id'");
if($query_details->numRows() > 0) {
	$get_details = $query_details->fetchRow();
} else {
	$admin->print_error($TEXT['NOT_FOUND'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}


// Unlink post access file
if(is_writable(WB_PATH.$get_details['mp3_file'].'.php')) {
	unlink(WB_PATH.$get_details['mp3_file'].'.php');
}

// Delete any images if they exists
$file = WB_PATH.MEDIA_DIRECTORY.'/audio/audio'.$get_details['mp3_id'].'.mp3';
if(file_exists($file) AND is_writable($file)) { unlink($file); }



// Delete entry from DB
$database->query("DELETE FROM ".TABLE_PREFIX."mod_audioplayer WHERE mp3_id = '$id'");


// Check if there is a db error, otherwise say successful
if($database->is_error()) {
	$admin->print_error($database->get_error(), ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&section_id='.$section_id);
} else {
	$admin->print_success($TEXT['SUCCESS'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&section_id='.$section_id);
}

// Print admin footer
$admin->print_footer();

?>