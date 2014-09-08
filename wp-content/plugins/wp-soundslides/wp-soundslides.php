<?php
/*
Plugin Name: WP-Soundslides
Version: 1.0 Beta
Plugin URI: http://svn.wp-plugins.org/wp-soundslides/
Description: A plugin for WordPress 2.2 or later to integrate Soundslides
Author: Daniel A. White
Author URI: http://svn.wp-plugins.org/wp-soundslides/
*/

// Global values
define( wp_soundslides_version, "1.0 Beta" );
define( wp_soundslides_relative_path,  dirname(plugin_basename(__FILE__)));
define( wp_soundslides_path, get_bloginfo('siteurl').'/wp-content/plugins/'.wp_soundslides_relative_path );
define( wp_soundslides_quicktag, '!<\!--wp-soundslides([^(-->)]*)[ ]*-->!i' );
define( wp_soundslides_debug, true );

function wp_soundslides_get_version() { return wp_soundslides_version; }

include('includes/quicktag.php');
include('includes/options.php');
include('includes/editor.php');

// Add actions, hooks and filters
add_filter('the_content', 'wp_soundslides_filter');
add_action('admin_menu', 'wp_soundslides_add_option_page');
add_action('admin_head', 'wp_soundslides_admin_header');

add_action('tinymce_before_init','wp_soundslides_mce_plugin_init');
add_filter('mce_plugins', 'wp_soundslides_add_mce_plugin');
add_filter('mce_buttons', 'wp_soundslides_add_mce_toolbar_icons');

?>