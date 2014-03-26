<?php
/*
Part of pb-embedFlash v1.5
© Pascal Berkhahn, <novayuna@googlemail.com>, http://pascal-berkhahn.de
*/
if (!function_exists('get_option')) { echo "Please don't load this file directly."; exit; }

function pbef_options($sub = false,$deep = false)
{
	require(PBEF_PATH.'/inc/inc.options.php');
	$pbef_options = get_option('pb_embedFlash');
	if (!empty($pbef_options) && is_array($pbef_options))
	{
		foreach ($pbef_options as $k => $o)
		{
			foreach ($pbef_options[$k] as $key => $option)
			{
				if (!is_null($option) /*&& isset($options[$k][$key])*/)
				{
					$options[$k][$key] = $option;
				} else {
					unset($options[$k][$key]);
				}
			}
		}
	}
	return (($sub) ? (($deep) ? $options[$sub][$deep] : $options[$sub]) : $options);
} // pbef_options

function pb_embedFlash_plugin($content)
{
	$content = preg_replace_callback(PBEF_REGEXP,'pb_embedFlash_plugin_callback',$content);
	return ($content);
} // pb_embedFlash_plugin

function pb_embedFlash_addAP()
{
	if (function_exists('add_options_page'))
	{
		add_options_page('pb-embedFlash','pb-embedFlash',9,basename(PBEF_PATH),'pb_embedflash_AP');
		add_submenu_page('index.php','pb-embedFlash Media Manager','pb-embedFlash Media Manager',9,'pbef_mm','pbef_mm_redirect');
	}
	return false;
} // pb_embedFlash_addAP

function pbef_mm_redirect()
{
	pb_embedFlash_AP(true);
	return false;
} // pbef_mm_redirect

function pb_embedFlash_AP($mm = false)
{
	require(PBEF_PATH.'/inc/req.adminpanel.php');
	return false;
} // pb_embedFlash_ap

function pb_embedFlash_activate()
{
   	require(PBEF_PATH.'/inc/req.activation.php');
	return false;
} // pb_embedFlash_activate

function pb_embedFlash_deactivate()
{
	if (intval(pbef_options('main','deleteoptionsondeactivation')) === 1)
	{
		$pbefmm_media 		= $wpdb->prefix.'pbefmm_media';
		$pbefmm_playlists 	= $wpdb->prefix.'pbefmm_playlists';
		$wpdb->query("DROP TABLE IF EXISTS `$pbefmm_media`,`$pbefmm_playlists`;");
		delete_option('pb_embedFlash');
		delete_option('pb_embedFlash_widgets');
		delete_option('pb_embedFlash_dbversion');
	}
	return false;
} // pb_embedFlash_deactivate

function pb_embedFlash_js_head()
{
	if (pbef_options('main','shadowbox') == 1)
	{
		echo pb_embedFlash_js_shadowbox();
	}
	echo '<link rel="stylesheet" type="text/css" media="screen" href="'.pbef_options('main','shadowboxcssurl').'" />';
	return false;
} // pb_embedFlash_js_head

function pb_embedFlash_js_shadowbox()
{ if (defined('PBEF_LOADED_SHADOWBOX') == false) { $add = '';
	require(PBEF_PATH.'/inc/req.shadowbox.php');
	return $add;
} }

function pb_embedFlash_js($mode)
{ $add = '';
	if ((strstr($_SERVER['HTTP_USER_AGENT'],'MSIE') && $mode == 2) || $mode == 1 || $mode == 4)
	{
		$add = '<script type="text/javascript" src="'.pbef_options('main','swfobjecturl').'"></script>';
		define('PBEF_LOADED_SWFOBJECT',true);
	}
	if (defined('PBEF_LOADED_SHADOWBOX') == false && $mode == 3)
	{
		echo pb_embedFlash_js_shadowbox();
		define('PBEF_LOADED_SHADOWBOX',true);
	}
	if (defined('PBEF_LOADED_POPUP') == false && $mode == 4)
	{
		if (defined('PBEF_LOADED_MOOTOOLS') == false)
		{
			$add .= '<script type="text/javascript" src="'.pbef_options('main','sbadapterurl').'mootools.js'.'"></script>';
			define('PBEF_LOADED_MOOTOOLS',true);
		}
		$add .= '<script type="text/javascript" src="'.pbef_options('main','popupurl').'"></script>'; 
		define('PBEF_LOADED_POPUP',true);
	}
	return $add;
} // pb_embedFlash_js

function pbef_buildpattern($pattern,$source = null)
{
	if ($source == 'url') { return ('%^(?:http://)?(?:.+\.)?'.$pattern.'[/?&]*.*%i'); }
	else { return ('%(?:^|[[:space:]])'.$pattern.'(?:[[:space:]]|$)%i'); }
} // pbef_buildpattern

// Code from TinyMCE external plugin example: http://an-archos.com/anarchy-media-player#download
function pb_embedflash_mce_plugins($plugins)
{    
	array_push($plugins,'-pb_embedflash_tinymceplugin','bold');
	return ($plugins);
} // pb_embedflash_mce_plugins
function pb_embedflash_mce_buttons($buttons)
{
	array_push($buttons,'separator','pb_embedflash_tinymceplugin');
	return ($buttons);
} // pb_embedflash_mce_buttons
function pb_embedflash_external_plugins()
{
	echo 'tinyMCE.loadPlugin("pb_embedflash_tinymceplugin","' . PBEF_SITEPATH . '/js/tinymceplugin/");' . "\n"; 
	return false;
} // pb_embedflash_external_plugins

if (!function_exists('htmlspecialchars_decode'))
{
    function htmlspecialchars_decode($string,$quote_style = ENT_COMPAT)
	{
        return strtr($string,array_flip(get_html_translation_table(HTML_SPECIALCHARS,$quote_style)));
    }
}

function pbef_mode($mode)
{
	if ((strstr($_SERVER['HTTP_USER_AGENT'],'MSIE') && $mode == 2) || $mode == 1)
	{
		$r['mode'] = 1;
		$r['target'] = '<span class="###CLASS###"###STYLE### id="###SWFID###">###MSG###</span>###EXTERN###<script type="text/javascript">
				var flashvars = {}; var params = {}; var attributes = {};###FLASHVARS######PARAM######ATTRIBUTES###
				swfobject.embedSWF("###URL###","###SWFID###","###WIDTH###","###HEIGHT###","9.0.0","'.PBEF_SITEPATH.'/swf/expressInstall.swf",flashvars,params,attributes);
		</script>';
	} elseif ($mode == 3) {
		$r['mode'] = 3;
		$r['target'] = '<a href="###URL######FLASHVARS###" rel="shadowbox;width=###WIDTH###;height=###HEIGHT###;" class="shadowbox" title="###CAPTION###">###LINKTEXT###</a>';
	} elseif ($mode == 4) {
		$r['mode'] = 4;
		$r['target'] = '<a href="###URL###" rel="popup ###WIDTH### ###HEIGHT######ATTRIBUTES######PARAM######FLASHVARS###" class="popup" title="###CAPTION###">###LINKTEXT###</a>';
	} else {
		$r['mode'] = 0;
		$r['target'] = '<object type="application/x-shockwave-flash" data="###URL###" width="###WIDTH###" height="###HEIGHT###"###ATTRIBUTES### class="###CLASS###"###STYLE###><param name="movie" value="###URL###" />###PARAM######FLASHVARS######MSG###</object>###EXTERN###';
	}
	return ($r);
} // pbef_mode

function pb_embedFlash_create_array($match)
{
	$match = str_replace('&amp;','&',$match); // convert &amp; to & - so there aren't both
	$match = str_replace('&','&amp;',$match); // now convert all & to &amp;
	$match = str_replace('&#038;','&amp;',$match); // replaces encoded ampersand with real ones - thx WordPress
	$match = str_replace('&#215;','&#120;',$match); // replaces the multiplication character "x" with the alphabetical "x" again because WordPress did the same vice-versa before
	$return = array();
	if (preg_match(pbef_buildpattern('mode=(\d)'),$match,$hit)) { 		$return['mode'] 	= $hit[1]; }
	if (preg_match(pbef_buildpattern('playlist=(.+?)'),$match,$hit)) { 	$return['playlist'] = $hit[1]; }
	if (preg_match(pbef_buildpattern('medium=(.+?)'),$match,$hit)) { 	$return['medium'] 	= $hit[1]; }
	if (preg_match(pbef_buildpattern('w=(.+?)'),$match,$hit)) { 		$return['w'] 		= $hit[1]; }
	if (preg_match(pbef_buildpattern('h=(.+?)'),$match,$hit)) { 		$return['h'] 		= $hit[1]; }
	if (preg_match(pbef_buildpattern('class=(.+?)'),$match,$hit)) { 	$return['class'] 	= $hit[1]; }
	if (preg_match(pbef_buildpattern('style={(.+?)}'),$match,$hit)) { 	$return['style'] 	= $hit[1]; }
	if (preg_match(pbef_buildpattern('extern={(.+?)}'),$match,$hit)) { 	$return['extern'] 	= $hit[1]; }
	elseif (strpos($match,'extern=1') !== false) { 						$return['extern'] 	= 1; }
	if (preg_match(pbef_buildpattern('o={(.+?)}'),$match,$hit)) { 		$return['o'] 		= $hit[1]; }
	if (preg_match(pbef_buildpattern('f={(.+?)}'),$match,$hit)) {
		(array) $flashvars = explode('&amp;',$hit[1]);
		foreach($flashvars as $f)
		{
			$e = explode('=',$f);
			$return['flashvars'][$e[0]] = $e[1];
		} unset($flashvars,$e);
	}
	if (preg_match(pbef_buildpattern('p={(.+?)}'),$match,$hit)) {
		(array) $params = explode('|',$hit[1]);
		foreach ($params as $p)
		{
			$e = explode(';',$p);
			$return['params'][$e[0]] = $e[1];
		} unset($params,$e);
	}
	if (preg_match(pbef_buildpattern('caption={(.+?)}'),$match,$hit)) { 	$return['caption'] 	= $hit[1]; }
	if (preg_match(pbef_buildpattern('preview={(.+?)}'),$match,$hit)) { 	$return['preview'] 	= $hit[1]; }
	elseif (strpos($match,'preview=force') !== false) { 					$return['preview'] 	= 'force'; }
	if (preg_match(pbef_buildpattern('pw=(.+?)'),$match,$hit)) { 			$return['pw'] 		= $hit[1]; }
	if (preg_match(pbef_buildpattern('ph=(.+?)'),$match,$hit)) { 			$return['ph'] 		= $hit[1]; }
	if (preg_match(pbef_buildpattern('linktext={(.+?)}'),$match,$hit)) { 	$return['linktext'] = $hit[1]; }
	return $return;
}

function pb_embedFlash_assign_array($to = array(),$from = array())
{
	foreach ($from as $k => $f)
	{
		if (is_array($f))
		{
			$to[$k] = pb_embedFlash_assign_array($to[$k],$f); 
		} else {
			$to[$k] = $f;
		}
	}
	return $to;
}

function pb_embedFlash_plugin_callback($match)
{ global $pbef_jwmp_extensions; global $pbef_options;
	$values = pb_embedFlash_create_array($match[1].' '.$match[2]);
	if (is_numeric($values['playlist']))
	{
		$mm = pb_embedFlash_mm_get_data(null, null, null, null);
		$match[1] = PBEF_SITEPATH.'/inc/inc.mediamanager.php?playlist='.$values['playlist'];
		$attributes = pb_embedFlash_create_array($mm['playlists'][$values['playlist']]['attributes']);
		$values = pb_embedFlash_assign_array($attributes,$values);
		$extension = true;
	} elseif (is_numeric($values['medium'])) {		
		$mm = pb_embedFlash_mm_get_data(null, null, null, null);
		$match[1] = $mm['media'][$values['medium']]['url'];
		$image = $mm['media'][$values['medium']]['image'];
		$attributes = pb_embedFlash_create_array($mm['media'][$values['medium']]['attributes']);
		$values = pb_embedFlash_assign_array($attributes,$values);
		$fileinfo = pathinfo(array_shift(explode('?',basename($match[1]))));
		$extension = array_search(strtolower($fileinfo['extension']),$pbef_jwmp_extensions);
	} else {
		$match[1] = str_replace('&#215;','&#120;',$match[1]); // replaces the multiplication character "x" with the alphabetical "x" again because WordPress did the same vice-versa before.
		$fileinfo = pathinfo(array_shift(explode('?',basename($match[1]))));
		$extension = array_search(strtolower($fileinfo['extension']),$pbef_jwmp_extensions);
	}
	$getmode = pbef_mode((isset($values['mode']) ? $values['mode'] : $pbef_options['main']['method']));
	$mode = $getmode['mode'];
	$output = pb_embedFlash_js($mode).$getmode['target'];
	// Main Config
	if ($extension)
	{
		if (!is_array($values['flashvars'])) { $values['flashvars'] = array(); }
		if($image) { $values['flashvars']['image'] = $image; }
		$values['flashvars'] = pb_embedFlash_assign_array($pbef_options['flashvars'], $values['flashvars']);
		$values['flashvars']['file'] = $match[1];
		foreach ($values['flashvars'] as $key => $option) {
			if ($option) {
				$flashvars .= (($mode == 1)
					? 'flashvars.'.$key.' = "'.$option.'";'
					: (($mode == 4)
						? '&amp;'.$key.'['.$option.']'
						: '&amp;'.$key.'='.$option
					)
				);
				if ($pbef_options['messages']['usepreviewimageasalternativemessage'] == 1 && $key == 'image') { $mi = $option; }
			}
		}
		$flashvars = (($mode == 1 || $mode == 3)
			? $flashvars
			: (($mode == 4)
				? ' f['.substr($flashvars,5).']'
				: '<param name="flashvars" value="'.substr($flashvars,5).'" />'
			)
		);
		$output = str_replace('###FLASHVARS###',$flashvars,$output);
		$output = str_replace('###URL###',$pbef_options['main']['playerurl'].'?width=###WIDTH###&amp;height=###HEIGHT###',$output);
	} else { // not a flv file - what may it be?
		$flashvars = null;
		if (!is_array($values['flashvars'])) { $values['flashvars'] = array(); }
		foreach ($values['flashvars'] as $key => $option)
		{
			$flashvars .= '&amp;'.$key.'='.$option;
		}
		$i = 0; global $pbef_hosters;
		while (isset($pbef_hosters[$i][0])) // search for YouTube,Google Video,etc.
		{
			if (preg_match(pbef_buildpattern($pbef_hosters[$i][0],'url'),$match[1],$hit) && (count($pbef_hosters[$i]) >= 5))
			{
				if ($mode == 3)
				{
					$h = (is_numeric($values['h']) ? $values['h'] : $pbef_hosters[$i][3])+5; // make the overlay bigger before applying object tag
					$mode = -1;
					$t = pbef_mode($mode);
					$rid = 'sbox'.md5(mt_rand().$match[1]);
					$output = str_replace('##URL###',$rid, $output);
					$output = str_replace('###HEIGHT###',$h,$output);
					$output .= '<span id="'.$rid.'" style="display:none;">'.$t['target'].'</span>';		
				}
				$output = str_replace('###URL###',str_replace('###ID###',$hit[1],$pbef_hosters[$i][1]).$flashvars,$output);
				if ($pbef_options['flashbox']['loadpreviewimage'] || ($values['preview']) == 'force') { $pp = str_replace('###ID###',$hit[1],$pbef_hosters[$i][5]); }
				$w = (isset($values['w']) ? $values['w'] : $pbef_hosters[$i][2]);
				$h = (isset($values['h']) ? $values['h'] : $pbef_hosters[$i][3]);
				$output = str_replace('###WIDTH###',$w,$output);
				$output = str_replace('###HEIGHT###',$h,$output);
				unset($w,$h);
				$break = true; break 1; // stop searching if we found sth.
			}
			$i++; // we don't want an infinite loop ;)
		}
		if (!isset($break)) // seems to be a normal swf or an unknown video hoster
		{
			$output = str_replace('###URL###',$match[1].$flashvars,$output);
		}
		$output = str_replace('###FLASHVARS###','',$output);
	}
// Unique ID for SWFObject
	if ($mode == 1) {
		$output = str_replace('###SWFID###','swfid'.md5(mt_rand().$match[1]),$output);
	}
// process values
	if (is_array($values)) 
	{
		if (!isset($break)) 
		{
			$w = (isset($values['w']) ? $values['w'] : $pbef_options['main']['defwidth']);
			$h = (isset($values['h']) ? $values['h'] : $pbef_options['main']['defheight']);
			$output = str_replace('###WIDTH###',$w,$output);
			$output = str_replace('###HEIGHT###',(($extension && strpos($h,'%') === false) ? $h+20 : $h),$output);
			if ($pbef_options['messages']['usepreviewimageasalternativemessage'] == 1) { $mw = $w; $mh = $h; }
		} unset($w,$h);
		$output = str_replace('###CLASS###',(isset($values['class']) ? $values['class'] : $pbef_options['main']['defclass']),$output);
		$output = str_replace('###STYLE###',(isset($values['style']) ? ' style="'.$values['style'].'"' : $values['style']),$output);
	// Extern
		if (isset($values['extern']))
		{
			if ($values['extern'] != 1 && $values['extern'] != ' ' && !is_search())
			{
				$e = explode('|',$values['extern']);
				$extern = (($e[0] == $values['extern'] && !isset($e[1]))
					? '<a href="'.$match[1].'" title="'.$hit[1].'">'.$hit[1].'</a>'
					: '<a href="'.$e[1].'" title="'.$e[0].'">'.$e[0].'</a>'
				); unset($e);
			} else {
				$extern = (($values['extern'] && isset($break) && $pbef_hosters[$i][4] && !is_search())
					?  '<a href="'.$match[1].'" title="'.__('Watch it at','pb-embedflash').' '.$pbef_hosters[$i][4].'">'.__('Watch it at','pb-embedflash').' '.$pbef_hosters[$i][4].'</a>'
					: null
				);
			}
		}
		$output = str_replace('###EXTERN###',$extern,$output);
		unset($extern);
	// Attributes
		if (isset($values['o']))
		{
			$values['o'] = str_replace('&#8221;','"',$values['o']); // replaces the characters &#8221; and &#8243; with the real quote character again because WordPress did the same vice-versa before.
			$values['o'] = str_replace('&#8243;','"',$values['o']);
			if ($mode == 1 || $mode == 4) {
				$attr = explode(' ',$values['o']);$attributes='';
				foreach($attr as $a) {
					if (preg_match('%(.+?)="(.+?)"%',$a,$e)) {
						$attributes .= (($mode == 1)
							? 'attributes.'.$e[1].' = "'.$e[2].'";'
							: '&amp;'.$e[1].'['.$e[2].']'
						);
					}
				} unset($attr);
				$attributes = (($mode == 1) ? ' '.$attributes : ' a['.$attributes.']');
				$output = str_replace('###ATTRIBUTES###',$attributes,$output);
			} else {
				$output = str_replace('###ATTRIBUTES###',' '.$values['o'],$output);
			}
		} else {
			$output = str_replace('###ATTRIBUTES###','',$output);
		}
	// Params
		if (is_array($values['params']))
		{
			if (isset($values['params']['allowfullscreen']) === false) { $values['params']['allowfullscreen'] = 'true'; }
			if (isset($values['params']['allowscriptaccess']) === false) { $values['params']['allowscriptaccess'] = 'always'; }
			foreach ($values['params'] as $k => $v)
			{
				$params .= (($mode == 1)
					? 'params.'.$k.' = "'.$v.'";'
					: (($mode == 3 || $mode == 4)
						? '&amp;'.$k.'['.$v.']'
						: '<param name="'.$k.'" value="'.$v.'" />'
					)
				);
			}
			if ($mode == 3 || $mode == 4) 	{ $output = str_replace('###PARAM###',' p['.$params.']',$output); }
			else 							{ $output = str_replace('###PARAM###',$params,$output); }
		} else {
			if ($mode == 1) 					{ $output = str_replace('###PARAM###','params.allowfullscreen = "true"; params.allowscriptaccess = "always";',$output); }
			elseif ($mode == 3 || $mode == 4) 	{ $output = str_replace('###PARAM###',' p[allowfullscreen[true]&amp;allowscriptaccess[always]]',$output); }
			else 								{ $output = str_replace('###PARAM###','<param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" />',$output); }
		}
	// Shadowbox/Popup stuff
		if ($mode == 3 || $mode == 4 || $mode == -1)
		{
			if ((is_search() && $pbef_options['flashbox']['openarticleatsearchresults']) || is_feed()) {
				$output = '<small>('.(($pbef_options['messages']['openarticle']) ? $pbef_options['messages']['openarticle'] : __('Please open the article to see the flash file or player.','pb-embedflash')).')</small>';
			} else {
				$output = str_replace('###CAPTION###',(isset($values['caption']) ? $values['caption'] : null),$output);

				if (isset($values['preview']) && $values['preview'] != 'force') {
					$prev = explode('|',$values['preview']);
					$linktext = '<img src="'.$prev[0].'" alt="'.basename($prev[0]).'"'.
						(($prev[1] && $prev[2])
							? ' width="'.$prev[1].'" height="'.$prev[2].'"'
							: (($pbef_options['flashbox']['previewimagewidth'] && $pbef_options['flashbox']['previewimageheight'])
								?' width="'.$pbef_options['flashbox']['previewimagewidth'].'" height="'.$pbef_options['flashbox']['previewimageheight'].'"'
								: ''
							)
						).' class="fbPreview" />';
				} elseif (isset($values['linktext'])) {
					$linktext = htmlspecialchars_decode($values['linktext']);
				} elseif (($pbef_options['flashbox']['loadpreviewimage'] && !empty($pp)) || $pbef_options['flashbox']['previewimage'] || $values['preview'] == 'force') {
					if (($pbef_options['flashbox']['loadpreviewimage'] || $values['preview'] == 'force') && !empty($pp)) {
						$linktext = '<img src="'.$pp.'" alt="'.$pbef_hosters[$i][4].'"';
					} elseif ($pbef_options['flashbox']['previewimage'] || $values['preview'] == 'force') {
						$linktext = '<img src="'.$pbef_options['flashbox']['previewimageurl'].'" alt="preview image"';
					}
					if (isset($values['pw']) && isset($values['ph'])) {
						$linktext .= ' width="'.$values['pw'].'" height="'.$values['ph'].'"';
					} elseif ($pbef_options['flashbox']['previewimagewidth'] && $pbef_options['flashbox']['previewimageheight']) {
						$linktext .= ' width="'.$pbef_options['flashbox']['previewimagewidth'].'" height="'.$pbef_options['flashbox']['previewimageheight'].'"';
					}
					$linktext .= ' class="fbPreview" />';
				}
				$output = str_replace('###LINKTEXT###',(($linktext) ? $linktext : (($mode == 3 || $mode == -1) ? $pbef_options['flashbox']['deflinktext'] : $pbef_options['flashbox']['defplinktext'])),$output);
				$output = str_replace('###SHOWCLOSE###',$pbef_options['flashbox']['showclose'],$output);
				unset($linktext);
			}
		}
// use default values if none specified 
	} else {
		if (!isset($break)) {
			$output = str_replace('###WIDTH###',$pbef_options['main']['defwidth'],$output);
			$output = str_replace('###HEIGHT###',$pbef_options['main']['defheight']+($extension ? 20 : 0),$output);
		}
		$output = str_replace('###CLASS###',$pbef_options['main']['defclass'],$output);
		$output = str_replace('###STYLE###','',$output);
		$output = str_replace('###EXTERN###','',$output);
		$output = str_replace('###ATTRIBUTES###','',$output);
		$output = str_replace('###PARAM###',($mode == 1)
			? 'params.allowfullscreen = "true"; params.allowscriptaccess = "always";'
			: (($mode == 3 || $mode == 4 || $mode == -1)
				? ' p[allowfullscreen[true]&amp;allowscriptaccess[always]]'
				: '<param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" />'
			),$output);
		$output = str_replace('###FLASHVARS###','',$output);
		if ($mode == 3 || $mode == 4 || $mode == -1) {
			$output = str_replace('###CAPTION###','',$output);
			$output = str_replace('###SHOWCLOSE###',$pbef_options['flashbox']['showclose'],$output);
			if ($pbef_options['flashbox']['previewimage'] && !empty($pp)) { $linktext = '<img src="'.$pp.'" alt="'.$pbef_hosters[$i][4].'" />'; }
			$output = str_replace('###SHOWCLOSE###',(($linktext) ? $linktext : (($mode == 3 || $mode == -1) ? $pbef_options['flashbox']['deflinktext'] : $pbef_options['flashbox']['defplinktext'])),$output);			
		}
	} unset($break,$extension,$mode);
	
	if (isset($mi)) {
		$output = str_replace('###MSG###','<img src="'.$mi.'" alt="" width="'.$mw.'" height="'.$mh.'" class="alternativeimage" />',$output);
	} else {
		$output = str_replace('###MSG###','<small>('.(
			(!is_search() && !is_feed()) // search results don't offer HTML,so no <object>,too; some feed reader  don't support <oject> and <a>...
				? (($pbef_options['messages']['nojs']) // adding message about missing JavaScript and/or an old Flash Player
					? $pbef_options['messages']['nojs']
					: __('Either JavaScript is not active or you are using an old version of Adobe Flash Player. <a href="http://www.adobe.com/de/">Please install the newest Flash Player</a>.','pb-embedflash')
				) : (($pbef_options['messages']['openarticle'])
					? $pbef_options['messages']['openarticle']
					: __('Please open the article to see the flash file or player.','pb-embedflash'))
		).')</small>',$output);
	}
	return ($output);
} // pb_embedflash

/*
** Media Manager stuff
*/
function pb_embedFlash_ajax_mediamanager()
{
	extract($_POST);
	$page = (int) $page;
	$limit = (int) $limit;
	$returnscript = null;
	if (!$mm = pb_embedFlash_mm_get_data($orderby,$order,null,null)) { $mm = array('media' => array(),'playlists' => array(),'count' => array('media' => 0,'playlists' => 0)); };	
	if ($mode == 'media_add')
	{
		if (!isset($mm['media'][$id]))
		{
			$url = rawurldecode($url);
			if (preg_match(pbef_buildpattern('youtube\.com/watch\?v=([\w-]+)','url'),$url,$hit))
			{
				if (empty($image)) { $image = str_replace('###ID###',$hit[1],'http://i.ytimg.com/vi/###ID###/0.jpg'); }
				if (empty($link)) { $link = $url; }
				if (empty($album)) { $album = 'YouTube'; }
				$type = null;
			}
			$mm['media'][$id]['id'] = $id;
			$mm['media'][$id]['url'] = ((!empty($url) && $url != 'undefined') ? $url : null);
			$mm['media'][$id]['title'] = ((!empty($title) && $title != 'undefined') ? rawurldecode($title) : null);
			$mm['media'][$id]['image'] = ((!empty($image) && $image != 'undefined') ? rawurldecode($image) : null);
			$mm['media'][$id]['author'] = ((!empty($author) && $author != 'undefined') ? rawurldecode($author) : null);
			$mm['media'][$id]['type'] = ((!empty($type) && $type != 'undefined') ? rawurldecode($type) : null);
			$mm['media'][$id]['link'] = ((!empty($link) && $link != 'undefined') ? rawurldecode($link) : null);
			$mm['media'][$id]['album'] = ((!empty($album) && $album != 'undefined') ? rawurldecode($album) : null);
			$mm['media'][$id]['captions'] = ((!empty($captions) && $captions != 'undefined') ? rawurldecode($captions) : null);
			$mm['media'][$id]['audio'] = ((!empty($audio) && $audio != 'undefined') ? rawurldecode($audio) : null);

			$count = pbef_options();
			$count['mm']['count_media']++;
			update_option('pb_embedFlash',$count);
			pb_embedFlash_mm_save_data('media_add',$mm['media'][$id]);
			
			$table = rawurlencode(pb_embedFlash_generate_media_table($mm['media'],$page,$limit));
			$returnscript = <<<RETURN
				pb_embedFlash_mediamanager('clear_media', '', '');
				document.getElementById('media_table').innerHTML = decodeURIComponent('{$table}');
				document.getElementById('media-add-id').value = {$id} + 1;
RETURN;
		} else {
			$returnscript = "alert('The media ID $id already exists!');";
		}
	} elseif ($mode == 'media_edit_submit') {
		if (isset($mm['media'][$id]))
		{
			$mm['media'][$id]['url'] = ((!empty($url) && $url != 'undefined') ? rawurldecode($url) : null);
			$mm['media'][$id]['title'] = ((!empty($title) && $title != 'undefined') ? rawurldecode($title) : null);
			$mm['media'][$id]['image'] = ((!empty($image) && $image != 'undefined') ? rawurldecode($image) : null);
			$mm['media'][$id]['link'] = ((!empty($link) && $link != 'undefined') ? rawurldecode($link) : null);
			$mm['media'][$id]['type'] = ((!empty($type) && $type != 'undefined') ? rawurldecode($type) : null);
			$mm['media'][$id]['captions'] = ((!empty($captions) && $captions != 'undefined') ? rawurldecode($captions) : null);
			$mm['media'][$id]['audio'] = ((!empty($audio) && $audio != 'undefined') ? rawurldecode($audio) : null);
			$mm['media'][$id]['album'] = ((!empty($album) && $album != 'undefined') ? rawurldecode($album) : null);
			$mm['media'][$id]['author'] = ((!empty($author) && $author != 'undefined') ? rawurldecode($author) : null);
			$mm['media'][$id]['attributes'] = ((!empty($attributes) && $attributes != 'undefined') ? rawurldecode($attributes) : null);
			pb_embedFlash_mm_save_data('media_edit_submit',$mm['media'][$id]);
			$table = rawurlencode(pb_embedFlash_generate_media_table($mm['media'],$page,$limit));
			$returnscript = "document.getElementById('media_table').innerHTML = decodeURIComponent('{$table}');";
		} else {
			$returnscript = "alert('The medium ID $id does not exist!');";
		}
	} elseif ($mode == 'media_del') {
		if (isset($mm['media'][$id]))
		{
			if (isset($mm['playlists'])) { foreach ($mm['playlists'] as $k => $p) {
				if (is_array($p['ids'])) { foreach (array_keys($p['ids'],$id) as $v) {
					unset($mm['playlists'][$k]['ids'][$v]);
					pb_embedFlash_mm_save_data('update_ids',$mm['playlists'][$k]);
				} }
			} }
			unset($mm['media'][$id]);
			pb_embedFlash_mm_save_data('media_del',$id);
#			$returnscript = "document.getElementById('media-list').removeChild(document.getElementById('media-$id'));document.getElementById('media-list').removeChild(document.getElementById('media-$id-two'));";
			$table = rawurlencode(pb_embedFlash_generate_media_table($mm['media'],$page,$limit));
			$returnscript = "document.getElementById('media_table').innerHTML = decodeURIComponent('{$table}');";
			if (count($mm['media']) == 0) { $returnscript .= "document.getElementById('nomedia').style['display'] = '';"; }
		} else {
			$returnscript = "alert('The medium ID $id does not exist!');";
		}
	} elseif ($mode == 'playlists_add') {
		if (isset($mm['playlists'][$id]) === false)
		{
			$mm['playlists'][$id]['id'] = $id;
			$mm['playlists'][$id]['title'] = ((!empty($title) && $title != 'undefined') ? rawurldecode($title) : 'Playlist '.$id);
			$mm['playlists'][$id]['attributes'] = ((!empty($attributes) && $attributes != 'undefined') ? rawurldecode($attributes) : null);
			$mm['playlists'][$id]['ids'] = array();
			$count = pbef_options();
			$count['mm']['count_playlists']++;
			update_option('pb_embedFlash',$count);
			pb_embedFlash_mm_save_data('playlists_add',$mm['playlists'][$id]);
			
			$table = rawurlencode(pb_embedFlash_generate_playlists_table($mm,$page,$limit));
			$returnscript = <<<RETURN
				document.getElementById('playlistsbox').style['display'] = 'none';
				document.getElementById('playlists_table').innerHTML = decodeURIComponent('{$table}');
				document.getElementById('playlists-add-id').value = {$id} + 1;
RETURN;
			foreach ($mm['media'] as $k => $m) {
				$returnscript .= <<<RETURN
					var el{$k} = document.createElement('option');
					el{$k}.id = 'm-{$k}_p-{$id}';
					el{$k}.value = '{$id}';
					el{$k}.innerHTML = decodeURIComponent('{$title}');
					document.getElementById('media_items-{$k}-select').appendChild(el{$k});
RETURN;
				if (count($mm['playlists']) == 1)
				{
					$returnscript .= "document.getElementById('media_items-$k-select').removeChild(document.getElementById('m-".$k."_p-0'));
						document.getElementById('media_items-{$k}-button').disabled = false;";
				}
			}
		} else {
			$returnscript = "alert('".__('The playlist ID $id already exists!','pb-embedflash')."');";
		}
	} elseif ($mode == 'playlists_edit_submit') {
		if (isset($mm['playlists'][$id]))
		{
			$mm['playlists'][$id]['title'] = ((!empty($title) && $title != 'undefined') ? rawurldecode($title) : null);
			$mm['playlists'][$id]['attributes'] = ((!empty($attributes) && $attributes != 'undefined') ? rawurldecode($attributes) : null);
			pb_embedFlash_mm_save_data('playlists_edit_submit',$mm['playlists'][$id]);
			foreach ($mm['media'] as $i => $m)
			{
				$returnscript .= "document.getElementById('m-{$i}_p-{$id}').innerHTML = decodeURIComponent('{$title}');";
			}
			$returnscript .= <<<RETURN
				document.getElementById('playlistsbox').style['display'] = 'none';
				document.getElementById('playlists-{$id}-title').innerHTML = decodeURIComponent('{$title}');
				document.getElementById('playlists-{$id}-attributes').innerHTML = decodeURIComponent('{$attributes}');
RETURN;
		} else {
			$returnscript = "alert('The medium ID $id does not exist!');";
		}
	} elseif ($mode == 'playlists_del') {
		if (isset($mm['playlists'][$id]))
		{
			unset($mm['playlists'][$id]);
			pb_embedFlash_mm_save_data('playlists_del',$id);
#			$returnscript = "document.getElementById('playlists-list').removeChild(document.getElementById('playlists-$id')); document.getElementById('playlists-list').removeChild(document.getElementById('playlists-$id-two'));";
			$table = rawurlencode(pb_embedFlash_generate_playlists_table($mm,$page,$limit));
			$returnscript = "document.getElementById('playlists_table').innerHTML = decodeURIComponent('{$table}');";
			if (is_array($mm['media'])) { foreach ($mm['media'] as $k => $m) {
				$returnscript .= "document.getElementById('media_items-$k-select').removeChild(document.getElementById('m-".$k."_p-$id'));";
				if (count($mm['playlists']) == 0)
				{
					$noplaylists = __('No playlists','pb-embedflash');
					$returnscript .= <<<RETURN
					var el{$k} = document.createElement('option');
					el{$k}.id = 'm-{$k}_p-0';
					el{$k}.value = '0';
					el{$k}.innerHTML = '{$noplaylists}';
					document.getElementById('media_items-{$k}-select').appendChild(el{$k})
					document.getElementById('media_items-{$k}-button').disabled = true;
RETURN;
				}
			} }
			if (count($mm['playlists']) == 0) { $returnscript .= "document.getElementById('noplaylists').style['display'] = '';"; }
		} else {
			$returnscript = "alert('The playlist ID $id does not exist!');";
		}
	} elseif ($mode == 'media_items_add') {
		if (isset($mm['media'][$mid]) && isset($mm['playlists'][$id]))
		{
			$mm['playlists'][$id]['ids'][] = $mid;
			$s = count(array_keys($mm['playlists'][$id]['ids'],$mid));
			$title = rawurlencode($mm['media'][$mid]['title']);
			pb_embedFlash_mm_save_data('update_ids',$mm['playlists'][$id]); # 8625; 8626
			$returnscript = <<<RETURN
				var title = decodeURIComponent('{$title}');
				var el = document.createElement('div');
				el.id = 'playlists-{$id}-ids-{$mid}';
				el.innerHTML = '[<a href="javascript:pb_embedFlash_mediamanager(\'media_items_up\',\'{$id}\',\'{$mid}.{$s}\');">&#9650;</a>]&nbsp;&nbsp;[<a href="javascript:pb_embedFlash_mediamanager(\'media_items_down\',\'{$id}\',\'{$mid}.{$s}\');">&#9660;</a>]&nbsp;&nbsp;[<a href="javascript:pb_embedFlash_mediamanager(\'media_items_del\',\'{$id}\',\'{$mid}.{$s}\');">x</a>]&nbsp;&nbsp;({$mid}) '+title;
				document.getElementById('playlists-{$id}-ids').appendChild(el);
				if (document.getElementById('ids-nomedia-{$id}').style.display == 'block') { document.getElementById('ids-nomedia-{$id}').style.display = 'none'; }
RETURN;
		} else {
			$returnscript = "alert('".__('The media ID '.$mid.' and/or the playlist ID '.$id.' do/es not exist!','pb-embedflash')."');";
		}
	} elseif ($mode == 'media_items_del') {
		$a = explode('.',$mid);
		if (isset($mm['media'][$a[0]]) && isset($mm['playlists'][$id]['ids']))
		{
			$s = array_keys($mm['playlists'][$id]['ids'],$a[0]);
			unset($mm['playlists'][$id]['ids'][$s[$a[1]-1]]);
			$mm['playlists'][$id]['ids'] = array_values($mm['playlists'][$id]['ids']);
			pb_embedFlash_mm_save_data('update_ids',$mm['playlists'][$id]);
			if (!empty($mm['playlists'][$id]['ids'])) {
				$items = rawurlencode(pb_embedFlash_generate_media_items($mm,$id));
				$returnscript = "document.getElementById('playlists-$id-ids').innerHTML = decodeURIComponent('$items');";
			} else {
				$returnscript = "document.getElementById('playlists-$id-ids').innerHTML = '<div id=\"ids-nomedia-$id\" style=\"width:100%; text-align: left; display: none\"><em><small>No media added to this playlist</small></em></div>';
					if (document.getElementById('ids-nomedia-$id').style.display) { document.getElementById('ids-nomedia-$id').style.display = 'block'; }";
			}
		} else {
			$returnscript = "alert('".__('The media ID '.$a[0].' and/or the playlist ID '.$id.' do/es not exist!','pb-embedflash')."');";
		}
	} elseif ($mode == 'media_items_up' || $mode == 'media_items_down') {
		$a = explode('.',$mid);
		if (isset($mm['media'][$a[0]]) && is_array($mm['playlists'][$id]['ids']))
		{
			$e = array_keys($mm['playlists'][$id]['ids']);
			$s = array_keys($mm['playlists'][$id]['ids'],$a[0]);
			$t = $s[$a[1]-1];
			$x = (($mode == 'media_items_up') ? -1 : 1);
			if (($mode == 'media_items_up' && $t != reset($e)) || ($mode == 'media_items_down' && $t != end($e)))
			{
				$tmp = $mm['playlists'][$id]['ids'][$t];
				$mm['playlists'][$id]['ids'][$t] = $mm['playlists'][$id]['ids'][$t+$x];
				$mm['playlists'][$id]['ids'][$t+$x] = $tmp;
				$mm['playlists'][$id]['ids'] = array_values($mm['playlists'][$id]['ids']);
				pb_embedFlash_mm_save_data('update_ids',$mm['playlists'][$id]);
				$items = rawurlencode(pb_embedFlash_generate_media_items($mm,$id));
				$returnscript = "document.getElementById('playlists-$id-ids').innerHTML = decodeURIComponent('$items');";
			}
		} else {
			$returnscript = "alert('".__('The media ID '.$mid.' does not exist in playlist ID '.$id.'!','pb-embedflash')."');";
		}
	} elseif ($mode == 'media_import') {
		if (!isset($mm['media'][$id]))
		{
			$data = pb_embedFlash_mm_import_from_wp($mid);
			$mm['media'][$id]['id'] = $id;
			$mm['media'][$id]['url'] = $data[0]['guid'];
			$mm['media'][$id]['title'] = $data[0]['post_title'];
			$mm['media'][$id]['image'] = null;
			$mm['media'][$id]['author'] = null;
			$mm['media'][$id]['type'] = null;
			$mm['media'][$id]['link'] = null;
			$mm['media'][$id]['album'] = null;
			$mm['media'][$id]['captions'] = null;
			$mm['media'][$id]['audio'] = null;

			$count = pbef_options();
			$count['mm']['count_media']++;
			update_option('pb_embedFlash',$count);
			pb_embedFlash_mm_save_data('media_import',$mm['media'][$id]);
			
			$table = rawurlencode(pb_embedFlash_generate_media_table($mm['media'],$page,$limit));
			$returnscript = <<<RETURN
				pb_embedFlash_mediamanager('clear_media', '', '');
				document.getElementById('media_table').innerHTML = decodeURIComponent('{$table}');
				document.getElementById('media-add-id').value = {$id} + 1;
RETURN;
		} else {
			$returnscript = "alert('The media ID $id already exists!');";
		}
	}
	die($returnscript);
} // pb_embedFlash_ajax_mediamanager

function pb_embedFlash_generate_media_table($mm = null,$page = 1,$limit = 15) // $mm['media']
{
	$pbefsp = PBEF_SITEPATH;
	if (!is_int($limit)) { $limit = 15; }
	$offset = ((!is_int($page) || $page <= 1) ? 0 : (($page-1) * $limit));
	$display = (is_array($mm) ? 'none' : '' );
	$c = null;
	$table = '<table id="media" class="widefat">
		<thead>
			<tr>
				<!-- <th scope="col" class="check-column"><input type="checkbox" onclick="checkAll(document.getElementById(\'posts-filter\'));" /></th> -->
				<th scope="col">'.__('Image','pb-embedflash').'</th>
				<th scope="col">'.__('Media','pb-embedflash').'</th>
				<th scope="col">'.__('Type','pb-embedflash').'</th>
				<th scope="col">'.__('Author','pb-embedflash').'</th>
				<th scope="col">'.__('Link','pb-embedflash').'</th>
				<th scope="col">'.__('Album','pb-embedflash').'</th>
				<th scope="col">'.__('Captions','pb-embedflash').'</th>
				<th scope="col">'.__('Audio','pb-embedflash').'</th>
			</tr>
		</thead>
		<tbody id="media-list" class="list:post">
			<tr id="nomedia" class="alternate author-self status-publish" style="display: '.$display.'">
				<td colspan="8" style="text-align: center;"><em>'.__('No media','pb-embedflash').'</em></td>
			</tr>';
	if (is_array($mm)) { foreach (array_slice($mm,$offset,$limit) as $id => $m) {
#		PBEF_SITEPATH.'/css/images/nopic.png
		$image =    (!empty($m['image']) ? '<a href="'.$m['image'].'" title="'.$m['title'].'"><img id="media-'.$m['id'].'-image" alt="'.$m['title'].'" src="'.$m['image'].'" width="80" height="60" class="attachment-80x60" /></a>' : '&nbsp;');
		$link =     (!empty($m['link']) ? '<a href="'.$m['link'].'" id="media-'.$m['id'].'-link">'.$m['link'].'</a>' : '&nbsp;');
		$captions = (!empty($m['captions']) ? '<a id="media-'.$m['id'].'-captions" href="'.$m['captions'].'">'.basename($m['captions']).'</a>' : '&nbsp;');
		$audio =    (!empty($m['audio']) ? '<a id="media-'.$m['id'].'-audio" href="'.$m['audio'].'">'.basename($m['audio']).'</a>' : '&nbsp;');
		$type = null;
		$c = (empty($c) ? 'alternate ' : null);

		$table .= <<<TABLE
			<tr id="media-{$m['id']}" class="{$c}author-self status-publish" valign="top">
				<!-- <th scope="row" class="check-column"><input type="checkbox" name="delete[]" value="{$m['id']}" /></th> -->
				<td class="media-icon" rowspan="2">{$image}</td>
				<td><strong><a href="{$m['url']}" id="media-{$m['id']}-url-title">{$m['title']}</a></strong></td>
				<td id="media-{$m['id']}-type">{$m['type']}</td>
				<td id="media-{$m['id']}-author">{$m['author']}</td>
				<td>{$link}</td>
				<td id="media-{$m['id']}-album">{$m['album']}</td>
				<td>{$captions}</td>
				<td>{$audio}</td>
			</tr>
			<tr id="media-{$m['id']}-two">
				<td colspan="7" class="{$c}author-self status-publish">
					<div style="float: left; width: 710px; overflow: hidden;">
						<div id="media-{$m['id']}-url-div">{$m['url']}</div>
						<div id="media-{$m['id']}-attributes">{$m['attributes']}</div>
					</div>
					<div style="float: right;">
						<span style=" vertical-align: top;">[ {$m['id']} ]</span>
						&nbsp;
						<a href="javascript:pb_embedFlash_mediamanager('media_edit','{$m['id']}','');"><img src="{$pbefsp}/css/images/mm_edit.png" /></a>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="javascript:pb_embedFlash_mediamanager('media_del','{$m['id']}','');"><img src="{$pbefsp}/css/images/mm_delete.png" /></a>
					</div>
				</td>
			</tr>	
TABLE;
	} }
	$table .= '</tbody></table>';
	return(str_replace(array("\t","\n","\r","\0","\x0B"),'',$table));
}

function pb_embedFlash_generate_playlists_table($mm = null,$page = 1,$limit = 15)
{
	$pbefsp = PBEF_SITEPATH;
	if (!is_int($limit)) { $limit = 15; }
	$offset = ((!is_int($page) || $page <= 1) ? 0 : (($page-1) * $limit));
	$display = (is_array($mm['playlists']) ? 'none' : '' );
	$c = null;
	$table = '<table id="playlists" class="widefat">
		<thead>
			<tr>
				<!-- <th scope="col" class="check-column"><input type="checkbox" onclick="checkAll(document.getElementById(\'posts-filter\'));" /></th> -->
				<th scope="col">'.__('ID','pb-embedflash').'</th>
				<th scope="col">'.__('Title','pb-embedflash').'</th>
				<th scope="col">'.__('Attributes','pb-embedflash').'</th>
			</tr>
		</thead>
		<tbody id="playlists-list" class="list:post">
			<tr id="noplaylists" class="alternate" style="display: '.$display.'">
				<td colspan="8" style="text-align: center;"><em>'.__('No playlists','pb-embedflash').'</em></td>
			</tr>';
	if (is_array($mm['playlists'])) { foreach (array_slice($mm['playlists'],$offset,$limit) as $id => $p) {
		$c = (empty($c) ? 'alternate ' : null);
		$table .= <<<TABLE
			<tr id="playlists-{$p['id']}" class="{$c}author-self status-publishe" valign="top">
				<!-- <th scope="row" class="check-column"><input type="checkbox" name="delete[]" value="{$p['id']}" /></th> -->
				<td>{$p['id']}</td>
				<td><strong id="playlists-{$p['id']}-title">{$p['title']}</strong></td>
				<td id="playlists-{$p['id']}-attributes">{$p['attributes']}</td>
			</tr>
			<tr id="playlists-{$p['id']}-two">
				<td colspan="3" class="{$c}author-self status-publish">
					<div style="float: left; width: 740px;" id="playlists-{$p['id']}-ids">
TABLE;
		$table .= pb_embedFlash_generate_media_items($mm,$p['id']);
		$table .= <<<TABLE
					</div>
					<div style="float: right;">
						<a href="javascript:pb_embedFlash_mediamanager('playlists_edit','{$p['id']}','');"><img src="{$pbefsp}/css/images/mm_edit.png" /></a>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="javascript:pb_embedFlash_mediamanager('playlists_del','{$p['id']}','');"><img src="{$pbefsp}/css/images/mm_delete.png" /></a>
					</div>
				</td>
			</tr>		
TABLE;
	} }
	$table .= '</tbody></table>';
	return(str_replace(array("\t","\n","\r","\0","\x0B"),'',$table));
}

function pb_embedFlash_generate_media_items($mm = null,$id = null)
{
	$count = null;
	$mm['media'] = pb_embedFlash_mm_get_media_data(null, null, null, null);
	if (is_array($mm['playlists'][$id]['ids'])) { foreach ($mm['playlists'][$id]['ids'] as $i) {
		$count[$i]++; # 8625; 8626
		$returnids .= <<<IDs
			<div id="playlists-{$id}-ids-{$i}.{$count[$i]}">
			[<a href="javascript:pb_embedFlash_mediamanager('media_items_up','{$id}','{$i}.{$count[$i]}');">&#9650;</a>]&nbsp;&nbsp;
			[<a href="javascript:pb_embedFlash_mediamanager('media_items_down','{$id}','{$i}.{$count[$i]}');">&#9660;</a>]&nbsp;&nbsp;
			[<a href="javascript:pb_embedFlash_mediamanager('media_items_del','{$id}','{$i}.{$count[$i]}');">x</a>]&nbsp;&nbsp;
			({$i}) {$mm['media'][$i]['title']}</div>
IDs;
	} }
	$returnids .= '<div id="ids-nomedia-'.$id.'" style="width:100%; text-align: left; display: '.($count ? 'none' : '').'"><em><small>No media added to this playlist</small></em></div>';
	return(str_replace(array("\t","\n","\r","\0","\x0B"),'',$returnids));
}


function pb_embedFlash_mm_save_data($action = false,$save = null)
{
	global $wpdb;
#	$wpdb->show_errors();
   	$pbefmm_media 		= $wpdb->prefix.'pbefmm_media';
	$pbefmm_playlists 	= $wpdb->prefix.'pbefmm_playlists';
	if (($action == 'media_add' || $action == 'media_import') && is_array($save))
	{
		$sql = "INSERT INTO `$pbefmm_media` (`id`,`url`,`title`,`image`,`author`,`link`,`type`,`captions`,`audio`,`album`,`attributes`)
			VALUES ('".$save['id']."','".$save['url']."','".$save['title']."','".$save['image']."','".$save['author']."','".$save['link']."','".$save['type']."','".$save['captions']."','".$save['audio']."','".$save['album']."','".$save['attributes']."');";
	} elseif ($action == 'media_edit_submit' && is_array($save)) {
		$sql = "UPDATE `$pbefmm_media` SET 
			`url` = '".$save['url']."',
			`title` = '".$save['title']."',
			`image` = '".$save['image']."',
			`author` = '".$save['author']."',
			`link` = '".$save['link']."',
			`type` = '".$save['type']."',
			`captions` = '".$save['captions']."',
			`audio` = '".$save['audio']."',
			`album` = '".$save['album']."',
			`attributes` = '".$save['attributes']."'
			WHERE `id` = '".$save['id']."';";
	} elseif ($action == 'media_del' && is_numeric($save)) {
		$sql = "DELETE FROM `$pbefmm_media` WHERE `id` = '$save';";
	} elseif ($action == 'playlists_add' && is_array($save)) {
		$sql = "INSERT INTO `$pbefmm_playlists` (`id`,`title`,`attributes`)
			VALUES ('".$save['id']."','".$save['title']."','".$save['attributes']."');";
	} elseif ($action == 'playlists_edit_submit' && is_array($save)) {
		$sql = "UPDATE `$pbefmm_playlists` SET 
			`title` = '".$save['title']."',
			`attributes` = '".$save['attributes']."'
			WHERE `id` = '".$save['id']."';";
	} elseif ($action == 'playlists_del' && is_numeric($save)) {
		$sql = "DELETE FROM `$pbefmm_playlists` WHERE `id` = '$save';";
	} elseif ($action == 'update_ids' && is_array($save)) {
		$sql = "UPDATE `$pbefmm_playlists` SET `ids` = '".serialize($save['ids'])."' WHERE `id` = '".$save['id']."';";
	}
	if (isset($sql)) { $wpdb->query($sql); }
	return false;
}

function pb_embedFlash_mm_get_media_data($orderby = 'id',$order = 'ASC',$page = 1,$limit = 15)
{
	if (empty($orderby)) { $orderby = 'id'; }
	if (empty($order)) { $order = 'ASC'; }
	if ($limit == null) { $LIMIT = ''; } else {
		if (!is_int($limit)) { $limit = 15; }
		$offset = ((!is_int($page) || $page < 1) ? 0 : (($page-1) * $limit));
		$LIMIT = "LIMIT $offset,$limit";
	}
	global $wpdb;
#	$wpdb->show_errors();
   	$pbefmm_media 		= $wpdb->prefix.'pbefmm_media';
	$result = $wpdb->get_results("SELECT * FROM `$pbefmm_media` ORDER BY `$orderby` $order $LIMIT;",ARRAY_A);
	if(is_array($result)) { foreach ($result as $m) { foreach ($m as $k => $v) { $array[$m['id']][$k] = $v; } } }
	return $array;
}
function pb_embedFlash_mm_get_playlists_data($orderby = 'id',$order = 'ASC',$page = 1,$limit = 15)
{
	if (empty($orderby)) { $orderby = 'id'; }
	if (empty($order)) { $order = 'ASC'; }
	if ($limit == null) { $LIMIT = ''; } else {
		if (!is_int($limit)) { $limit = 15; }
		$offset = ((!is_int($page) || $page < 1) ? 0 : (($page-1) * $limit));
		$LIMIT = "LIMIT $offset,$limit";
	}
	global $wpdb;
#	$wpdb->show_errors();
	$pbefmm_playlists 	= $wpdb->prefix.'pbefmm_playlists';
	$result = $wpdb->get_results("SELECT * FROM `$pbefmm_playlists` ORDER BY `$orderby` $order $LIMIT;",ARRAY_A);
	if(is_array($result)) { foreach ($result as $p) { foreach ($p as $k => $v) { $array[$p['id']][$k] = (($k == 'ids') ? unserialize($v) : $v); } } }
	return $array;
}
function pb_embedFlash_mm_get_data($orderby = 'id',$order = 'ASC',$page = 1,$limit = 15)
{
	$mm['media'] = pb_embedFlash_mm_get_media_data($orderby,$order,$page,$limit);
	$mm['playlists'] = pb_embedFlash_mm_get_playlists_data($orderby,$order,$page,$limit);
	return $mm;
}

function pb_embedFlash_mm_count_data($target = 'media')
{
	global $wpdb;
#	$wpdb->show_errors();
	if ($target == 'media' || empty($target))
	{
	   	$pbefmm_media = $wpdb->prefix.'pbefmm_media';
		$result = $wpdb->get_results("SELECT `id` FROM `$pbefmm_media`",ARRAY_A);
	} elseif ($target == 'playlists') {
	   	$pbefmm_playlists = $wpdb->prefix.'pbefmm_playlists';
		$result = $wpdb->get_results("SELECT `id` FROM `$pbefmm_playlists`",ARRAY_A);
	}
	if(is_array($result)) { return count($result); } else { return false; }
}

function pb_embedFlash_mm_import_from_wp($id = null)
{
	global $wpdb;
	$wp_posts = $wpdb->prefix.'posts';
	if (is_numeric($id))
	{
		$result = $wpdb->get_results("SELECT `post_title`, `guid` FROM `$wp_posts` WHERE `ID` = '$id'",ARRAY_A);
	} else { // create list of importable data
		$result = $wpdb->get_results("SELECT `ID`, `post_title` FROM `$wp_posts` WHERE `post_type` = 'attachment' ORDER BY `post_title` ASC",ARRAY_A);
	}
	return $result;
}
?>