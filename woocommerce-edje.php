<?php
/*
Plugin Name: WooCommerce Edje
Description: Library that helps customize WooCommerce. Designed to work with Timber.
Plugin URI: http://github.com/hrsetyono/woocommerce-edje
Author: The Syne Studio
Author URI: http://thesyne.com/
Version: 1.2.0
*/

// exit if accessed directly
if( !defined('ABSPATH') ) { exit; }
require_once 'public/hoo-utility.php';

define( 'HOO_DIR', plugins_url( '', __FILE__ ) );
define( 'HOO_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );


// Main portal for calling all methods
new Hoo();
class Hoo {
  function __construct() {
    // disable everything if WC not installed
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
      return false;
    }

    add_action( 'admin_init', array( $this, 'admin_init' ) );
    add_action( 'template_redirect', array( $this, 'public_init' ) );
    add_action( 'init', array( $this, 'public_before_init' ) );

    add_action( 'wp_enqueue_scripts', array($this, 'hoo_enqueue_scripts'), 99999 );
  }


  /*
    Inititate functions for admin
    @action admin_init
  */
  function admin_init() {
    require_once 'admin/all.php';

    new Hoo_Save();
    new Hoo_Metabox();
    new Hoo_Handlebars();
    new Hoo_Settings();
  }


  /*
    Front end function that needs to run on init
    @action init
  */
  function public_before_init() {
    require_once 'public/hoo-init.php';
    new Hoo_Init();
  }

  /*
    Initiate functions for end user
    @action template_redirect
  */
  function public_init() {
    if( is_account_page() ) {
      require_once 'public/hoo-myaccount.php';
      require_once 'public/hoo-form-fields.php';
      new Hoo_MyAccount();
      new Hoo_Form();
    }

    if( is_cart() ) {
      require_once 'public/hoo-cart.php';
      new Hoo_Cart();
    }

    if( is_checkout() && get_theme_support('h-wc-checkout') ) {
      require_once 'public/hoo-checkout.php';
      require_once 'public/hoo-form-fields.php';
      new Hoo_Checkout();
      new Hoo_Form();
    }

    if( is_wc_endpoint_url( 'order-received' ) ) {
      require_once 'public/hoo-thankyou.php';
      new Hoo_Thankyou();
    }
  }

  /*
    Enqueue assets for use in all pages
  */
  function hoo_enqueue_scripts( $hook ) {
    wp_enqueue_script( 'hoo-script', HOO_DIR . '/assets/js/hoo.js' );
  }
}
