<?php

// Path constants
define('THEMELIB', TEMPLATEPATH . '/library');

// Create Theme Options Page
require_once (THEMELIB . '/functions/theme-options.php');

// Get Post Thumbnails and Images
include(THEMELIB . '/functions/post-images.php');

// Load widgets
include(THEMELIB . '/functions/widgets.php');

// Produces an avatar image with the hCard-compliant photo class for author info
include(THEMELIB . '/functions/author-info-avatar.php');

// Remove the WordPress Generator – via http://blog.ftwr.co.uk/archives/2007/10/06/improving-the-wordpress-generator/
function modularity_remove_generators() { return ''; }
add_filter('the_generator','modularity_remove_generators');

// Prevent Wordpress from using fixed width caption wrappers
add_filter( 'img_caption_shortcode', 'responsive_img_caption_filter', 10, 3 );
function responsive_img_caption_filter( $val, $attr, $content = null ) {
	extract( shortcode_atts( array(
		'id' => '',
		'align' => '',
		'width' => '',
		'caption' => ''
		), $attr
	) );

	if ( 1 > (int) $width || empty( $caption ) )
		return $val;

	$new_caption = sprintf( '<div id="%1$s" class="wp-caption %2$s">%4$s<p class="wp-caption-text">%5$s</p></div>',
		esc_attr( $id ),
		esc_attr( $align ),
		'', //( 10 + (int) $width ),
		do_shortcode( $content ),
		$caption
	);
	return $new_caption;
}

?>
