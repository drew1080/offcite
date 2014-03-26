<?php
/*
Part of pb-embedFlash v1.5
© Pascal Berkhahn, <novayuna@googlemail.com>, http://pascal-berkhahn.de
*/
if (!function_exists('get_option')) { echo "Please don't load this file directly."; exit; }

function pbembedFlash_addbuttons()
{
	// Don't bother doing this stuff if the current user lacks permissions
	if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) return;
		 
	// Add only in Rich Editor mode
	if ( get_user_option('rich_editing') == 'true') {
	 
	// add the button for wp25 in a new way
		add_filter('mce_external_plugins', 'add_pbembedFlash_tinymce_plugin', 5);
		add_filter('mce_buttons', 'register_pbembedFlash_button', 5);
	}
}

// used to insert button in wordpress 2.5x editor
function register_pbembedFlash_button($buttons)
{
	array_push($buttons, 'separator', 'pbembedFlash');
	return $buttons;
}

// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function add_pbembedFlash_tinymce_plugin($plugin_array)
{
	$plugin_array['pbembedFlash'] = PBEF_SITEPATH.'/tinymce3plugin/editor_plugin.js';
	return $plugin_array;
}

// init process for button control
add_action('init', 'pbembedFlash_addbuttons');
?>