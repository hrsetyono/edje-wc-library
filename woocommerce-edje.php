<?php
/*
Plugin Name: WooCommerce Edje
Description: Library that helps customize WooCommerce. Designed to work with Timber.
Plugin URI: http://github.com/hrsetyono/woocommerce-edje
Author: The Syne Studio
Author URI: http://thesyne.com/
Version: 1.3.0
*/

// exit if accessed directly
if( !defined('ABSPATH') ) { exit; }
define( 'HOO_DIR', plugins_url( '', __FILE__ ) );
define( 'HOO_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );


run_woocommerce_edje();
new Hoo();


/////

function run_woocommerce_edje() {
  require_once 'module-checkout-ui/base.php';
  require_once 'module-variations-ui/base.php';
  require_once 'module-profile-ui/base.php';
  require_once 'module-frontend-changes/base.php';
}


// Main portal for calling all methods
class Hoo {
  function __construct() {
    // disable everything if WC not installed
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
      return false;
    }

    add_action( 'admin_init', array( $this, 'admin_init' ) );
    add_action( 'init', array( $this, 'public_init' ) );

    add_action( 'wp_enqueue_scripts', array($this, 'hoo_enqueue_scripts'), 99999 );
  }


  /*
    Inititate functions for admin
    @action admin_init
  */
  function admin_init() {
    require_once 'admin/hoo-settings.php';
    new Hoo_Settings();
  }


  /*
    Functions affecting public visitor
    @action init
  */
  function public_init() {
    require_once 'public/hoo-init.php';
    new Hoo_Init();
  }

  /*
    Enqueue assets for use in all pages
  */
  function hoo_enqueue_scripts( $hook ) {
    wp_enqueue_script( 'hoo-script', HOO_DIR . '/assets/js/hoo.js' );
  }
}
