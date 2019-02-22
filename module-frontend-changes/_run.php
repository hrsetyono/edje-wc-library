<?php
/*
  Functions affecting public visitor
*/

add_action( 'template_redirect', '_h_module_frontend' );
add_action( 'init', '_h_module_frontend_init' );

/////

function _h_module_frontend() {
  // if in admin OR theme doesn't support woocommerce
  if( is_admin() || !get_theme_support('h-woocommerce') ) { return false; }

  
  // disable woocommerce CSS
  add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

  // remove default image in product thumb
  remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );


  // my account page
  if( is_account_page() ) {
    require_once 'myaccount.php';
    require_once HOO_PATH . '/module-checkout-ui/form-fields.php';
    new \h\Frontend_MyAccount();
    new \h\Checkout_Fields();
  }
  // cart page
  elseif( is_cart() ) {
    require_once 'cart.php';
    new \h\Frontend_Cart();
  }
  // single product page
  elseif( is_product() || is_shop() ) {
    require_once 'product.php';
    new \h\Frontend_Product();
  }
  // shop page
  elseif( is_shop() ) {
    require_once 'shop.php';
    new \h\Frontend_Shop();
  }
}

function _h_module_frontend_init() {
  if( is_admin() || !get_theme_support('h-woocommerce') ) { return false; }

  require_once 'register.php';
  new \h\Frontend_Register();
}
