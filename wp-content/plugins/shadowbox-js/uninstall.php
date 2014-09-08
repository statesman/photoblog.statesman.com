<?php
/**
 * @package shadowbox-js
 * @subpackage uninstall
 */

// If uninstall/delete not called from WordPress then exit
if( ! defined ( 'ABSPATH' ) && ! defined ( 'WP_UNINSTALL_PLUGIN' ) )
	exit ();

// Delete shadowbox option from options table
delete_option ( 'shadowbox' );
?>
