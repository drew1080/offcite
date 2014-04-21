<?php
/*
Plugin Name: pb-embedFlash
Plugin URI: http://wordpress.org/extend/plugins/pb-embedflash/
Description: A filter for WordPress that displays any flash content in valid XHTML code offering the possibility to specify attributes and parameters individually. With admin panel, widget, TinyMCE popup and playlist/media manager!
Version: 1.5.1
Author: Pascal Berkhahn
Author URI: http://pascal-berkhahn.de/

**********************************************************************
Copyright (c) 2007, 2008 Pascal Berkhahn
Released under the terms of the GNU GPL: http://www.gnu.org/licenses/gpl.txt

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
**********************************************************************

Installation: Upload the folder "pb-embedflash" with it's content to "wp-content/plugins/" and activate the plugin in your admin panel.

Usage, Issues, Change log:
Visit http://wordpress.org/extend/plugins/pb-embedflash/
*/
if (!function_exists('get_option')) { echo "Please don't load this file directly."; exit; }

define('PBEF_PATH', dirname(__FILE__));
define('PBEF_SITEPATH', get_option('siteurl').'/wp-content/plugins/pb-embedflash');
define('PBEF_ADMINPATH', get_option('siteurl').'/wp-admin/options-general.php?page=pb-embedflash');
define('PBEF_VERSION', '1.5.1');
define('PBEF_DBVERSION', '1.0');
require_once(PBEF_PATH.'/inc/inc.functions.php');
require_once(PBEF_PATH.'/inc/inc.settings.php');
require_once(PBEF_PATH.'/inc/inc.widgets.php');
include_once(PBEF_PATH.'/inc/inc.tinymce3plugin.php');

load_textdomain('pb-embedflash', PBEF_PATH.'/locales/pb-embedflash-'.get_locale().'.mo');

add_filter('the_content', 'pb_embedFlash_plugin', 5); // 10 = default, lower values result in earlier execution
add_filter('the_excerpt', 'pb_embedFlash_plugin', 5);
add_filter('comment_text', 'pb_embedFlash_plugin', 5);
add_action('wp_head', 'pb_embedFlash_js_head');
add_action('admin_menu', 'pb_embedFlash_addAP');
add_action('wp_ajax_pbefmediamanager', 'pb_embedFlash_ajax_mediamanager');
add_action('widgets_init', 'pb_embedFlash_widget_init');

register_activation_hook( __FILE__, 'pb_embedFlash_activate');
register_deactivation_hook( __FILE__, 'pb_embedFlash_deactivate');
?>