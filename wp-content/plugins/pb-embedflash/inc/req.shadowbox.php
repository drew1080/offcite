<?php 
	$pbef_options = pbef_options();
	$adapter = $pbef_options['main']['sbadapter'];
	if ($pbef_options['main']['sbframework'])
	{ 
		switch ($adapter)
		{
			case 'jquery': 
				$add .= '<script type="text/javascript" src="'.get_option('siteurl').'/wp-includes/js/jquery/jquery.js"></script>';
				break;
			case 'prototype': 
				$add .= '<script type="text/javascript" src="'.get_option('siteurl').'/wp-includes/js/scriptaculous/prototype.js"></script>';
				$add .= '<script type="text/javascript" src="'.get_option('siteurl').'/wp-includes/js/scriptaculous/scriptaculous.js"></script>';
				break;
			case 'mootools': 
				$add .= '<script type="text/javascript" src="'.$pbef_options['main']['sbadapterurl'].'mootools.js"></script>';
				define('PBEF_LOADED_MOOTOOLS',true);
				break;
		}
	}
	$add .= '<script type="text/javascript" src="'.$pbef_options['main']['sbadapterurl'].'shadowbox-'.$adapter.'.js"></script>';
	$add .= '<script type="text/javascript" src="'.$pbef_options['main']['shadowboxurl'].'"></script>';
	$sitepath = PBEF_SITEPATH;
	$add .= "<script type=\"text/javascript\"><!--\r\n";
		$add .= preg_replace('%[\r\n\t]+|\s\s+%', '', <<<JS
		window.onload = function() {
		var options = 
		{
			assetURL: 			'{$pbef_options['shadowboxoptions']['assetURL']}',
			loadingImage: 		'{$pbef_options['shadowboxoptions']['loadingImage']}',
			flvPlayer: 			'{$pbef_options['shadowboxoptions']['flvPlayer']}',
			animate: 			{$pbef_options['shadowboxoptions']['animate']},
			animSequence: 		'{$pbef_options['shadowboxoptions']['animSequence']}',
			overlayColor: 		'{$pbef_options['shadowboxoptions']['overlayColor']}',
			overlayOpacity: 	{$pbef_options['shadowboxoptions']['overlayOpacity']},
			overlayBgImage: 	'{$pbef_options['shadowboxoptions']['overlayBgImage']}',
			listenOverlay: 		{$pbef_options['shadowboxoptions']['listenOverlay']},
			autoplayMovies: 	{$pbef_options['shadowboxoptions']['autoplayMovies']},
			showMovieControls: 	{$pbef_options['shadowboxoptions']['showMovieControls']},
			resizeDuration: 	{$pbef_options['shadowboxoptions']['resizeDuration']},
			fadeDuration: 		{$pbef_options['shadowboxoptions']['fadeDuration']},
			displayNav: 		{$pbef_options['shadowboxoptions']['displayNav']},
			continuous: 		{$pbef_options['shadowboxoptions']['continuous']},
			displayCounter: 	{$pbef_options['shadowboxoptions']['displayCounter']},
			counterType: 		'{$pbef_options['shadowboxoptions']['counterType']}',
			viewportPadding: 	{$pbef_options['shadowboxoptions']['viewportPadding']},
			handleLgImages: 	'{$pbef_options['shadowboxoptions']['handleLgImages']}',
			initialHeight: 		{$pbef_options['shadowboxoptions']['initialHeight']},
			initialWidth: 		{$pbef_options['shadowboxoptions']['initialWidth']},
			enableKeys: 		{$pbef_options['shadowboxoptions']['enableKeys']},
			keysClose: 			['{$pbef_options['shadowboxoptions']['keysClose']}', 'q', 27],
			keysPrev: 			['{$pbef_options['shadowboxoptions']['keysPrev']}', 37],
			keysNext: 			['{$pbef_options['shadowboxoptions']['keysNext']}', 39],
			handleUnsupported:  '{$pbef_options['shadowboxoptions']['handleUnsupported']}',
			text: {
				cancel:  '{$pbef_options['shadowboxtexts']['cancel']}',
				loading: '{$pbef_options['shadowboxtexts']['loading']}',
				close:   '{$pbef_options['shadowboxtexts']['close']}',
				next:    '{$pbef_options['shadowboxtexts']['next']}',
				prev:    '{$pbef_options['shadowboxtexts']['prev']}',
				errors:  {
					single: 'You must install the <a href="{0}">{1}</a> browser plugin to view this content.',
					shared: 'You must install both the <a href="{0}">{1}</a> and <a href="{2}">{3}</a> browser plugins to view this content.',
					either: 'You must install either the <a href="{0}">{1}</a> or the <a href="{2}">{3}</a> browser plugin to view this content.'
				}
			}
		};
		Shadowbox.init(options);
	}
JS
	);
	$add .= "\r\n--></script>";
	define('PBEF_LOADED_SHADOWBOX',true);
?>