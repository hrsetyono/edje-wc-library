<?php
/*
Plugin Name: WooCommerce Edje
Description: Library that helps customize WooCommerce. Designed to work with Timber.
Plugin URI: http://github.com/hrsetyono/woocommerce-edje
Author: The Syne Studio
Author URI: http://thesyne.com/
Version: 1.1.6
*/

// exit if accessed directly
if( !defined('ABSPATH') ) { exit; }

require_once 'admin/all.php';
require_once 'public/all.php';
define( 'HOO_DIR', plugins_url( '', __FILE__ ) );
define( 'HOO_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );


function run_hoo() {
  $hoo = new Hoo();
}
run_hoo();




// Main portal for calling all methods
class Hoo {
  function __construct() {
    // disable everything if WC not installed
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
      return false;
    }

    add_action( 'admin_init', array( $this, 'admin_init' ) );

    // front end woocommerce page
    add_action( 'init', array( $this, 'general_init' ) );
    add_action( 'template_redirect', array( $this, 'public_init' ) );
  }

  function admin_init() {
    $hoo_save = new Hoo_Save();
    $hoo_metabox = new Hoo_Metabox();
    $hoo_template = new Hoo_Template();
  }

  function public_init() {
    if( is_checkout() ) {
      $hoo_checkout = new Hoo_Checkout();
    }

    if( is_wc_endpoint_url( 'order-received' ) ) {
      $hoo_thankyou = new Hoo_Thankyou();
    }
  }

  function general_init() {
    $hoo_general = new Hoo_General();
  }
}
