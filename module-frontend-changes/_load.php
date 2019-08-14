<?php

function load_hmodule_frontend_changes() {
  if( is_admin() || !defined('EDJE') ) { return; }

  require_once __DIR__ . '/register.php';
  require_once __DIR__ . '/toast.php';
  require_once __DIR__ . '/single.php';
  require_once __DIR__ . '/shop.php';

  new \h\Frontend_Register();
  new \h\Frontend_Toast();
  new \h\Frontend_Single();
  new \h\Frontend_Shop();

  add_action( 'template_redirect', function() {
    // my account page
    if( is_account_page() ) {
      require_once __DIR__ . '/myaccount.php';
      new \h\Frontend_MyAccount();
      
      require_once HOO_PATH . '/module-checkout-ui/form-fields.php';
      new \h\Checkout_Fields();
    }
    // cart page
    elseif( is_cart() ) {
      require_once __DIR__ . '/cart.php';
      new \h\Frontend_Cart();
    }
  } );
}