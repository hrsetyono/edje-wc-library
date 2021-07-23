<?php
/*
Plugin Name: Edje WooCommerce Library
Description: Simplify WooCommerce complicated features. Designed to work with Timber.
Plugin URI: http://github.com/hrsetyono/edje-wc-library
Author: Pixel Studio
Author URI: https://pixelstudio.id/
Version: 3.0.0
*/

if( !defined( 'WPINC' ) ) { die; } // exit if accessed directly

define( 'H_WC_VERSION', '3.0.0' );
define( 'HOO_DIR', plugins_url( '', __FILE__ ) );
define( 'HOO_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'HOO_BASE', basename(dirname(__FILE__) ).'/'.basename(__FILE__) );

/////

if( !class_exists('Edje_WC_Library') ):

require_once __DIR__ . '/module-gutenberg/_index.php';
require_once __DIR__ . '/module-widgets/_index.php';

// Modules list
$hwc_modules = [
  'frontend-changes',
  'checkout-ui',
];

// require all module loaders
foreach( $hwc_modules as $m ) {
  require_once "module-$m/_load.php";
}


class Edje_WC_Library {
  function __construct() {
    add_action( 'plugins_loaded' , [$this, 'load_modules'] );

    if( defined('EDJE') ) {
      add_action( 'wp_enqueue_scripts', [$this, 'enqueue_scripts'], 99999 );
      register_activation_hook( HOO_BASE, [$this, 'register_activation_hook'] );
    }
  }

  /**
   * Load all modules
   */
  function load_modules() {
    if( !class_exists('WooCommerce') ) { return; }

    global $hwc_modules;
    foreach( $hwc_modules as $m ) {
      $m = str_replace( '-', '_', $m );
      $func_name = "load_hmodule_$m";

      if( function_exists( $func_name ) ) {
        call_user_func( $func_name );
      }
    }

    $this->module_helper();
    // $this->module_profile_ui();
    $this->module_variations_ui();
    // $this->module_wholesale();
  }


  /**
   * Enqueue custom assets
   */
  function enqueue_scripts() {
    wp_enqueue_script( 'h-wc', HOO_DIR . '/assets/js/h-wc.js' );
  }

  /**
   * Codes to run when the plugin is activated
   */
  function register_activation_hook() {
    
  }

  //

  /**
   * Module with generic functions to help other module
   */
  private function module_helper() {
    require_once 'module-helper/helper.php';
    require_once 'module-helper/change-default.php';
    
    new \hoo\Change_Default();
  }


  /**
   * Module to modify the WooCommerce fields in User Profile page
   */
  private function module_profile_ui() {
    if( !is_admin() ) { return; }

    require_once 'module-profile-ui/profile-ui.php';
    new \h\Profile_UI();
  }

  /**
   * Module to modify the WooCommerce variation metabox in Product's edit page
   */
  private function module_variations_ui() {
    if( !is_admin() ) { return; }

    require_once 'module-variations-ui/var-ui.php';
    require_once 'module-variations-ui/var-template.php';
    new \h\Variations_UI();
    new \h\Variations_Template();
  }

  /**
   * Module to add Wholesale fields and frontend
   * TODO: Far from even alpha test
   */
  private function module_wholesale() {
    if( !get_theme_support('h-wholesale') ) { return; }

    if( is_admin() ) {
      require_once HOO_PATH . '/module-wholesale/wholesale-admin.php';
      new \h\Wholesale_Admin();
    } else {
      require_once 'module-wholesale/wholesale-frontend.php';
      new \h\Wholesale_Frontend();
    }
  }
}

new Edje_WC_Library();
endif; // class_exists