<?php
class DC_Infomous_Cloud_Template {

	public function __construct() {
		add_filter('widget_text', 'do_shortcode');
	}
}
