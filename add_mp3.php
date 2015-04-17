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
// Include WB admin wrapper script
require(WB_PATH.'/modules/admin.php');

// Include the ordering class
require(WB_PATH.'/framework/class.order.php');
$order = new order(TABLE_PREFIX.'mod_audioplayer', 'position', 'mp3_id', 'section_id');
$position = $order->get_new($section_id);

// Insert new row into database
$database->query("INSERT INTO ".TABLE_PREFIX."mod_audioplayer (section_id,page_id,position,mp3_active,mp3_visible) VALUES ('$section_id','$page_id',$position,'1','1')");

// Get the id
$mp3_id = $database->get_one("SELECT LAST_INSERT_ID()");

// Say that a new record has been added, then redirect to modify page
if($database->is_error()) {
	$admin->print_error($database->get_error(), WB_URL.'/modules/audioplayer/modify_mp3.php?page_id='.$page_id.'&section_id='.$section_id.'&mp3_id='.$mp3_id);
} else {
	$admin->print_success($TEXT['SUCCESS'], WB_URL.'/modules/audioplayer/modify_mp3.php?page_id='.$page_id.'&section_id='.$section_id.'&mp3_id='.$mp3_id);
}

// Print admin footer
$admin->print_footer();

?>