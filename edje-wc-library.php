<?php
/*
Plugin Name: Edje WooCommerce Library
Description: WooCommerce library plugins to be used with Edje Theme.
Plugin URI: http://github.com/hrsetyono/edje-wc-library
Author: Pixel Studio
Author URI: https://pixelstudio.id/
Version: 4.0.0
*/

if (!defined('WPINC')) { die; } // exit if accessed directly

define('H_WC_VERSION', '4.0.0');
define('HOO_DIR', plugins_url('', __FILE__ ));
define('HOO_PATH', untrailingslashit(plugin_dir_path( __FILE__ )));
define('HOO_BASE', basename(dirname(__FILE__) ).'/'.basename(__FILE__));

/////

add_action('plugins_loaded' , '_h_after_woocommerce_plugin_loaded');
add_action('template_redirect', '_h_after_woocommerce_template_loaded');
add_action('wp_enqueue_scripts', '_h_enqueue_woocommerce_scripts', 99999);

/**
 * @action plugins_loaded
 */
function _h_after_woocommerce_plugin_loaded() {
  if(!class_exists('WooCommerce')) { return; }

  require_once __DIR__ . '/module-gutenberg/_index.php';
  require_once __DIR__ . '/module-checkout-ui/_index.php';
  require_once __DIR__ . '/module-variations-ui/_index.php';
  require_once __DIR__ . '/module-widgets/_index.php';
}

/**
 * @action template_redirect
 */
function _h_after_woocommerce_template_loaded() {
  if(!class_exists('WooCommerce')) { return; }
  
  require_once __DIR__ . '/inc/_general.php';
  require_once __DIR__ . '/inc/alert.php';
  require_once __DIR__ . '/inc/cart.php';
  require_once __DIR__ . '/inc/my-account.php';
  require_once __DIR__ . '/inc/my-account-register.php';
  require_once __DIR__ . '/inc/shop.php';
  require_once __DIR__ . '/inc/order-table.php';
}

/**
 * Enqueue custom WooCommerce assets
 */
function _h_enqueue_woocommerce_scripts() {
  wp_enqueue_script('h-wc', HOO_DIR . '/assets/js/h-wc.js');
}