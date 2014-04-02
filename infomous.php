<?php
/*
Plugin Name: Infomous
Plugin URI: http://dualcube.com/
Description: Infomous is the interactive word cloud that enhances your site by helping visitors find relevant content from your site or from any other source you choose. Add Infomous to a specific page to showcase related information, or place it on your entire site to facilitate navigation. Use your own content, or cruise to infomous.com to create a cloud from social media, news, web searches or any other content that you want to feature.
Author: Dualcube
Version: 1.0.3
Author URI: http://dualcube.com/
*/


require_once 'config.php';
if(!defined('ABSPATH')) exit; // Exit if accessed directly
if(!defined('DC_INFOMOUS_CLOUD_PLUGIN_TOKEN')) exit;
if(!defined('DC_INFOMOUS_CLOUD_TEXT_DOMAIN')) exit;

if(!class_exists('DC_Infomous_Cloud')) {
	require_once( 'classes/class-dc-infomous-cloud.php' );
	if(!session_id()) session_start();
	global $DC_Infomous_Cloud;
	$DC_Infomous_Cloud = new DC_Infomous_Cloud( __FILE__ );
	$GLOBALS['DC_Infomous_Cloud'] = $DC_Infomous_Cloud;
	
	// Activation Hooks
	register_activation_hook( __FILE__, array('DC_Infomous_Cloud', 'activate_dc_infomous_cloud') );
	register_activation_hook( __FILE__, 'flush_rewrite_rules' );
	
	// Deactivation Hooks
	register_deactivation_hook( __FILE__, array('DC_Infomous_Cloud', 'deactivate_dc_infomous_cloud') );
}
?>
