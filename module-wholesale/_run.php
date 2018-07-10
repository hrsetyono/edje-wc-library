<?php
/*
  Add Wholesale functionality
*/

add_action( 'init', '_run_h_wholesale' );
add_action( 'admin_init', '_run_admin_h_wholesale' );

/////

function _run_h_wholesale() {
  if( !current_user_can('wholesale') ) { return false; }

  require_once HOO_PATH . '/module-wholesale/wholesale-frontend.php';
  new \h\Wholesale_Frontend();
}

function _run_admin_h_wholesale() {
  require_once HOO_PATH . '/module-wholesale/wholesale-admin.php';
  new \h\Wholesale_Admin();
}
