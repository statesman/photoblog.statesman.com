<?php
	/*
		WP-Soundslides
		includes/editor.php
	*/
		
	// wp_soundslides_toolbar_icon
	function wp_soundslides_mce_plugin_init()
	{
		$path = wp_soundslides_path . '/includes/tinymce/';
		
		echo 'tinyMCE.loadPlugin("WP-Soundslides", "'.$path.'");'."\n";
	}
	// wp_soundslides_toolbar_icon
	
	function wp_soundslides_admin_header()
	{
		$path = wp_soundslides_path.'/includes/submodal';
		
		$markup = <<<EOF
		
<!-- Begin WP-Soundslide Editor Plugin -->
    <link rel="stylesheet" type="text/css" href="$path/subModal.css" />
    <script type="text/javascript" src="$path/common.js"></script>
    <script type="text/javascript" src="$path/subModal.js"></script>
<!-- End WP-Soundslide Editor Plugin -->

EOF;
		print($markup);
	}
	
	function wp_soundslides_add_mce_plugin($plugins)
	{
		array_push($plugins, 'WP-Soundslides');
		return $plugins;
	}
	function wp_soundslides_add_mce_toolbar_icons($buttons)
	{
		array_push($buttons, 'separator', 'WP_Soundslides_insert');
		return $buttons;
	}


?>