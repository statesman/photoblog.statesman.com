/*
	WP-Soundslides
	includes/editor_pluging.js
*/

// Global insert array
var WP_Soundslides_Insert_Params ='';

// Language data
tinyMCE.importPluginLanguagePack('WP-Soundslides');

var TinyMCE_WP_Soundslides = {

	getInfo : function() {
		return {
			longname : 'WP-Soundslides',
			author : 'Daniel A. White',
			authorurl : 'http://svn.wp-plugins.org/wp-soundslides/',
			infourl : 'http://svn.wp-plugins.org/wp-soundslides/',
			version : "1.0 Beta"
		};
	},
	
	initInstance : function(inst) {
		//inst.addShortcut('ctrl', 's', 'lang_WP_Soundslides_step_desc', 'mceWP_Soundslides_step');
	},

	getControlHTML : function(cn) {
		switch (cn) {
			case "WP_Soundslides_insert":
				return tinyMCE.getButtonHTML(cn, 'lang_wp_soundslides_insert_desc', '{$pluginurl}/images/wp-soundslides.png', 'mceWP_Soundslides_insert', true);
		}

		return "";
	},

	execCommand : function(editor_id, element, command, user_interface, value) {

		switch (command) {

			case "mceWP_Soundslides_insert":
				showPopWin( this.baseURL + '/../dialog.php', 500, 525, 'subModalCallback' );
				return true;
				
		}

		return false;
	},
	
	subModalCallback : function() {
		if ( WP_Soundslides_Insert_Params.length == 0 )
		{
			return ;
		}
		
		var quicktag = '<!--wp-soundslides '+WP_Soundslides_Insert_Params+'-->';
		
		tinyMCE.execInstanceCommand(editor_id, 'mceInsertContent', false, quicktag);
		tinyMCE.selectedInstance.repaint();
		
		WP_Soundslides_Insert_Params = '';
	}
};

// Add the plugin class to the list of available TinyMCE plugins
tinyMCE.addPlugin('WP-Soundslides', TinyMCE_WP_Soundslides);
