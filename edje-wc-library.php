<?php
/*
Plugin Name: Edje WooCommerce Library
Description: Simplify WooCommerce complicated features. Designed to work with Timber.
Plugin URI: http://github.com/hrsetyono/woocommerce-edje
Author: The Syne Studio
Author URI: http://thesyne.com/
Version: 2.1.0
*/

if( !defined( 'WPINC' ) ) { die; } // exit if accessed directly

define( 'HOO_DIR', plugins_url( '', __FILE__ ) );
define( 'HOO_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'HOO_BASE', basename(dirname(__FILE__) ).'/'.basename(__FILE__) );

/////

if( !class_exists('Edje_WC_Library') ):

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
    if( !class_exists('woocommerce') ) { return; }

    $this->module_helper();
    $this->module_checkout_ui();
    $this->module_frontend_changes();
    $this->module_profile_ui();
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
   * Module to replace Checkout page interface with our custom one
   */
  private function module_checkout_ui() {
    add_action( 'template_redirect', function() {
      if( is_checkout() ) {
        require_once 'module-checkout-ui/checkout-ui.php';
        require_once 'module-checkout-ui/form-fields.php';
        new \h\Checkout_UI();
        new \h\Checkout_Fields();
      }
      
      if( is_wc_endpoint_url( 'order-received' ) ) {
        require_once 'module-checkout-ui/thankyou-page.php';
        new \h\Checkout_Thankyou();
      }
    } );
  }

  /**
   * Module to change Frontend template. Need to add `define('EDJE', true)` in wp-config
   */
  private function module_frontend_changes() {
    if( is_admin() || !defined('EDJE') ) { return; }

    // register page
    require_once 'module-frontend-changes/register.php';
    new \h\Frontend_Register();


    add_action( 'template_redirect', function() {
      // my account page
      if( is_account_page() ) {
        require_once 'module-frontend-changes/myaccount.php';
        require_once 'module-checkout-ui/form-fields.php';
        new \h\Frontend_MyAccount();
        new \h\Checkout_Fields();
      }
      // cart page
      elseif( is_cart() ) {
        require_once 'module-frontend-changes/cart.php';
        new \h\Frontend_Cart();
      }
      // single product page
      elseif( is_product() || is_shop() ) {
        require_once 'module-frontend-changes/product.php';
        new \h\Frontend_Product();
      }
      // shop page
      elseif( is_shop() ) {
        require_once 'module-frontend-changes/shop.php';
        new \h\Frontend_Shop();
      }
    } );
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