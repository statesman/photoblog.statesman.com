<?php 
	/*
		WP-Soundslides
		includes/dialog.php
	*/
	
	require_once( dirname(__FILE__) . '/../../../../wp-config.php');
	$options = wp_soundslides_load_options(false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

<meta http-equiv="content-type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('url'); ?>/wp-admin/wp-admin.css" />
<title>WP-Soundslides</title>

<script type="text/javascript">
//<![CDATA[
	function wp_soundslides_insert()
	{
		var path = document.getElementById('ss_path').value;
		if ( path.length == 0 )
		{
			alert('Please include a path.', 'WP-Soundslides');
			return ;
		}
		path = 'path="'+path+'" ';
		
		var width = document.getElementById('ss_width').value;
		if ( width.length > 0 )
		{
			width = 'width="'+width+'" ';
		}
		
		var height = document.getElementById('ss_height').value;
		if ( height.length > 0 )
		{
			height = 'height="'+height+'" ';
		}
		
		var size = document.getElementById('ss_size').value;
		if ( size.length > 0 )
		{
			size = 'size="'+size+'" ';
		}
		
		var bgcolor = document.getElementById('ss_bgcolor').value;
		if ( bgcolor.length > 0 )
		{
			bgcolor = 'bgcolor="'+bgcolor+'" ';
		}
		
		var divclass = document.getElementById('ss_class').value;
		if ( divclass.length > 0 )
		{
			divclass = 'class="'+divclass+'" ';
		}
		
		window.top.WP_Soundslides_Insert_Params = path+width+height+size+bgcolor+divclass;

		window.top.hidePopWin();
	}
//]]>
</script>

</head>

<body>
	<div class="wrap">
		<h2>Insert Soundslides</h2>
			<table class="optiontable">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="ss_path">Path or URL:</label></th>
						<td>
							<input type="textbox" name="ss_path" id="ss_path" size="30"/><br />
							Base path is <strong><?php echo $options['path']; ?></strong>.
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="ss_width">Width</label> &times; <label for="ss_height">Height</label>:</th>
						<td>
							<input type="textbox" name="ss_width" id="ss_width" size="5"/> &times;
							<input type="textbox" name="ss_height" id="ss_height" size="5"/><br />
							(Optional; default is <strong><?php echo $options['width']; ?> &times; <?php echo $options['height']; ?></strong>.)
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="ss_size">Size:</label></th>
						<td>
							<input type="textbox" name="ss_size" id="ss_size" size="30" maxlength="1"/><br />
							(Optional; default is <strong><?php echo $options['size']; ?></strong>).
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="ss_bgcolor">Background:</label></th>
						<td>
							<input type="textbox" name="ss_bgcolor" id="ss_bgcolor"  size="30" maxlength="7" /><br />
							(Optional; default is <strong><?php echo $options['bgcolor']; ?></strong>).
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="ss_class">DIV class:</label></th>
						<td>
							<input type="textbox" name="ss_class" id="ss_class" size="30" /><br />
							(Optional; default is <?php if ( empty( $options['class'] ) ) {echo "not set"; } ?><strong><?php echo $options['class']; ?></strong>).
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input type="button" value="Cancel" name="cancel" onclick="window.top.hidePopWin()" style="float: left;"/>
				<input type="button" value="Insert &raquo;" onclick="wp_soundslides_insert()" name="update"/>
			</p>
			<table>
				<tr>
					<td><img src="<?php echo( wp_soundslides_path ); ?>/includes/icon48.png" alt="WP-Soundslides"/></td>
					<td><h3>Powered by WP-Soundslides <?php echo wp_soundslides_get_version(); ?></h3></td>
				</tr>
			</table>
			
	</div>
</body>

</html>