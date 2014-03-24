<?php
class DC_Infomous_Cloud {

	public $plugin_url;

	public $plugin_path;

	public $version;

	public $token;
	
	public $text_domain;
	
	public $library;

	public $shortcode;

	public $admin;

	public $template;

	private $file;
	
	public $dc_wp_fields;
	
	public $dc_post_Infomous_Cloud;

	public function __construct($file) {

		$this->file = $file;
		$this->plugin_url = trailingslashit(plugins_url('', $plugin = $file));
		$this->plugin_path = trailingslashit(dirname($file));
		$this->token = DC_INFOMOUS_CLOUD_PLUGIN_TOKEN;
		$this->text_domain = DC_INFOMOUS_CLOUD_TEXT_DOMAIN;
		$this->version = DC_INFOMOUS_CLOUD_PLUGIN_VERSION;
		
		add_action('init', array(&$this, 'init'));
	}
	
	/**
	 * initilize plugin on WP init
	 */
	function init() {
		
		// Init Text Domain
		$this->load_plugin_textdomain();
		
		// Init library
		$this->load_class('library');
		$this->library = new DC_Infomous_Cloud_Library();

		if (is_admin()) {
			$this->load_class('admin');
			$this->admin = new DC_Infomous_Cloud_Admin();
		}

		if (!is_admin()) {
			// init shortcode
      $this->load_class('shortcode');
      $this->shortcode = new DC_Infomous_Cloud_Shortcode();
  
      // init templates
      $this->load_class('template');
      $this->template = new DC_Infomous_Cloud_Template();
		}
		
		// DC Wp Fields
		$this->dc_wp_fields = $this->library->load_wp_fields();
		
		// Init user roles
    $this->init_user_roles();
    
    // Init demo_plugin taxonomies
    $this->init_post_and_taxonomy();
	}
	
	/**
   * Load Localisation files.
   *
   * Note: the first-loaded translation file overrides any following ones if the same translation is present
   *
   * @access public
   * @return void
   */
  public function load_plugin_textdomain() {
    $locale = apply_filters( 'plugin_locale', get_locale(), $this->text_domain );

    load_textdomain( $this->text_domain, WP_LANG_DIR . "/dc-infomous-cloud/dc-infomous-cloud-$locale.mo" );
    load_textdomain( $this->text_domain, $this->plugin_path . "/languages/dc-infomous-cloud-$locale.mo" );
  }

	public function load_class($class_name = '') {
		if ('' != $class_name && '' != $this->token) {
			require_once ('class-' . esc_attr($this->token) . '-' . esc_attr($class_name) . '.php');
		} // End If Statement
	}// End load_class()
	
	/**
   * Init demo_plugin user capabilities.
   *
   * @access public
   * @return void
   */
  function init_user_roles() {
    global $wp_roles;
    if ( class_exists('WP_Roles') ) if ( ! isset( $wp_roles ) ) $wp_roles = new WP_Roles();
    $wp_roles->add_cap( 'administrator', 'manage_infomous_cloud' );
  }
  
  /**
   * Init demo_plugin taxonomies.
   *
   * @access public
   * @return void
   */
  function init_post_and_taxonomy() {
    global $wpdb;
    
    $this->load_class('post-infomous-cloud');
    $this->dc_post_Infomous_Cloud = new DC_Infomous_Cloud_Post_Infomous_Cloud();
    
    register_activation_hook( __FILE__, 'flush_rewrite_rules' );
  }
  
  /**
   * Install upon activation.
   *
   * @access public
   * @return void
   */
  function activate_dc_infomous_cloud() {
    global $DC_Infomous_Cloud;
    
    update_option( 'dc_infomous_cloud_installed', 1 );
  }
  
  /**
   * UnInstall upon deactivation.
   *
   * @access public
   * @return void
   */
  function deactivate_dc_infomous_cloud() {
    global $DC_Infomous_Cloud;
    delete_option( 'dc_infomous_cloud_installed' );
  }
	
	/** Cache Helpers *********************************************************/

	/**
	 * Sets a constant preventing some caching plugins from caching a page. Used on dynamic pages
	 *
	 * @access public
	 * @return void
	 */
	function nocache() {
		if (!defined('DONOTCACHEPAGE'))
			define("DONOTCACHEPAGE", "true");
		// WP Super Cache constant
	}

}
