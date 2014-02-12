<?php

class DC_Infomous_Cloud_Post_Infomous_Cloud {
  private $post_type;
  
  private $plugin_url;
  
  private $setDelta = 1;
  
  public function __construct() {
    $this->post_type = 'infomous_cloud';
    $this->register_post_type();
    
    if(is_admin()) {
      add_action( 'add_meta_boxes', array(&$this, 'add_custom_meta_boxes') );
      add_action( 'save_post', array(&$this, 'save_infomous_cloud_meta_data') );
    }
    
    add_filter( 'the_content', array(&$this, 'show_infomous_cloud_as_post') );
  }
   
  /**
  * Infomous Cloud Post Type
  **/
  function register_post_type() {
    global $DC_Infomous_Cloud;
    
    if ( post_type_exists($this->post_type) ) return;
    do_action( 'dc_infomous_cloud_register_post_type' );
  
    register_post_type( "infomous_cloud",
      apply_filters( 'dc_infomous_cloud_register_post_type_infomous_cloud',
				array(
          'labels' => array(
            'name' 					=> __( 'Infomous Clouds', $DC_Infomous_Cloud->text_domain ),
            'singular_name' 		=> __( 'Infomous Cloud', $DC_Infomous_Cloud->text_domain ),
            'menu_name'				=> _x( 'Infomous Clouds', 'Admin menu name', $DC_Infomous_Cloud->text_domain ),
            'add_new' 				=> __( 'Add Infomous Cloud', $DC_Infomous_Cloud->text_domain ),
            'add_new_item' 			=> __( 'Add New Infomous Cloud', $DC_Infomous_Cloud->text_domain ),
            'edit' 					=> __( 'Edit', $DC_Infomous_Cloud->text_domain ),
            'edit_item' 			=> __( 'Edit Infomous Cloud', $DC_Infomous_Cloud->text_domain ),
            'new_item' 				=> __( 'New Infomous Cloud', $DC_Infomous_Cloud->text_domain ),
            'view' 					=> __( 'View Infomous Cloud', $DC_Infomous_Cloud->text_domain ),
            'view_item' 			=> __( 'View Infomous Cloud', $DC_Infomous_Cloud->text_domain ),
            'search_items' 			=> __( 'Search Infomous Clouds', $DC_Infomous_Cloud->text_domain ),
            'not_found' 			=> __( 'No Infomous Clouds found', $DC_Infomous_Cloud->text_domain ),
            'not_found_in_trash' 	=> __( 'No Infomous Clouds found in trash', $DC_Infomous_Cloud->text_domain ),
            'parent' 				=> __( 'Parent Infomous cloud', $DC_Infomous_Cloud->text_domain )
          ),
          'description' 			=> __( 'This is where you can add new Infomous Clouds for your site.', $DC_Infomous_Cloud->text_domain ),
          'public' 				=> true,
          'show_ui' 				=> true,
          'show_in_menu'   => true,
          'show_in_nav_menus' => true,
          'show_in_admin_bar' => true,
          'menu_position'  => 20,
          'menu_icon' => $DC_Infomous_Cloud->plugin_url . 'assets/images/infomous.png',
          'capability_type' 		=> $this->post_type,
          'capabilities' => array(
            'publish_posts' 		=> 'manage_infomous_cloud',
            'edit_posts' 			=> 'manage_infomous_cloud',
            'edit_others_posts' 	=> 'manage_infomous_cloud',
            'delete_posts' 			=> 'manage_infomous_cloud',
            'delete_others_posts'	=> 'manage_infomous_cloud',
            'read_private_posts'	=> 'manage_infomous_cloud',
            'edit_post' 			=> 'manage_infomous_cloud',
            'delete_post' 			=> 'manage_infomous_cloud',
            'read_post' 			=> 'manage_infomous_cloud'
          ),
          'publicly_queryable' 	=> true,
          'exclude_from_search' 	=> false,
          'hierarchical' 			=> false, // Hierarchical causes memory issues - WP loads all records!
          'rewrite' 				=> false,
          'query_var' 			=> true,
          'supports' 				=> array( 'title', 'excerpt' ),
          'has_archive' 			=> $this->post_type
				)
		  )
	  );
  }
  
  /**
   * Infomous Cloud custom meta options
   */
  function add_custom_meta_boxes() {
    global $DC_Infomous_Cloud;
    
    // Cloud settings
    add_meta_box( 
        'infomous_cloud_options',
        __( 'Cloud Options', $DC_Infomous_Cloud->text_domain ),
        array(&$this, 'set_infomous_cloud_options'),
        $this->post_type, 'normal', 'high'
    );
    
    // Cloud embeded codes
    add_meta_box( 
        'infomous_cloud_embed_codes',
        __( 'Embed Code', $DC_Infomous_Cloud->text_domain ),
        array(&$this, 'show_infomous_embed_codes'),
        $this->post_type, 'normal', 'high' 
    );
  }
  
  function set_infomous_cloud_options($post) {
    global $DC_Infomous_Cloud;
    $cloud_options = get_post_meta($post->ID, '_cloud_options', true);
    if(!$cloud_options) $cloud_options = array('cloud_type' => 'dynamic', 'use_comments' => '', 'nid' => '', 'width' => '600', 'height' => '400', 'words' => '', 'colFrame' => 'AAAAAA', 'colFrameTitle' => 'AAAAAA');
    
    $DC_Infomous_Cloud->dc_wp_fields->radio_input(array('label' => __('Create your Infomous Cloud using:', $DC_Infomous_Cloud->text_domain), 'type' => 'radio', 'id' => 'cloud_type', 'class' => 'cloud_type', 'label_for' => 'cloud_type', 'name' => 'cloud_options[cloud_type]', 'options' => array('dynamic' => __('Content from your blog feed', $DC_Infomous_Cloud->text_domain)), 'value' => $cloud_options['cloud_type']));
    $DC_Infomous_Cloud->dc_wp_fields->checkbox_input(array('label' => __('Include user comments', $DC_Infomous_Cloud->text_domain), 'type' => 'checkbox', 'id' => 'use_comments', 'class' => 'use_comments checkbox', 'label_for' => 'use_comments', 'name' => 'cloud_options[use_comments]', 'dfvalue' => $cloud_options['use_comments'], 'value' => 'yes'));
    $DC_Infomous_Cloud->dc_wp_fields->radio_input(array('type' => 'radio', 'id' => 'cloud_type', 'class' => 'cloud_type', 'label_for' => 'cloud_type', 'name' => 'cloud_options[cloud_type]', 'options' => array('static' => __('An existing cloud from infomous.com', $DC_Infomous_Cloud->text_domain)), 'value' => $cloud_options['cloud_type']));
    $DC_Infomous_Cloud->dc_wp_fields->text_input(array('label' => __('Enter the node ID of your cloud: http://infomous.com/node/', $DC_Infomous_Cloud->text_domain), 'type' => 'text', 'id' => 'nid', 'label_for' => 'nid', 'name' => 'cloud_options[nid]', 'placeholder' => __('NID', $DC_Infomous_Cloud->text_domain), 'value' => $cloud_options['nid'], 'hints' => __('If you have already created a cloud on infomous.com, please enter the node ID, which is the number that appears after http://infomous.com/node/ when you look at your cloud. For example, if your cloud is http://infomous.com/node/1000, enter &quot;1000&quot; in this box.', $DC_Infomous_Cloud->text_domain)));
    
    echo '<p><strong>' . __('Customize the look & feel of your Infomous Cloud', $DC_Infomous_Cloud->text_domain) . '</strong></p>';
    
    $DC_Infomous_Cloud->dc_wp_fields->text_input(array('label' => __('Frame title', $DC_Infomous_Cloud->text_domain), 'type' => 'text', 'id' => 'frame_title', 'label_for' => 'frame_title', 'name' => 'cloud_options[frame_title]', 'placeholder' => __('Frame Title', $DC_Infomous_Cloud->text_domain), 'value' => $cloud_options['frame_title'], 'hints' => __('Title to be displayed in the top bar of this embed. It will not change the default title of the cloud at the site or other embeds of the same cloud.', $DC_Infomous_Cloud->text_domain)));
    echo '<p></p>';
    $DC_Infomous_Cloud->dc_wp_fields->text_input(array('label' => __('Width', $DC_Infomous_Cloud->text_domain), 'type' => 'text', 'id' => 'width', 'label_for' => 'width', 'name' => 'cloud_options[width]', 'placeholder' => __('Width', $DC_Infomous_Cloud->text_domain), 'value' => $cloud_options['width']));
    $DC_Infomous_Cloud->dc_wp_fields->text_input(array('label' => __('Height', $DC_Infomous_Cloud->text_domain), 'type' => 'text', 'id' => 'height', 'label_for' => 'height', 'name' => 'cloud_options[height]', 'placeholder' => __('Height', $DC_Infomous_Cloud->text_domain), 'value' => $cloud_options['height']));
    $DC_Infomous_Cloud->dc_wp_fields->text_input(array('label' => __('Number of words', $DC_Infomous_Cloud->text_domain), 'type' => 'text', 'id' => 'words', 'label_for' => 'words', 'name' => 'cloud_options[words]', 'placeholder' => __('No of Words', $DC_Infomous_Cloud->text_domain), 'value' => $cloud_options['words'], 'hints' => __('The number of words influences the visualization of a cloud. With too many words, the cloud will look busy and cluttered, and will contain some unnecessary words. With too few words, the cloud will look boring and empty, and will exclude some relevant topics. We recommend 40 words per cloud, as this number provides a nice balance between the two extremes.', $DC_Infomous_Cloud->text_domain)));
    
    echo  '<p class="dimension_help">' . __('Cloud size must be atleast 300x300', $DC_Infomous_Cloud->text_domain) . '<span class="img_tip" data-desc="' . __('300x300 is the smallest size possible in order to visualize content effectively. If the cloud is any smaller, interaction becomes nearly impossible, dramatically reducing the value of the cloud. Please see our guide to effective Infomous clouds for additional guide.', $DC_Infomous_Cloud->text_domain) . '"></span></p>';
    
    $DC_Infomous_Cloud->dc_wp_fields->colorpicker_input(array('label' => __('Frame Color', $DC_Infomous_Cloud->text_domain), 'type' => 'colorpicker', 'name' => 'cloud_options[colFrame]', 'label_for' => 'colFrame', 'id' => 'colFrame', 'default' => 'AAAAAA', 'value' => $cloud_options['colFrame']));
    $DC_Infomous_Cloud->dc_wp_fields->colorpicker_input(array('label' => __('Frame Title Color', $DC_Infomous_Cloud->text_domain), 'type' => 'colorpicker', 'name' => 'cloud_options[colFrameTitle]', 'label_for' => 'colFrameTitle', 'id' => 'colFrameTitle', 'default' => 'AAAAAA', 'value' => $cloud_options['colFrameTitle']));
    
  }
  
  function show_infomous_embed_codes($post) {
    global $DC_Infomous_Cloud;
    if(!empty($post) && $post->ID) {
      //echo "<p><strong>Short Code</strong></p>";
      echo "[infomous_cloud id=\"{$post->ID}\"]";
      
      //$embed_code = $this->get_infomous_cloud_embed_code($post->ID);
      //if($embed_code) {
        //echo "<p><strong>Embed Code</strong></p>";
        //echo str_replace('<', '&lt;', str_replace('>', '&gt;', $embed_code));
      //}
    }
  }
  
  function save_infomous_cloud_meta_data($post_id) {
    global $DC_Infomous_Cloud, $wpdb, $post, $_POST;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( !current_user_can( 'edit_post', $post_id ) ) return;
    if($post->post_type != $this->post_type) return;
    
    if(isset($_POST['cloud_options'])) {
      $cloud_options = $_POST['cloud_options'];
      
      // Width checking
      $width = (int)$cloud_options['width'];
      if($width < 300) {
        $_SESSION['dc_infamous_cloud_error'][] = __('Cloud width must be atleast 300', $DC_Infomous_Cloud->text_domain);
        $cloud_options['width'] = 300;
      }
      
      // Height checking
      $height = (int)$cloud_options['height'];
      if($height < 300) {
        $_SESSION['dc_infamous_cloud_error'][] = __('Cloud height must be atleast 300', $DC_Infomous_Cloud->text_domain);
        $cloud_options['height'] = 300;
      }
      
      update_post_meta($post->ID, '_cloud_options', $cloud_options);
    }
  }
  
  function get_infomous_cloud_embed_code($postID) {
    global $DC_Infomous_Cloud;
    $infomous_cloud = '';
    
    $cloud_options = get_post_meta($postID, '_cloud_options', true);
    
    // Cloud Type
    if (!isset($cloud_options["cloud_type"])) {
      $cloud_type = 'dynamic';
    } else {
      $cloud_type = $cloud_options["cloud_type"];
    }
    
    $infomous_cloud = '<script type="text/javascript" src="' . INFOMOUS_JS_LIB;
    
    if($cloud_type == 'dynamic') {
      $infomous_cloud .= 'dynamic.js?cloud_type=' . $cloud_type;
      $infomous_cloud .= '&url=' . site_url();
      $use_comments = ($cloud_options["use_comments"]) ? 'yes' : '';
      $infomous_cloud .= '&use_comments=' . $use_comments; 
    } else if($cloud_type == 'static') {
      $infomous_cloud .= 'static.js?cloud_type=' . $cloud_type;
      $infomous_cloud .= '&nid=' . $cloud_options["nid"];
    }
    
    $infomous_cloud .= '&delta=' . $this->setDelta;
    $this->setDelta += 1;
    
    // Cloud title
    $frame_title = '';
    if (isset($cloud_options["frame_title"]) && !empty($cloud_options["frame_title"]) && trim($cloud_options["frame_title"]))
      $infomous_cloud .= '&title=' . trim($cloud_options["frame_title"]);
    
    // Cloud Width
    $width = '';
    if (isset($cloud_options["width"]) && !empty($cloud_options["width"]) && trim($cloud_options["width"]))
      $infomous_cloud .= '&width=' . trim($cloud_options["width"]);
    
    // Cloud Height
    $height = '';
    if (isset($cloud_options["height"]) && !empty($cloud_options["height"]) && trim($cloud_options["height"]))
      $infomous_cloud .= '&height=' . trim($cloud_options["height"]);
    
    // No of words
    $max_words = '';
    if (isset($cloud_options["words"]) && !empty($cloud_options["words"]) && trim($cloud_options["words"]))
      $infomous_cloud .= '&max_words=' . trim($cloud_options["words"]);
    
    // Cloud Frame color
    $colFrame = '';
    if (isset($cloud_options["colFrame"]) && !empty($cloud_options["colFrame"]) && trim($cloud_options["colFrame"]))
      $infomous_cloud .= '&col_frame=' . str_replace('#', '0x', $cloud_options["colFrame"]);
    
    // Cloud Frame title color
    $colFrameTitle = '';
    if (isset($cloud_options["colFrameTitle"]) && !empty($cloud_options["colFrameTitle"]) && trim($cloud_options["colFrameTitle"]))
      $infomous_cloud .= '&col_frame_title=' . str_replace('#', '0x', $cloud_options["colFrameTitle"]);
    
    $infomous_cloud .= '"></script>';
  
    return $infomous_cloud;    
  }
  
  function show_infomous_cloud_as_post($content) {
    global $post, $DC_Infomous_Cloud;
    if($post->post_type != $this->post_type) return $content;
    
    $infomous_cloud = $this->get_infomous_cloud_embed_code($post->ID);
    if($infomous_cloud) {
      $content .= $infomous_cloud;
    }
    
    return $content;
  }
}