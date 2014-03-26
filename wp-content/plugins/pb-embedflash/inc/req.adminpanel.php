<?php
/*
Part of pb-embedFlash v1.5
© Pascal Berkhahn, <novayuna@googlemail.com>, http://pascal-berkhahn.de
*/
if (!function_exists('get_option')) { echo "Please don't load this file directly."; exit; }

$pbef_options = pbef_options();
if (isset($_POST['update-pbef']))
{
	foreach ($_POST as $key => $option)
	{
		if (isset($_POST[$key]) && $key != 'update-pbef')
		{
			$k = explode('_', $key);
			$pbef_options[$k[0]][$k[1]] = ($option == '') ? null : stripslashes($option);
		}
	}
	update_option('pb_embedFlash', $pbef_options);
	?><div class="updated fade"><p><strong><?php _e('Settings updated.', 'pb-embedflash');?></strong></p></div><?php
}
?><link rel="stylesheet" type="text/css" href="<?php echo PBEF_SITEPATH; ?>/css/admin.css" />
<style type="text/css" media="screen">a.bg{background: no-repeat;padding-left: 20px;border: 0 none;}
a.linkauthor{background-image: url('<?php echo get_option('siteurl'); ?>/?pbef_resource=author.png');}
a.linkwp{background-image: url('<?php echo get_option('siteurl'); ?>/?pbef_resource=wordpress.png');}</style>
<script type="text/javascript">// <![CDATA[
	function toggleDisplay(itm) {
		var display; var img;
		if (document.getElementById(itm).style.display == 'block') { display = 'none'; img = 'plus'  } else { display = 'block'; img = 'minus' }
		if (document.getElementById(itm)) { document.getElementById(itm).style.display = display; }
		if (document.getElementById('timg_'+itm) != undefined) { document.getElementById('timg_'+itm).src = '<?php echo PBEF_SITEPATH; ?>/css/images/toggle_'+img+'.png'; document.getElementById('timg_'+itm).alt = img; }		
		if (document.forms[0].elements['apd_'+itm] != undefined) { document.forms[0].elements['apd_'+itm].value = display; }
	};
	function setValue(itm, val) {
		if (document.getElementById(itm).value != val) { document.getElementById(itm).value = val }
	};
	function toggleChooseDisableLoad(itm, status) {
		if (document.getElementById(itm+'_yes')) { document.getElementById(itm+'_yes').disabled = status; }
		if (document.getElementById(itm+'_no')) { document.getElementById(itm+'_no').disabled = status; }
		if (status == true && document.getElementById('sbframework_no')) { document.getElementById('sbframework_no').checked = true; }
	};
// ]]></script>
<script type="text/javascript" src="<?php echo PBEF_SITEPATH; ?>/js/colorpicker.js"></script>

<div class="wrap" style="font-size:100% !important;">
	<h2>pb-embedFlash</h2>
<?php if (isset($_GET['mediamanager']) || $mm == true) {
	require(PBEF_PATH.'/inc/inc.mediamanager.php');
} else { ?>	
	<div id="poststuff" class="metabox-holder">
		<div id="side-info-column" class="inner-sidebar" style="width: 220px;">
			<div id="side-sortables" class="meta-box-sortables" style="position: relative; font-size:12px !important;">
				<div id="pbef_links" class="postbox">
					<!-- <div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br /></div> -->
					<h3 class="hndle"><span><?php _e('Menu', 'pb-embedflash'); ?></span></h3>
					<div class="inside">
						&raquo; <a href="<?php echo PBEF_ADMINPATH; ?>"><?php _e('Settings', 'pb-embedflash'); ?></a>
						<br />&raquo; <?php _e('Media manager', 'pb-embedflash'); ?>
						<br />&nbsp;&nbsp;&raquo; <a href="<?php echo PBEF_ADMINPATH; ?>&amp;mediamanager=media"><?php _e('Manage media', 'pb-embedflash'); ?></a>
						<br />&nbsp;&nbsp;&raquo; <a href="<?php echo PBEF_ADMINPATH; ?>&amp;mediamanager=playlists"><?php _e('Manage playlists', 'pb-embedflash'); ?></a>
					</div>
				</div>
				<div id="pbef_links" class="postbox">
					<!-- <div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br /></div> -->
					<h3 class="hndle"><span><?php _e('About this plugin', 'pb-embedflash'); ?></span></h3>
					<div class="inside">
						<strong>pb-embedFlash</strong>
						<br /><?php _e('by', 'pb-embedflash'); ?> <em>Pascal Berkhahn</em>
						<br /><?php _e('Version', 'pb-embedflash'); ?>: <?php echo PBEF_VERSION; ?>
						<div style="line-height:150% !important">
							<a href="http://wordpress.org/extend/plugins/pb-embedflash/" class="bg linkwp"><?php _e('Plugin site', 'pb-embedflash'); ?></a>
							<br /><a href="http://pascal-berkhahn.de/" class="bg linkauthor"><?php _e('Author', 'pb-embedflash'); ?></a>
							<br /><a href="http://wordpress.org/tags/pb-embedflash?forum_id=10#postform" class="bg linkwp"><?php _e('Post bugs or questions', 'pb-embedflash'); ?></a>
						</div>
					</div>
				</div>
				<div id="pbef_donation" class="postbox">
					<!-- <div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br /></div> -->
					<h3 class="hndle"><span><?php _e('Donate', 'pb-embedflash'); ?></span></h3>
					<div class="inside" style="text-align: center;">
						<a href="javascript:document.getElementById('donate_form').submit();"><img src="<?php echo get_option('siteurl'); ?>/?pbef_resource=paypal.png" alt="PayPal Donation" style="border: 0px;" /></a>
						<br /><span><small><?php _e('Thanks for your support!', 'pb-embedflash'); ?></small></span>
					</div>
				</div>
				<div id="pbef_save" class="postbox">
					<!-- <div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br /></div> -->
					<h3 class="hndle"><span><?php _e('Save', 'pb-embedflash'); ?></span></h3>
					<div class="inside" style="text-align: center;">
						<input type="button" class="button" name="update-pbef" onclick="document.pbef_ap.submit();" value="<?php _e('Save', 'pb-embedflash'); ?> &raquo;" />
					</div>
				</div>
			</div>
		</div>
		<div id="post-body" class="has-sidebar" style="margin-right: -220px">
			<div id="post-body-content" class="has-sidebar-content" style="margin-right: 230px">
				<div id="normal-sortables" class="meta-box-sortables" style="position: relative;">
				<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" name="pbef_ap" method="post">				
					<div id="pbef_choose" class="postbox">
						<!-- <div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br /></div> -->
						<h3 class="hndle"><span><?php _e('Please choose the method how to embed your flash content', 'pb-embedflash'); ?></span></h3>
						<div class="inside">
							<?php _e('There are currently four options of embedding flash content supported by this plugin:<ul><li>The &lt;object&gt; tag is the safest way because it embeds your flash content in valid XHTML Strict code directly into the source code of the file.</li><li>SWFObject is a JavaScript class, so JavaScript has to be supported and enabled by the browser.</li><li>Shadowbox displays any content like Lightbox does with images: fading out the other content and showing the flash in the middle of the screen.</li><li>Popup just pops up :)</li></ul>', 'pb-embedflash'); ?>
							<input class="radio" type="radio" id="method_objecttag" name="main_method" value="0"<?php if ($pbef_options['main']['method'] == 0) { echo ' checked="checked"'; }?> />
							<label for="method_objecttag"><?php _e('&lt;object&gt; tag', 'pb-embedflash'); ?></label>
							<br />
							<input class="radio" type="radio" id="method_swfobject" name="main_method" value="1"<?php if ($pbef_options['main']['method'] == 1) { echo ' checked="checked"'; }?> />
							<label for="method_swfobject"><?php _e('SWFObject (JavaScript)', 'pb-embedflash'); ?></label>
							&nbsp;&nbsp;&nbsp;&nbsp;
							<input class="radio" type="radio" id="method_swfobjectieonly" name="main_method" value="2"<?php if ($pbef_options['main']['method'] == 2) { echo ' checked="checked"'; }?> />
							<label for="method_swfobjectieonly"><?php _e('SWFObject only on the Internet Explorer (JavaScript)', 'pb-embedflash'); ?></label>
							<br />
							<input class="radio" type="radio" id="method_shadowbox" name="main_method" value="3"<?php if ($pbef_options['main']['method'] == 3) { echo ' checked="checked"'; }?> />
							<label for="method_shadowbox"><?php _e('Shadowbox (JavaScript)', 'pb-embedflash'); ?></label>
							<br />
							<input class="radio" type="radio" id="method_popup" name="main_method" value="4"<?php if ($pbef_options['main']['method'] == 4) { echo ' checked="checked"'; }?> />
							<label for="method_popup"><?php _e('Popup (JavaScript)', 'pb-embedflash'); ?></label>
						</div>
					</div>
					<div id="pbef_main" class="postbox">
						<!-- <div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br /></div> -->
						<h3 class="hndle"><span><?php _e('Main options', 'pb-embedflash'); ?></span></h3>
						<div class="inside">
							<?php _e('Here you can set the default values used for embedding falsh content:', 'pb-embedflash'); ?>
							<br /><br />
							<label for="playerurl" class="blocktext"><?php _e('URL to mediaplayer.swf:', 'pb-embedflash'); ?></label>&nbsp;
							<input type="text" id="playerurl" class="textfield" name="main_playerurl" value="<?php echo $pbef_options['main']['playerurl']; ?>" />
							<small><a href="javascript:setValue('playerurl', '<?php echo PBEF_SITEPATH; ?>/swf/mediaplayer.swf')" title="<?php echo PBEF_SITEPATH; ?>/swf/mediaplayer.swf"><?php _e('default', 'pb-embedflash'); ?></a></small><br />
							
							<label for="swfobjecturl" class="blocktext"><?php _e('URL to swfobject.js:', 'pb-embedflash'); ?></label>&nbsp;
							<input type="text" id="swfobjecturl" class="textfield" name="main_swfobjecturl" value="<?php echo $pbef_options['main']['swfobjecturl']; ?>" />
							<small><a href="javascript:setValue('swfobjecturl', '<?php echo PBEF_SITEPATH; ?>/js/swfobject.js')" title="<?php echo PBEF_SITEPATH; ?>/js/swfobject.js"><?php _e('default', 'pb-embedflash'); ?></a></small><br />

							<label for="shadowboxurl" class="blocktext"><?php _e('URL to shadowbox.js:', 'pb-embedflash'); ?></label>&nbsp;
							<input type="text" id="shadowboxurl" class="textfield" name="main_shadowboxurl" value="<?php echo $pbef_options['main']['shadowboxurl']; ?>" />
							<small><a href="javascript:setValue('shadowboxurl', '<?php echo PBEF_SITEPATH; ?>/js/shadowbox.js')" title="<?php echo PBEF_SITEPATH; ?>/js/shadowbox.js"><?php _e('default', 'pb-embedflash'); ?></a></small><br />

							<label for="shadowboxcssurl" class="blocktext"><?php _e('URL to shadowbox.css:', 'pb-embedflash'); ?></label>&nbsp;
							<input type="text" id="shadowboxcssurl" class="textfield" name="main_shadowboxcssurl" value="<?php echo $pbef_options['main']['shadowboxcssurl']; ?>" />
							<small><a href="javascript:setValue('shadowboxcssurl', '<?php echo PBEF_SITEPATH; ?>/css/shadowbox.css')" title="<?php echo PBEF_SITEPATH; ?>/css/shadowbox.css"><?php _e('default', 'pb-embedflash'); ?></a></small><br />

							<label for="popupurl" class="blocktext"><?php _e('URL to popup.js:', 'pb-embedflash'); ?></label>&nbsp;
							<input type="text" id="popupurl" class="textfield" name="main_popupurl" value="<?php echo $pbef_options['main']['popupurl']; ?>" />
							<small><a href="javascript:setValue('popupurl', '<?php echo PBEF_SITEPATH; ?>/js/popup.js')" title="<?php echo PBEF_SITEPATH; ?>/js/popup.js"><?php _e('default', 'pb-embedflash'); ?></a></small><br />

							<label for="defwidth" class="blocktext"><?php _e('Default width:', 'pb-embedflash'); ?></label>&nbsp;
							<input type="text" id="defwidth" class="textfield" name="main_defwidth" value="<?php echo $pbef_options['main']['defwidth']; ?>" />
							<small><a href="javascript:setValue('defwidth', '425')" title="425"><?php _e('default', 'pb-embedflash'); ?></a></small><br />

							<label for="defheight" class="blocktext"><?php _e('Default height:', 'pb-embedflash'); ?></label>&nbsp;
							<input type="text" id="defheight" class="textfield" name="main_defheight" value="<?php echo $pbef_options['main']['defheight']; ?>" />
							<small><a href="javascript:setValue('defheight', '355')" title="355"><?php _e('default', 'pb-embedflash'); ?></a></small><br />

							<label for="defclass" class="blocktext"><?php _e('Default class:', 'pb-embedflash'); ?></label>&nbsp;
							<input type="text" id="defclass" class="textfield" name="main_defclass" value="<?php echo $pbef_options['main']['defclass']; ?>" />
							<small><a href="javascript:setValue('defclass', 'embedflash')" title="embedflash"><?php _e('default', 'pb-embedflash'); ?></a></small><br />

							<acronym title="<?php _e('Set to No if you want to keep all settings (e.g. for updating).', 'pb-embedflash'); ?>"><?php _e('Delete settings, media and playlists on plugin deactivation?', 'pb-embedflash'); ?></acronym>
							<br />
							<input class="radio" type="radio" id="deleteoptionsondeactivation_yes" name="main_deleteoptionsondeactivation" value="1"<?php if ($pbef_options['main']['deleteoptionsondeactivation'] == 1) { echo ' checked="checked"'; }?> />
							<label for="deleteoptionsondeactivation_yes"><?php _e('Yes', 'pb-embedflash'); ?></label>
							&nbsp;&nbsp;&nbsp;&nbsp;
							<input class="radio" type="radio" id="deleteoptionsondeactivation_no" name="main_deleteoptionsondeactivation" value="0"<?php if ($pbef_options['main']['deleteoptionsondeactivation'] == 0) { echo ' checked="checked"'; }?> />
							<label for="deleteoptionsondeactivation_no"><?php _e('No', 'pb-embedflash'); ?></label>
						</div>
					</div>
					<div id="pbef_messages" class="postbox">
						<!-- <div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br /></div> -->
						<h3 class="hndle"><span><?php _e('Messages', 'pb-embedflash'); ?></span></h3>
						<div class="inside">
							<?php _e('Overwrite default messages.', 'pb-embedflash'); ?>
							<br /><br />
							<label for="msg_nojs" class="blocktext"><?php _e('Message if JavaScript is deactivated', 'pb-embedflash'); ?>:</label>&nbsp;
							<input type="text" id="msg_nojs" class="textfield" name="messages_nojs" value="<?php echo htmlspecialchars($pbef_options['messages']['nojs']); ?>" />
							<small><a href="javascript:setValue('msg_nojs', '<?php echo htmlspecialchars(__('Either JavaScript is not active or you are using an old version of Adobe Flash Player. <a href="http://www.adobe.com/de/">Please install the newest Flash Player</a>.', 'pb-embedflash')); ?>')" title="<?php echo htmlspecialchars(__('Either JavaScript is not active or you are using an old version of Adobe Flash Player. <a href="http://www.adobe.com/de/">Please install the newest Flash Player</a>.', 'pb-embedflash')); ?>"><?php _e('default', 'pb-embedflash'); ?></a></small><br />

							<label for="msg_openarticle" class="blocktext"><?php _e('Message for feeds and search results', 'pb-embedflash'); ?>:</label>&nbsp;
							<input type="text" id="msg_openarticle" class="textfield" name="messages_openarticle" value="<?php echo htmlspecialchars($pbef_options['messages']['openarticle']); ?>" />
							<small><a href="javascript:setValue('msg_openarticle', '<?php echo htmlspecialchars(__('Please open the article to see the flash file or player.', 'pb-embedflash')); ?>')" title="<?php echo htmlspecialchars(__('Please open the article to see the flash file or player.', 'pb-embedflash')); ?>"><?php _e('default', 'pb-embedflash'); ?></a></small><br />

							<br />
							<?php _e('Use preview image defined for JW FLV Media Player (f={image=...}) as alternative content for disabled JavaScript?', 'pb-embedflash'); ?>
							<br />
							<input class="radio" type="radio" id="usepreviewimageasalternativemessage_yes" name="messages_usepreviewimageasalternativemessage" value="1"<?php if ($pbef_options['messages']['usepreviewimageasalternativemessage'] == 1) { echo ' checked="checked"'; }?> />
							<label for="deleteoptionsondeactivation_yes"><?php _e('Yes', 'pb-embedflash'); ?></label>
							&nbsp;&nbsp;&nbsp;&nbsp;
							<input class="radio" type="radio" id="usepreviewimageasalternativemessage_no" name="messages_usepreviewimageasalternativemessage" value="0"<?php if ($pbef_options['messages']['usepreviewimageasalternativemessage'] == 0) { echo ' checked="checked"'; }?> />
							<label for="deleteoptionsondeactivation_no"><?php _e('No', 'pb-embedflash'); ?></label>
						</div>
					</div>
					<div id="pbef_shadowbox" class="postbox">
						<!-- <div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br /></div> -->
						<h3 class="hndle"><span><?php _e('Shadowbox &amp; Popup', 'pb-embedflash'); ?></span></h3>
						<div class="inside">
							<?php _e('Shadowbox can display likely any content inside an overlay. It is fully compatible to Lightbox!', 'pb-embedflash'); ?>
							<br /><br />

							<div style="width: 300px;">
								<label><?php _e("Load Shadowbox by default even if there is no flash content displayed, e.g. to make it available for gallery plugins?", 'pb-embedflash'); ?></label>
								<br /><br />
								<input class="radio" type="radio" id="method_shadowbox_yes" name="main_shadowbox" value="1"<?php if ($pbef_options['main']['shadowbox'] == 1) { echo ' checked="checked"'; } ?> />
								<label for="method_shadowbox_yes"><?php _e('Yes', 'pb-embedflash'); ?></label>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<input class="radio" type="radio" id="method_shadowbox_no" name="main_shadowbox" value="0"<?php if ($pbef_options['main']['shadowbox'] == 0) { echo ' checked="checked"'; } ?> />
								<label for="method_shadowbox_no"><?php _e('No', 'pb-embedflash'); ?></label>
							</div>
							<br />
							<div style="width: 300px;float: left;">
								<label for="sbadapter"><?php _e('Choose the JavaScript framework to use with Shadowbox:', 'pb-embedflash'); ?></label>
								<br /><br />
								<select class="textfield" id="sbadapter" name="main_sbadapter">
										<option value="jquery"<?php if ($pbef_options['main']['sbadapter'] == 'jquery') { echo ' selected="selected"'; }?> onclick="toggleChooseDisableLoad('sbframework', false);">jQuery (default) *</option>
										<!--<option value="prototype"<?php if ($pbef_options['main']['sbadapter'] == 'prototype') { echo ' selected="selected"'; }?> onclick="toggleChooseDisableLoad('sbframework', false);">prototype *</option>
-->										<option value="mootools"<?php if ($pbef_options['main']['sbadapter'] == 'mootools') { echo ' selected="selected"'; }?> onclick="toggleChooseDisableLoad('sbframework', false);">mootools **</option>
										<option value="dojo"<?php if ($pbef_options['main']['sbadapter'] == 'dojo') { echo ' selected="selected"'; }?> onclick="toggleChooseDisableLoad('sbframework', true);">Dojo</option>
										<option value="ext"<?php if ($pbef_options['main']['sbadapter'] == 'ext') { echo ' selected="selected"'; }?> onclick="toggleChooseDisableLoad('sbframework', true);">Ext</option>
										<option value="yui"<?php if ($pbef_options['main']['sbadapter'] == 'yui') { echo ' selected="selected"'; }?> onclick="toggleChooseDisableLoad('sbframework', true);">YahooUI</option>
								</select>
								<br /><small>* <?php _e('included within WordPress', 'pb-embedflash'); ?></small>
								<br /><small>** <?php _e('included within pb-embedFlash', 'pb-embedflash'); ?></small>
								<br /><br />
							</div>

							<div style="width: 300px;float: right;">
								<label><?php _e('Load JavaScript framework with Shadowbox? (Choose "No" if another plugin already loads it.)', 'pb-embedflash'); $included = array('jquery', 'prototype', 'mootools');?></label>
								<br /><br />
								<input class="radio" type="radio" id="sbframework_no" name="main_sbframework" value="0"<?php if (array_search($pbef_options['main']['sbadapter'], $included) === false) { echo ' disabled="disabled"';} if ($pbef_options['main']['sbframework'] == 0) { echo ' checked="checked"'; } ?> />
								<label for="sbframework_no"><?php _e('No', 'pb-embedflash'); ?></label>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<input class="radio" type="radio" id="sbframework_yes" name="main_sbframework" value="1"<?php if (array_search($pbef_options['main']['sbadapter'], $included) === false) { echo ' disabled="disabled"';} if ($pbef_options['main']['sbframework'] == 1) { echo ' checked="checked"'; } ?> />
								<label for="sbframework_yes"><?php _e('Yes', 'pb-embedflash'); ?></label>
								<br /><br />
							</div>
							<div style="clear: both;">
								<img id="timg_sboxoptions" src="<?php echo PBEF_SITEPATH.'/css/images/toggle_plus.png' ?>" alt="plus">
								<a href="javascript:toggleDisplay('sboxoptions')"><strong><?php _e('Shadowbox settings', 'pb-embedflash'); ?></strong></a>
								<br />
								<div id="sboxoptions" style="display: none">
									<label class="blocktext indent" for="sbox-cancel">cancel:</label>
									<input type="text" class="textfield" style="width: 320px" id="sbox-cancel" name="shadowboxtexts_cancel" value="<?php echo $pbef_options['shadowboxtexts']['cancel']; ?>" />
									<small><a href="javascript:setValue('sbox-cancel', '<?php _e('Cancel', 'pb-embedflash'); ?>');" title="<?php _e('Cancel', 'pb-embedflash'); ?>"><?php _e('default', 'pb-embedflash'); ?></a></small>
									<br />

									<label class="blocktext indent" for="sbox-loading">loading:</label>
									<input type="text" class="textfield" style="width: 320px" id="sbox-loading" name="shadowboxtexts_loading" value="<?php echo $pbef_options['shadowboxtexts']['loading']; ?>" />
									<small><a href="javascript:setValue('sbox-loading', '<?php _e('loading', 'pb-embedflash'); ?>');" title="<?php _e('loading', 'pb-embedflash'); ?>"><?php _e('default', 'pb-embedflash'); ?></a></small>
									<br />

									<label class="blocktext indent" for="sbox-loadingImage">loadingImage:</label>
									<input type="text" class="textfield" style="width: 320px" id="sbox-loadingImage" name="shadowboxoptions_loadingImage" value="<?php echo $pbef_options['shadowboxoptions']['loadingImage']; ?>" />
									<small><a href="javascript:setValue('sbox-loadingImage', '<?php echo PBEF_SITEPATH; ?>/css/images/loading.gif');" title="<?php echo PBEF_SITEPATH; ?>/css/images/loading.gif"><?php _e('default', 'pb-embedflash'); ?></a></small>
									<br />

									<label class="blocktext indent" for="sbox-close">close &amp; keysClose:</label>
									<input type="text" class="textfield" style="width: 295px" id="sbox-close" name="shadowboxtexts_close" value="<?php echo str_replace('"', '&quot;', $pbef_options['shadowboxtexts']['close']); ?>" />
									<input type="text" class="textfield" style="width: 20px" id="sbox-keysClose" name="shadowboxoptions_keysClose" value="<?php echo $pbef_options['shadowboxoptions']['keysClose']; ?>" maxlength="1" />
									<small><a href="javascript:setValue('sbox-close', '<span class=&quot;shortcut&quot;>C</span>lose');javascript:setValue('sbox-keysClose', 'c');" title="<span class=&quot;shortcut&quot;>C</span>lose"><?php _e('default', 'pb-embedflash'); ?></a></small>
									<br />

									<label class="blocktext indent" for="sbox-prev">prev &amp; keysPrev:</label>
									<input type="text" class="textfield" style="width: 295px" id="sbox-prev" name="shadowboxtexts_prev" value="<?php echo str_replace('"', '&quot;', $pbef_options['shadowboxtexts']['prev']); ?>" />
									<input type="text" class="textfield" style="width: 20px" id="sbox-keysPrev" name="shadowboxoptions_keysPrev" value="<?php echo $pbef_options['shadowboxoptions']['keysPrev']; ?>" maxlength="1" />
									<small><a href="javascript:setValue('sbox-prev', '<span class=&quot;shortcut&quot;>P</span>revious');javascript:setValue('sbox-keysPrev', 'p');" title="<span class=&quot;shortcut&quot;>P</span>revious"><?php _e('default', 'pb-embedflash'); ?></a></small>
									<br />

									<label class="blocktext indent" for="sbox-next">next &amp; keysNext:</label>
									<input type="text" class="textfield" style="width: 295px" id="sbox-next" name="shadowboxtexts_next" value="<?php echo str_replace('"', '&quot;', $pbef_options['shadowboxtexts']['next']); ?>" />
									<input type="text" class="textfield" style="width: 20px" id="sbox-keysNext" name="shadowboxoptions_keysNext" value="<?php echo $pbef_options['shadowboxoptions']['keysNext']; ?>" maxlength="1" />
									<small><a href="javascript:setValue('sbox-next', '<span class=&quot;shortcut&quot;>N</span>ext');javascript:setValue('sbox-keysNext', 'n');" title="<span class=&quot;shortcut&quot;>N</span>ext"><?php _e('default', 'pb-embedflash'); ?></a></small>
									<br />
									
									<label class="blocktext indent" for="sbox-enableKeys">enableKeys:</label>
									<select class="textfield" id="sbox-enableKeys" name="shadowboxoptions_enableKeys" style="width: 330px">
										<option value="true"<?php if ($pbef_options['shadowboxoptions']['enableKeys'] == 'true') { echo ' selected="selected"'; }?>>true (default)</option>
										<option value="false"<?php if ($pbef_options['shadowboxoptions']['enableKeys'] == 'false') { echo ' selected="selected"'; }?>>false</option>
									</select>
									<br />
									
									<label class="blocktext indent" for="sbox-handleLgImages">handleLgImages:</label>
									<select class="textfield" id="sbox-handleLgImages" name="shadowboxoptions_handleLgImages" style="width: 330px">
										<option value="resize"<?php if ($pbef_options['shadowboxoptions']['handleLgImages'] == 'resize') { echo ' selected="selected"'; }?>>resize (default)</option>
										<option value="drag"<?php if ($pbef_options['shadowboxoptions']['handleLgImages'] == 'drag') { echo ' selected="selected"'; }?>>drag</option>
										<option value="none"<?php if ($pbef_options['shadowboxoptions']['handleLgImages'] == 'none') { echo ' selected="selected"'; }?>>none</option>
										</select>
									<br />

									<label class="blocktext indent" for="sbox-animate">animate:</label>
									<select class="textfield" id="sbox-animate" name="shadowboxoptions_animate" style="width: 330px">
										<option value="true"<?php if ($pbef_options['shadowboxoptions']['animate'] == 'true') { echo ' selected="selected"'; }?>>true (default)</option>
										<option value="false"<?php if ($pbef_options['shadowboxoptions']['animate'] == 'false') { echo ' selected="selected"'; }?>>false</option>
									</select>
									<br />

									<label class="blocktext indent" for="sbox-animSequence">animSequence:</label>
									<select class="textfield" id="sbox-animSequence" name="shadowboxoptions_animSequence" style="width: 330px">
										<option value="wh"<?php if ($pbef_options['shadowboxoptions']['animSequence'] == 'wh') { echo ' selected="selected"'; }?>>wh (default)</option>
										<option value="hw"<?php if ($pbef_options['shadowboxoptions']['animSequence'] == 'hw') { echo ' selected="selected"'; }?>>hw</option>
										<option value="sync"<?php if ($pbef_options['shadowboxoptions']['animSequence'] == 'sync') { echo ' selected="selected"'; }?>>sync</option>
									</select>
									<br />

									<label class="blocktext indent" for="sbox-overlayColor">overlayColor:</label>
									<input type="text" class="textfield" style="width: 320px" id="sbox-overlayColor" name="shadowboxoptions_overlayColor" value="<?php echo $pbef_options['shadowboxoptions']['overlayColor']; ?>" />
									<small><a href="javascript:setValue('sbox-overlayColor', '#000');" title="#000"><?php _e('default', 'pb-embedflash'); ?></a></small>
									<br />

									<label class="blocktext indent" for="sbox-overlayOpacity">overlayOpacity:</label>
									<input type="text" class="textfield" style="width: 320px" id="sbox-overlayOpacity" name="shadowboxoptions_overlayOpacity" value="<?php echo $pbef_options['shadowboxoptions']['overlayOpacity']; ?>" />
									<small><a href="javascript:setValue('sbox-overlayOpacity', 0.85);" title="0.85"><?php _e('default', 'pb-embedflash'); ?></a></small>
									<br />

									<label class="blocktext indent" for="sbox-listenOverlay">listenOverlay:</label>
									<select class="textfield" id="sbox-listenOverlay" name="shadowboxoptions_listenOverlay" style="width: 330px">
										<option value="true"<?php if ($pbef_options['shadowboxoptions']['listenOverlay'] == 'true') { echo ' selected="selected"'; }?>>true (default)</option>
										<option value="false"<?php if ($pbef_options['shadowboxoptions']['listenOverlay'] == 'false') { echo ' selected="selected"'; }?>>false</option>
									</select>
									<br />

									<label class="blocktext indent" for="sbox-autoplayMovies">autoplayMovies:</label>
									<select class="textfield" id="sbox-autoplayMovies" name="shadowboxoptions_autoplayMovies" style="width: 330px">
										<option value="true"<?php if ($pbef_options['shadowboxoptions']['autoplayMovies'] == 'true') { echo ' selected="selected"'; }?>>true (default)</option>
										<option value="false"<?php if ($pbef_options['shadowboxoptions']['autoplayMovies'] == 'false') { echo ' selected="selected"'; }?>>false</option>
									</select>
									<br />

									<label class="blocktext indent" for="sbox-showMovieControls">showMovieControls:</label>
									<select class="textfield" id="sbox-showMovieControls" name="shadowboxoptions_showMovieControls" style="width: 330px">
										<option value="true"<?php if ($pbef_options['shadowboxoptions']['showMovieControls'] == 'true') { echo ' selected="selected"'; }?>>true (default)</option>
										<option value="false"<?php if ($pbef_options['shadowboxoptions']['showMovieControls'] == 'false') { echo ' selected="selected"'; }?>>false</option>
									</select>
									<br />

									<label class="blocktext indent" for="sbox-resizeDuration">resizeDuration:</label>
									<input type="text" class="textfield" style="width: 320px" id="sbox-resizeDuration" name="shadowboxoptions_resizeDuration" value="<?php echo $pbef_options['shadowboxoptions']['resizeDuration']; ?>" />
									<small><a href="javascript:setValue('sbox-resizeDuration', 0.35);" title="0.35"><?php _e('default', 'pb-embedflash'); ?></a></small>
									<br />

									<label class="blocktext indent" for="sbox-fadeDuration">fadeDuration:</label>
									<input type="text" class="textfield" style="width: 320px" id="sbox-fadeDuration" name="shadowboxoptions_fadeDuration" value="<?php echo $pbef_options['shadowboxoptions']['fadeDuration']; ?>" />
									<small><a href="javascript:setValue('sbox-fadeDuration', 0.35);" title="0.35"><?php _e('default', 'pb-embedflash'); ?></a></small>
									<br />

									<label class="blocktext indent" for="sbox-displayNav">displayNav:</label>
									<select class="textfield" id="sbox-displayNav" name="shadowboxoptions_displayNav" style="width: 330px">
										<option value="true"<?php if ($pbef_options['shadowboxoptions']['displayNav'] == 'true') { echo ' selected="selected"'; }?>>true (default)</option>
										<option value="false"<?php if ($pbef_options['shadowboxoptions']['displayNav'] == 'false') { echo ' selected="selected"'; }?>>false</option>
									</select>
									<br />

									<label class="blocktext indent" for="sbox-continuous">continuous:</label>
									<select class="textfield" id="sbox-continuous" name="shadowboxoptions_continuous" style="width: 330px">
										<option value="false"<?php if ($pbef_options['shadowboxoptions']['continuous'] == 'false') { echo ' selected="selected"'; }?>>false (default)</option>
										<option value="true"<?php if ($pbef_options['shadowboxoptions']['continuous'] == 'true') { echo ' selected="selected"'; }?>>true</option>
									</select>
									<br />

									<label class="blocktext indent" for="sbox-displayCounter">displayCounter:</label>
									<select class="textfield" id="sbox-displayCounter" name="shadowboxoptions_displayCounter" style="width: 330px">
										<option value="true"<?php if ($pbef_options['shadowboxoptions']['displayCounter'] == 'true') { echo ' selected="selected"'; }?>>true (default)</option>
										<option value="false"<?php if ($pbef_options['shadowboxoptions']['displayCounter'] == 'false') { echo ' selected="selected"'; }?>>false</option>
									</select>
									<br />

									<label class="blocktext indent" for="sbox-counterType">counterType:</label>
									<select class="textfield" id="sbox-counterType" name="shadowboxoptions_counterType" style="width: 330px">
										<option value="default"<?php if ($pbef_options['shadowboxoptions']['counterType'] == 'default') { echo ' selected="selected"'; }?>>default</option>
										<option value="skip"<?php if ($pbef_options['shadowboxoptions']['counterType'] == 'skip') { echo ' selected="selected"'; }?>>skip</option>
									</select>
									<br />

									<label class="blocktext indent" for="sbox-viewportPadding">viewportPadding:</label>
									<input type="text" class="textfield" style="width: 320px" id="sbox-viewportPadding" name="shadowboxoptions_viewportPadding" value="<?php echo $pbef_options['shadowboxoptions']['viewportPadding']; ?>" />
									<small><a href="javascript:setValue('sbox-viewportPadding', 20);" title="20"><?php _e('default', 'pb-embedflash'); ?></a></small>
									<br />

									<label class="blocktext indent" for="sbox-initialWidth">initialWidth:</label>
									<input type="text" class="textfield" style="width: 320px" id="sbox-initialWidth" name="shadowboxoptions_initialWidth" value="<?php echo $pbef_options['shadowboxoptions']['initialWidth']; ?>" />
									<small><a href="javascript:setValue('sbox-initialWidth', 320);" title="320"><?php _e('default', 'pb-embedflash'); ?></a></small>
									<br />

									<label class="blocktext indent" for="sbox-initialHeight">initialHeight:</label>
									<input type="text" class="textfield" style="width: 320px" id="sbox-initialHeight" name="shadowboxoptions_initialHeight" value="<?php echo $pbef_options['shadowboxoptions']['initialHeight']; ?>" />
									<small><a href="javascript:setValue('sbox-initialHeight', 160);" title="160"><?php _e('default', 'pb-embedflash'); ?></a></small>
									<br />
								</div>
								<br />
							</div>
							<div style="clear: both;">
								<?php _e('Use a default preview image as link to Shadowbox/the popup instead of text?', 'pb-embedflash'); ?>
								<br />
								<input class="radio" type="radio" id="previewimage_yes" name="flashbox_previewimage" value="1"<?php if ($pbef_options['flashbox']['previewimage'] == 1) { echo ' checked="checked"'; }?> />
								<label for="previewimage_yes"><?php _e('Yes', 'pb-embedflash'); ?></label>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<input class="radio" type="radio" id="previewimage_no" name="flashbox_previewimage" value="0"<?php if ($pbef_options['flashbox']['previewimage'] == 0) { echo ' checked="checked"'; }?> />
								<label for="previewimage_no"><?php _e('No', 'pb-embedflash'); ?></label>

								<br /><br />
								<?php _e('Load preview images from YouTube &amp; GameVideos?', 'pb-embedflash'); ?>
								<br />
								<input class="radio" type="radio" id="loadpreviewimage_yes" name="flashbox_loadpreviewimage" value="1"<?php if ($pbef_options['flashbox']['loadpreviewimage'] == 1) { echo ' checked="checked"'; }?> />
								<label for="loadpreviewimage_yes"><?php _e('Yes', 'pb-embedflash'); ?></label>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<input class="radio" type="radio" id="loadpreviewimage_no" name="flashbox_loadpreviewimage" value="0"<?php if ($pbef_options['flashbox']['loadpreviewimage'] == 0) { echo ' checked="checked"'; }?> />
								<label for="loadpreviewimage_no"><?php _e('No', 'pb-embedflash'); ?></label>

								<br /><br />
								<acronym title="<?php _e('Use this if search results show an excerpt.', 'pb-embedflash'); ?>"><?php _e('Show a message in search results instead of the Shadowbox/popup link?', 'pb-embedflash'); ?></acronym>
								<br />
								<input class="radio" type="radio" id="openarticleatsearchresults_yes" name="flashbox_openarticleatsearchresults" value="1"<?php if ($pbef_options['flashbox']['openarticleatsearchresults'] == 1) { echo ' checked="checked"'; }?> />
								<label for="openarticleatsearchresults_yes"><?php _e('Yes', 'pb-embedflash'); ?></label>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<input class="radio" type="radio" id="openarticleatsearchresults_no" name="flashbox_openarticleatsearchresults" value="0"<?php if ($pbef_options['flashbox']['openarticleatsearchresults'] == 0) { echo ' checked="checked"'; }?> />
								<label for="openarticleatsearchresults_no"><?php _e('No', 'pb-embedflash'); ?></label>

								<br /><br />								
								<label class="blocktext" for="previewimagewidth"><acronym title="<?php _e('You can leave this empty! If you use it, set both width &amp; height.', 'pb-embedflash'); ?>"><?php _e('Default image width:', 'pb-embedflash'); ?></acronym></label>&nbsp;
								<input type="text" class="textfield" id="previewimagewidth" name="flashbox_previewimagewidth" value="<?php echo $pbef_options['flashbox']['previewimagewidth']; ?>" />
								<small><a href="javascript:setValue('previewimagewidth', '')" title="(<?php _e('empty', 'pb-embedflash'); ?>)"><?php _e('default', 'pb-embedflash'); ?></a></small><br />
								
								<label class="blocktext" for="previewimageheight"><acronym title="<?php _e('You can leave this empty! If you use it, set both width &amp; height.', 'pb-embedflash'); ?>"><?php _e('Default image height:', 'pb-embedflash'); ?></label></acronym>&nbsp;
								<input type="text" class="textfield" id="previewimageheight" name="flashbox_previewimageheight" value="<?php echo $pbef_options['flashbox']['previewimageheight']; ?>" />
								<small><a href="javascript:setValue('previewimageheight', '')" title="(<?php _e('empty', 'pb-embedflash'); ?>)"><?php _e('default', 'pb-embedflash'); ?></a></small><br />
								
								<label class="blocktext" for="previewimageurl"><?php _e('Default preview image:', 'pb-embedflash'); ?></label>&nbsp;
								<input type="text" class="textfield" id="previewimageurl" name="flashbox_previewimageurl" value="<?php echo $pbef_options['flashbox']['previewimageurl']; ?>" />
								<small><a href="javascript:setValue('previewimageurl', '<?php echo PBEF_SITEPATH; ?>/css/previewimage.png')" title="<?php echo PBEF_SITEPATH; ?>/css/previewimage.png"><?php _e('default', 'pb-embedflash'); ?></a></small><br />

								<br /><label class="blocktext" for="deflinktext" style="width: 220px;"><?php _e('Default linktext (Shadowbox):', 'pb-embedflash'); ?></label>&nbsp;
								<input type="text" class="textfield" style="width: 320px;" id="deflinktext" name="flashbox_deflinktext" value="<?php echo $pbef_options['flashbox']['deflinktext']; ?>" />
								<small><a href="javascript:setValue('deflinktext', '<?php _e('- Watch the video in an overlay -', 'pb-embedflash'); ?>')" title="<?php _e('- Watch the video in an overlay -', 'pb-embedflash'); ?>"><?php _e('default', 'pb-embedflash'); ?></a></small><br />

								<label class="blocktext" for="defplinktext" style="width: 220px;"><?php _e('Default linktext (Popup):', 'pb-embedflash'); ?></label>&nbsp;
								<input type="text" class="textfield" style="width: 320px;" id="defplinktext" name="flashbox_defplinktext" value="<?php echo $pbef_options['flashbox']['defplinktext']; ?>" />
								<small><a href="javascript:setValue('defplinktext', '<?php _e('- Watch the video in a popup window -', 'pb-embedflash'); ?>')" title="<?php _e('- Watch the video in a popup window -', 'pb-embedflash'); ?>"><?php _e('default', 'pb-embedflash'); ?></a></small>
							</div>
						</div>
					</div>
					<div id="pbef_flashvars" class="postbox">
						<!-- <div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br /></div> -->
						<h3 class="hndle"><span><?php _e('Flashvars', 'pb-embedflash'); ?></span></h3>
						<div class="inside">							
							<?php _e('In this section you can overwrite the default values of the <a href="http://www.jeroenwijering.com/?item=Supported_Flashvars">flashvars</a> supported by the <a href="http://www.jeroenwijering.com/?item=JW_FLV_Media_Player">JW FLV Media Player</a>.Some flashvars are not available in this section for compatibility purposes.Empty fields result in default values.<br /><small>(Inspired by JW\'s <a href="http://www.jeroenwijering.com/?page=wizard&example=91">Setup Wizard</a>)</small>', 'pb-embedflash'); ?>
							<br /><br />
							<div style="display:block;">
								<img id="timg_basics" src="<?php echo PBEF_SITEPATH.'/css/images/toggle_'.(($pbef_options['apd']['basics'] == 'none') ? 'plus' : 'minus').'.png' ?>" alt="<?php echo (($pbef_options['apd']['basics'] == 'none') ? 'plus' : 'minus') ?>">
							<a href="javascript:toggleDisplay('basics')"><?php _e('The basics', 'pb-embedflash'); ?></a>
								<div id="basics" style="display: <?php echo $pbef_options['apd']['basics'] ?>;"><input type="hidden" name="apd_basics" value="<?php echo $pbef_options['apd']['basics'] ?>" />
									<!--<label class="blocktext indent"><acronym title="<?php _e('The location of the mediaplayer.swf or imagerotator.swf', 'pb-embedflash'); ?>">source</acronym></label>
									<input type="text" class="textfield" name="flashvars_source" value="" /><br />--><input type="hidden" name="flashvars_source" value="" />

									<!--<label class="blocktext indent"><acronym title="<?php _e('The overall height of the player/rotator.', 'pb-embedflash'); ?>">height</acronym></label>
									<input type="text" class="textfield" name="flashvars_height" value="" /><br /> --><input type="hidden" name="flashvars_height" value="" />

									<!--<label class="blocktext indent"><acronym title="<?php _e('The overall width of the player/rotator.', 'pb-embedflash'); ?>">width</acronym></label>
									<input type="text" class="textfield" name="flashvars_width" value="" /><br /> --><input type="hidden" name="flashvars_width" value="" />

									<!--<label class="blocktext indent"><acronym title="<?php _e('The location of the file to play. Can be a single file or a playlist.', 'pb-embedflash'); ?>">file</acronym></label>
									<input type="text" class="textfield" name="flashvars_file" value="" /><br /> --><input type="hidden" name="flashvars_file" value="" />

									<label class="blocktext indent"><acronym title="<?php _e('The url of a preview image. With playlists, set these in the XML.', 'pb-embedflash'); ?>">image</acronym></label>
									<input type="text" class="textfield" name="flashvars_image" value="<?php echo $pbef_options['flashvars']['image'] ?>" /><br />

									<!--<label class="blocktext indent"><acronym title="<?php _e('The RTMP stream identifier. With playlists, set these in the XML.', 'pb-embedflash'); ?>">id</acronym></label>
									<input type="text" class="textfield" name="flashvars_id" value="" /><br /> --><input type="hidden" name="flashvars_id" value="" />

									<label class="blocktext indent"><acronym title="<?php _e('Show a searchbar below the player.', 'pb-embedflash'); ?>">searchbar</acronym></label>
									<select class="textfield" name="flashvars_searchbar" style="width: 350px">
										<option value=""<?php if ($pbef_options['flashvars']['searchbar'] == null) { echo ' selected="selected"'; }?>>true (default)</option>
										<option  value="false"<?php if ($pbef_options['flashvars']['searchbar'] == 'false') { echo ' selected="selected"'; }?>>false</option>
									</select><br />
								</div>
							</div>								

							<div style="display:block;">
								<img id="timg_colors" src="<?php echo PBEF_SITEPATH.'/css/images/toggle_'.(($pbef_options['apd']['colors'] == 'none') ? 'plus' : 'minus').'.png' ?>" alt="<?php echo (($pbef_options['apd']['colors'] == 'none') ? 'plus' : 'minus') ?>">
								<a href="javascript:toggleDisplay('colors')"><?php _e('The colors', 'pb-embedflash'); ?></a>
								<div id="colors" style="display: <?php echo $pbef_options['apd']['colors'] ?>; width:600px;"><input type="hidden" name="apd_colors" value="<?php echo $pbef_options['apd']['colors'] ?>" />
									<label class="blocktext indent"><acronym title="<?php _e('Background color of the controls, in HEX format.', 'pb-embedflash'); ?>">backcolor</acronym></label>
									<input type="text" class="textfield" name="flashvars_backcolor" id="backcolor" value="<?php echo $pbef_options['flashvars']['backcolor'] ?>" />
									<a href="javascript:pickColor('backcolor');" class="pick" id="backcolorpick" style="background-color: <?php if ($pbef_options['flashvars']['backcolor']) { echo str_replace('0x','#',$pbef_options['flashvars']['backcolor']); } else { echo '#FFFFFF'; }?>;">&nbsp;&nbsp;&nbsp;&nbsp;</a><br />

									<label class="blocktext indent"><acronym title="<?php _e('Texts &amp; buttons color of the controls, in HEX format.', 'pb-embedflash'); ?>">frontcolor</acronym></label>				
									<input type="text" class="textfield" name="flashvars_frontcolor" id="frontcolor" value="<?php echo $pbef_options['flashvars']['frontcolor'] ?>" onblur="document.getElementById('frontcolor').style.backgroundColor = this.value"/>
									<a href="javascript:pickColor('frontcolor');" class="pick" id="frontcolorpick" style="background-color: <?php if ($pbef_options['flashvars']['frontcolor']) { echo str_replace('0x','#',$pbef_options['flashvars']['frontcolor']); } else { echo '#000000'; } ?>;">&nbsp;&nbsp;&nbsp;&nbsp;</a><br />

									<label class="blocktext indent"><acronym title="<?php _e('Rollover color of the controls, in HEX format.', 'pb-embedflash'); ?>">lightcolor</acronym></label>
									<input type="text" class="textfield" name="flashvars_lightcolor" id="lightcolor" value="<?php echo $pbef_options['flashvars']['lightcolor'] ?>" />
									<a href="javascript:pickColor('lightcolor');" class="pick" id="lightcolorpick" style="background-color: <?php if ($pbef_options['flashvars']['lightcolor']) { echo str_replace('0x','#',$pbef_options['flashvars']['lightcolor']); } else { echo '#000000'; } ?>;">&nbsp;&nbsp;&nbsp;&nbsp;</a><br />

									<label class="blocktext indent"><acronym title="<?php _e('Color of the display area, in HEX format.', 'pb-embedflash'); ?>">screencolor</acronym></label>
									<input type="text" class="textfield" name="flashvars_screencolor" id="screencolor" value="<?php echo $pbef_options['flashvars']['screencolor'] ?>" />
									<a href="javascript:pickColor('screencolor');" class="pick" id="screencolorpick" style="background-color: <?php if ($pbef_options['flashvars']['screencolor']) { echo str_replace('0x','#',$pbef_options['flashvars']['screencolor']); } else { echo '#000000'; } ?>;">&nbsp;&nbsp;&nbsp;&nbsp;</a><br />
								</div>
							</div>

							<div style="display:block;">
								<img id="timg_display" src="<?php echo PBEF_SITEPATH.'/css/images/toggle_'.(($pbef_options['apd']['display'] == 'none') ? 'plus' : 'minus').'.png' ?>" alt="<?php echo (($pbef_options['apd']['display'] == 'none') ? 'plus' : 'minus') ?>">
								<a href="javascript:toggleDisplay('display')"><?php _e('Display appearance', 'pb-embedflash'); ?></a>
								<div id="display" style="display: <?php echo $pbef_options['apd']['display'] ?>;"><input type="hidden" name="apd_display" value="<?php echo $pbef_options['apd']['display'] ?>" />
									<label class="blocktext indent"><acronym title="<?php _e('Set this to an image put as a watermark in the top right corner.', 'pb-embedflash'); ?>">logo</acronym></label>
									<input type="text" class="textfield" name="flashvars_logo" value="<?php echo $pbef_options['flashvars']['logo'] ?>" /><br />

									<label class="blocktext indent"><acronym title="<?php _e('Sets how to stretch images and movies to fit the display.', 'pb-embedflash'); ?>">overstretch</acronym></label>
									<select class="textfield" name="flashvars_overstretch" style="width: 350px">
										<option value=""<?php if ($pbef_options['flashvars']['overstretch'] == null) { echo ' selected="selected"'; }?>>false (default)</option>
										<option value="true"<?php if ($pbef_options['flashvars']['overstretch'] == 'true') { echo ' selected="selected"'; }?>>true</option>
										<option value="fit"<?php if ($pbef_options['flashvars']['overstretch'] == 'fit') { echo ' selected="selected"'; }?>>fit</option>
										<option value="none"<?php if ($pbef_options['flashvars']['overstretch'] == 'none') { echo ' selected="selected"'; }?>>none</option>
									</select><br />
									
									<label class="blocktext indent"><acronym title="<?php _e('Set this to true to show a (fake) equalizer at the bottom of the display. Nice for MP3 files.', 'pb-embedflash'); ?>">showeq</acronym></label>
									<select class="textfield" name="flashvars_showeq" style="width: 350px">
										<option value=""<?php if ($pbef_options['flashvars']['showeq'] == null) { echo ' selected="selected"'; }?>>false (default)</option>
										<option value="true"<?php if ($pbef_options['flashvars']['showeq'] == 'true') { echo ' selected="selected"'; }?>>true</option>
									</select><br />

									<label class="blocktext indent"><acronym title="<?php _e('Set this to false to hide the activity icon and play button in the display.', 'pb-embedflash'); ?>">showicons</acronym></label>
									<select class="textfield" name="flashvars_showicons" style="width: 350px">
										<option value=""<?php if ($pbef_options['flashvars']['showicons'] == null) { echo ' selected="selected"'; }?>>true (default)</option>
										<option value="false"<?php if ($pbef_options['flashvars']['showicons'] == 'false') { echo ' selected="selected"'; }?>>false</option>
									</select><br />
									
									<label class="blocktext indent"><acronym title="<?php _e('Set this to the transition you want to use for playlists.', 'pb-embedflash'); ?>">transition</acronym></label>
									<select class="textfield" name="flashvars_transition" style="width: 350px">
										<option value=""<?php if ($pbef_options['flashvars']['transition'] == FALSE) { echo ' selected="selected"'; }?>>random (default)</option>
										<option value="fade"<?php if ($pbef_options['flashvars']['transition'] == 'fade') { echo ' selected="selected"'; }?>>fade</option>
										<option value="bgfade"<?php if ($pbef_options['flashvars']['transition'] == 'bgfade') { echo ' selected="selected"'; }?>>bgfade</option>
										<option value="blocks"<?php if ($pbef_options['flashvars']['transition'] == 'blocks') { echo ' selected="selected"'; }?>>blocks</option>
										<option value="bubbles"<?php if ($pbef_options['flashvars']['transition'] == 'bubbles') { echo ' selected="selected"'; }?>>bubbles</option>
										<option value="circles"<?php if ($pbef_options['flashvars']['transition'] == 'circles') { echo ' selected="selected"'; }?>>circles</option>
										<option value="flash"<?php if ($pbef_options['flashvars']['transition'] == 'flash') { echo ' selected="selected"'; }?>>flash</option>
										<option value="fluids"<?php if ($pbef_options['flashvars']['transition'] == 'fluids') { echo ' selected="selected"'; }?>>fluids</option>
										<option value="lines"<?php if ($pbef_options['flashvars']['transition'] == 'lines') { echo ' selected="selected"'; }?>>lines</option>
										<option value="slowfade"<?php if ($pbef_options['flashvars']['transition'] == 'slowfade') { echo ' selected="selected"'; }?>>slowfade</option>
									</select><br />
								</div>
							</div>

							<div style="display:block;">
								<img id="timg_controls" src="<?php echo PBEF_SITEPATH.'/css/images/toggle_'.(($pbef_options['apd']['controls'] == 'none') ? 'plus' : 'minus').'.png' ?>" alt="<?php echo (($pbef_options['apd']['controls'] == 'none') ? 'plus' : 'minus') ?>">
								<a href="javascript:toggleDisplay('controls')"><?php _e('Controlbar appearance', 'pb-embedflash'); ?></a>
								<div id="controls" style="display: <?php echo $pbef_options['apd']['controls'] ?>;"><input type="hidden" name="apd_controls" value="<?php echo $pbef_options['apd']['controls'] ?>" />
									<label class="blocktext indent"><acronym title="<?php _e('Set this to false to disable the controlbar.', 'pb-embedflash'); ?>">shownavigation</acronym></label>
									<select class="textfield" name="flashvars_shownavigation" style="width: 350px">
										<option value=""<?php if ($pbef_options['flashvars']['shownavigation'] == null) { echo ' selected="selected"'; }?>>true (default)</option>
										<option  value="false"<?php if ($pbef_options['flashvars']['shownavigation'] == 'false') { echo ' selected="selected"'; }?>>false</option>
									</select><br />

									<label class="blocktext indent"><acronym title="<?php _e('Set this to true to show a stop button in the controlbar.', 'pb-embedflash'); ?>">showstop</acronym></label>
									<select class="textfield" name="flashvars_showstop" style="width: 350px">
										<option value=""<?php if ($pbef_options['flashvars']['showstop'] == null) { echo ' selected="selected"'; }?>>false (default)</option>
										<option  value="true"<?php if ($pbef_options['flashvars']['showstop'] == 'true') { echo ' selected="selected"'; }?>>true</option>
									</select><br />

									<label class="blocktext indent"><acronym title="<?php _e('Set this to false to hide the elapsed/remaining digits in the controlbar.', 'pb-embedflash'); ?>">showdigits</acronym></label>
									<select class="textfield" name="flashvars_showdigits" style="width: 350px">
										<option value=""<?php if ($pbef_options['flashvars']['showdigits'] == null) { echo ' selected="selected"'; }?>>true (default)</option>
										<option  value="false"<?php if ($pbef_options['flashvars']['showdigits'] == 'false') { echo ' selected="selected"'; }?>>false</option>
									</select><br />

									<label class="blocktext indent"><acronym title="<?php _e('Set to true to show a link button in the controlbar.', 'pb-embedflash'); ?>">showdownload</acronym></label>
									<select class="textfield" name="flashvars_showdownload" style="width: 350px">
										<option value=""<?php if ($pbef_options['flashvars']['showdownload'] == null) { echo ' selected="selected"'; }?>>false (default)</option>
										<option  value="true"<?php if ($pbef_options['flashvars']['showdownload'] == 'true') { echo ' selected="selected"'; }?>>true</option>
									</select><br />

									<label class="blocktext indent"><acronym title="<?php _e('Set this to false to hide the fullscreen button.', 'pb-embedflash'); ?>">usefullscreen</acronym></label>
									<select class="textfield" name="flashvars_usefullscreen" style="width: 350px">
										<option value=""<?php if ($pbef_options['flashvars']['usefullscreen'] == null) { echo ' selected="selected"'; }?>>true (default)</option>
										<option  value="false"<?php if ($pbef_options['flashvars']['usefullscreen'] == 'false') { echo ' selected="selected"'; }?>>false</option>
									</select><br />
								</div>
							</div>

							<div style="display:block;">
								<img id="timg_playlists" src="<?php echo PBEF_SITEPATH.'/css/images/toggle_'.(($pbef_options['apd']['playlists'] == 'none') ? 'plus' : 'minus').'.png' ?>" alt="<?php echo (($pbef_options['apd']['playlists'] == 'none') ? 'plus' : 'minus') ?>">
								<a href="javascript:toggleDisplay('playlists')"><?php _e('Playlist appearance', 'pb-embedflash'); ?></a>
								<div id="playlists" style="display: <?php echo $pbef_options['apd']['playlists'] ?>;"><input type="hidden" name="apd_playlists" value="<?php echo $pbef_options['apd']['playlists'] ?>" />
									<label class="blocktext indent"><acronym title="<?php _e('Set to true to scroll the playlist on rollover, hiding the scrollbar.', 'pb-embedflash'); ?>">autoscroll</acronym></label>
									<select class="textfield" name="flashvars_autoscroll" style="width: 350px">
										<option value=""<?php if ($pbef_options['flashvars']['autoscroll'] == null) { echo ' selected="selected"'; }?>>false (default)</option>
										<option  value="true"<?php if ($pbef_options['flashvars']['autoscroll'] == 'true') { echo ' selected="selected"'; }?>>true</option>
									</select><br />

									<label class="blocktext indent"><acronym title="<?php _e('Set this smaller as the height to show a playlist below the display.', 'pb-embedflash'); ?>">displayheight</acronym></label>
									<input type="text" class="textfield" name="flashvars_displayheight" value="<?php echo $pbef_options['flashvars']['displayheight'] ?>" /><br />

									<label class="blocktext indent"><acronym title="<?php _e('Set this smaller as the width to show a playlist to the right of the display.', 'pb-embedflash'); ?>">displaywidth</acronym></label>
									<input type="text" class="textfield" name="flashvars_displaywidth" value="<?php echo $pbef_options['flashvars']['displaywidth'] ?>" /><br />

									<label class="blocktext indent"><acronym title="<?php _e('If you have preview images in your playlist, set this to true to show them.', 'pb-embedflash'); ?>">thumbsinplaylist</acronym></label>
									<select class="textfield" name="flashvars_thumbsinplaylist" style="width: 350px">
										<option value=""<?php if ($pbef_options['flashvars']['thumbsinplaylist'] == null) { echo ' selected="selected"'; }?>>false (default)</option>
										<option  value="true"<?php if ($pbef_options['flashvars']['thumbsinplaylist'] == 'true') { echo ' selected="selected"'; }?>>true</option>
									</select><br />
								</div>
							</div>

							<div style="display:block;">
								<img id="timg_behaviour" src="<?php echo PBEF_SITEPATH.'/css/images/toggle_'.(($pbef_options['apd']['behaviour'] == 'none') ? 'plus' : 'minus').'.png' ?>" alt="<?php echo (($pbef_options['apd']['behaviour'] == 'none') ? 'plus' : 'minus') ?>">
								<a href="javascript:toggleDisplay('behaviour')"><?php _e('Playback behaviour', 'pb-embedflash'); ?></a>
								<div id="behaviour" style="display: <?php echo $pbef_options['apd']['behaviour'] ?>;"><input type="hidden" name="apd_behaviour" value="<?php echo $pbef_options['apd']['behaviour'] ?>" />
									<!--<label class="blocktext indent"><acronym title="<?php _e('Assigns a synced MP3. With the player and playlists, set these in the XML.', 'pb-embedflash'); ?>">audio</acronym></label>
									<input type="text" class="textfield" name="flashvars_audio" value="" /><br />--><input type="hidden" name="flashvars_audio" value="" />

									<label class="blocktext indent"><acronym title="<?php _e('Set to true in the player to automatically start playing on page load.', 'pb-embedflash'); ?>">autostart</acronym></label>
									<select class="textfield" name="flashvars_autostart" style="width: 350px">
										<option value=""<?php if ($pbef_options['flashvars']['autostart'] == null) { echo ' selected="selected"'; }?>>false (default)</option>
										<option  value="true"<?php if ($pbef_options['flashvars']['autostart'] == 'true') { echo ' selected="selected"'; }?>>true</option>
									</select><br />

									<label class="blocktext indent"><acronym title="<?php _e('Sets the number of seconds an FLV is buffered before starting.', 'pb-embedflash'); ?>">bufferlength</acronym></label>
									<input type="text" class="textfield" name="flashvars_bufferlength" value="<?php echo $pbef_options['flashvars']['bufferlenght'] ?>" /><br />

									<!--<label class="blocktext indent"><acronym title="<?php _e('Assigns closed captions TimedText file. With playlists, set these in the XML.', 'pb-embedflash'); ?>">captions</acronym></label>
									<input type="text" class="textfield" name="flashvars_captions" value="" /><br />--><input type="hidden" name="flashvars_captions" value="" />

									<!--<label class="blocktext indent"><acronym title="<?php _e('Set this to an FLV fallback if you stream an MP4 file.', 'pb-embedflash'); ?>">fallback</acronym></label>
									<input type="text" class="textfield" name="flashvars_fallback" value="" /><br />--><input type="hidden" name="flashvars_fallback" value="" />

									<label class="blocktext indent"><acronym title="<?php _e('Set to true to repeat playback, to list to playback the entire playlist once.', 'pb-embedflash'); ?>">repeat</acronym></label>
									<select class="textfield" name="flashvars_repeat" style="width: 350px">
										<option value=""<?php if ($pbef_options['flashvars']['repeat'] == null) { echo ' selected="selected"'; }?>>false (default)</option>
										<option  value="list"<?php if ($pbef_options['flashvars']['repeat'] == 'list') { echo ' selected="selected"'; }?>>list</option>
										<option  value="true"<?php if ($pbef_options['flashvars']['repeat'] == 'true') { echo ' selected="selected"'; }?>>true</option>
									</select><br />

									<label class="blocktext indent"><acronym title="<?php _e('Sets the number of seconds an image is played back.', 'pb-embedflash'); ?>">rotatetime</acronym></label>
									<input type="text" class="textfield" name="flashvars_rotatetime" value="<?php echo $pbef_options['flashvars']['rotatetime'] ?>" /><br />

									<label class="blocktext indent"><acronym title="<?php _e('Set this to false to playback the playlist sequentially instead of shuffled.', 'pb-embedflash'); ?>">shuffle</acronym></label>
									<select class="textfield" name="flashvars_shuffle" style="width: 350px">
										<option value=""<?php if ($pbef_options['flashvars']['shuffle'] == null) { echo ' selected="selected"'; }?>>true (default)</option>
										<option  value="false"<?php if ($pbef_options['flashvars']['shuffle'] == 'false') { echo ' selected="selected"'; }?>>false</option>
									</select><br />
									
									<label class="blocktext indent"><acronym title="<?php _e('Only for the mediaplayer. Set this to false to turn of the smoothing of video. Quality will decrease, but performance will increase. Good for HD files and slower computers.', 'pb-embedflash'); ?>">smoothing</acronym></label>
									<select class="textfield" name="flashvars_smoothing" style="width: 350px">
										<option value=""<?php if ($pbef_options['flashvars']['smoothing'] == null) { echo ' selected="selected"'; }?>>true (default)</option>
										<option  value="false"<?php if ($pbef_options['flashvars']['smoothing'] == 'false') { echo ' selected="selected"'; }?>>false</option>
									</select><br />

									<label class="blocktext indent"><acronym title="<?php _e('Sets the startup volume for playback of sounds/movies.', 'pb-embedflash'); ?>">volume</acronym></label>
									<input type="text" class="textfield" name="flashvars_volume" value="<?php echo $pbef_options['flashvars']['volume'] ?>" /><br />	
								</div>
							</div>
							<div style="display:block;">
								<img id="timg_communication" src="<?php echo PBEF_SITEPATH.'/css/images/toggle_'.(($pbef_options['apd']['communication'] == 'none') ? 'plus' : 'minus').'.png' ?>" alt="<?php echo (($pbef_options['apd']['communication'] == 'none') ? 'plus' : 'minus') ?>">
								<a href="javascript:toggleDisplay('communication')"><?php _e('External communication', 'pb-embedflash'); ?></a>
								<div id="communication" style="display: <?php echo $pbef_options['apd']['communication'] ?>;"><input type="hidden" name="apd_communication" value="<?php echo $pbef_options['apd']['communication'] ?>" />
									<!--<label class="blocktext indent"><acronym title="<?php _e('Set this to true to enable javascript interaction.', 'pb-embedflash'); ?>">enablejs</acronym></label>
									<select class="textfield" name="flashvars_enablejs" style="width: 350px">
										<option value="">false (default)</option>
										<option  value="true">true</option>
									</select><br />--><input type="hidden" name="flashvars_enablejs" value="" />

									<!--<label class="blocktext indent"><acronym title="<?php _e('Use this to give each player / rotator a unique ID.', 'pb-embedflash'); ?>">javascriptid</acronym></label>
									<input type="text" class="textfield" name="flashvars_javascriptid" value="" /><br />--><input type="hidden" name="flashvars_javascriptid" value="" />

									<!--<label class="blocktext indent"><acronym title="<?php _e('Set this to analytics or a serverside script that can process statistics.', 'pb-embedflash'); ?>">callback</acronym></label>
									<input type="text" class="textfield" name="flashvars_callback" value="" /><br />--><input type="hidden" name="flashvars_callback" value="" />

									<!--<label class="blocktext indent"><acronym title="<?php _e('Set this to an XML with items you want to recommend, just like YouTube.', 'pb-embedflash'); ?>">recommendations</acronym></label>
									<input type="text" class="textfield" name="flashvars_recommendations" value="" /><br />--><input type="hidden" name="flashvars_recommendations" value="" />

									<!--<label class="blocktext indent"><acronym title="<?php _e('Set this to lighttpd or the URL of a script to use for http streaming.', 'pb-embedflash'); ?>">streamscript</acronym></label>
									<input type="text" class="textfield" name="flashvars_streamscript" value="" /><br />--><input type="hidden" name="flashvars_streamscript" value="" />

									<!--<label class="blocktext indent"><acronym title="<?php _e('Force the type of file you play if autodetection doesn\'t work.', 'pb-embedflash'); ?>">type</acronym></label>
									<select class="textfield" name="flashvars_type" style="width: 350px">
										<option value="">autodetect (default)</option>
										<option  value="flv">video</option>
										<option  value="rtmp">stream</option>
										<option  value="mp3">audio</option>
										<option  value="jpg">image</option>
									</select><br />--><input type="hidden" name="flashvars_type" value="" />

									<label class="blocktext indent"><acronym title="<?php _e('Set this to an external URL. With playlists, set links in the XML.', 'pb-embedflash'); ?>">link</acronym></label>
									<input type="text" class="textfield" name="flashvars_link" value="<?php echo $pbef_options['flashvars']['link'] ?>" /><br />

									<label class="blocktext indent"><acronym title="<?php _e('Set this to true to make a click on the display result in a jump to the link.', 'pb-embedflash'); ?>">linkfromdisplay</acronym></label>
									<select class="textfield" name="flashvars_linkfromdisplay" style="width: 350px">
										<option value=""<?php if ($pbef_options['flashvars']['linkfromdisplay'] == null) { echo ' selected="selected"'; }?>>false (default)</option>
										<option  value="true"<?php if ($pbef_options['flashvars']['linkfromdisplay'] == 'true') { echo ' selected="selected"'; }?>>true</option>
									</select><br />

									<label class="blocktext indent"><acronym title="<?php _e('Set this to the frame you want hyperlinks to open in.', 'pb-embedflash'); ?>">linktarget</acronym></label>
									<input type="text" class="textfield" name="flashvars_linktarget" value="<?php echo $pbef_options['flashvars']['linktarget'] ?>" /><br />
								</div>
							</div>
						</div>
					</div>
					</div>
					<input type="hidden" name="update-pbef" value="true" />
					<p class="submit"><input type="submit" value="<?php _e('Update Settings', 'pb-embedflash'); ?> &raquo;" /></p>
				</form>
			</div>
		</div>
	</div>
<?php } // page switch ?>
</div>
<form id="donate_form" action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_s-xclick" />
	<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHbwYJKoZIhvcNAQcEoIIHYDCCB1wCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYBWkfKVHDbcGRTA9bfUfjS/IU5qoApGDveyxt4VQDsr0Dbl123KtQ3/6PNcb4tr7na8FfFBeXvkToPQygc4w969VUzyQpCUdC5gK8KzgbCuQ1DhKYAdgw3D8t27Q5X38dFkG8qBqtJYR73Gmdv7U5TeTixSv7GG+X1RCHbutRDiuzELMAkGBSsOAwIaBQAwgewGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIu9mqMfWbo8iAgciNCQwCzxof3AAIbNdhhmaLZ86JRUIzTTpMBXnaTs34os3ofVg/Uo/oIIOoRrsArR+/uUQjR/OfF6pVqg2Pm4dhSpQa2dLFlOBjjVqmA7f3fUWqYvWMTfR84EBsruKFKwcwFXfkCpMXL7REI4Hilh9G4hr7SWcJc3pJYM9Pa1GgEMObPxJSHX59W2nyncovWzhHKbZLmPGp00zWcgugIxPt5AuzxerozBKDtVg5l3WtZY48sCEyk7/FPbCf4q16YS99+cBQvS+6/KCCA4cwggODMIIC7KADAgECAgEAMA0GCSqGSIb3DQEBBQUAMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTAeFw0wNDAyMTMxMDEzMTVaFw0zNTAyMTMxMDEzMTVaMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEAwUdO3fxEzEtcnI7ZKZL412XvZPugoni7i7D7prCe0AtaHTc97CYgm7NsAtJyxNLixmhLV8pyIEaiHXWAh8fPKW+R017+EmXrr9EaquPmsVvTywAAE1PMNOKqo2kl4Gxiz9zZqIajOm1fZGWcGS0f5JQ2kBqNbvbg2/Za+GJ/qwUCAwEAAaOB7jCB6zAdBgNVHQ4EFgQUlp98u8ZvF71ZP1LXChvsENZklGswgbsGA1UdIwSBszCBsIAUlp98u8ZvF71ZP1LXChvsENZklGuhgZSkgZEwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tggEAMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQEFBQADgYEAgV86VpqAWuXvX6Oro4qJ1tYVIT5DgWpE692Ag422H7yRIr/9j/iKG4Thia/Oflx4TdL+IFJBAyPK9v6zZNZtBgPBynXb048hsP16l2vi0k5Q2JKiPDsEfBhGI+HnxLXEaUWAcVfCsQFvd2A1sxRr67ip5y2wwBelUecP3AjJ+YcxggGaMIIBlgIBATCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwCQYFKw4DAhoFAKBdMBgGCSqGSIb3DQEJAzELBgkqhkiG9w0BBwEwHAYJKoZIhvcNAQkFMQ8XDTA3MDUxMDEwMzcwOFowIwYJKoZIhvcNAQkEMRYEFMFN4W1tVQPxjiY41lMa8ka6pNTAMA0GCSqGSIb3DQEBAQUABIGAoI4bNp8txgMJ/Tt2zKj3495jYYRodKqXlc/jkaY8Axq9c0JkHlViZdNhSWMJSb1MifnRI6Z2moyhLrCLperLAcd9EqAMwls7UeaWzPlF0JrugpHASckxyYSFKOq0eLp1LzUudaSnGJt7Hd7MML7p+RKuImPdeU/K8fzc2+ThAmA=-----END PKCS7-----" />
</form>