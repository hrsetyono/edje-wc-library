<?php
/*
Plugin Name: WooCommerce Edje
Description: Library that helps customize WooCommerce. Designed to work with Timber.
Plugin URI: http://github.com/hrsetyono/woocommerce-edje
Author: The Syne Studio
Author URI: http://thesyne.com/
Version: 1.3.2
*/

// exit if accessed directly
if( !defined('ABSPATH') ) { exit; }

define( 'HOO_DIR', plugins_url( '', __FILE__ ) );
define( 'HOO_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

run_woocommerce_edje();

add_action( 'admin_init', 'admin_init_woocommerce_edje' );
add_action( 'init', 'init_woocommerce_edje' );
add_action( 'wp_enqueue_scripts', 'enqueue_scripts_woocommerce_edje', 99999 );


/////


function run_woocommerce_edje() {
  // disable everything if WC not installed
  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
  if( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
    return false;
  }

  require_once 'module-checkout-ui/_run.php';
  require_once 'module-variations-ui/_run.php';
  require_once 'module-profile-ui/_run.php';
  require_once 'module-frontend-changes/_run.php';
}


/*
  Inititate functions for admin
  @action admin_init
*/
function admin_init_woocommerce_edje() {
  require_once 'admin/hoo-settings.php';
  new Hoo_Settings();
}

/*
  Functions affecting public visitor
  @action init
*/
function init_woocommerce_edje() {
  require_once 'public/hoo-init.php';
  new Hoo_Init();
}

function enqueue_scripts_woocommerce_edje( $hook ) {
  wp_enqueue_script( 'hoo-script', HOO_DIR . '/assets/js/hoo.js' );
}
