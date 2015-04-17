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

// Must include code to stop this file being access directly
if(!defined('WB_PATH')) die(header('Location: index.php'));  

// include core functions of WB 2.7 to edit the optional module CSS files (frontend.css, backend.css)
require_once(WB_PATH .'/framework/module.functions.php');
require_once(WB_PATH .'/framework/class.order.php');
require_once(WB_PATH.'/modules/audioplayer/languages/EN.php');
if(file_exists(WB_PATH.'/modules/audioplayer/languages/'.LANGUAGE.'.php')) {
	require_once(WB_PATH.'/modules/audioplayer/languages/'.LANGUAGE.'.php');
}

$order = new order(TABLE_PREFIX.'mod_audioplayer', 'position', 'mp3_id', 'section_id');
if(isset($_GET['up'])) {
	$order->move_up(intval($_GET['up']));
	unset($_GET['up']);
}
if(isset($_GET['down'])) {
	$order->move_down(intval($_GET['down']));
	unset($_GET['down']);
}
$order->clean($section_id);
	
// check if backend.css file needs to be included into the <body></body> of modify.php
if(!method_exists($admin, 'register_backend_modfiles') && file_exists(WB_PATH .'/modules/audioplayer/backend.css')) {
	echo '<style type="text/css">';
	include(WB_PATH .'/modules/audioplayer/backend.css');
	echo "\n</style>\n";
}
?>
<h2><?php echo $MP3P['MODTITLE'] ?></h2>
<div>
<form name="edit" action="<?php echo WB_URL; ?>/modules/audioplayer/save.php" method="post" style="margin: 0;">
<input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
<input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />


<?php
$query_audioplayer = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_audioplayer WHERE section_id = '".$section_id."' ORDER BY `position`" );
if($max = $query_audioplayer->numRows()) {
	$item = 0;
	$row = 'a';
	?>
	<table cellpadding="2" cellspacing="0" border="0" width="100%">
		<tr>
			<th><?php echo $MP3P['ARTIST'] ?></th>
			<th><?php echo $MP3P['TITLE'] ?></th>
			<th><?php echo $MP3P['VISIBLE'] ?></th>
			<th width="20" style="padding-left: 5px;" colspan="4"> </th>
		</tr>
		<?php
	while($mp3 = $query_audioplayer ->fetchRow()) {
		?>
		<tr class="sectionrow row_<?php echo $row; ?>" height="20">
			<td style="padding-left: 5px;">
				<a href="<?php echo WB_URL; ?>/modules/audioplayer/modify_mp3.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&mp3_id=<?php echo $mp3['mp3_id']; ?>">
					<?php echo stripslashes($mp3['mp3_author']) ?>
				</a>
			</td>            
			<td style="padding-left: 5px;">
				<a href="<?php echo WB_URL; ?>/modules/audioplayer/modify_mp3.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&mp3_id=<?php echo $mp3['mp3_id']; ?>">
					<?php echo stripslashes($mp3['mp3_name']) ?>
				</a>
			</td>            
			<td width="20">
				<a href="<?php echo WB_URL; ?>/modules/audioplayer/modify_mp3.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&mp3_id=<?php echo $mp3['mp3_id']; ?>">
				<?php if($mp3['mp3_visible'] == '1') { ?>
					<img src="<?php echo THEME_URL; ?>/images/view_16.png" border="0" alt="" />
				<?php } else { ?>
					<img src="<?php echo THEME_URL; ?>/images/none_16.png" border="0" alt="" />
				<?php } ?>
				</a>
			</td>
			<td width="20" style="padding-left: 5px;">
				<?php if($item++ > 0) { ?> 
				<a href="<?php echo ADMIN_URL; ?>/pages/modify.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&up=<?php echo $mp3['mp3_id']; ?>" title="Up">
					<img src="<?php echo THEME_URL; ?>/images/up_16.png" border="0" alt="Modify" />
				</a>
				<?php } ?>
			</td>
			<td width="20" style="padding-left: 5px;">
				<?php if($item != $max) { ?> 
				<a href="<?php echo ADMIN_URL; ?>/pages/modify.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&down=<?php echo $mp3['mp3_id']; ?>" title="Down">
					<img src="<?php echo THEME_URL; ?>/images/down_16.png" border="0" alt="Modify" />
				</a>
				<?php } ?>
			</td>
			<td width="20" style="padding-left: 5px;">
				<a href="<?php echo WB_URL; ?>/modules/audioplayer/modify_mp3.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&mp3_id=<?php echo $mp3['mp3_id']; ?>" title="Edit">
					<img src="<?php echo THEME_URL; ?>/images/modify_16.png" border="0" alt="Modify" />
				</a>
			</td>
			<td width="20">
				<a href="javascript: confirm_link('Are you sure that you want to delete this audio?', '<?php echo WB_URL; ?>/modules/audioplayer/delete_mp3.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&mp3_id=<?php echo $mp3['mp3_id']; ?>');" title="Delete">
					<img src="<?php echo THEME_URL; ?>/images/delete_16.png" border="0" alt="Delete" />
				</a>
			</td>
            
		</tr>
		<?php
		// Alternate row color
		if($row == 'a') {
			$row = 'b';
		} else {
			$row = 'a';
		}
	}
	?>
	</table>
	<?php
} else {
	echo $MP3P['NOTFOUND']."<br/>";
}
?>
<br/>

<input type="button" value="<?php echo $MP3P['ADDNEW'] ?>" onclick="javascript: window.location = '<?php echo WB_URL; ?>/modules/audioplayer/add_mp3.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>';" style="width: 50%;" />
<input type="button" value="<?php echo $MP3P['CANCEL'] ?>" onclick="javascript: window.location = '<?php echo ADMIN_URL; ?>/pages/index.php'; return false;" style="width: 150px;" />
</form>
	<?php	
	if(function_exists('edit_module_css')) {
		edit_module_css('audioplayer');
	}
?>

<br/>
</div>
