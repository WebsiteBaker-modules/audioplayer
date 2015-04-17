<?php
/**
*
**/
// prevent this file from being accessed directly
if(!defined('WB_PATH')) die(header('Location: index.php'));  

function _db_add_field($field, $table, $desc) {
	global $database;
	$table = TABLE_PREFIX.$table;
	$query = $database->query("DESCRIBE $table '$field'");
	if(!$query || $query->numRows() == 0) { // add field
		$query = $database->query("ALTER TABLE $table ADD $field $desc");
		echo (mysql_error()?mysql_error().'<br />':'');
		$query = $database->query("DESCRIBE $table '$field'");
		echo (mysql_error()?mysql_error().'<br />':'');
	}
}

_db_add_field("`position`", "mod_audioplayer", "INT NOT NULL DEFAULT 0 AFTER `page_id`");

