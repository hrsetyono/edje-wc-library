<?php

add_filter('woocommerce_background_image_regeneration', '__return_false');

if (is_admin()) {
  add_action('admin_enqueue_scripts', 'h_woocommerce_admin_assets', 100);
}

function h_woocommerce_admin_assets() {
  $dir = HOO_DIR . '/dist';

  wp_enqueue_script('edje-wc-admin', $dir . '/edje-wc-admin.js', [], H_WC_VERSION , true);
  wp_enqueue_style('edje-wc-admin', $dir . '/edje-wc-admin.css', [], H_WC_VERSION);
}