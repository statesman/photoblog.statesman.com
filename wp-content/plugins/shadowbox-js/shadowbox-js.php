<?php
/**
 * Shadowbox JS, A javascript media viewer plugin for WordPress similar to Lightbox and Thickbox.  Supports all types of media, not just images.
 *
 * @author Matt Martz <matt@sivel.net>
 * @version 2.0.3.2
 * @package shadowbox-js
 */
/*
Plugin Name: Shadowbox JS
Plugin URI: http://sivel.net/category/wordpress/plugins/
Description: A javascript media viewer similar to Lightbox and Thickbox. Supports all types of media, not just images. [ <a href="options-general.php?page=shadowbox-js">Settings</a> ] 
Version: 2.0.3.2
Author:  Matt Martz <matt@sivel.net>
Author URI: http://sivel.net

	Copyright (c) 2008 Matt Martz (http://sivel.net)
	Shadowbox JS is released under the GNU General Public License (LGPL)
	http://www.gnu.org/licenses/lgpl-2.1.txt

	Shadowbox (c) 2008 Michael J. I. Jackson (http://mjijackson.com/shadowbox)
	Shadowbox is licensed under the Creative Commons Attribution-Noncommercial-Share Alike license
	http://creativecommons.org/licenses/by-nc-sa/3.0/
*/

/**
 * If we are in the admin load the admin functionality
 */
if ( is_admin () )
	require_once( dirname ( __FILE__ ) . '/inc/admin.php' );

/**
 * Get specific option from the options table
 *
 * @param string $option Name of option to be used as array key for retrieving the specific value
 * @return mixed 
 * @since 2.0.3
 */
function shadowbox_option ( $option ) {
	$shadowbox = get_option ( 'shadowbox' );
	return $shadowbox[$option];
}


/**
 * Get the full URL to the plugin
 *
 * @return string
 * @since 2.0.3
 */
function plugin_url () {
	$siteurl = get_option ( 'siteurl' );
	if ( ! defined ( 'WP_PLUGIN_URL' ) ) :
		if ( ! defined ( 'WP_CONTENT_URL' ) )
			define ( 'WP_CONTENT_URL' , get_option ( 'siteurl' ) . '/wp-content' );
		define ( 'WP_PLUGIN_URL' , WP_CONTENT_URL . '/plugins' );
	endif;
	$plugin_url = WP_PLUGIN_URL . '/' . plugin_basename ( dirname ( __FILE__ ) );
	return $plugin_url;
}

/**
 * Enqueue Shadowbox CSS 
 *
 * @since 2.0.3
 */
function shadowbox_styles () {
	$skin = shadowbox_option ( 'skin' );
	wp_enqueue_style ( 'shadowbox-skin' , plugin_url () . '/skin/' . $skin . '/skin.css' , false , false , 'screen' );
	wp_enqueue_style ( 'shadowbox-extras' , plugin_url () . '/css/extras.css' , false , false , 'screen' );
	if ( ! did_action ( 'wp_print_styles' ) )
		wp_print_styles ();
}

/**
 * Enqueue Shadowbox javascript and dependencies
 * 
 * @since 2.0.3
 */
function shadowbox_scripts () {
	$adapter = 'shadowbox-' . shadowbox_option ( 'library' );
	$language = shadowbox_option ( 'language' );
	$skin = shadowbox_option ( 'skin' );
	wp_register_script ( 'yui' , 'http://yui.yahooapis.com/2.6.0/build/yahoo-dom-event/yahoo-dom-event.js' );
	wp_register_script ( 'ext-base' , plugin_url () . '/js/ext-base.js' );
	wp_register_script ( 'ext-core' , plugin_url () . '/js/ext-core.js' );
	wp_register_script ( 'dojo' , 'http://ajax.googleapis.com/ajax/libs/dojo/1.2.3/dojo/dojo.xd.js' );
	wp_register_script ( 'mootools' , 'http://ajax.googleapis.com/ajax/libs/mootools/1.2.1/mootools-yui-compressed.js' );
	wp_register_script ( 'shadowbox-base' , plugin_url () . '/js/adapter/shadowbox-base.js' );
	wp_register_script ( 'shadowbox-yui' , plugin_url () . '/js/adapter/shadowbox-yui.js' , array ( 'yui' ) );
	wp_register_script ( 'shadowbox-prototype' , plugin_url () . '/js/adapter/shadowbox-prototype.js' , array ( 'prototype' ) );
	wp_register_script ( 'shadowbox-jquery' , plugin_url () . '/js/adapter/shadowbox-jquery.js' , array ( 'jquery' ) );
	wp_register_script ( 'shadowbox-ext' , plugin_url () . '/js/adapter/shadowbox-ext.js' , array ( 'ext-base' , 'ext-core' ) );
	wp_register_script ( 'shadowbox-dojo' , plugin_url () . '/js/adapter/shadowbox-dojo.js' , array ( 'dojo' ) );
	wp_register_script ( 'shadowbox-mootools' , plugin_url () . '/js/adapter/shadowbox-mootools.js' , array ( 'mootools' ) );
	wp_register_script ( 'shadowbox' , plugin_url () . '/js/shadowbox-2.0.js' , array ( $adapter ) );
	wp_register_script ( 'shadowbox-lang' , plugin_url () . '/js/lang/shadowbox-' . $language . '.js' , array ( 'shadowbox' ) );
	wp_register_script ( 'shadowbox-skin' , plugin_url () . '/skin/' . $skin . '/skin.js' , array ( 'shadowbox' ) );
	wp_enqueue_script ( 'shadowbox-lang' );
	wp_enqueue_script ( 'shadowbox-skin' );
}

/**
 * Echo Shadowbox configuration and initialization scripts

 * @since 0.1
 */
function shadowbox_headers () {
	$shadowbox_start = "\n" . '<!-- Begin Shadowbox JS -->' . "\n";
	$shadowbox_end = '<!-- End Shadowbox JS -->' . "\n\n";

	// Shadowbox initialization options
	$shadowbox_init_ops = '		animate: ' . shadowbox_option ( 'animate' ) . ',' . "\n";
	$shadowbox_init_ops .= '		animateFade: ' . shadowbox_option ( 'animateFade' ) . ',' . "\n";
	$shadowbox_init_ops .= '		animSequence: "' . shadowbox_option ( 'animSequence' ) . '",' . "\n";
	$shadowbox_init_ops .= '		modal: ' . shadowbox_option ( 'modal' ) . ',' . "\n";
	$shadowbox_init_ops .= '		overlayColor: "' . shadowbox_option ( 'overlayColor' ) . '",' . "\n";
	$shadowbox_init_ops .= '		overlayOpacity: ' . shadowbox_option ( 'overlayOpacity' ) . ',' . "\n";
	$shadowbox_init_ops .= '		flashBgColor: "' . shadowbox_option ( 'flashBgColor' ) . '",' . "\n";
	$shadowbox_init_ops .= '		autoplayMovies: ' . shadowbox_option ( 'autoplayMovies' ) . ',' . "\n";
	$shadowbox_init_ops .= '		showMovieControls: ' . shadowbox_option ( 'showMovieControls' ) . ',' . "\n";
	$shadowbox_init_ops .= '		slideshowDelay: ' . shadowbox_option ( 'slideshowDelay' ) . ',' . "\n";
	$shadowbox_init_ops .= '		resizeDuration: ' . shadowbox_option ( 'resizeDuration' ) . ',' . "\n";
	$shadowbox_init_ops .= '		fadeDuration: ' . shadowbox_option ( 'fadeDuration' ) . ',' . "\n";
	$shadowbox_init_ops .= '		displayNav: ' . shadowbox_option ( 'displayNav' ) . ',' . "\n";
	$shadowbox_init_ops .= '		continuous: ' . shadowbox_option ( 'continuous' ) . ',' . "\n";
	$shadowbox_init_ops .= '		displayCounter: ' . shadowbox_option ( 'displayCounter' ) . ',' . "\n";
	$shadowbox_init_ops .= '		counterType: "' . shadowbox_option ( 'counterType' ) . '",' . "\n";
	$shadowbox_init_ops .= '		counterLimit: ' . shadowbox_option ( 'counterLimit' ) . ',' . "\n";
	$shadowbox_init_ops .= '		viewportPadding: ' . shadowbox_option ( 'viewportPadding' ) . ',' . "\n";
	$shadowbox_init_ops .= '		handleOversize: "' . shadowbox_option ( 'handleOversize' ) . '",' . "\n";
	$shadowbox_init_ops .= '		handleUnsupported: "' . shadowbox_option ( 'handleUnsupported' ) . '",' . "\n";
	$shadowbox_init_ops .= '		initialHeight: ' . shadowbox_option ( 'initialHeight' ) . ',' . "\n";
	$shadowbox_init_ops .= '		initialWidth: ' . shadowbox_option ( 'initialWidth' ) . ',' . "\n";
	$shadowbox_init_ops .= '		enableKeys: ' . shadowbox_option ( 'enableKeys' ) . ',' . "\n";
	$shadowbox_init_ops .= '		flvPlayer: "' . plugin_url () . '/flvplayer.swf"';

	// The full Shadowbox configuration
	$shadowbox_init = '<script type="text/javascript">' . "\n";
	$shadowbox_init .= '	var shadowbox_conf = {' . "\n";
	$shadowbox_init .= $shadowbox_init_ops . "\n";
	$shadowbox_init .= '	};' . "\n";
	$shadowbox_init .= '	window.onload = function(){' . "\n";
	$shadowbox_init .= '		Shadowbox.init(shadowbox_conf);' . "\n";
	$shadowbox_init .= '	};' . "\n";
	$shadowbox_init .= '</script>'. "\n";

	echo $shadowbox_start . $shadowbox_init . $shadowbox_end;
}

/**
 * This function is called by the add_filter WordPress function to 
 * link the gallery images directly to their full size counterpart
 *
 * @param string $link The link of the attachment
 * @param integer $id The id of the post
 * @return string
 * @since 2.0.1
 */
if ( ! function_exists ( 'attachment_direct_linkage' ) ) :
	function attachment_direct_linkage ( $link , $id ) {
		$mimetypes = array ( 'image/jpeg' , 'image/png' , 'image/gif' );
		$post = get_post ( $id );
		if ( in_array ( $post->post_mime_type , $mimetypes ) )
			return wp_get_attachment_url ( $id );
		else
			return $link;
	}
endif;

/**
 * This function is called by the add_filter WordPress function to add 
 * the rel="shadowbox[post-123]" attribute to all links of a specified
 * type.
 *
 * @param string $content The content of the post
 * @return string
 * @since 2.0.3
 */
function shadowbox_add_attr_to_link ( $content ) {
	global $post;
	
	// Search Patterns
	$img_pattern = '/<a(.*?)href=(\'|")([^>]*)\.(bmp|gif|jpe?g|png)(\'|")(.*?)>/i';
	$mov_pattern = '/<a(.*?)href=(\'|")([^>]*)\.(swf|flv|dv|moo?v|movie|mp4|asf|wmv?|avi|mpe?g)(\'|")(.*?)>/i';
	$aud_pattern = '/<a(.*?)href=(\'|")([^>]*)\.(mp3|aac)(\'|")(.*?)>/i';
	$tube_pattern = '/<a(.*?)href=(\'|")([^>]*)(youtube\.com\/(watch|v\/)|video\.google\.com\/googleplayer.swf)(.*?)(\'|")(.*?)>/i';
	$master_pattern = '/<a(.*?)href=(\'|")([^>]*)(\.(bmp|gif|jpe?g|png|swf|flv|dv|moo?v|movie|mp4|asf|wmv?|avi|mpe?g|mp3|aac)(\'|")|(youtube\.com\/(watch|v\/)|video\.google\.com\/googleplayer.swf))(.*?)>/i';	

	// Rel attrs for different file types
	$img_rel_attr = 'rel=$2shadowbox[post-' . $post->ID . '];player=img;$5';
	$mov_rel_attr = 'rel=$2shadowbox[post-' . $post->ID . ']$5';
	$aud_rel_attr = 'rel=$2shadowbox[post-' . $post->ID . '];player=flv;height=0;$5';
	$tube_rel_attr = 'rel=$2shadowbox[post-' . $post->ID . '];width=425;height=355;$7';

	// Replacement patterns
	$img_replace = '<a$1href=$2$3.$4$5 ' . $img_rel_attr . '$6>';
	$mov_replace = '<a$1href=$2$3.$4$5 ' . $mov_rel_attr . '$6>';
	$aud_replace = '<a$1href=$2$3.$4$5 ' . $aud_rel_attr . '$6>';
	$tube_replace = '<a$1href=$2$3$4$6$7 ' . $tube_rel_attr . '$8>';

	// Non specific search patterns
	$rel_pattern = '/\ rel=(\'|")(.*?)(\'|")/i';
	$box_rel_pattern = '/\ rel=(\'|")(.*?)(shadow|light|no)box(.*?)(\'|")/i';

	if ( preg_match_all ( $master_pattern , $content , $links ) ) :
		foreach ( $links[0] as $link ) :
			
			if ( preg_match ( $img_pattern , $link ) && shadowbox_option ( 'autoimg' ) == "true" ) :
				$link_pattern = $img_pattern;
				$rel_attr = $img_rel_attr;
				$link_replace = $img_replace;
			elseif ( preg_match ( $mov_pattern , $link ) && shadowbox_option ( 'automov' ) == "true" ) :
				$link_pattern = $mov_pattern;
				$rel_attr = $mov_rel_attr;
				$link_replace = $mov_replace;
			elseif ( preg_match ( $aud_pattern , $link ) && shadowbox_option ( 'autoaud' ) == "true" ) :
				$link_pattern = $aud_pattern;
				$rel_attr = $aud_rel_attr;
				$link_replace = $aud_replace;
			elseif ( preg_match ( $tube_pattern , $link ) && shadowbox_option ( 'autotube' ) == "true" ) :
				$link_pattern = $tube_pattern;
				$rel_attr = $tube_rel_attr;
				$link_replace = $tube_replace;
			endif;
	
			if ( ! preg_match ( $rel_pattern , $link ) ) :
				$link_replace = preg_replace ( $link_pattern , $link_replace , $link );
				$content = str_replace ( $link , $link_replace , $content );
			else :
				if ( ! preg_match ( $box_rel_pattern , $link ) ) :
					preg_match ( $rel_pattern , $link , $link_rel );
					$link_no_rel = preg_replace( $rel_pattern , '' , $link );
					$link_replace = preg_replace ( $link_pattern , $link_replace , $link_no_rel );
					$content = str_replace ( $link , $link_replace , $content );
				endif;
			endif;
		endforeach;
	endif;
	return $content;
}

// WordPress hooks
// only hook in if the options are in the options table so that WordPress will still function
if ( get_option ( 'shadowbox' ) ) :
	// Enqueue the Shadowbox CSS and JS files and print Shadowbox init to the head
	add_action ( 'wp_head' , 'shadowbox_styles' , 8 );
	add_action ( 'wp_head' , 'shadowbox_scripts' , 9 );
	add_action ( 'wp_head' , 'shadowbox_headers' );
	
	// Automatically add Shadowbox to links
	if ( shadowbox_option ( 'autoimg' ) == "true" || shadowbox_option ( 'automov' ) == "true" || shadowbox_option ( 'autoaud' ) == "true" || shadowbox_option ( 'autotube' ) == "true" )
		add_filter ( 'the_content' , 'shadowbox_add_attr_to_link' , 11 );
	if ( shadowbox_option ( 'autoimg' ) == "true" ) 
		add_filter ( 'attachment_link' , 'attachment_direct_linkage' , 10 , 2 );
endif;
?>
