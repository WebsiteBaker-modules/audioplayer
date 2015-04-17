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

// Get id
if(!isset($_POST['mp3_id']) OR !is_numeric($_POST['mp3_id'])) {
	header("Location: ".ADMIN_URL."/pages/index.php");
} else {
	$id = $_POST['mp3_id'];
	$mp3_id = $id;
}

// Include WB admin wrapper script
$update_when_modified = true; // Tells script to update when this page was last updated
require(WB_PATH.'/modules/admin.php');

// Validate all fields
if($admin->get_post('mp3_name') == '') {
	$admin->print_error($MESSAGE['GENERIC']['FILL_IN_ALL'], WB_URL.'/modules/audioplayer/modify_mp3.php?page_id='.$page_id.'&section_id='.$section_id.'&mp3_id='.$id);
} else {
	$mp3_file = $admin->get_post('mp3_file');
	$mp3_name = $admin->get_post('mp3_name');
	$mp3_title = $admin->get_post('mp3_title');
	$mp3_author = $admin->get_post('mp3_author');
	$mp3_thumbnail = $admin->get_post('mp3_thumbnail');
	$mp3_description = $admin->get_post('mp3_description');
	$mp3_autoplay = $admin->get_post('mp3_autoplay');
	$mp3_visible = $admin->get_post('mp3_visible');
	$mp3_active = $admin->get_post('mp3_active');
}
// Include WB functions file
require(WB_PATH.'/framework/functions.php');
//create the thumbnails directory
make_dir(WB_PATH.MEDIA_DIRECTORY.'/audio_thumbnails');
// upload thumbnail file
if ((($_FILES["mp3_thumbnail"]["type"] == "image/gif")
|| ($_FILES["mp3_thumbnail"]["type"] == "image/jpeg")
|| ($_FILES["mp3_thumbnail"]["type"] == "image/pjpeg"))
&& ($_FILES["mp3_thumbnail"]["size"] < 200000))
  {
  if ($_FILES["mp3_thumbnail"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["mp3_thumbnail"]["error"] . "<br />";
    }
  else
    {
	$_FILES["mp3_thumbnail"]["name"] . "<br />";
    $_FILES["mp3_thumbnail"]["type"] . "<br />";
    ($_FILES["mp3_thumbnail"]["size"] / 1024) . " Kb<br />";
    $_FILES["mp3_thumbnail"]["tmp_name"] . "<br />";
    if (file_exists("upload/" . $_FILES["mp3_thumbnail"]["name"]))
      {
      echo $_FILES["mp3_thumbnail"]["name"] . " already exists. ";
      }
    else
      {
	   
      move_uploaded_file($_FILES["mp3_thumbnail"]["tmp_name"],
      WB_PATH.MEDIA_DIRECTORY."/audio_thumbnails/". $_FILES["mp3_thumbnail"]["name"]);
	  $mp3_thumbnail = $_FILES["mp3_thumbnail"]["name"];
      }
    }
  }


//create the audio directory
make_dir(WB_PATH.MEDIA_DIRECTORY.'/audio');
// upload mp3 file

if ($_FILES["mp3_file"]["name"] != ""){
  if ($_FILES["mp3_file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["mp3_file"]["error"] . "<br />";
    }
  else
    {
	echo "MP3 File Name: " .$_FILES["mp3_file"]["name"] . "<br />";
   echo "File Type: " . $_FILES["mp3_file"]["type"] . "<br />";
   echo "File Size: " . ($_FILES["mp3_file"]["size"] / 1024) . " Kb<br />";
	$_FILES["mp3_file"]["tmp_name"] . "<br />";
    if (file_exists("upload/" . $_FILES["mp3_file"]["name"]))
      {
      echo $_FILES["mp3_file"]["name"] . " already exists. ";
      }
    else
      {
	   
      move_uploaded_file($_FILES["mp3_file"]["tmp_name"],
      WB_PATH.MEDIA_DIRECTORY."/audio/". $_FILES["mp3_file"]["name"]);
	  $mp3_file = $_FILES["mp3_file"]["name"];
      }
    }
}

// Get page link URL
$query_page = $database->query("SELECT level,link FROM ".TABLE_PREFIX."pages WHERE page_id = '$page_id'");
$page = $query_page->fetchRow();
$page_level = $page['level'];
$page_link = $page['link'];


if(isset($_POST['delete_mp3']) AND $_POST['delete_mp3'] != '') {
	$mp3_file = '';
}
if(isset($_POST['delete_thumbnail_mp3']) AND $_POST['delete_thumbnail_mp3'] != '') {
	
	$mp3_thumbnail = '';
	
	}
// Update row
$database->query("UPDATE ".TABLE_PREFIX."mod_audioplayer SET mp3_name = '$mp3_name', mp3_file = '$mp3_file', mp3_title = '$mp3_title', mp3_author = '$mp3_author', mp3_thumbnail = '$mp3_thumbnail', mp3_description = '$mp3_description', mp3_autoplay = '$mp3_autoplay', mp3_visible = '$mp3_visible', mp3_active = '$mp3_active' WHERE mp3_id = '$mp3_id'");

// Check if there is a db error, otherwise say successful
if($database->is_error()) {
	$admin->print_error($database->get_error(), WB_URL.'/modules/audioplayer/modify_mp3.php?page_id='.$page_id.'&section_id='.$section_id.'&mp3_id='.$mp3_id);
} else {
	$admin->print_success($TEXT['SUCCESS'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}

// Print admin footer
$admin->print_footer();

?>