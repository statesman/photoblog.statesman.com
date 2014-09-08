<?php
/**
 * @package shadowbox-js
 * @subpackage admin
 */

// Full path and plugin basename of the main plugin file
$shadowbox_plugin_file = dirname ( dirname ( __FILE__ ) ) . '/shadowbox-js.php';
$shadowbox_plugin_basename = plugin_basename ( $shadowbox_plugin_file );

load_plugin_textdomain( 'shadowbox-js', FALSE, '/shadowbox-js/lang' );

/**
 * Enqueue jQuery when in the admin
 *
 * @since 2.0.3
 */
function shadowbox_admin_jquery () {
	wp_enqueue_script('jquery');
}	

/**
 * Places javascript into the footer to hide/show the advanced settings
 * 
 * @since 2.0.3
 */
function shadowbox_admin_js () {
?>
<script type="text/javascript">
/* <![CDATA[ */
        var sbadvshow = '<?php _e( 'Show Advanced Configuration' ); ?>';
        var sbadvhide = '<?php _e( 'Hide Advanced Configuration' ); ?>';
	jQuery('#sbadvancedbtn').show();
	jQuery('#sbadvancedtitle').hide();
	jQuery('#sbadvanced').hide();
	jQuery('#sbadvancedbtn').click(function(){
		jQuery('#sbadvanced').toggle();
		jQuery(this).attr('value',jQuery(this).attr('value') == sbadvshow ? sbadvhide : sbadvshow);
	});
/* ]]> */
</script>
<?php
}

/**
 * Return the default options
 *
 * @return array
 * @since 2.0.3
 */
function shadowbox_defaults () {
	$defaults = array (
			'library'		=>	'base' ,
			'skin'			=>	'classic' ,
			'language'		=>	'en' ,
			'autoimg'		=>	'true' ,
			'automov'		=>	'true' ,
			'autotube'		=>	'true' ,
			'autoaud'		=>	'true' ,
			'animateFade'		=>	'true' ,
			'animate'		=>	'true' ,
			'animSequence'		=>	'wh' ,
			'autoplayMovies'	=>	'true' ,
			'continuous'		=>	'false' ,
			'counterLimit'		=>	10 ,
			'counterType'		=>	'default' ,
			'displayCounter'	=>	'true' ,
			'displayNav'		=>	'true' ,
			'enableKeys'		=>	'true' ,
			'fadeDuration'		=>	0.35 ,
			'flashBgColor'		=>	'#000000' ,
			'handleOversize'	=>	'resize' ,
			'handleUnsupported'	=>	'link' ,
			'initialHeight'		=>	160 ,
			'initialWidth'		=>	320 ,
			'modal'			=>	'false' ,
			'overlayColor'		=>	'#000' ,
			'overlayOpacity'	=>	0.8 ,
			'resizeDuration'	=>	0.55 ,
			'showMovieControls'	=>	'true' ,
			'slideshowDelay'	=>	0 ,
			'viewportPadding'	=>	20
			);
	return $defaults;
}

/**
 * Initialize the default options during plugin activation
 *
 * @since 2.0.3
 */
function shadowbox_init () {
	if ( ! get_option ( 'shadowbox' ) )
		add_option ( 'shadowbox' , shadowbox_defaults () );
}

/**
 * Delete the options from the options table
 *
 * @since 2.0.3
 */
function shadowbox_delete () {
	delete_option ( 'shadowbox' );
}

/**
 * Add the options page
 *
 * @since 2.0.3
 */
function shadowbox_page () {
	global $shadowbox_plugin_basename;
	if ( current_user_can ( 'manage_options' ) && function_exists ( 'add_options_page' ) ) :
		add_options_page ( 'Shadowbox JS' , 'Shadowbox JS' , 'manage_options' , 'shadowbox-js' , 'shadowbox_admin_page' );
		add_filter("plugin_action_links_$shadowbox_plugin_basename" , 'shadowbox_filter_plugin_actions' );
	endif;
}

/**
 * Add a settings link to the plugin actions
 *
 * @param array $links Array of the plugin action links
 * @return array
 * @since 2.0.3
 */
function shadowbox_filter_plugin_actions ( $links ) { 
	$settings_link = '<a href="options-general.php?page=shadowbox-js">' . __( 'Settings' ) . '</a>'; 
	array_unshift( $links, $settings_link ); 
 	return $links;
}

/**
 * Output the options page
 *
 * @since 2.0.3
 */
function shadowbox_admin_page () {
	if ( isset( $_POST['default'] ) && $_POST['default'] == 'true' ) :
		update_option ( 'shadowbox' , shadowbox_defaults () );
		echo '<div id="message" class="updated fade"><p><strong>' . __( 'Settings saved as defaults' ) . '.</strong></p></div>';
	elseif ( isset( $_POST['delete'] ) && $_POST['delete'] == 'true' ) :
		global $shadowbox_plugin_basename;
		shadowbox_delete ();
		echo '<div id="message" class="updated fade"><p><strong>' . __( 'Settings deleted. The plugin can now be' ) . '<a href="' . wp_nonce_url('plugins.php?action=deactivate&amp;plugin=' . $shadowbox_plugin_basename, 'deactivate-plugin_' . $shadowbox_plugin_basename) . '" title="' . __( 'Deactivate Shadowbox JS' ) . '" style="border-bottom: none;"> ' . __( 'deactivated' ) . '</a>.</strong></p></div>';
	elseif ( isset( $_POST['action'] ) && $_POST['action'] == 'update' ) :
		$shadowbox = array ();
		foreach ( $_POST as $key => $value ) :
			if ( $key != 'submit' && $key != 'action' ) :
				$shadowbox[$key] = $value;			
			endif;
		endforeach;
		unset ( $key , $value );
		update_option ( 'shadowbox' , $shadowbox );
		echo '<div id="message" class="updated fade"><p><strong>' . __( 'Settings saved' ) . '.</strong></p></div>';
	endif;
?>
	<div class="wrap">
		<h2><?php _e( 'Shadowbox JS' ); ?></h2>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
			<input type="hidden" name="action" value="update" />	
			<h3>General</h3>
			<p><?php _e( 'These are general options for the Shadowbox Javascript that tell Shadowbox how to run, how to look and what language to use.' ); ?></p>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Javascript Library' ); ?>
					</th>
					<td>
						<select name="library">
							<option value="base"<?php selected ( 'base' , shadowbox_option ( 'library' ) ); ?>><?php _e( 'None' ); ?></option>
							<option value="yui"<?php selected ( 'yui' , shadowbox_option ( 'library' ) ); ?>>YUI</option>
							<option value="prototype"<?php selected ( 'prototype' , shadowbox_option ( 'library' ) ); ?>>Prototype</option>
							<option value="jquery"<?php selected ( 'jquery' , shadowbox_option ( 'library' ) ); ?>>jQuery</option>
							<option value="ext"<?php selected ( 'ext' , shadowbox_option ( 'library' ) ); ?>>Ext</option>
							<option value="dojo"<?php selected ( 'dojo' , shadowbox_option ( 'library' ) ); ?>>Dojo</option>
							<option value="mootools"<?php selected ( 'mootools' , shadowbox_option ( 'library' ) ); ?>>Mootools</option>
						</select>
						<br />
						<?php _e( 'Default is None.' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Shadowbox Skin' ); ?>
					</th>
					<td>
						<select name="skin">
<?php
$skin_path = dirname ( dirname ( __FILE__ ) ) . '/skin';
$dh = @opendir ( $skin_path );
while ( $skin = readdir ( $dh ) ) :
	if ( ! in_array ( $skin , array ( '.' , '..' , 'README' ) ) ) :
?>
							<option value="<?php echo $skin; ?>"<?php selected ( $skin , shadowbox_option ( 'skin' ) ); ?>><?php echo $skin; ?></option>
<?php
	endif;
endwhile;
closedir ( $dh );
?>
						</select>
						<br />
						<?php _e( 'Default is' ); ?> classic.
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Language' ); ?>
					</th>
					<td>
						<select name="language">
<?php $languages = array ( 'ar' , 'ca' , 'cs' , 'de-CH' , 'de-DE' , 'en' , 'es' , 'et' , 'fi' , 'fr' , 'gl' , 'he' , 'id' , 'is' , 'it' , 'ko' , 'my' , 'nl' , 'no' , 'pl' , 'pt-BR' , 'pt-PT' , 'ro' , 'ru' , 'sk' , 'sv' , 'tr' , 'zh-CN' , 'zh-TW' ); ?>
<?php foreach ( $languages as $language ) : ?>
							<option value="<?php echo $language; ?>"<?php selected ( $language , shadowbox_option ( 'language' ) ); ?>><?php echo $language; ?></option>
<?php endforeach; ?>
<?php unset ( $language ); ?>
						</select>
						<br />
						<?php _e( 'Default is en.' ); ?>
					</td>
				</tr>
			</table>
			<h3 id="sbadvancedtitle"><?php _e( 'Advanced Configuration' ); ?></h3>
                        <p><input id="sbadvancedbtn" type="button" class="button" name="" value="<?php _e( 'Show Advanced Configuration' ); ?>" style="display:none; font-weight: bold; width: 216px;"/></p>
			<table id="sbadvanced" class="form-table">
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Animate' ); ?>
					</th>
					<td>
						<select name="animate">
							<option value="true"<?php selected ( 'true' , shadowbox_option ( 'animate' ) ); ?>><?php _e( 'true' ); ?></option>
							<option value="false"<?php selected ( 'false' , shadowbox_option ( 'animate' ) ); ?>><?php _e( 'false' ); ?></option>
						</select>
						<br />
						<?php _e( 'Set this false to disable all fancy animations (except fades). This can improve the overall effect on computers with poor performance. Defaults to true.' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Fade Animations' ); ?>
					</th>
					<td>
						<select name="animateFade">
							<option value="true"<?php selected ( 'true' , shadowbox_option ( 'animateFade' ) ); ?>><?php _e( 'true' ); ?></option>
							<option value="false"<?php selected ( 'false' , shadowbox_option ( 'animateFade' ) ); ?>><?php _e( 'false' ); ?></option>
						</select>
						<br />
						<?php _e( 'Set this false to disable all fading animations. Defaults to true.' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Animation Sequence' ); ?>
					</th>
					<td>
						<select name="animSequence">
							<option value="wh"<?php selected ( 'wh' , shadowbox_option ( 'animSequence' ) ); ?>>wh</option>
							<option value="hw"<?php selected ( 'hw' , shadowbox_option ( 'animSequence' ) ); ?>>hw</option>
							<option value="sync"<?php selected ( 'sync' , shadowbox_option ( 'animSequence' ) ); ?>>sync</option>
						</select>
						<br />
						<?php _e( 'The animation sequence to use when resizing Shadowbox. May be either "wh" (width first, then height), "hw" (height first, then width), or "sync" (both simultaneously). Defaults to "wh".' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Modal' ); ?>
					</th>
					<td>
						<select name="modal">
							<option value="true"<?php selected ( 'true' , shadowbox_option ( 'modal' ) ); ?>><?php _e( 'true' ); ?></option>
							<option value="false"<?php selected ( 'false' , shadowbox_option ( 'modal' ) ); ?>><?php _e( 'false' ); ?></option>
						</select>
						<br />
						<?php _e( 'Set this true to disable listening for mouse clicks on the overlay that will close Shadowbox. Defaults to false.' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Overlay Color' ); ?>
					</th>
					<td>
						<input type="text" name="overlayColor" value="<?php echo shadowbox_option ( 'overlayColor' ); ?>" size="7" />
						<br />
						<?php _e( 'The color to use for the modal overlay (in hex). Defaults to "#000".' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Overlay Opacity' ); ?>
					</th>
					<td>
						<input type="text" name="overlayOpacity" value="<?php echo shadowbox_option ( 'overlayOpacity' ); ?>" size="4" />
						<br />
						<?php _e( 'The opacity to use for the modal overlay. Defaults to 0.8.' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Flash Background Color' ); ?>
					</th>
					<td>
						<input type="text" name="flashBgColor" value="<?php echo shadowbox_option ( 'flashBgColor' ); ?>" size="7" />
						<br />
						<?php _e( 'The default background color to use for Flash movies. Defaults to "#000000".' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Auto-Play Movies' ); ?>
					</th>
					<td>
						<select name="autoplayMovies">
							<option value="true"<?php selected ( 'true' , shadowbox_option ( 'autoplayMovies' ) ); ?>><?php _e( 'true' ); ?></option>
							<option value="false"<?php selected ( 'false' , shadowbox_option ( 'autoplayMovies' ) ); ?>><?php _e( 'false' ); ?></option>
						</select>
						<br />
						<?php _e( 'Set this false to disable automatically playing movies when they are loaded. Defaults to true.' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Show Movie Controls' ); ?>
					</th>
					<td>
						<select name="showMovieControls">
							<option value="true"<?php selected ( 'true' , shadowbox_option ( 'showMovieControls' ) ); ?>><?php _e( 'true' ); ?></option>
							<option value="false"<?php selected ( 'false' , shadowbox_option ( 'showMovieControls' ) ); ?>><?php _e( 'false' ); ?></option>
						</select>
						<br />
						<?php _e( 'Set this false to disable displaying QuickTime and Windows Media player movie control bars. Defaults to true.' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Slideshow Delay' ); ?>
					</th>
					<td>
						<input type="text" name="slideshowDelay" value="<?php echo shadowbox_option ( 'slideshowDelay' ); ?>" size="2" style="width: 1.5em;" />
						<br />
						<?php _e( 'A delay (in seconds) to use for slideshows. If set to anything other than 0, this value determines an interval at which Shadowbox will automatically proceed to the next piece in the gallery. Defaults to 0.' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Resize Duration' ); ?>
					</th>
					<td>
						<input type="text" name="resizeDuration" value="<?php echo shadowbox_option ( 'resizeDuration' ); ?>" size="4" />
						<br />
						<?php _e( 'The duration (in seconds) of the resizing animations. Defaults to 0.55.' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Fade Duration' ); ?>
					</th>
					<td>
						<input type="text" name="fadeDuration" value="<?php echo shadowbox_option ( 'fadeDuration' ); ?>" size="4" />
						<br />
						<?php _e( 'The duration (in seconds) of the fade animations. Defaults to 0.35.' ); ?>
					</td>
				</tr>				
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Display Navigation' ); ?>
					</th> 
					<td>
						<select name="displayNav">
							<option value="true"<?php selected ( 'true' , shadowbox_option ( 'displayNav' ) ); ?>><?php _e( 'true' ); ?></option>
							<option value="false"<?php selected ( 'false' , shadowbox_option ( 'displayNav' ) ); ?>><?php _e( 'false' ); ?></option>
						</select>
						<br />
						<?php _e( 'Set this false to hide the gallery navigation controls. Defaults to true.' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Continuous' ); ?>
					</th> 
					<td>
						<select name="continuous">
							<option value="true"<?php selected ( 'true' , shadowbox_option ( 'continuous' ) ); ?>><?php _e( 'true' ); ?></option>
							<option value="false"<?php selected ( 'false' , shadowbox_option ( 'continuous' ) ); ?>><?php _e( 'false' ); ?></option>
						</select>
						<br />
						<?php _e( 'Set this true to enable "continuous" galleries. By default, the galleries will not let a user go before the first image or after the last. Enabling this feature will let the user go directly to the first image in a gallery from the last one by selecting "Next". Defaults to false.' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Display Counter' ); ?>
					</th>
					<td>
						<select name="displayCounter">
							<option value="true"<?php selected ( 'true' , shadowbox_option ( 'displayCounter' ) ); ?>><?php _e( 'true' ); ?></option>
							<option value="false"<?php selected ( 'false' , shadowbox_option ( 'displayCounter' ) ); ?>><?php _e( 'false' ); ?></option>
						</select>
						<br />
						<?php _e( 'Set this false to hide the gallery counter. Counters are never displayed on elements that are not part of a gallery. Defaults to true.' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Counter Type' ); ?>
					</th>
					<td>
						<select name="counterType">
							<option value="default"<?php selected ( 'default' , shadowbox_option ( 'counterType' ) ); ?>><?php _e( 'default' ); ?></option>
							<option value="skip"<?php selected ( 'skip' , shadowbox_option ( 'counterType' ) ); ?>><?php _e( 'skip' ); ?></option>
						</select>
						<br />
						<?php _e( 'The mode to use for the gallery counter. May be either "default" or "skip". The default counter is a simple "1 of 5" message. The skip counter displays a separate link to each piece in the gallery, enabling quick navigation in large galleries. Defaults to "default".' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Counter Limit' ); ?>
					</th>
					<td>
						<input type="text" name="counterLimit" value="<?php echo shadowbox_option ( 'counterLimit' ); ?>" size="3" />
						<br />
						<?php _e( 'Limits the number of counter links that will be displayed in a "skip" style counter. If the actual number of gallery elements is greater than this value, the counter will be restrained to the elements immediately preceding and following the current element. Defaults to 10.' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Viewport Padding' ); ?>
					</th>
					<td>
						<input type="text" name="viewportPadding" value="<?php echo shadowbox_option ( 'viewportPadding' ); ?>" size="3" />
						<br />
						<?php _e( 'The amount of padding (in pixels) to maintain around the edge of the browser window. Defaults to 20.' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Handle Oversize' ); ?>
					</th>
					<td>
						<select name="handleOversize">
							<option value="none"<?php selected ( 'none' , shadowbox_option ( 'handleOversize' ) ); ?>><?php _e( 'none' ); ?></option>
							<option value="resize"<?php selected ( 'resize' , shadowbox_option ( 'handleOversize' ) ); ?>><?php _e( 'resize' ); ?></option>
							<option value="drag"<?php selected ( 'drag' , shadowbox_option ( 'handleOversize' ) ); ?>><?php _e( 'drag' ); ?></option>
						</select>
						<br />
						<?php _e( 'The mode to use for handling content that is too large for the viewport. May be one of "none", "resize", or "drag" (for images). The "none" setting will not alter the image dimensions, though clipping may occur. Setting this to "resize" enables on-the-fly resizing of large content. In this mode, the height and width of large, resizable content will be adjusted so that it may still be viewed in its entirety while maintaining its original aspect ratio. The "drag" mode will display an oversized image at its original resolution, but will allow the user to drag it within the view to see portions that may be clipped. Defaults to "resize".' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Handle Unsupported' ); ?>
					</th>
					<td>
						<select name="handleUnsupported">
							<option value="link"<?php selected ( 'link' , shadowbox_option ( 'handleUnsupported' ) ); ?>><?php _e( 'link' ); ?></option>
							<option value="remove"<?php selected ( 'remove' , shadowbox_option ( 'handleUnsupported' ) ); ?>><?php _e( 'remove' ); ?></option>
						</select>
						<br />
						<?php _e( 'The mode to use for handling unsupported media. May be either "link" or "remove". Media are unsupported when the browser plugin required to display the media properly is not installed. The link option will display a user-friendly error message with a link to a page where the needed plugin can be downloaded. The remove option will simply remove any unsupported gallery elements from the gallery before displaying it. With this option, if the element is not part of a gallery, the link will simply be followed. Defaults to "link".' ); ?>
					</td>
				</tr>				
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Initial Height' ); ?>
					</th>
					<td>
						<input type="text" name="initialHeight" value="<?php echo shadowbox_option ( 'initialHeight' ); ?>" size="3" />
						<br />
						<?php _e( 'The height of Shadowbox (in pixels) when it first appears on the screen. Defaults to 160.' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Initial Width' ); ?>
					</th> 
					<td>
						<input type="text" name="initialWidth" value="<?php echo shadowbox_option ( 'initialWidth' ); ?>" size="3" />
						<br />
					       	<?php _e( 'The width of Shadowbox (in pixels) when it first appears on the screen. Defaults to 320.' ); ?>
					</td>
				</tr>				
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Enable Keys' ); ?>
					</th> 
					<td>
						<select name="enableKeys">
							<option value="true"<?php selected ( 'true' , shadowbox_option ( 'enableKeys' ) ); ?>><?php _e( 'true' ); ?></option>
							<option value="false"<?php selected ( 'false' , shadowbox_option ( 'enableKeys' ) ); ?>><?php _e( 'false' ); ?></option>
						</select>
						<br />
						<?php _e( 'Set this false to disable keyboard navigation of galleries. Defaults to true.' ); ?>
					</td>
				</tr>
			</table>
			<h3><?php _e( 'Shadowbox Automation' ); ?></h3>
			<p><?php _e( 'These options will give you the capability to have Shadowbox automatically used for all of a certain file type.' ); ?></p>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
						<acronym title="bmp, gif, png, jpg, and jpeg"><?php _e( 'Image Links' ); ?></acronym>
					</th>
					<td>
						<select name="autoimg">
							<option value="true"<?php selected ( 'true' , shadowbox_option ( 'autoimg' ) ); ?>><?php _e( 'true' ); ?></option>
							<option value="false"<?php selected ( 'false' , shadowbox_option ( 'autoimg' ) ); ?>><?php _e( 'false' ); ?></option>
						</select>
						<br />
						<?php _e( 'Default is true.' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<acronym title="swf, flv, dv, mov, moov, movie, mp4, asf, wm, wmv, avi, mpg and mpeg"><?php _e( 'Movie Links' ); ?></acronym>
					</th>
					<td>
						<select name="autotube">
							<option value="true"<?php selected ( 'true' , shadowbox_option ( 'autotube' ) ); ?>><?php _e( 'true' ); ?></option>
							<option value="false"<?php selected ( 'false' , shadowbox_option ( 'autotube' ) ); ?>><?php _e( 'false' ); ?></option>
						</select>
						<br />
						<?php _e( 'Default is true.' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<acronym title="mp3, aac"><?php _e( 'Music Links' ); ?></acronym>
					</th>
					<td>
						<select name="autoaud">
							<option value="true"<?php selected ( 'true' , shadowbox_option ( 'autoaud' ) ); ?>><?php _e( 'true' ); ?></option>
							<option value="false"<?php selected ( 'false' , shadowbox_option ( 'autoaud' ) ); ?>><?php _e( 'false' ); ?></option>
						</select>
						<br />
						<?php _e( 'Default is true.' ); ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'YouTube and Google Video Links' ); ?>
					</th>
					<td>
						<select name="automov">
							<option value="true"<?php selected ( 'true' , shadowbox_option ( 'automov' ) ); ?>><?php _e( 'true' ); ?></option>
							<option value="false"<?php selected ( 'false' , shadowbox_option ( 'automov' ) ); ?>><?php _e( 'false' ); ?></option>
						</select>
						<br />
						<?php _e( 'Default is true.' ); ?>
					</td>
				</tr>
			</table>
			<h3><?php _e( 'Resets' ); ?></h3>
			<p><?php _e( 'These options will allow you to revert the options back to their defaults or to remove the options from the database for a clean uninstall.' ); ?></p>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Reset to Defaults' ); ?>
					</th>
					<td>
						<select name="default">
							<option value="false" selected="selected"><?php _e( 'false' ); ?></option>
							<option value="true"><?php _e( 'true' ); ?></option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Delete Options for a Clean Uninstall' ); ?>
					</th>
					<td>
						<select name="delete">
							<option value="false" selected="selected"><?php _e( 'false' ); ?></option>
							<option value="true"><?php _e( 'true' ); ?></option>
						</select>
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
	</div>
<?php
}

// Activation hook
register_activation_hook ( $shadowbox_plugin_file , 'shadowbox_init' );

// Activate the options page
add_action ( 'admin_menu' , 'shadowbox_page' ) ;
add_action ( 'init' , 'shadowbox_admin_jquery' );
add_action ( 'admin_footer' , 'shadowbox_admin_js' );
?>
