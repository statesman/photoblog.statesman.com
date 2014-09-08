<?php
	/*
		WP-Soundslides
		includes/quicktag.php
	*/
function wp_soundslides_raw()
{
	$markup = <<<EOF

<!-- Begin WP-Soundslide Instance [NUM] -->[BLOCK_START]
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
			codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0"
			width="[WIDTH]" height="[HEIGHT]">
	
		<param name="allowScriptAccess" value="sameDomain" />
		<param name="movie" value="[MOVIE_SRC]" />
 		<param name="quality" value="high" />
 		<param name="menu" value="false" />
		<param name="bgcolor" value="[BACKGROUND_COLOR]" />
	
		<embed src="[MOVIE_SRC]"
			   quality="high" bgcolor="[BACKGROUND_COLOR]"
			   width="[WIDTH]" height="[HEIGHT]" menu="false"
			   allowscriptaccess="sameDomain"
			   type="application/x-shockwave-flash"
			   pluginspage="http://www.macromedia.com/go/getflashplayer"
		/>
	
	</object>[BLOCK_END]
<!-- End WP-Soundslide Instance [NUM] -->

EOF;

	return $markup;
}
function wp_soundslides_define_path($src, $base)
{
	if ( substr( $base, 0, 1 ) != '/')
		$base .= '/';
	if ( substr( $base, -1 ) != '/')
		$base .= '/';
	
	// Check for http://
	if ( strtolower( substr( $src, 0, 7 ) ) != 'http://' )
		$src = $base.$src;
	
	// Remove leading and trailing slash
	$src = trim( $src, '/' );
	
	return $src;
}
function wp_soundslides_src_params($src, $base)
{
	$path = get_bloginfo('siteurl').'/'.wp_soundslides_define_path($src, $base);
	
	$assets = "&or_path_to_assets=$path/";
	$text = "&or_path_to_sstext=$path/soundslide.txt";
	return $assets.$text;
}
function wp_soundslides_block_builder($object, $block_param)
{
	if ( strlen($block_param) > 0 )
	{
		$object = str_replace( '[BLOCK_START]', "\n<div class=\"$block_param\">", $object );
		$object = str_replace( '[BLOCK_END]', "\n</div>", $object );
	}
	else
	{
		$object = str_replace( '[BLOCK_START]', ' ', $object );
		$object = str_replace( '[BLOCK_END]', ' ', $object );
	}

	return $object;
}
function wp_soundslides_get_param($parameters, $key, $default = '')
{
	$value = $default;
	preg_match_all( '!'.$key.'="([^"]*)"!i', $parameters, $matches );
		
	for ( $j = 0; $j < count($matches); $j++ )
		$value = $matches[$j][0];
	
	if ( strlen($value) == 0 )
		$value = $default;
	
	return $value;
}
function wp_soundslide_get_file_settings($file)
{

	if ( $content = file_get_contents($file) )
	{
		$content = urldecode($content);

		$ret_val = array();
		
		preg_match('!\^custom_size\|([^^]*)!i', $content, $custom_size);
		$ret_val['custom_size'] = (bool) $custom_size[1];
		
		preg_match('!\^custom_width\|([^^]*)!i', $content, $custom_width);
		$ret_val['custom_width'] = (int) $custom_width[1];
		
		preg_match('!\^custom_height\|([^^]*)!i', $content, $custom_width);
		$ret_val['custom_height'] = (int) $custom_width[1];
		
		return $ret_val;
	}

	return false;
}
function wp_soundslides_filter($content)
{
	global $post;
	$options = wp_soundslides_load_options();
	
	preg_match_all( wp_soundslides_quicktag, $content, $matches );
	$tags = $matches[0];
	$parameters = $matches[1];
	
	if ( $options['showonall'] == false )
	{
		if ( !is_page() && !is_single() )
		{
			foreach ( $tags as $tag )
				$content = str_replace($tag, '', $content);
			return $content;
		}
	}
	
	for ( $i = 0; $i < count($tags); $i++ )
	{
		$object = wp_soundslides_raw();
		
		$src = wp_soundslides_get_param($parameters[$i], 'src');
		if ( strlen( trim($src) ) == 0 )
		{
			if (wp_soundslides_debug)
				$content = str_replace( $tags[$i], '<em><strong>WP-Soundslides Error:</strong> Src attribute is empty.</em>', $content );
			else
				$content = str_replace( $tags[$i], '', $content );
				
			continue ;
		}
		
		$div_class = wp_soundslides_get_param( $parameters[$i], 'class', $options['class'] );
		$object = wp_soundslides_block_builder( $object, $div_class );
		
		$path = wp_soundslides_define_path($src, $options['path']);
		
		$txt_properties = wp_soundslide_get_file_settings($path.'/soundslide.txt');
		$width = $options['width'];
		$height = $options['height'];
		
		
		if ( $txt_properties['custom_size'] )
		{
			$width = $txt_properties['custom_width'];
			$height = $txt_properties['custom_height'];
		}
		
		$size = wp_soundslides_get_param( $parameters[$i], 'size', $options['size'] );
		$background_color = wp_soundslides_get_param( $parameters[$i], 'bgcolor', $options['bgcolor'] );
		$width = wp_soundslides_get_param( $parameters[$i], 'width', $width );
		$height = wp_soundslides_get_param( $parameters[$i], 'height', $height );
		
		$src_params = wp_soundslides_src_params($src, $options['path']);
		
		$object = str_replace( "[MOVIE_SRC]", wp_soundslides_path.'/soundslider.swf?size='.$size.$src_params, $object );
		$object = str_replace( "[BACKGROUND_COLOR]", $background_color, $object );
		$object = str_replace( "[WIDTH]", $width, $object );
		$object = str_replace( "[HEIGHT]", $height, $object );
		$object = str_replace( "[NUM]", $i+1, $object );
		
		$content = str_replace( $tags[$i], $object, $content );
	}
	return $content;
}

?>