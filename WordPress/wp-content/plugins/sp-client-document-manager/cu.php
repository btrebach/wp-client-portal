<?php
/*
Plugin Name: SP Client Project & Document Manager
Plugin URI: http://smartypantsplugins.com/
Description: A WordPress plug-in that allows your business manage documents and projects with permissions in an easy to use interface.
Author: smartypants
Version: 2.1.2
Author URI: http://smartypantsplugins.com
*/
global $sp_client_upload;
$sp_client_upload = "2.1.2";
function sp_cdm_language_init()
{
    load_plugin_textdomain('sp-cdm', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('init', 'sp_cdm_language_init');
if (get_option('sp_cu_limit_file_size') == "") {
    ini_set('upload_max_filesize', '2000M');
    ini_set('post_max_size', '2000M');
    ini_set('max_input_time', 300);
    ini_set('max_execution_time', 300);
} else {
    ini_set('upload_max_filesize', '' . get_option('sp_cu_limit_file_size') . 'M');
    ini_set('post_max_size', '' . get_option('sp_cu_limit_file_size') . 'M');
    ini_set('max_input_time', 300);
    ini_set('max_execution_time', 300);
}
$cdm_upload_dir = wp_upload_dir();
define('SP_CDM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SP_CDM_PLUGIN_URL', plugins_url() . '/sp-client-document-manager/');
if (get_option('sp_cu_overide_upload_path') != "") {
    define('SP_CDM_UPLOADS_DIR', stripslashes(get_option('sp_cu_overide_upload_path')));
    define('SP_CDM_UPLOADS_DIR_URL', stripslashes(get_option('sp_cu_overide_upload_url')));
} else {
    define('SP_CDM_UPLOADS_DIR', $cdm_upload_dir['basedir'] . '/sp-client-document-manager/');
    define('SP_CDM_UPLOADS_DIR_URL', $cdm_upload_dir['baseurl'] . '/sp-client-document-manager/');
}
add_action('admin_menu', 'sp_client_upload_menu');
add_filter('wp_head', 'sp_cdm_tinymce_editor');
function sp_cdm_tinymce_editor()
{
    wp_admin_css('thickbox');
    wp_enqueue_script('post');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_script('tiny_mce');
    wp_enqueue_script('editor');
    wp_enqueue_script('editor-functions');
    add_thickbox();
}
require_once '' . dirname(__FILE__) . '/classes/install.php';
require_once '' . dirname(__FILE__) . '/classes/mat.thumb.php';
include_once '' . dirname(__FILE__) . '/classes/ajax.php';
include_once '' . dirname(__FILE__) . '/common.php';
include_once '' . dirname(__FILE__) . '/zip.class.php';
include_once '' . dirname(__FILE__) . '/admin/vendors.php';
include_once '' . dirname(__FILE__) . '/admin/projects.php';
include_once '' . dirname(__FILE__) . '/user/projects.php';
include_once '' . dirname(__FILE__) . '/functions.php';
include_once '' . dirname(__FILE__) . '/shortcode.php';
include_once '' . dirname(__FILE__) . '/admin/fileview.php';
function sp_client_upload_init()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('smUpload', plugins_url('upload.js', __FILE__));
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-dialog');
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_script('jquery-form');
    wp_enqueue_script('smcdmvalidate', plugins_url('js/jquery.validate.js', __FILE__));
    wp_enqueue_script('swfupload');
    wp_enqueue_script('swfupload-degrade');
    wp_enqueue_script('swfupload-queue');
    wp_enqueue_script('swfupload-handlers');
    wp_enqueue_script('jquery-cookie', plugins_url('js/jquery.cookie.js', __FILE__), array(
        'jquery'
    ));
}
function sp_client_upload_load_css()
{
    wp_register_style('cdm-style', plugins_url('style.css', __FILE__));
    if (get_option('sp_cu_jqueryui_theme') != 'none') {
        if (get_option('sp_cu_jqueryui_theme') == '') {
            $theme = 'smoothness';
        } else {
            $theme = get_option('sp_cu_jqueryui_theme');
        }
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            wp_register_style('jquery-ui-css', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/' . $theme . '/jquery-ui.min.css');
        } else {
            wp_register_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/' . $theme . '/jquery-ui.min.css');
        }
    }
    wp_enqueue_style('cdm-style');
    wp_enqueue_style('jquery-ui-css');
    //echo '<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" >';
}
function sp_client_upload_load_admin_css()
{
    wp_register_style('cdm-potatoe-menu', plugins_url('css/menu.css', __FILE__));
    wp_enqueue_style('cdm-potatoe-menu');
    //echo '<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" >';
}
function sp_client_upload_admin_init()
{
    wp_enqueue_script('cdm-potatoe-menu-js', plugins_url('js/menu.js', __FILE__));
}
add_action('wp_head', 'sp_client_upload_load_css');
add_action('init', 'sp_client_upload_init');
add_action('admin_menu', 'sp_client_upload_load_css');
add_action('admin_menu', 'sp_client_upload_load_admin_css');
add_action('admin_init', 'sp_client_upload_admin_init');
function sp_client_upload_menu()
{
    $projects        = new cdmProjects;
    $sp_cdm_fileview = new sp_cdm_fileview;
    add_menu_page('sp_cu', 'Client Documents', 'sp_cdm', 'sp-client-document-manager', 'sp_client_upload_options');
    add_submenu_page('sp_cu', 'Vendors', 'Vendors', 'sp_cdm_vendors', 'sp-client-document-manager-vendors', 'sp_client_upload_options_vendors');
    add_submenu_page('sp_cu', 'Help', 'Help', 'sp_cdm', 'sp-client-document-manager-help', 'sp_client_upload_help');
    add_submenu_page('sp_cu', 'Settings', 'Settings', 'sp_cdm_settings', 'sp-client-document-manager-settings', 'sp_client_upload_settings');
    add_submenu_page('sp_cu', sp_cdm_folder_name(1), sp_cdm_folder_name(1), 'sp_cdm_projects', 'sp-client-document-manager-projects', array(
        $projects,
        'view'
    ));
    add_submenu_page('sp_cu', 'User Files', 'User Files', 'sp_cdm_uploader', 'sp-client-document-manager-fileview', array(
        $sp_cdm_fileview,
        'view'
    ));
}
function sp_client_upload_options()
{
    global $wpdb;
    if (@$_POST['sp-client-document-manager-submit'] != "") {
        update_option('sp_client_upload_page', $_POST['sp_client_upload_page']);
        echo '<p style="color:green">' . __("Updated Settings!", "sp-cdm") . '</p>';
    }
    echo '<h2>' . __("Latest uploads", "sp-cdm") . '</h2>' . sp_client_upload_nav_menu() . '
				' . sp_client_upload_admin() . '';
}
?>