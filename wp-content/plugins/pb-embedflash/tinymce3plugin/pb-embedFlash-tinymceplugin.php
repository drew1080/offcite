<?php
/*
Part of pb-embedFlash v1.5
© Pascal Berkhahn, <novayuna@googlemail.com>, http://pascal-berkhahn.de
*/
$wpconfig = realpath('../../../../wp-config.php');
if (!file_exists($wpconfig)) { exit('Could not find wp-config.php.'); }
require_once($wpconfig);
require_once(ABSPATH.'/wp-admin/admin.php');
if(!current_user_can('edit_posts')) die;

load_textdomain('pb-embedflash', get_option('siteurl').'/wp-content/plugins/pb-embedflash/locales/pb-embedflash-'.get_locale().'.mo');

//$pbef_options = get_option('pb_embedflash');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" lang="de-DE">
<head>
	<title>pb-embedFlash</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script type="text/javascript" src="<?php echo PBEF_SITEPATH ?>/tinymce3plugin/pb-embedFlash-tinymceplugin.js"></script>
	<script type="text/javascript" src="<?php echo PBEF_SITEPATH ?>/js/colorpicker.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo PBEF_SITEPATH ?>/css/admin.css" />
	<base target="_self" />
</head>
<body id="link" onload="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';document.getElementById('flashURL').focus();" style="display: none">
	<form name="pb-embedFlash" action="#" accept-charset="utf-8" >
		<div class="tabs">
			<ul>
				<li id="insert_tab" class="current"><span><a href="javascript:mcTabs.displayTab('insert_tab','insert_panel');" onmousedown="return false;"><?php _e('Insert', 'pb-embedflash'); ?></a></span></li>
				<li id="shadowbox_tab"><span><a href="javascript:mcTabs.displayTab('shadowbox_tab','shadowbox_panel');" onmousedown="return false;"><?php _e('Shadowbox & Popup', 'pb-embedflash'); ?></a></span></li>
				<li id="options_tab"><span><a href="javascript:mcTabs.displayTab('options_tab','options_panel');" onmousedown="return false;"><?php _e('JW FLV MP', 'pb-embedflash'); ?></a></span></li>
			</ul>
		</div>
		<div class="panel_wrapper" style="height:200px;">
			<!-- insert panel -->
			<div id="insert_panel" class="panel current" style="margin-left: 5px; margin-right: 10px;">
				<table border="0" cellpadding="4" cellspacing="0" style="width: 100%;">
					<tr>
						<td nowrap="nowrap" colspan="2"><strong><?php _e('Flash content'); ?></strong></td>
						<td nowrap="nowrap" colspan="2" align="right"><strong><font color="red">beta!</font></strong></td>
					</tr>
					<tr>
						<td nowrap="nowrap"><label for="flashURL"><?php _e('URL', 'pb-embedflash'); ?>:</label></td>
						<td colspan="3"><input type="text" id="flashURL" value="" style="width:400px;"/></td>
					</tr>
					<tr>
						<td nowrap="nowrap"><label for="flashWidth"><?php _e('Width', 'pb-embedflash'); ?>:</label></td>
						<td><input type="text" id="flashWidth" value="" style="width:155px;" /></td>
						<td nowrap="nowrap"><label for="flashHeight"><?php _e('Height', 'pb-embedflash'); ?>:</label></td>
						<td><input type="text" id="flashHeight" value="" style="width:155px;" /></td>
					</tr>
					<tr>
						<td nowrap="nowrap" colspan="4">
							<strong><?php _e('Mode'); ?></strong>
							<br />
							<select id="selMode">
								<option value=""><?php _e('default', 'pb-embedflash'); ?></option>
								<option value="0">(0) <?php _e('&lt;object&gt;', 'pb-embedflash'); ?></option>
								<option value="1">(1) <?php _e('SWFObject', 'pb-embedflash'); ?></option>
								<option value="2">(2) <?php _e('SWFObject (IE only)', 'pb-embedflash'); ?></option>
								<option value="3">(3) <?php _e('Shadowbox', 'pb-embedflash'); ?></option>
								<option value="4">(4) <?php _e('Popup', 'pb-embedflash'); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap" colspan="4"><strong><?php _e('Playlist'); ?></strong></td>
					</tr>
					<?php $mm = pb_embedFlash_mm_get_data(); ?>
					<tr>
						<td nowrap="nowrap"><label for="optMMPlaylists">
							<input type="checkbox" id="optMMPlaylists" value="1" onclick="document.getElementById('optMMMedia').checked = false;" />&nbsp;&nbsp;
						</td>
						<td colspan="3">
							<select id="selMMPlaylists">
						
						<?php if (is_array($mm['playlists'])) { foreach ($mm['playlists'] as $id => $item) { ?>
								<option value="<?php echo $id ?>">(<?php echo $id ?>) <?php echo htmlspecialchars($item['title']); ?></option>
						<?php } } else { ?>
								<option value="0"><?php _e('No playlists', 'pb-embedflash'); ?></option>
						<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td nowrap="nowrap" colspan="4"><strong><?php _e('Media'); ?></strong></td>
					</tr>
					<tr>
						<td nowrap="nowrap"><label for="optMMMedia">
							<input type="checkbox" id="optMMMedia" value="1" onclick="document.getElementById('optMMPlaylists').checked = false;" />&nbsp;&nbsp;
						</td>
						<td colspan="3">
							<select id="selMMMedia">
						<?php if (is_array($mm['media'])) { foreach ($mm['media'] as $id => $item) { ?>
								<option value="<?php echo $id ?>">(<?php echo $id ?>) <?php echo utf8_decode($item['title']); ?></option>
						<?php } } else { ?>
								<option value="0"><?php _e('No media', 'pb-embedflash'); ?></option>
						<?php } ?>
							</select>
						</td>
					</tr>
				</table>
			</div>
			<!-- insert panel -->
			<!-- shadowbox panel -->
			<div id="shadowbox_panel" class="panel" style="margin-left: 5px; margin-right: 10px;">
				<table border="0" cellpadding="4" cellspacing="0" style="width: 100%;">
					<tr>
						<td nowrap="nowrap" colspan="4"><strong><?php _e('Shadowbox &amp; Popup settings'); ?></strong></td>
					</tr>					
					<tr>
						<td nowrap="nowrap"><label for="flashPreview"><?php _e('Preview image', 'pb-embedflash'); ?>:</label></td>
						<td><input type="text" id="flashPreview" value="" style="width:150px;" /></td>
						<td nowrap="nowrap"><label for="flashForcePreview"><?php _e('Force preview image', 'pb-embedflash'); ?>:</label></td>
						<td><input type="checkbox" id="flashForcePreview" value="1" /></td>						
					</tr>
					<tr>
						<td nowrap="nowrap"><label for="flashPreviewWidth"><?php _e('Width', 'pb-embedflash'); ?>*:</label></td>
						<td><input type="text" id="flashPreviewWidth" value="" style="width:150px;" /></td>
						<td nowrap="nowrap" colspan="2">
							<label for="flashPreviewHeight"><?php _e('Height', 'pb-embedflash'); ?>*:</label>
							&nbsp;<input type="text" id="flashPreviewHeight" value="" style="width:150px;" />
						</td>
					</tr>					
					<tr>			
						<td nowrap="nowrap"><label for="flashLinktext"><?php _e('Linktext', 'pb-embedflash'); ?>:</label></td>
						<td colspan="3"><input type="text" id="flashLinktext" value="" style="width:370px;" /></td>
					</tr>					
					<tr>					
						<td nowrap="nowrap"><label for="flashCaption"><?php _e('Caption/Title', 'pb-embedflash'); ?>:</label></td>
						<td colspan="3"><input type="text" id="flashCaption" value="" style="width:370px;" /></td>
					</tr>
					<tr>					
						<td colspan="4" style="text-align: right;">* <?php _e('optional, but set both of them if used', 'pb-embedflash'); ?></td>
					</tr>
				</table>
			</div>
			<!-- shadowbox panel -->
			<!-- options panel -->
			<div id="options_panel" class="panel">
				<div class="tabs">
					<ul>
						<li id="opt1_tab" class="current"><span><a href="javascript:mcTabs.displayTab('opt1_tab','opt1_panel');" onmousedown="return false;"><?php _e('Basics', 'pb-embedflash'); ?></a></span></li>
						<li id="opt2_tab"><span><a href="javascript:mcTabs.displayTab('opt2_tab','opt2_panel');" onmousedown="return false;"><?php _e('Colors', 'pb-embedflash'); ?></a></span></li>
						<li id="opt3_tab"><span><a href="javascript:mcTabs.displayTab('opt3_tab','opt3_panel');" onmousedown="return false;"><?php _e('Display', 'pb-embedflash'); ?></a></span></li>
						<li id="opt4_tab"><span><a href="javascript:mcTabs.displayTab('opt4_tab','opt4_panel');" onmousedown="return false;"><?php _e('Controls', 'pb-embedflash'); ?></a></span></li>
						<li id="opt5_tab"><span><a href="javascript:mcTabs.displayTab('opt5_tab','opt5_panel');" onmousedown="return false;"><?php _e('Playlist', 'pb-embedflash'); ?></a></span></li>
						<li id="opt6_tab"><span><a href="javascript:mcTabs.displayTab('opt6_tab','opt6_panel');" onmousedown="return false;"><?php _e('Playback', 'pb-embedflash'); ?></a></span></li>
						<li id="opt7_tab"><span><a href="javascript:mcTabs.displayTab('opt7_tab','opt7_panel');" onmousedown="return false;"><?php _e('Extern', 'pb-embedflash'); ?></a></span></li>
					</ul>
				</div>
				<div class="panel_wrapper" style="height:150px;">
					<div id="opt1_panel" class="panel current">
						<table border="0" cellpadding="2" cellspacing="0">
							<tr>
								<td nowrap="nowrap" colspan="2"><strong><?php _e('JW FLV Media Player settings', 'pb-embedflash'); ?> - <?php _e('Basics', 'pb-embedflash'); ?></strong></td>
							</tr>
							<tr>
								<td nowrap="nowrap" style="width:100px;"><label for="optImage">image:</label></td>
								<td><input type="text" id="optImage" value="" style="width:330px;" /></td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optId">id:</label></td>
								<td><input type="text" id="optId" value="" style="width:330px;" /></td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optSearchbar">searchbar:</label></td>
								<td>
									<input type="checkbox" id="optSearchbar" value="1" />&nbsp;&nbsp;
									<select id="selSearchbar">
										<option value="true" selected="selected">true</option>
										<option value="false">false</option>
									</select>
								</td>
							</tr>
						</table>
					</div>
					<div id="opt2_panel" class="panel">
						<table border="0" cellpadding="2" cellspacing="0">
							<tr>
								<td nowrap="nowrap" colspan="2"><strong><?php _e('JW FLV Media Player settings', 'pb-embedflash'); ?> - <?php _e('Colors', 'pb-embedflash'); ?></strong></td>
							</tr>
							<tr>
								<td nowrap="nowrap" style="width:100px;"><label for="optBackcolor">backcolor:</label></td>
								<td>
									<input type="text" id="optBackcolor" value="" />
									<a href="javascript:pickColor('optBackcolor');" class="pick" id="optBackcolorpick" style="background-color: #FFFFFF;">&nbsp;&nbsp;&nbsp;</a>
								</td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optFrontcolor">frontcolor:</label></td>
								<td>
									<input type="text" id="optFrontcolor" value="" />
									<a href="javascript:pickColor('optFrontcolor');" class="pick" id="optFrontcolorpick" style="background-color: #000000;">&nbsp;&nbsp;&nbsp;</a>
								</td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optLightcolor">lightcolor:</label></td>
								<td>
									<input type="text" id="optLightcolor" value="" />
									<a href="javascript:pickColor('optLightcolor');" class="pick" id="optLightcolorpick" style="background-color: #000000;">&nbsp;&nbsp;&nbsp;</a>
								</td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optScreencolor">screencolor:</label></td>
								<td>
									<input type="text" id="optScreencolor" value="" />
									<a href="javascript:pickColor('optScreencolor');" class="pick" id="optScreencolorpick" style="background-color: #000000;">&nbsp;&nbsp;&nbsp;</a>
								</td>
							</tr>
						</table>
					</div>
					<div id="opt3_panel" class="panel">
						<table border="0" cellpadding="2" cellspacing="0">
							<tr>
								<td nowrap="nowrap" colspan="2"><strong><?php _e('JW FLV Media Player settings', 'pb-embedflash'); ?> - <?php _e('Display appearance', 'pb-embedflash'); ?></strong></td>
							</tr>
							<tr>
								<td nowrap="nowrap" style="width:100px;"><label for="optLogo">logo:</label></td>
								<td><input type="text" id="optLogo" value="" style="width:330px;" /></td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optOverstretch">overstretch:</label></td>
								<td>
									<input type="checkbox" id="optOverstretch" value="1" />&nbsp;&nbsp;
									<select id="selOverstretch">
										<option value="false" selected="selected">false</option>
										<option value="true">true</option>
									</select>
								</td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optShowicons">showeq:</label></td>
								<td>
									<input type="checkbox" id="optShoweq" value="1" />&nbsp;&nbsp;
									<select id="selShoweq">
										<option value="false" selected="selected">false</option>
										<option value="true">true</option>
									</select>
								</td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optShowicons">showicons:</label></td>
								<td>
									<input type="checkbox" id="optShowicons" value="1" />&nbsp;&nbsp;
									<select id="selShowicons">
										<option value="true" selected="selected">true</option>
										<option value="false">false</option>
									</select>
								</td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optTransition">transition:</label></td>
								<td>
									<input type="checkbox" id="optTransition" value="1" />&nbsp;&nbsp;
									<select id="selTransition">
										<option value="random" selected="selected">random</option>
										<option value="fade">fade</option>
										<option value="bgfade">bgfade</option>
										<option value="blocks">blocks</option>
										<option value="bubbles">bubbles</option>
										<option value="circles">circles</option>
										<option value="flash">flash</option>
										<option value="fluids">fluids</option>
										<option value="lines">lines</option>
										<option value="slowfade">slowfade</option>
									</select>
								</td>
							</tr>
						</table>
					</div>
					<div id="opt4_panel" class="panel">
						<table border="0" cellpadding="2" cellspacing="0">
							<tr>
								<td nowrap="nowrap" colspan="4"><strong><?php _e('JW FLV Media Player settings', 'pb-embedflash'); ?> - <?php _e('Controlbar appearance', 'pb-embedflash'); ?></strong></td>
							</tr>
							<tr>
								<td nowrap="nowrap" style="width:100px;"><label for="optShownavigation">shownavigation:</label></td>
								<td>
									<input type="checkbox" id="optShownavigation" value="1" />&nbsp;&nbsp;
									<select id="selShownavigation">
										<option value="true" selected="selected">true</option>
										<option value="false">false</option>
									</select>
								</td>
								
								<td nowrap="nowrap"><label for="optShowdownload">&nbsp;showdownload:</label></td>
								<td>
									<input type="checkbox" id="optShowdownload" value="1" />&nbsp;&nbsp;
									<select id="selShowdownload">
										<option value="false" selected="selected">false</option>
										<option value="true">true</option>
									</select>
								</td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optShowstop">showstop:</label></td>
								<td>
									<input type="checkbox" id="optShowstop" value="1" />&nbsp;&nbsp;
									<select id="selShowstop">
										<option value="false" selected="selected">false</option>
										<option value="true">true</option>
									</select>
								</td>
								
								<td nowrap="nowrap"><label for="optUsefullscreen">&nbsp;usefullscreen:</label></td>
								<td>
									<input type="checkbox" id="optUsefullscreen" value="1" />&nbsp;&nbsp;
									<select id="selUsefullscreen">
										<option value="true" selected="selected">true</option>
										<option value="false">false</option>
									</select>
								</td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optShowdigits">showdigits:</label></td>
								<td colspan="3">
									<input type="checkbox" id="optShowdigits" value="1" />&nbsp;&nbsp;
									<select id="selShowdigits">
										<option value="true" selected="selected">true</option>
										<option value="false">false</option>
									</select>
								</td>
							</tr>
						</table>
					</div>
					<div id="opt5_panel" class="panel">
						<table border="0" cellpadding="2" cellspacing="0">
							<tr>
								<td nowrap="nowrap" colspan="2"><strong><?php _e('JW FLV Media Player settings', 'pb-embedflash'); ?> - <?php _e('Playlist appearance', 'pb-embedflash'); ?></strong></td>
							</tr>
							<tr>
								<td nowrap="nowrap" style="width:100px;"><label for="optAutoscroll">autoscroll:</label></td>
								<td>
									<input type="checkbox" id="optAutoscroll" value="1" />&nbsp;&nbsp;
									<select id="selAutoscroll">
										<option value="false" selected="selected">false</option>
										<option value="true">true</option>
									</select>
								</td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optDisplayheight">displayheight:</label></td>
								<td><input type="text" id="optDisplayheight" value="" style="width:330px;" /></td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optDisplaywidth">displaywidth:</label></td>
								<td><input type="text" id="optDisplaywidth" value="" style="width:330px;" /></td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optThumbsinplaylist">thumbsinplaylist:</label></td>
								<td>
									<input type="checkbox" id="optThumbsinplaylist" value="1" />&nbsp;&nbsp;
									<select id="selThumbsinplaylist">
										<option value="false" selected="selected">false</option>
										<option value="true">true</option>
									</select>
								</td>
							</tr>
						</table>
					</div>
					<div id="opt6_panel" class="panel">
						<table border="0" cellpadding="2" cellspacing="0">
							<tr>
								<td nowrap="nowrap" colspan="4"><strong><?php _e('JW FLV Media Player settings', 'pb-embedflash'); ?> - <?php _e('Playback behaviour', 'pb-embedflash'); ?></strong></td>
							</tr>
							<tr>
								<td nowrap="nowrap" style="width:80px;"><label for="optAudio">audio:</label></td>
								<td colspan="3"><input type="text" id="optAudio" value="" style="width:350px;"/></td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optAutostart">autostart:</label></td>
								<td>
									<input type="checkbox" id="optAutostart" value="1" />&nbsp;&nbsp;
									<select id="selAutostart">
										<option value="false" selected="selected">false</option>
										<option value="true">true</option>
									</select>
								</td>
								
								<td nowrap="nowrap"><label for="optRotatetime">&nbsp;rotatetime:</label></td>
								<td><input type="text" id="optRotatetime" value="" style="width:135px;" /></td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optBufferlength">bufferlength:</label></td>
								<td><input type="text" id="optBufferlength" value="" style="width:135px;" /></td>

								<td nowrap="nowrap"><label for="optShuffle">&nbsp;shuffle:</label></td>
								<td>
									<input type="checkbox" id="optShuffle" value="1" />&nbsp;&nbsp;
									<select id="selShuffle">
										<option value="true" selected="selected">true</option>
										<option value="false">false</option>
									</select>
								</td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optCaptions">captions:</label></td>
								<td><input type="text" id="optCaptions" value="" style="width:135px;" /></td>
								
								<td nowrap="nowrap"><label for="optSmoothing">&nbsp;smoothing:</label></td>
								<td>
									<input type="checkbox" id="optSmoothing" value="1" />&nbsp;&nbsp;
									<select id="selSmoothing">
										<option value="true" selected="selected">true</option>
										<option value="false">false</option>
									</select>
								</td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optFallback">fallback:</label></td>
								<td><input type="text" id="optFallback" value="" style="width:135px;" /></td>

								<td nowrap="nowrap"><label for="optVolume">&nbsp;volume:</label></td>
								<td><input type="text" id="optVolume" value="" style="width:135px;" /></td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optRepeat">repeat:</label></td>
								<td>
									<input type="checkbox" id="optRepeat" value="1" />&nbsp;&nbsp;
									<select id="selRepeat">
										<option value="false" selected="selected">false</option>
										<option value="true">true</option>
									</select>
								</td>
								<td nowrap="nowrap"><label for="optRepeat">&nbsp;</label></td>
								<td>
									&nbsp;&nbsp;
								</td>
							</tr>
						</table>
					</div>
					<div id="opt7_panel" class="panel">
						<table border="0" cellpadding="2" cellspacing="0">
							<tr>
								<td nowrap="nowrap" colspan="4"><strong><?php _e('JW FLV Media Player settings', 'pb-embedflash'); ?> - <?php _e('External communication', 'pb-embedflash'); ?></strong></td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optCallback">callback:</label></td>
								<td><input type="text" id="optCallback" value="" style="width:135px;" /></td>

								<td nowrap="nowrap"><label for="optLinktarget">&nbsp;linktarget:</label></td>
								<td><input type="text" id="optLinktarget" value="" style="width:135px;" /></td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optEnablejs">enablejs:</label></td>
								<td>
									<input type="checkbox" id="optEnablejs" value="1" />&nbsp;&nbsp;
									<select id="selEnablejs">
										<option value="false" selected="selected">false</option>
										<option value="true">true</option>
									</select>
								</td>

								<td nowrap="nowrap"><label for="optRecommendations">&nbsp;recommen-<br />&nbsp;dations:</label></td>
								<td><input type="text" id="optRecommendations" value="" style="width:135px;" /></td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optJavascriptid">javascriptid:</label></td>
								<td><input type="text" id="optJavascriptid" value="" style="width:135px;" /></td>

								<td nowrap="nowrap"><label for="optStreamscript">&nbsp;streamscript:</label></td>
								<td><input type="text" id="optStreamscript" value="" style="width:135px;" /></td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optLink">link:</label></td>
								<td><input type="text" id="optLink" value="" style="width:135px;" /></td>

								<td nowrap="nowrap"><label for="optType">&nbsp;type:</label></td>
								<td>
									<input type="checkbox" id="optType" value="1" />&nbsp;&nbsp;
									<select id="selType">
										<option value="flv" selected="selected">flv</option>
										<option value="mp3">mp3</option>
										<option value="rtmp">rtmp</option>
										<option value="jpg">jpg</option>
										<option value="png">png</option>
										<option value="gif">gif</option>
										<option value="swf">swf</option>
									</select>
								</td>
							</tr>
							<tr>
								<td nowrap="nowrap"><label for="optLinkfromdisplay">linkfrom-<br />display:</label></td>
								<td colspan="3">
									<input type="checkbox" id="optLinkfromdisplay" value="1" />&nbsp;&nbsp;
									<select id="selLinkfromdisplay">
										<option value="false" selected="selected">false</option>
										<option value="true">true</option>
									</select>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<small>
					<span style="float: left;"><?php _e('Use this to overwrite the values defined in <em>Settings/pb-embedFlash</em>', 'pb-embedflash'); ?></span>
					<a href="http://www.jeroenwijering.com/?item=Supported_Flashvars" style="float: right;" target="_blank">Flashvars</a>
				</small>
			</div>
			<!-- options panel -->
		</div>

		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" id="cancel" name="cancel" value="<?php _e('Cancel', 'pb-embedflash'); ?>" onclick="tinyMCEPopup.close();" />
			</div>
			<div style="float: right">
				<input type="submit" id="insert" name="insert" value="<?php _e('Insert', 'pb-embedflash'); ?>" onclick="insertFlashCode();" />
			</div>
		</div>
	</form>
</body>
</html>