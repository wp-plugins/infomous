<?php
class DC_WP_Fields {
  
  /**
   * Start up
   */
  public function __construct() {
    
  }
  
  /**
   * Output a hidden input box.
   *
   * @access public
   * @param array $field
   * @return void
   */
  function hidden_input( $field ) {
  
    $field['value'] = isset( $field['value'] ) ? $field['value'] : '';
    $field['class'] = isset( $field['class'] ) ? $field['class'] : 'hidden';
    $field['name'] 			= isset( $field['name'] ) ? $field['name'] : $field['id'];
    
    // Custom attribute handling
    $custom_attributes = array();

    if ( ! empty( $field['custom_attributes'] ) && is_array( $field['custom_attributes'] ) )
      foreach ( $field['custom_attributes'] as $attribute => $value )
        $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
  
    printf(
        '<input type="hidden" id="%s" name="%s" class="%s" value="%s" %s />',
        esc_attr($field['id']),
        esc_attr($field['name']),
        esc_attr($field['class']),
        esc_attr($field['value']),
        implode( ' ', $custom_attributes )
    );
  }
  
  /**
   * Output a text input box.
   *
   * @access public
   * @param array $field
   * @return void
   */
  public function text_input($field) {
    $field['placeholder'] 	= isset( $field['placeholder'] ) ? $field['placeholder'] : '';
    $field['class'] 		= isset( $field['class'] ) ? $field['class'] : 'regular-text';
    $field['value'] 		= isset( $field['value'] ) ? $field['value'] : '';
    $field['name'] 			= isset( $field['name'] ) ? $field['name'] : $field['id'];
    $field['type'] 			= isset( $field['type'] ) ? $field['type'] : 'text';
    $field['label_for'] = isset( $field['label_for'] ) ? $field['label_for'] : $field['id'];
    
    // Custom attribute handling
    $custom_attributes = array();

    if ( ! empty( $field['custom_attributes'] ) && is_array( $field['custom_attributes'] ) )
      foreach ( $field['custom_attributes'] as $attribute => $value )
        $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
    
    if(isset($field['label'])) {
      printf(
        '<p class="%s"><strong>%s</strong></p><label class="screen-reader-text" for="%s">%s</label>',
        $field['label_for'],
        $field['label'],
        $field['label_for'],
        $field['label']
      );
    }
    
    printf(
        '<input type="%s" id="%s" name="%s" class="%s" value="%s" placeholder="%s" %s />',
        $field['type'],
        esc_attr($field['id']),
        esc_attr($field['name']),
        esc_attr($field['class']),
        esc_attr($field['value']),
        esc_attr($field['placeholder']),
        implode( ' ', $custom_attributes )
    );
    
    // Help message
    if(isset($field['hints'])) {
      printf(
        '<span class="img_tip %s" data-desc="%s"></span>',
        $field['label_for'],
        wp_kses_post ( $field['hints'] )
      );
    }
    
    // Description
    if(isset($field['desc'])) {
      printf(
        '<p class="description">%s</p>',
        wp_kses_post ( $field['desc'] )
      );
    }
  }
  
  /**
   * Output a textarea input box.
   *
   * @access public
   * @param array $field
   * @return void
   */
  function textarea_input( $field ) {
  
    $field['name'] 			= isset( $field['name'] ) ? $field['name'] : $field['id'];
    $field['placeholder'] 	= isset( $field['placeholder'] ) ? $field['placeholder'] : '';
    $field['class'] 		= isset( $field['class'] ) ? $field['class'] : 'textarea';
    $field['rows'] 			= isset( $field['rows'] ) ? $field['rows'] : 2;
    $field['cols'] 			= isset( $field['cols'] ) ? $field['cols'] : 20;
    $field['value'] 		= isset( $field['value'] ) ? $field['value'] : '';
    $field['label_for'] = isset( $field['label_for'] ) ? $field['label_for'] : $field['id'];
    
    // Custom attribute handling
    $custom_attributes = array();

    if ( ! empty( $field['custom_attributes'] ) && is_array( $field['custom_attributes'] ) )
      foreach ( $field['custom_attributes'] as $attribute => $value )
        $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
      
    if(isset($field['label'])) {
      printf(
        '<p class="%s"><strong>%s</strong>',
        $field['label_for'],
        $field['label']
      );
      if(isset($field['hints'])) {
        printf(
          '<span class="img_tip" data-desc="%s"></span>',
          wp_kses_post ( $field['hints'] )
        );
      }
      printf(
        '</p><label class="screen-reader-text" for="%s">%s</label>',
        $field['label_for'],
        $field['label']
      );
    }
  
    printf(
        '<textarea id="%s" name="%s" class="%s" placeholder="%s" rows="%s" cols="%s" %s>%s</textarea>',
        esc_attr($field['id']),
        esc_attr($field['name']),
        esc_attr($field['class']),
        esc_attr($field['placeholder']),
        absint($field['rows']), 
        absint($field['cols']),
        implode( ' ', $custom_attributes ),
        esc_textarea($field['value'])
    );
    
    // Help message
    if(!isset($field['label']) && isset($field['hints'])) {
      printf(
        '<span class="img_tip" data-desc="%s"></span>',
        wp_kses_post ( $field['hints'] )
      );
    }
    
    // Description
    if(isset($field['desc'])) {
      printf(
        '<p class="description">%s</p>',
        wp_kses_post ( $field['desc'] )
      );
    }
  }
  
  /**
   * Output a checkbox.
   *
   * @access public
   * @param array $field
   * @return void
   */
  public function checkbox_input($field) {
    $field['class'] 		= isset( $field['class'] ) ? $field['class'] : 'checkbox';
    $field['value'] 		= isset( $field['value'] ) ? $field['value'] : '';
    $field['name'] 			= isset( $field['name'] ) ? $field['name'] : $field['id'];
    $field['dfvalue'] 		= isset( $field['dfvalue'] ) ? $field['dfvalue'] : '';
    $field['label_for'] = isset( $field['label_for'] ) ? $field['label_for'] : $field['id'];
    
    // Custom attribute handling
    $custom_attributes = array();

    if ( ! empty( $field['custom_attributes'] ) && is_array( $field['custom_attributes'] ) )
      foreach ( $field['custom_attributes'] as $attribute => $value )
        $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
    
    printf(
        '<input type="checkbox" id="%s" name="%s" class="%s" value="%s" %s %s />',
        esc_attr($field['id']),
        esc_attr($field['name']),
        esc_attr($field['class']),
        esc_attr($field['value']),
        checked( $field['value'], $field['dfvalue'], false ),
        implode( ' ', $custom_attributes )
    );
    
    if(isset($field['label'])) {
      printf(
        '<label class="%s" for="%s">%s</label>',
        $field['label_for'],
        $field['label_for'],
        $field['label']
      );
    }
    
    // Help message
    if(isset($field['hints'])) {
      printf(
        '<span class="img_tip" data-desc="%s"></span>',
        wp_kses_post ( $field['hints'] )
      );
    }
    
    // Description
    if(isset($field['desc'])) {
      printf(
        '<p class="description">%s</p>',
        wp_kses_post ( $field['desc'] )
      );
    }
  }
  
  /**
   * Output a radio gruop field.
   *
   * @access public
   * @param array $field
   * @return void
   */
  public function radio_input($field) {
    $field['class'] 		= isset( $field['class'] ) ? $field['class'] : 'select short';
    $field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
    $field['name'] 			= isset( $field['name'] ) ? $field['name'] : $field['id'];
    $field['value'] 		= isset( $field['value'] ) ? $field['value'] : '';
    $field['dfvalue'] 		= isset( $field['dfvalue'] ) ? $field['dfvalue'] : '';
    $field['value'] 		= ( $field['value'] ) ? $field['value'] : $field['dfvalue'];
    $field['label_for'] = isset( $field['label_for'] ) ? $field['label_for'] : $field['id'];
    
    $options = '';
    foreach ( $field['options'] as $key => $value ) {
      $options .= '<label title="' . esc_attr($key) .'"><input class="' . esc_attr($field['class']) . '" type="radio" ' . checked( esc_attr($field['value']), esc_attr($key), false ) . ' value="' . esc_attr($key) . '" name="' . esc_attr($field['name']) . '"> <span>' . esc_html($value) . '</span></label><br />';
    }
    
    if(isset($field['label'])) {
      printf(
        '<p class="%s"><strong>%s</strong>',
        $field['label_for'],
        $field['label']
      );
      if(isset($field['hints'])) {
        printf(
          '<span class="img_tip" data-desc="%s"></span>',
          wp_kses_post ( $field['hints'] )
        );
      }
      printf(
        '</p><label class="screen-reader-text" for="%s">%s</label>',
        $field['label_for'],
        $field['label']
      );
    }
    
    printf(
        '
        <fieldset id="%s" class="%s_field %s">
          <legend class="screen-reader-text"><span>%s</span></legend>
            %s
        </fieldset>
        ',
        esc_attr($field['id']),
        esc_attr($field['id']),
        esc_attr($field['wrapper_class']),
        esc_attr($field['title']),
        $options
    );
    
    // Help message
    if(!isset($field['label']) && isset($field['hints'])) {
      printf(
        '<span class="img_tip" data-desc="%s"></span>',
        wp_kses_post ( $field['hints'] )
      );
    }
    
    // Description
    if(isset($field['desc'])) {
      printf(
        '<p class="description">%s</p>',
        wp_kses_post ( $field['desc'] )
      );
    }
  }
  
  /**
   * Output a select input box.
   *
   * @access public
   * @param array $field
   * @return void
   */
  public function select_input($field) {
    $field['class'] 		= isset( $field['class'] ) ? $field['class'] : 'select short';
    $field['value'] 		= isset( $field['value'] ) ? $field['value'] : '';
    $field['name'] 			= isset( $field['name'] ) ? $field['name'] : $field['id'];
    $field['label_for'] = isset( $field['label_for'] ) ? $field['label_for'] : $field['id'];
    
    // Custom attribute handling
    $custom_attributes = array();

    if ( ! empty( $field['custom_attributes'] ) && is_array( $field['custom_attributes'] ) )
      foreach ( $field['custom_attributes'] as $attribute => $value )
        $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
      
    $options = '';
    foreach ( $field['options'] as $key => $value ) {
      $options .= '<option value="' . esc_attr( $key ) . '" ' . selected( esc_attr( $field['value'] ), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
    }
    
    if(isset($field['label'])) {
      printf(
        '<p class="%s"><strong>%s</strong>',
        $field['label_for'],
        $field['label']
      );
      if(isset($field['hints'])) {
        printf(
          '<span class="img_tip" data-desc="%s"></span>',
          wp_kses_post ( $field['hints'] )
        );
      }
      printf(
        '</p><label class="screen-reader-text" for="%s">%s</label>',
        $field['label_for'],
        $field['label']
      );
    }
    
    printf(
        '<select id="%s" name="%s" class="%s" %s />%s</select>',
        esc_attr($field['id']),
        esc_attr($field['name']),
        esc_attr($field['class']),
        implode( ' ', $custom_attributes ),
        $options
    );
    
    // Help message
    if(!isset($field['label']) && isset($field['hints'])) {
      printf(
        '<span class="img_tip" data-desc="%s"></span>',
        wp_kses_post ( $field['hints'] )
      );
    }
    
    // Description
    if(isset($field['desc'])) {
      printf(
        '<p class="description">%s</p>',
        wp_kses_post ( $field['desc'] )
      );
    } 
  }
  
  /**
   * Output a upload input box.
   *
   * @access public
   * @param array $field
   * @return void
   */
  public function upload_input($field) {
    $field['class'] 		= isset( $field['class'] ) ? $field['class'] : 'upload_input';
    $field['value'] 		= isset( $field['value'] ) ? $field['value'] : '';
    $field['name'] 			= isset( $field['name'] ) ? $field['name'] : $field['id'];
    $field['prwidth'] 			= isset( $field['prwidth'] ) ? $field['prwidth'] : 75;
    $field['label_for'] = isset( $field['label_for'] ) ? $field['label_for'] : $field['id'];
    $customStyle 		= isset( $field['value'] ) ? 'display: none;' : '';
    $placeHolder 		= ( $field['value'] ) ? '' : 'placeHolder';
    
    if(isset($field['label'])) {
      printf(
        '<p class="%s"><strong>%s</strong>',
        $field['label_for'],
        $field['label']
      );
      if(isset($field['hints'])) {
        printf(
          '<span class="img_tip" data-desc="%s"></span>',
          wp_kses_post ( $field['hints'] )
        );
      }
      printf(
        '</p><label class="screen-reader-text" for="%s">%s</label>',
        $field['label_for'],
        $field['label']
      );
    }
    
    printf(
        '
        <span class="dc-wp-fields-uploader">
          <img id="%s_display" src="%s" width="%d" class="%s" />
          <input type="text" name="%s" id="%s" style="%s" class="%s" readonly value="%s" />
          <input type="button" class="upload_button button button-secondary" name="%s_button" id="%s_button" value="Upload" />
          <input type="button" class="remove_button button button-secondary" name="%s_remove_button" id="%s_remove_button" value="Remove" />
        </span>
        ',
        esc_attr($field['id']),
        esc_attr( $field['value'] ),
        absint( $field['prwidth'] ),
        $placeHolder,
        esc_attr($field['name']),
        esc_attr($field['id']),
        $customStyle,
        esc_attr( $field['class'] ),
        esc_attr( $field['value'] ),
        esc_attr($field['id']),
        esc_attr($field['id']),
        esc_attr($field['id']),
        esc_attr($field['id'])
    );
    
    // Help message
    if(!isset($field['label']) && isset($field['hints'])) {
      printf(
        '<span class="img_tip" data-desc="%s"></span>',
        wp_kses_post ( $field['hints'] )
      );
    }
    
    // Description
    if(isset($field['desc'])) {
      printf(
        '<p class="description">%s</p>',
        wp_kses_post ( $field['desc'] )
      );
    } 
  }
  
  /**
   * Output a colorpicker box.
   *
   * @access public
   * @param array $field
   * @return void
   */
  public function colorpicker_input($field) {
    $field['class'] 		= isset( $field['class'] ) ? $field['class'] : 'colorpicker';
    $field['default'] 		= isset( $field['default'] ) ? $field['default'] : 'fbfbfb';
    $field['value'] 		= isset( $field['value'] ) ? $field['value'] : $field['value'];
    $field['name'] 			= isset( $field['name'] ) ? $field['name'] : $field['id'];
    $field['label_for'] = isset( $field['label_for'] ) ? $field['label_for'] : $field['id'];
    
    if(isset($field['label'])) {
      printf(
        '<p class="%s"><strong>%s</strong>',
        $field['label_for'],
        $field['label']
      );
      if(isset($field['hints'])) {
        printf(
          '<span class="img_tip" data-desc="%s"></span>',
          wp_kses_post ( $field['hints'] )
        );
      }
      printf(
        '</p><label class="screen-reader-text" for="%s">%s</label>',
        $field['label_for'],
        $field['label']
      );
    }
    
    printf(
        '<input type="%s" id="%s" name="%s" class="%s" data-default="%s" value="%s" />',
        $field['type'],
        esc_attr($field['id']),
        esc_attr($field['name']),
        esc_attr($field['class']),
        esc_attr($field['default']),
        esc_attr($field['value'])
    );
    
    // Help message
    if(!isset($field['label']) && isset($field['hints'])) {
      printf(
        '<span class="img_tip" data-desc="%s"></span>',
        wp_kses_post ( $field['hints'] )
      );
    }
    
    // Description
    if(isset($field['desc'])) {
      printf(
        '<p class="description">%s</p>',
        wp_kses_post ( $field['desc'] )
      );
    }
  }
}