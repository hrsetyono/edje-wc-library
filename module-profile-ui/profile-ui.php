<?php

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
