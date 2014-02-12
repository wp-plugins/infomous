<?php
class DC_Infomous_Cloud_Admin {
  
  public $settings;

	public function __construct() {
		//admin script and style
		add_action('admin_enqueue_scripts', array(&$this, 'enqueue_admin_script'));
		
		add_action('dualcube_admin_footer', array(&$this, 'dualcube_admin_footer_for_dc_infomous_cloud'));
		
		add_action('admin_footer-edit.php', array(&$this, 'dualcube_admin_footer_for_dc_infomous_cloud'));
		add_action('admin_footer-post-new.php', array(&$this, 'dualcube_admin_footer_for_dc_infomous_cloud'));
		add_action('admin_footer-post.php', array(&$this, 'dualcube_admin_footer_for_dc_infomous_cloud'));
		
		add_action( 'admin_notices', array(&$this, 'dc_infomous_cloud_message') );
		
	}

	function dualcube_admin_footer_for_dc_infomous_cloud() {
    global $DC_Infomous_Cloud;
    $screen = get_current_screen();
    if (in_array( $screen->id, array( 'edit-infomous_cloud', 'infomous_cloud' ))) :
    ?>
      <div style="clear: both"></div>
      <div id="dc_admin_footer">
        <?php _e('Powered by', $DC_Infomous_Cloud->text_domain); ?> <a href="http://www.infomous.com" target="_blank"><img src="<?php echo $DC_Infomous_Cloud->plugin_url.'/assets/images/infomous.png'; ?>"></a>Infomous & Developed by <a href="http://dualcube.com" target="_blank"><img width="20" src="<?php echo $DC_Infomous_Cloud->plugin_url.'/assets/images/dclogo.png'; ?>"></a><?php _e('Dualcube', $DC_Infomous_Cloud->text_domain); ?> &copy; <?php echo date('Y');?>
      </div>
    <?php
    endif;
	}
	
	function dc_infomous_cloud_message() {
	  global $DC_Infomous_Cloud, $notice;
	  
	  if(isset($_SESSION['dc_infamous_cloud_error']) && !empty($_SESSION['dc_infamous_cloud_error'])) {
	    foreach($_SESSION['dc_infamous_cloud_error'] as $error) {
	      $notice .= $error . '</br>'; 
	    }
	  }
	  unset($_SESSION['dc_infamous_cloud_error']);
	}

	/**
	 * Admin Scripts
	 */

	public function enqueue_admin_script() {
		global $DC_Infomous_Cloud;
		$screen = get_current_screen();
		
		// Enqueue admin script and stylesheet from here
		if (in_array( $screen->id, array( 'edit-infomous_cloud', 'infomous_cloud' ))) :   
		  $DC_Infomous_Cloud->library->load_qtip_lib();
		  $DC_Infomous_Cloud->library->load_upload_lib();
		  $DC_Infomous_Cloud->library->load_colorpicker_lib();
		  wp_enqueue_script('admin_js', $DC_Infomous_Cloud->plugin_url.'assets/admin/js/admin.js', array('jquery'), $DC_Infomous_Cloud->version, true);
		  wp_enqueue_style('admin_css',  $DC_Infomous_Cloud->plugin_url.'assets/admin/css/admin.css', array(), $DC_Infomous_Cloud->version);
	  endif;
	}
}