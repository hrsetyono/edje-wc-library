<?php
/*
  Modify the WooCommerce metabox in Product edit page
*/


add_action( 'admin_init', '_run_admin_h_profileui' );

/////

function _run_admin_h_profileui() {
  require_once HOO_PATH . '/module-profile-ui/profile-ui.php';
  new H_ProfileUI();
}
