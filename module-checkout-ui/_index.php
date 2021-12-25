<?php

add_action('template_redirect', '_hwc_checkout_ui');

function _hwc_checkout_ui() {
  if (!get_theme_support('h-checkout')) { return; }

  require_once __DIR__ . '/locate-template.php';

  if (is_checkout()) {
    require_once __DIR__ . '/checkout-ui.php';
    require_once __DIR__ . '/form-fields.php';
    new \h\Checkout_UI();
    new \h\Checkout_Fields();
  }
  
  if (is_wc_endpoint_url('order-received')) {
    require_once __DIR__ . '/thankyou-page.php';
    new \h\Checkout_Thankyou();
  }
}