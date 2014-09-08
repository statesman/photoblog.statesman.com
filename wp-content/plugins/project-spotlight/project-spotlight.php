<?php
/*
Plugin Name: Project Spotlight
Plugin URI:
Description: Displays image and brief description of recent project
Author: Cameron Dube
Version: 1
*/

if(!class_exists('ProjectSpotlight')){
    class ProjectSpotlight{
        var $adminOptionsName = "projectSpotlightAdminOptions";
        function displayProject(){
            echo '<img src="http://photoblog.statesman.com/test.png" /><br />';
            echo 'short description of project here';
        }
        function getAdminOptions(){
            $projectSpotlightAdminOptions = array('show_title' => 'true', 'show_thumbnail' => 'true', 'show_description' => 'true');
            $psOptions = get_option($this->adminOptionsName);
            if(!empty($psOptions)){
                foreach($psOptions as $key => $option)
                    $projectSpotlightAdminOptions[$key] = $option;
            }
            update_option($this->adminOptionName, $projectSpotlightAdminOptions);
            return $projectSpotlightAdminOptions;
        }
        function init(){
            $this->getAdminOptions();
        }
        function printAdminPage(){
            $psOptions = $this->getAdminOptions();

            if(isset($_POST['update_projectSpotlightSettings'])){
                if(isset($_POST['projectSpotlightTitle'])){
                    $psOptions['show_title'] = $_POST['projectSpotlightTitle'];
                }
                if(isset($_POST['projectSpotlightThumbnail'])){
                    $psOptions['show_thumbnail'] = $_POST['projectSpotlightThumbnail'];
                }
                if(isset($_POST['projectSpotlighttDescription'])){
                    $psOptions['show_descriptions'] = $_POST['projectSpotlightDescription'];
                }
                update_option($this->adminOptionsName, $psOptions);
                ?>

                <div class="update"><p><strong><?php _e("Settings Updated.", "ProjectSpotlight");?></strong></p></div>
                <?php } ?>

                <div class="wrap">
                <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <h2>Project Spotlight</h2>
                <h3>Show title?</h3>
                <h3>Show thumbnail?</h3>
                <h3>Show description?</h3>
                <div class="submit">
                <input type="submit" name="update_projectSpotlightSettings" value="<?php _e('Update Settings', 'ProjectSpotlight') ?>" /></div>
                </form>
                </div>
    <?php } // end printAdminPage()
    }
}


if(class_exists('ProjectSpotlight')){
    $project = new ProjectSpotlight();
}
if(!function_exists("projectSpotlight_ap")){
    function projectSpotlight_ap(){
        global $project;
        if(!isset($project)){
            return;
            }
        if(function_exists('add_options_page')){
            add_options_page('Project Spotlight', 'Project Spotlight', 9, basename(__FILE__), array(&$project,'printAdminPage'));
        }
    }
}
if(isset($project)){
    //add_action('plugins_loaded', array(&$project, 'displayProject'),1);
    add_action('admin_menu','projectSpotlight_ap');
    add_action('activate_project-spotlight/project-spotlight.php',array(&$project, 'init'));
    add_action('init',widget_projectSpotlight_register);
}

function widget_projectSpotlight_register(){
    register_sidebar_widget('Project Spotlight', array(&$project, 'displayProject'));
}
?>
