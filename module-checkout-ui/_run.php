<?php
/*
  Replace Checkout interface with our UI
*/

// run
add_action( 'template_redirect', '_run_h_checkout_ui' );

/////

function _run_h_checkout_ui() {
  if( is_checkout() && get_theme_support('h-wc-checkout') ) {
    require_once HOO_PATH . '/module-checkout-ui/checkout-ui.php';
    require_once HOO_PATH . '/module-checkout-ui/form-fields.php';
    require_once HOO_PATH . '/module-checkout-ui/locate-template.php';
    new H_CheckoutUI();
    new H_CheckoutUI_Fields();
  }

  if( is_wc_endpoint_url( 'order-received' ) ) {
    require_once HOO_PATH . '/module-checkout-ui/thankyou-page.php';
    new H_CheckoutUI_Thankyou();
  }
}
