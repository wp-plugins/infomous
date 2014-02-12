<?php
class DC_Infomous_Cloud_Shortcode {

	public function __construct() {
		//shortcodes
		add_shortcode('infomous_cloud', array(&$this, 'infomous_cloud'));
	}

	public function infomous_cloud($attr) {
		global $DC_Infomous_Cloud;
		$this->load_class('infomous-cloud');
		return $this->shortcode_wrapper(array('WC_Infomous_Cloud_Shortcode', 'output'), $attr);
	}

	/**
	 * Helper Functions
	 */

	/**
	 * Shortcode Wrapper
	 *
	 * @access public
	 * @param mixed $function
	 * @param array $atts (default: array())
	 * @return string
	 */
	public function shortcode_wrapper($function, $atts = array()) {
		ob_start();
		call_user_func($function, $atts);
		return ob_get_clean();
	}

	/**
	 * Shortcode CLass Loader
	 *
	 * @access public
	 * @param mixed $class_name
	 * @return void
	 */
	public function load_class($class_name = '') {
		global $DC_Infomous_Cloud;
		if ('' != $class_name && '' != $DC_Infomous_Cloud->token) {
			require_once ('shortcode/class-' . esc_attr($DC_Infomous_Cloud->token) . '-shortcode-' . esc_attr($class_name) . '.php');
		}
	}

}
?>
