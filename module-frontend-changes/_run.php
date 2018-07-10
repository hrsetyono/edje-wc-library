<?php
/*
  Functions affecting public visitor
*/

add_action( 'template_redirect', '_run_h_frontend_changes' );

/////

function _run_h_frontend_changes() {
  if( is_account_page() ) {
    require_once HOO_PATH . '/module-frontend-changes/myaccount.php';
    require_once HOO_PATH . '/module-checkout-ui/form-fields.php';
    new \h\Frontend_MyAccount();
    new \h\Checkout_Fields();
  }

  if( is_cart() ) {
    require_once HOO_PATH . '/module-frontend-changes/cart.php';
    new \h\Frontend_Cart();
  }
}
