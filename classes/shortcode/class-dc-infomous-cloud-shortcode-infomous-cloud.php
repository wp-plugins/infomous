<?php
class WC_Infomous_Cloud_Shortcode {

	public function __construct() {

	}

	/**
	 * Output the demo shortcode.
	 *
	 * @access public
	 * @param array $atts
	 * @return void
	 */
	public function output( $attr ) {
		global $DC_Infomous_Cloud;
		$DC_Infomous_Cloud->nocache();
	  
		do_action('before_dc_infomous_cloud_shortcode');
		
		if(!empty($attr) && isset($attr['id']) && !empty($attr['id'])) {
		  $infomous_cloud = $DC_Infomous_Cloud->dc_post_Infomous_Cloud->get_infomous_cloud_embed_code($attr['id']);
		  echo $infomous_cloud;
		}
		
		do_action('after_dc_infomous_cloud_shortcode');

	}
}
