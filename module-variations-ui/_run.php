<?php
/*
  Modify the WooCommerce metabox in Product edit page
*/

add_action( 'admin_init', '_run_admin_h_variations_ui' );

/////

function _run_admin_h_variations_ui() {
  require_once HOO_PATH . '/module-variations-ui/var-ui.php';
  require_once HOO_PATH . '/module-variations-ui/var-template.php';
  new \h\Variations_UI();
  new \h\Variations_Template();
}
