<?php
/*
Part of pb-embedFlash v1.5
© Pascal Berkhahn, <novayuna@googlemail.com>, http://pascal-berkhahn.de
*/
if (!function_exists('get_option')) { echo "Please don't load this file directly."; exit; }

$options = array( // default values
	'main' => array(
		'method' => 0,
		'shadowbox' => 1,
		'sbframework' => 1,
		'defwidth' => 425,
		'defheight' => 355,
		'defclass' => 'embedflash',
		'deleteoptionsondeactivation' => 0,
		'playerurl' => PBEF_SITEPATH.'/swf/mediaplayer.swf',
		'swfobjecturl' => PBEF_SITEPATH.'/js/swfobject.js',
		'shadowboxurl' => PBEF_SITEPATH.'/js/shadowbox.js',
		'shadowboxcssurl' => PBEF_SITEPATH.'/css/shadowbox.css',
		'sbadapterurl' => PBEF_SITEPATH.'/js/sbadapter/',
		'sbadapter' => 'jquery',
		'sbincluded' => array(
			'jquery' => '1.2.3',
			#'prototype' => '1.6.0',
			'mootools' => '1.11'
		),
		'mootools' => PBEF_SITEPATH.'/js/mootools.js',
		'popupurl' => PBEF_SITEPATH.'/js/popup.js'
	),
	'messages' => array(
		'nojs' => __('Either JavaScript is not active or you are using an old version of Adobe Flash Player. <a href="http://www.adobe.com/">Please install the newest Flash Player</a>.', 'pb-embedflash'),
		'openarticle' => __('Please open the article to see the flash file or player.', 'pb-embedflash'),
		'usepreviewimageasalternativemessage' => 0
	),	
	'flashbox' => array( // shadowbox, popup
		'previewimage' => 1,
		'previewimagewidth' => null,
		'previewimageheight' => null,
		'previewimageurl' =>PBEF_SITEPATH.'/css/images/previewimage.png',
		'loadpreviewimage' => 1, // YouTube & GameVideos
		'openarticleatsearchresults' => 1,		
		'deflinktext' => __('- Watch the video in an overlay -', 'pb-embedflash'),		
		'defplinktext' => __('- Watch the video in a popup window -', 'pb-embedflash')
	),
	'shadowboxtexts' => array(
		'cancel' => __('Cancel', 'pb-embedflash'),
		'loading' => __('loading', 'pb-embedflash'),
		'close' => '<span class="shortcut">C</span>lose',
		'next' => '<span class="shortcut">N</span>ext',
		'prev' => '<span class="shortcut">P</span>revious',
		'errors' => array(
			'single' => 'You must install the <a href="{0}">{1}</a> browser plugin to view this content.',
			'shared' => 'You must install both the <a href="{0}">{1}</a> and <a href="{2}">{3}</a> browser plugins to view this content.',
			'either' => 'You must install either the <a href="{0}">{1}</a> or the <a href="{2}">{3}</a> browser plugin to view this content.'
		)
	),
	'shadowboxoptions' => array(
		'assetURL' => null,
		'loadingImage' => PBEF_SITEPATH.'/css/images/loading.gif',
		'flvPlayer' => PBEF_SITEPATH.'/swf/mediaplayer.swf',
		'animate' => 'true',
		'animSequence' => 'wh', 				//wh, hw, sync
		'overlayColor' => '#000',
		'overlayOpacity' => 0.85,
		'overlayBgImage' => PBEF_SITEPATH.'/css/images/overlay-85.png',
		'listenOverlay' => 'true', 				//close on click
		'autoplayMovies' => 'true',
		'showMovieControls' => 'true',
		'resizeDuration' => 0.35,
		'fadeDuration' => 0.35,
		'displayNav' => 'true',
		'continuous' => 'false',
		'displayCounter' => 'true',
		'counterType' => 'default', 			//default, skip
		'viewportPadding' => 20,
		'handleLgImages' => 'resize', 			//resize, drag, none
		'initialHeight' => 160,
		'initialWidth' => 320,
		'enableKeys' => 'true',
		'keysClose' => 'c',
		'keysNext' => 'n',
		'keysPrev' => 'p'
	),
	'flashvars' => array(
		'source' => null,
		'height' => null,
		'width' => null,
		'file' => null,
		'image' => null,
		'id' => null,
		'searchbar' => 'false',
		'backcolor' => null,
		'frontcolor' => null,
		'lightcolor' => null,
		'screencolor' => null,
		'logo' => null,
		'overstretch' => null,
		'showeq' => null,
		'showicons' => null,
		'transition' => null,
		'shownavigation' => null,
		'showstop' => null,
		'showdigits' => null,
		'showdownload' => null,
		'usefullscreen' => null,
		'autoscroll' => null,
		'displayheight' => null,
		'displaywidth' => null,
		'thumbsinplaylist' => null,
		'audio' => null,
		'autostart' => null,
		'bufferlength' => null,
		'captions' => null,
		'fallback' => null,
		'repeat' => null,
		'rotatetime' => null,
		'shuffle' => null,
		'smoothing' => null,
		'volume' => null,
		'callback' => null,
		'enablejs' => null,
		'javascriptid' => null,
		'link' => null,
		'linkfromdisplay' => null,
		'linktarget' => null,
		'recommendations' => null,
		'streamscript' => null,
		'type' => null
	),
	'apd' => array(
		'basics' => 'none',
		'colors' => 'none',
		'display' => 'none',
		'controls' => 'none',
		'playlists' => 'none',
		'behaviour' => 'none',
		'communication' => 'none'
	),
	'mm' => array(
		'count_media' => 0,
		'count_playlists' => 0
	)
);
?>