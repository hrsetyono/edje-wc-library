<?php namespace h;
/**
 * Change the interface for Edit Profile (admin) page
 */
class Profile_UI {
  function __construct() {
    add_action( 'admin_enqueue_scripts', [$this, 'admin_enqueue_scripts'], 999 );
  }

  /**
   * Call the custom CSS and JS
   * @action admin_enqueue_scripts
   */
  function admin_enqueue_scripts( $hook ) {
    if( in_array( $hook, ['user-edit.php', 'profile.php'] ) ) {
      wp_enqueue_style( 'h-admin-profile', HOO_DIR . '/assets/css/h-admin-profile.css' );
    }
  }
}
