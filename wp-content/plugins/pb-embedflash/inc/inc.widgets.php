<?php
/*
Part of pb-embedFlash v1.5
© Pascal Berkhahn, <novayuna@googlemail.com>, http://pascal-berkhahn.de
*/
if (!function_exists('get_option')) { echo "Please don't load this file directly."; exit; }

function pb_embedFlash_widget_output($arguments, $widget_args = 1)
{
	if (!function_exists('pb_embedFlash_plugin')) { return false; }

	extract($arguments, EXTR_SKIP);
	if (is_numeric($widget_args)) { $widget_args = array('number' => $widget_args); }
	$widget_args = wp_parse_args($widget_args, array('number' => -1 ));
	extract($widget_args, EXTR_SKIP);
	$options = get_option('pb_embedFlash_widgets');
	
	$option = $options[$number];
	if (empty($option['url'])) { return false; }
	
	$flashcode = '[flash '.$option['url'].' mode='.$option['mode'];
	if (!empty($option['width'])) { $flashcode .= ' w='.$option['width']; }
	if (!empty($option['height'])) { $flashcode .= ' h='.$option['height']; }
	if ($option['mode'] == 3 || $option['mode'] == 4)
	{
		if ($option['force'] == 1) {
			$flashcode .= ' preview=force';
			if (!empty($option['pw'])) { $flashcode .= ' pw='.$option['pw']; }
			if (!empty($option['ph'])) { $flashcode .= ' ph='.$option['ph']; }
		} else {
			if (!empty($option['preview'])) { $flashcode .= ' preview={'.$option['preview'].'|'.$option['pw'].'|'.$option['ph']; }
			if (!empty($option['linktext'])) { $flashcode .= ' linktext={'.$option['linktext'].'}'; }
		}
		if (!empty($option['caption'])) { $flashcode .= ' caption={'.$option['caption'].'}'; }
	}
	if (!empty($option['expert'])) { $flashcode .= ' '.$option['expert']; }
	$flashcode .= ']';
	
	$output =  $before_widget.($option['title'] ? $before_title.$option['title'].$after_title : '<br />');
	$output .= (($option['addtext'] == 'before') ? $option['text'] : NULL).'<div style="text-align: center;">'.pb_embedFlash_plugin($flashcode).'</div>'.(($option['addtext'] == 'after') ? $option['text'] : NULL);
	$output .= $after_widget;
	
	echo $output;
	return false;
}
function pb_embedFlash_widget_control($widget_args)
{ global $wp_registered_widgets; static $updated = false;

	if (is_numeric($widget_args)) { $widget_args = array('number' => $widget_args); }
	$widget_args = wp_parse_args($widget_args, array('number' => -1));
	extract($widget_args, EXTR_SKIP);

	$options = get_option('pb_embedFlash_widgets');
	if (is_array($options) === false) { $options = array(); }

	if ($updated === false && empty($_POST['sidebar']) === false)
	{
		$sidebar = (string) $_POST['sidebar'];
		$sidebars_widgets = wp_get_sidebars_widgets();
		if (isset($sidebars_widgets[$sidebar]))
		{
			$this_sidebar =& $sidebars_widgets[$sidebar];
		} else {
			$this_sidebar = array();
		}
		foreach ($this_sidebar as $_widget_id)
		{
			if ($wp_registered_widgets[$_widget_id]['callback'] == 'pb_embedFlash_widget_output' && isset($wp_registered_widgets[$_widget_id]['params'][0]['number']))
			{
				$widget_number = $wp_registered_widgets[$_widget_id]['params'][0]['number'];
				if (in_array('pb_embedFlash_widget-'.$widget_number, (array) $_POST['widget-id']) === false)
				{
					unset($options[$widget_number]);
				}
			}
		}
		foreach ((array) $_POST['pb_embedFlash_widget'] as $number => $value)
		{
			/* if (!current_user_can('unfiltered_html'))
			{
				foreach ($value as $k => $o)
				{
					$value[$k] = $text = wp_filter_post_kses($value[$k]);
				}
			} */
			$options[$number]['title'] = strip_tags(stripslashes($value['title']));
			$options[$number]['text'] = stripslashes($value['text']);
			$options[$number]['addtext'] = $value['addtext'];
			$options[$number]['url'] = $value['url'];
			$options[$number]['mode'] = (int) $value['mode'];
			$options[$number]['width'] = (int) $value['width'];
			$options[$number]['height'] = (int) $value['height'];
			$options[$number]['preview'] = $value['preview'];
			$options[$number]['force'] = (int) (isset($value['force']) ? 1 : 0);
			$options[$number]['pw'] = (int) $value['prevwidth'];
			$options[$number]['ph'] = (int) $value['prevheight'];
			$options[$number]['linktext'] = $value['linktext'];
			$options[$number]['caption'] = $value['caption'];
			$options[$number]['expert'] = $value['expert'];
		}
		update_option('pb_embedFlash_widgets', $options);
		$updated = true;
	}
	if ($number == -1)
	{
		$title = null;
		$text = null;
		$addtext = null;
		$url = null;
		$mode = 0;
		$width = null;
		$height = null;
		$preview = null;
		$force = 0;
		$prevwidth = null;
		$prevheight = null;
		$linktext = null;
		$caption = null;
		$expert = null;
		$number = '%i%';
	} else {
		$title = htmlspecialchars($options[$number]['title']);
		$text = htmlspecialchars($options[$number]['text']);
		$addtext = $options[$number]['addtext'];
		$url = htmlspecialchars($options[$number]['url']);
		$mode = (int) $options[$number]['mode'];
		$width = (int) $options[$number]['width'];
		$height = (int) $options[$number]['height'];
		$preview = htmlspecialchars($options[$number]['preview']);
		$force = (int) $options[$number]['force'];
		$prevwidth = (int) $options[$number]['pw'];
		$prevheight = (int) $options[$number]['ph'];
		$linktext = htmlspecialchars($options[$number]['linktext']);
		$caption = htmlspecialchars($options[$number]['caption']);
		$expert = htmlspecialchars($options[$number]['expert']);
	}
	?>
	<script type="text/javascript">// <![CDATA[
	function toggleSettings(number, value) {
		var display;
		if (value <= 2) { display = 'none' } else { display = 'block'; }
		document.getElementById('fb-settings-'+number).style['display'] = display;
	};
	function toggleText(number, value) {
		document.getElementById('textcontent-'+number).style['display'] = value;
	};
	function toggleActive(number) {
		var newstatus;
		if (document.getElementById('pb_embedFlash_widget-'+number+'-preview').readOnly == true) { newstatus = false } else { newstatus = true }
		document.getElementById('pb_embedFlash_widget-'+number+'-preview').readOnly = newstatus;
		document.getElementById('pb_embedFlash_widget-'+number+'-linktext').readOnly = newstatus;
	};
	// ]]></script><style type="text/css">input:disabled { background-color: #E7E7E7; color: #777777; }</style>
	<div>
		<small style="display: block; float: right;"><?php _e('Empty fields will result in default values.', 'pb-embedflash'); ?></small>
		<br />
		<div>
			<div style="width: 75px; display: block; float: left;"><label for="pb_embedFlash_widget-<?php echo $number; ?>-title">
					<strong><?php _e('Title', 'pb-embedflash'); ?>:</strong>
			</label></div>
			<input style="width: 410px; type="text" id="pb_embedFlash_widget-<?php echo $number; ?>-title" name="pb_embedFlash_widget[<?php echo $number; ?>][title]" value="<?php echo $title; ?>" />
		</div>

		<div>
			<div style="width: 75px; display: block; float: left;"><label for="pb_embedFlash_widget-<?php echo $number; ?>-url">
				<strong><?php _e('URL', 'pb-embedflash'); ?>:</strong>
			</label></div>
			<input style="width: 410px" type="text" id="pb_embedFlash_widget-<?php echo $number; ?>-url" name="pb_embedFlash_widget[<?php echo $number; ?>][url]" value="<?php echo $url; ?>" />
		</div>

		<div style="float: left;">
			<div style="width: 75px; display: block; float: left;"><label for="pb_embedFlash_widget-<?php echo $number; ?>-width">
				<strong><?php _e('Width', 'pb-embedflash'); ?>:</strong>
			</label></div>
			<input style="width: 162px;" type="text" id="pb_embedFlash_widget-<?php echo $number; ?>-width" name="pb_embedFlash_widget[<?php echo $number; ?>][width]" value="<?php echo $width; ?>" />
		</div>
		
		<div>
			<div style="width: 75px; display: block; float: left;"><label for="pb_embedFlash_widget-<?php echo $number; ?>-height">
				<strong><?php _e('Height', 'pb-embedflash'); ?>:</strong>
			</label></div>
			<input style="width: 162px;" type="text" id="pb_embedFlash_widget-<?php echo $number; ?>-height" name="pb_embedFlash_widget[<?php echo $number; ?>][height]" value="<?php echo $height; ?>" />
		</div>
		<div style="clear:both;">
			<div style="width: 75px; display: block; float: left;"><label for="pb_embedFlash_widget-<?php echo $number; ?>-mode">
				<strong><?php _e('Mode', 'pb-embedflash'); ?>:</strong>
			</label></div>
			<select onchange="toggleSettings('<?php echo $number; ?>', this.options[this.selectedIndex].value)";style="width: 195px; clear: left;" id="pb_embedFlash_widget-<?php echo $number; ?>-mode" name="pb_embedFlash_widget[<?php echo $number; ?>][mode]">
				<option value="0"<?php if ($mode == 0) { echo ' selected="selected"'; } ?>><?php _e('&lt;object&gt;', 'pb-embedflash'); ?></option>
				<option value="1"<?php if ($mode == 1) { echo ' selected="selected"'; } ?>><?php _e('SWFObject', 'pb-embedflash'); ?></option>
				<option value="2"<?php if ($mode == 2) { echo ' selected="selected"'; } ?>><?php _e('SWFObject (IE only)', 'pb-embedflash'); ?></option>
				<option value="3"<?php if ($mode == 3) { echo ' selected="selected"'; } ?>><?php _e('Shadowbox', 'pb-embedflash'); ?></option>
				<option value="4"<?php if ($mode == 4) { echo ' selected="selected"'; } ?>><?php _e('Popup', 'pb-embedflash'); ?></option>
			</select>
		</div>
		<div id="fb-settings-<?php echo $number; ?>" style="display: <?php echo (($mode == 3 || $mode == 4) ? 'block' : 'none'); ?>">
			<div style="display: block; clear: both">
				<strong style="display: inline; float: left;"><?php _e('Preview image', 'pb-embedflash'); ?></strong>
				<div style="display: inline; float: right;">
					<input type="checkbox" id="pb_embedFlash_widget-<?php echo $number; ?>-force" name="pb_embedFlash_widget[<?php echo $number; ?>][force]"<?php if ($force == 1) { echo ' checked="checked"'; } ?> value="1" onclick="javascript:toggleActive('<?php echo $number; ?>')"
					<label for="pb_embedFlash_widget-<?php echo $number; ?>-force">
						<?php _e('Force auto-load', 'pb-embedflash'); ?>
					</label>
				</div>
			</div>
			<div style="clear: both;">
				<div style="width: 75px; display: block; float: left;"><label for="pb_embedFlash_widget-<?php echo $number; ?>-preview">
					<strong><?php _e('URL', 'pb-embedflash'); ?>:</strong>
				</label></div>
				<input style="width: 410px;" type="text" id="pb_embedFlash_widget-<?php echo $number; ?>-preview" name="pb_embedFlash_widget[<?php echo $number; ?>][preview]" value="<?php echo $preview; ?>"<?php if ($force == 1) { echo ' readonly="readonly"'; } ?> />
			</div>
			<div style="float: left;">
				<div style="width: 75px; display: block; float: left;"><label for="pb_embedFlash_widget-<?php echo $number; ?>-prevwidth">
					<strong><?php _e('Width', 'pb-embedflash'); ?>:</strong>
				</label></div>
				<input style="width: 162px;" type="text" id="pb_embedFlash_widget-<?php echo $number; ?>-prevwidth" name="pb_embedFlash_widget[<?php echo $number; ?>][prevwidth]" value="<?php echo $prevwidth; ?>" />
			</div>
			<div>
				<div style="width: 75px; display: block; float: left;"><label for="pb_embedFlash_widget-<?php echo $number; ?>-prevheight">
					<strong><?php _e('Height', 'pb-embedflash'); ?>:</strong>
				</label></div>
				<input style="width: 162px;" type="text" id="pb_embedFlash_widget-<?php echo $number; ?>-prevheight" name="pb_embedFlash_widget[<?php echo $number; ?>][prevheight]" value="<?php echo $prevheight; ?>" />
			</div>
			<div style="clear: both;">
				<div style="width: 75px; display: block; float: left;"><label for="pb_embedFlash_widget-<?php echo $number; ?>-linktext">
					<strong><?php _e('Linktext', 'pb-embedflash'); ?>:</strong>
				</label></div>
				<input style="width: 410px;" type="text" id="pb_embedFlash_widget-<?php echo $number; ?>-linktext" name="pb_embedFlash_widget[<?php echo $number; ?>][linktext]" value="<?php echo $linktext; ?>"<?php if ($force == 1) { echo ' readonly="readonly"'; } ?> />
			</div>
			<div>
				<div style="width: 100px; display: block; float: left;"><label for="pb_embedFlash_widget-<?php echo $number; ?>-caption">
					<strong><?php _e('Caption/Title', 'pb-embedflash'); ?>:</strong>
				</label></div>
				<input style="width: 385px;" type="text" id="pb_embedFlash_widget-<?php echo $number; ?>-caption" name="pb_embedFlash_widget[<?php echo $number; ?>][caption]" value="<?php echo $caption; ?>" />
			</div>
		</div>
		<div style="display: block; clear: both">
			<strong style="display: inline; float: left;"><?php _e('Text', 'pb-embedflash'); ?></strong>
			<div style="display: inline; float: right;">
				&nbsp;&nbsp;<input type="radio" name="pb_embedFlash_widget[<?php echo $number; ?>][addtext]"<?php if ($addtext == 'no' || empty($addtext)) { echo ' checked="checked"'; } ?> id="pb_embedFlash_widget-<?php echo $number; ?>-addtext_no" value="no" onclick="javascript:toggleText('<?php echo $number; ?>', 'none')" /> <?php _e('No', 'pb-embedflash'); ?>
				&nbsp;&nbsp;<input type="radio" name="pb_embedFlash_widget[<?php echo $number; ?>][addtext]"<?php if ($addtext == 'before') { echo ' checked="checked"'; } ?> id="pb_embedFlash_widget-<?php echo $number; ?>-addtext_before" onclick="javascript:toggleText('<?php echo $number; ?>', 'block')" /> <?php _e('Before flash', 'pb-embedflash'); ?>
				&nbsp;&nbsp;<input type="radio" name="pb_embedFlash_widget[<?php echo $number; ?>][addtext]"<?php if ($addtext == 'after') { echo ' checked="checked"'; } ?> id="pb_embedFlash_widget-<?php echo $number; ?>-addtext_after" value="after" onclick="javascript:toggleText('<?php echo $number; ?>', 'block')" /> <?php _e('After flash', 'pb-embedflash'); ?>
			</div>
			<div id="textcontent-<?php echo $number; ?>" style="display: <?php echo (($addtext == 'no' || empty($addtext)) ? 'none' : 'block'); ?>"><br />
				<textarea style="width: 490px; height: 70px; clear: left;" type="text" id="pb_embedFlash_widget-<?php echo $number; ?>-text" name="pb_embedFlash_widget[<?php echo $number; ?>][text]"><?php echo $text; ?></textarea>
			</div>
		</div>
		<div style="clear: both">
			<div><label for="pb_embedFlash_widget-<?php echo $number; ?>-expert">
				<strong><?php _e('Advanced settings', 'pb-embedflash'); ?></strong> <small>(<?php _e('see <a href="http://wordpress.org/extend/plugins/pb-embedflash/installation/" target="_blank">usage</a>', 'pb-embedflash'); ?>)</small></span>
			</label></div>
			<input style="width: 490px; clear: left;" type="text" id="pb_embedFlash_widget-<?php echo $number; ?>-expert" name="pb_embedFlash_widget[<?php echo $number; ?>][expert]" value="<?php echo $expert; ?>" />
		</div>
		<input type="hidden" name="pb_embedFlash_widget-<?php echo $number; ?>" id="pb_embedFlash_widget-<?php echo $number; ?>" value="true" />
	</div>
	<?php
	return false;
}

function pb_embedFlash_widget_init()
{
	if (!function_exists('wp_register_sidebar_widget') || !function_exists('wp_register_widget_control')) { return false; }

	$options = get_option('pb_embedFlash_widgets');
	if (!is_array($options)) { $options = array(); }
	$widget_args = array('classname' => 'pb_embedflash_widgets', 'description' => __('A widget to display any flash content easily', 'pb-embedflash'));
	$control_args = array('width' => 530, 'height' => 520, 'id_base' => 'pbembedflash');
	$name = __('pb-embedFlash Widget', 'pb-embedflash');

	$id = false;
	foreach (array_keys($options) as $i)
	{
		if (!isset($options[$i]['url'])) { continue; }
		$id = "pbembedflash-$i";
		wp_register_sidebar_widget($id, $name, 'pb_embedFlash_widget_output', $widget_args, array('number' => $i));
		wp_register_widget_control($id, $name, 'pb_embedFlash_widget_control', $control_args, array('number' => $i));
	}
	if ($id === false)
	{
		wp_register_sidebar_widget('pb_embedFlash_widget-1', $name, 'pb_embedFlash_widget_output', $widget_args, array('number' => -1));
		wp_register_widget_control('pb_embedFlash_widget-1', $name, 'pb_embedFlash_widget_control', $control_args, array('number' => -1));
	}
	return false;
}
?>