<?php
/*
  Functions affecting public visitor
*/

add_action( 'template_redirect', 'run_h_frontend_changes' );

function run_h_frontend_changes() {
  if( is_account_page() ) {
    require_once 'myaccount.php';
    require_once HOO_PATH . '/module-checkout-ui/form-fields.php';
    new H_Frontend_MyAccount();
    new H_CheckoutUI_Fields();
  }

  if( is_cart() ) {
    require_once 'cart.php';
    new H_Frontend_Cart();
  }
}
