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
require(WB_PATH.'/modules/admin.php');

// Get id
if(!isset($_GET['mp3_id']) OR !is_numeric($_GET['mp3_id'])) {
	header("Location: ".ADMIN_URL."/pages/index.php");
} else {
	$mp3_id = $_GET['mp3_id'];
}

require_once(WB_PATH.'/modules/audioplayer/languages/EN.php');
if(file_exists(WB_PATH.'/modules/audioplayer/languages/'.LANGUAGE.'.php')) {
	require_once(WB_PATH.'/modules/audioplayer/languages/'.LANGUAGE.'.php');
}

$query_content = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_audioplayer WHERE mp3_id = '$mp3_id'");
$fetch_content = $query_content->fetchRow();
?>

<form name="modify" action="<?php echo WB_URL; ?>/modules/audioplayer/save_mp3.php" method="post" enctype="multipart/form-data" style="margin: 0;">
<input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
<input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
<input type="hidden" name="mp3_id" value="<?php echo $mp3_id; ?>">
<table cellpadding="4" cellspacing="0" border="0" width="100%">
<tr>
	<td width="80"><?php echo $MP3P['NAME'] ?></td>
	<td>
		<input type="text" name="mp3_name" value="<?php echo stripslashes($fetch_content['mp3_name']); ?>" style="width: 100%;" maxlength="255" />
        </td>
</tr>
<tr>
<td width="80"><?php echo $MP3P['TITLE'] ?></td>
    <td><input type="text" name="mp3_title" value="<?php echo stripslashes($fetch_content['mp3_title']); ?>" style="width: 100%;" maxlength="255" /></td>
</tr>
<tr>
<td width="80"><?php echo $MP3P['ARTIST'] ?></td>
    <td><input type="text" name="mp3_author" value="<?php echo stripslashes($fetch_content['mp3_author']); ?>" style="width: 100%;" maxlength="255" /></td>
</tr>
<tr>
<td width="80"><?php echo $MP3P['THUMB'] ?></td>
<?php if($fetch_content['mp3_thumbnail'] != '') { ?>
	<td>
		<?php echo stripslashes($fetch_content['mp3_thumbnail']); ?>&nbsp;&nbsp;<input type="checkbox" name="delete_thumbnail_mp3" id="delete_thumbnail_mp3" value="true" />
		<label for="delete_thumbnail_mp3"><?php echo $TEXT['DELETE']; ?></label>
        <input type="hidden" name="mp3_thumbnail" value="<?php echo stripslashes($fetch_content['mp3_thumbnail']); ?>">
	</td>
	<?php } else { ?>
    <td><input type="file" name="mp3_thumbnail" /></td>
    <?php } ?>
</tr>
<tr>
<td width="80"><?php echo $MP3P['DESCRIPTION'] ?></td>
    <td><input type="text" name="mp3_description" value="<?php echo stripslashes($fetch_content['mp3_description']); ?>" style="width: 100%;" maxlength="255" /></td>
</tr>
<tr>
	<td><?php echo $MP3P['FILE'] ?></td>
	<?php if($fetch_content['mp3_file'] != '') { ?>
	<td>
		<?php echo stripslashes($fetch_content['mp3_file']); ?>&nbsp;&nbsp;<input type="checkbox" name="delete_mp3" id="delete_mp3" value="true" />
		<label for="delete_mp3"><?php echo $TEXT['DELETE']; ?></label>
        <input type="hidden" name="mp3_file" value="<?php echo stripslashes($fetch_content['mp3_file']); ?>">
        
	</td>
	<?php } else { ?>
	<td><input type="file" name="mp3_file" />
	</td>
	<?php } ?>
</tr>
<tr>
	<td><?php echo $MP3P['VISIBLE'] ?></td>
	<td>
		<input type="radio" name="mp3_visible" id="mp3_visible_true" value="1" <?php if($fetch_content['mp3_visible'] == 1) { echo ' checked'; } ?> />
		<a href="#" onclick="javascript: document.getElementById('mp3_visible_true').checked = true;">
		<?php echo $TEXT['YES']; ?>
		</a>
		&nbsp;
		<input type="radio" name="mp3_visible" id="mp3_visible_false" value="0" <?php if($fetch_content['mp3_visible'] == 0) { echo ' checked'; } ?> />
		<a href="#" onclick="javascript: document.getElementById('mp3_visible_false').checked = true;">
		<?php echo $TEXT['NO']; ?>
		</a>
	</td>
</tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td width="90">&nbsp;</td>
	<td align="left">
		<input name="save" type="submit" value="<?php echo $TEXT['SAVE']; ?>" style="width: 200px; margin-top: 5px;"></form>
	</td>
	<td align="right">
		<input type="button" value="<?php echo $TEXT['CANCEL']; ?>" onclick="javascript: window.location = '<?php echo ADMIN_URL; ?>/pages/modify.php?page_id=<?php echo $page_id; ?>';" style="width: 100px; margin-top: 5px;" />
	</td>
</tr>
</table>
<?php

// Print admin footer
$admin->print_footer();

?>