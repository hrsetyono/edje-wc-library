<?php
/*
  Functions affecting public visitor
*/

add_action( 'template_redirect', '_run_h_mfc_template_redirect' );
add_action( 'init', '_run_h_mfc_init' );

/////

function _run_h_mfc_template_redirect() {
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

function _run_h_mfc_init() {
  require_once HOO_PATH . '/module-frontend-changes/register.php';
  new \h\Frontend_Register();
}
