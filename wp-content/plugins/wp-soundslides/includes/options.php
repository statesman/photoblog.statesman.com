<?php
	/*
		WP-Soundslides
		includes/options.php
	*/

function wp_soundslides_load_options($create = true)
{
	$options = array();
	
	if (!get_option('WP-Soundslides') && $create)
	{
		add_option( 'WP-Soundslides', 'Installed', 'WP-Soundslides is installed' );
		add_option( 'WP-Soundslides_Class', '', 'WP-Soundslides default block class' );
		add_option( 'WP-Soundslides_BackgroundColor', '#ffffff', 'WP-Soundslides default background color' );
		add_option( 'WP-Soundslides_Width', '640', 'WP-Soundslides default width' );
		add_option( 'WP-Soundslides_Height', '480', 'WP-Soundslides default height' );
		add_option( 'WP-Soundslides_Size', '0', 'WP-Soundslides default size' );
		add_option( 'WP-Soundslides_Path', '/soundslides/', 'WP-Soundslides default base path to' );
		add_option( 'WP-Soundslides_ShowOnAll', false, 'WP-Soundslides shows on all pages, not just posts/pages' );
	}
	
	$options['installed'] = get_option('WP-Soundslides');
	$options['class'] = get_option('WP-Soundslides_Class');
	$options['bgcolor'] = get_option('WP-Soundslides_BackgroundColor');
	$options['width'] = get_option('WP-Soundslides_Width');
	$options['height'] = get_option('WP-Soundslides_Height');
	$options['size'] = get_option('WP-Soundslides_Size');
	$options['path'] = get_option('WP-Soundslides_Path');
	$options['showonall'] = get_option('WP-Soundslides_ShowOnAll');
	
	return $options;
}
function wp_soundslides_update_options($options)
{
	update_option( 'WP-Soundslides_Class', $options['class'] );
	update_option( 'WP-Soundslides_BackgroundColor', $options['bgcolor'] );
	update_option( 'WP-Soundslides_Width', $options['width'] );
	update_option( 'WP-Soundslides_Height', $options['height'] );
	update_option( 'WP-Soundslides_Size', $options['size'] );
	update_option( 'WP-Soundslides_Path', $options['path'] );
	update_option( 'WP-Soundslides_ShowOnAll', $options['showonall'] );
}
function wp_soundslides_delete_options()
{
	delete_option('WP-Soundslides');
	delete_option('WP-Soundslides_Class');
	delete_option('WP-Soundslides_BackgroundColor');
	delete_option('WP-Soundslides_Width');
	delete_option('WP-Soundslides_Height');
	delete_option('WP-Soundslides_Size');
	delete_option('WP-Soundslides_Path');
	delete_option('WP-Soundslides_ShowOnAll');
}
function wp_soundslides_add_option_page()
{
	if ( function_exists('add_options_page'))
	{
	    add_options_page('WP-Soundslides Options', 'WP-Soundslides', 8, 'wp-soundslides', 'wp_soundslides_option_page');
		return;
	}
	else if ( function_exists('add_submenu_page') )
	{
		add_submenu_page( 'options-general.php', 'WP-Soundslides Options', 'WP-Soundslides', 8, 'wp-soundslides', 'wp_soundslides_option_page');
		return;
	}
}
function wp_soundslides_option_page()
{
	$options = array();
	if ($_POST['delete'])
	{
		wp_soundslides_delete_options();
		$deactivate_url = "plugins.php?action=deactivate&amp;plugin=wp-soundslides/wp-soundslides.php";
			if(function_exists('wp_nonce_url')) { 
				$deactivate_url = wp_nonce_url($deactivate_url, 'deactivate-plugin_'.wp_soundslides_relative_path.'/wp-soundslides.php');
			}
		echo "\n" . '<div id="message" class="updated fade"><p><strong>WP-Soundslide options have been deleted.';
		echo ' <a href="'.$deactivate_url.'">Click here to deactivate this plugin.</a></strong></p></div>' . "\n";
		return;
	}
	if ($_POST['default'])
	{
		wp_soundslides_delete_options();
		echo "\n" . '<div id="message" class="updated fade"><p><strong>WP-Soundslide options have been restored.</strong></p></div>' . "\n";
		return ;
	}
	if ($_POST['update'])
	{
		$options['class'] = $_POST['ss_class'];
		$options['bgcolor'] = $_POST['ss_bgcolor'];
		$options['width'] = $_POST['ss_width'];
		$options['height'] = $_POST['ss_height'];
		$options['size'] = $_POST['ss_size'];
		$options['path'] = $_POST['ss_path'];
		if ($_POST['ss_showonall'])
			$options['showonall'] = false;
		else
			$options['showonall'] = true;

		wp_soundslides_update_options($options);
		echo "\n" . '<div id="message" class="updated fade"><p><strong>WP-Soundslide options have been updated.</strong></p></div>' . "\n";
		return;
	}
	
	if (sizeof($options) == false)
		$options = wp_soundslides_load_options();
		
	$class = $options['class'];
	$bgcolor = $options['bgcolor'];
	$width = $options['width'];
	$height = $options['height'];
	$size = $options['size'];
	$path = $options['path'];
	
	$icon = wp_soundslides_path.'/includes/icon128.png';
	
	$showonallchk = '';
	if ($options['showonall'] == false)
		$showonallchk = ' checked="checked"';
	
	$page = <<<EOF
	<div class="wrap">
		<h2>WP-Soundslides Options</h2>
		<img src="$icon" style="float: right;" alt="Soundslides"/>
		<form name="wpss_config" method="post" action="">
			<table class="optiontable">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="ss_bgcolor">Background color:</label></th>
						<td><input type="textbox" name="ss_bgcolor" id="ss_bgcolor" value='$bgcolor' size="40" maxlength="7" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="ss_width">Width:</label></th>
						<td><input type="textbox" name="ss_width" id="ss_width" value='$width' size="40"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="ss_height">Height:</label></th>
						<td><input type="textbox" name="ss_height" id="ss_height" value='$height' size="40"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="ss_size">Size (0, 1 or 2):</label></th>
						<td><input type="textbox" name="ss_size" id="ss_size" value='$size' size="40" maxlength="1"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="ss_path">Base path:</label></th>
						<td><input type="textbox" name="ss_path" id="ss_path" value='$path' size="40"/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="ss_showonall">Show only on pages and posts:</label></th>
						<td><input type="checkbox" name="ss_showonall" id="ss_showonall" value='true'$showonallchk/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="ss_class"> DIV block class (optional):</label></th>
						<td><input type="textbox" name="ss_class" id="ss_class" value='$class' size="40"/></td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input type="submit" name="default" value="Reset to Default" style="float:left" />
				<input type="submit" value="Update Options &raquo;" name="update"/>
			</p>
		</form>
	</div>
	<div class="wrap">
		<h2>Uninstall WP-Soundslides</h2>
		<p>To uninstall WP-Soundslides, click Delete WP-Soundslides Options.  From there, WordPress will give you the option to deactivate WP-Soundslides.</p>
		<form name="wpss_delete" method="post" action="">
			<p class="submit"><input type="submit" name="delete" value="Delete WP-Soundslides Options &raquo;" /></p>
		</form>
	</div>
EOF;
	echo($page);
}

?>