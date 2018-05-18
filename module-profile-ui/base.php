<?php
/*
  Modify the WooCommerce metabox in Product edit page
*/

// run
add_action( 'admin_init', 'run_h_profile_ui' );
function run_h_profile_ui() {
  new H_ProfileUI();
}

/////

class H_ProfileUI {
  function __construct() {
    add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 999 );
  }

  /*
    Call the custom CSS and JS
    @action admin_enqueue_scripts
  */
  function admin_enqueue_scripts( $hook ) {
    if( in_array( $hook, array( 'user-edit.php', 'profile.php' ) ) ) {
      wp_enqueue_style( 'hoo-admin-profile-css', HOO_DIR . '/assets/css/hoo-admin-profile.css' );
    }
  }
}
