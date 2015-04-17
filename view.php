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
if(defined('WB_PATH') == false) { exit("Cannot access this file directly"); }

require_once(WB_PATH.'/modules/audioplayer/languages/EN.php');
if(file_exists(WB_PATH.'/modules/audioplayer/languages/'.LANGUAGE.'.php')) {
	require_once(WB_PATH.'/modules/audioplayer/languages/'.LANGUAGE.'.php');
}
$player = '<li>
<div class="mp3row">
	<a href="#" onclick="return play'.$section_id.'([MP3_ID],\'[MP3_FILE]\',\'[MP3_TITLE]\');" >
		[MP3_NAME] [MP3_AUTHOR] [TOOLTIP]
	</a>
</div>
';
$tooltip = '<span class="mp3tooltip" id="id[MP3_ID]">[MP3_THUMBNAIL][MP3_DESCRIPTION]</span>';

//Player width setting
$player_width = 600;

//Optional player color settings - see: http://flash-mp3-player.net/players/maxi/documentation/
//$player_colors = "&amp;bgcolor1=01B0F1&amp;bgcolor2=11396D&amp;slidercolor1=FFFFFF&amp;slidercolor2=DDDDDD&amp;sliderovercolor=F2A600&amp;buttonovercolor=F2A600";
$player_colors = "";


$query = "SELECT * FROM ".TABLE_PREFIX."mod_audioplayer WHERE section_id = '$section_id' AND mp3_visible= '1' AND mp3_name != '' ORDER BY `position`";
$query_content = $database->query($query);
if($query_content->numRows() > 0) {
	?>
	
	<script type="text/javascript">
	<!--
	function decode<?php echo $section_id ?>(s) {
    var e={},i,k,v=[],r='',w=String.fromCharCode;
    var n=[[65,91],[97,123],[48,58],[43,44],[47,48]];
    for(z in n){for(i=n[z][0];i<n[z][1];i++){v.push(w(i));}}
    for(i=0;i<64;i++){e[v[i]]=i;}
    for(i=0;i<s.length;i+=72){
    var b=0,c,x,l=0,o=s.substring(i,i+72);
         for(x=0;x<o.length;x++){
                c=e[o.charAt(x)];b=(b<<6)+c;l+=6;
                while(l>=8){r+=w((b>>>(l-=8))%256);}
         }
    }
    return r;
    }

	_playing<?php echo $section_id ?> = -1;
	function play<?php echo $section_id ?>(id,filename,audioTitle) {
		var title = document.getElementById("titleAudioName-<?php echo $section_id ?>");
		if(_playing<?php echo $section_id ?> == id) {
			_playing<?php echo $section_id ?>=-1;
			document.getElementById("player<?php echo $section_id ?>").SetVariable("player:jsStop", "");	
		} else {
			_playing<?php echo $section_id ?>=id;
			if(title) title.innerHTML = audioTitle;
			document.getElementById("player<?php echo $section_id ?>").SetVariable("player:jsUrl", decode<?php echo $section_id ?>(filename));
			document.getElementById("player<?php echo $section_id ?>").SetVariable("player:jsPlay", "");	
		}
		return false;
	}
	//-->
	</script>
	<div class="mp3player">
	<object id="player<?php echo $section_id ?>" type="application/x-shockwave-flash" data="<?php echo WB_URL ?>/modules/audioplayer/player_mp3_maxi.swf" width="<?php echo $player_width ?>" height="30">
		<param name="movie" value="<?php echo WB_URL ?>/modules/audioplayer/player_mp3_maxi.swf" />
		<param name="wmode" value="transparent"/>
		<param name="FlashVars" value="width=<?php echo $player_width ?>&amp;height=30&amp;showstop=1&amp;showvolume=1&amp;buttonwidth=30&amp;volumeheight=10&amp;volumewidth=45&amp;sliderheight=12<?php echo $player_colors; ?>" />
	</object>
	<div class="playing"><?php echo $MP3P['NOWPLAYING'] ?> <span id="titleAudioName-<?php echo $section_id ?>"><?php echo $MP3P['NOTHING'] ?></span></div>
	<ol class="playlist">
	<?php
	while($audio = $query_content->fetchRow()) {
		$thumb ='';
		if ($audio['mp3_thumbnail']) $thumb = '<img src="'.WB_URL.MEDIA_DIRECTORY.'/audio_thumbnails/'.$audio['mp3_thumbnail'].'" alt="" border="0" />';
		if (!$audio['mp3_title']) $audio['mp3_title'] = $audio['mp3_name'];
		if ($audio['mp3_author']) $audio['mp3_author'] = ' - ' .$audio['mp3_author'];

		//Build tooltip
		$vars = array('[MP3_ID]','[MP3_THUMBNAIL]', '[MP3_DESCRIPTION]');
		$values = array($audio['mp3_id'], $thumb, $audio['mp3_description']);
		$tip = ($thumb || $audio['mp3_description']) ? str_replace($vars, $values, $tooltip) : '';

		//Build row
		$vars = array('[MP3_ID]', '[MP3_FILE]', '[MP3_NAME]', '[MP3_TITLE]', '[MP3_AUTHOR]', '[TOOLTIP]', '[MP3_AUTOPLAY]', '[MP3_VISIBLE]', '[MP3_ACTIVE]');
		$values = array($audio['mp3_id'], base64_encode(WB_URL.MEDIA_DIRECTORY.'/audio/'.stripslashes($audio['mp3_file'])), $audio['mp3_name'], ($audio['mp3_title']), $audio['mp3_author'], $tip, $audio['mp3_autoplay'], $audio['mp3_visible'], $audio['mp3_active']);
		if($audio['mp3_visible']=='1') echo str_replace($vars, $values, $player);
	}
	?>
	</ol>
	</div>
	<?php
} 

