<?php
/*
Plugin Name: WooCommerce Edje
Description: Library that helps customize WooCommerce. Designed to work with Timber.
Plugin URI: http://github.com/hrsetyono/woocommerce-edje
Author: The Syne Studio
Author URI: http://thesyne.com/
Version: 1.4.0
*/

// exit if accessed directly
if( !defined('ABSPATH') ) { exit; }

define( 'HOO_DIR', plugins_url( '', __FILE__ ) );
define( 'HOO_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

/////

new Woocommerce_Edje();
class Woocommerce_Edje {
  function __construct() {
		register_activation_hook( __FILE__, array($this, 'activation_hook') );
		register_deactivation_hook( __FILE__, array($this, 'deactivation_hook') );

		$this->load();

    add_action( 'admin_init', array($this, 'admin_init') );
    add_action( 'init', array($this, 'init') );
    add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts'), 99999 );
	}

  /*
		Load the required dependencies for BOTH Admin and Public pages.
	*/
	function load() {
    // disable everything if WC not installed
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
      return false;
    }

    require_once 'module-checkout-ui/_run.php';
    require_once 'module-variations-ui/_run.php';
    require_once 'module-profile-ui/_run.php';
    require_once 'module-frontend-changes/_run.php';
    require_once 'module-wholesale/_run.php';
	}

  /*
    The code that runs during plugin activation.
  */
  function activation_hook() {
    // create "wholesale" role
    $role = get_role( 'customer' );
    $caps = $role->capabilities;
    $caps[] = 'wholesale';

    add_role( 'wholesale', 'Wholesale', $caps );
  }

  /*
    The code that runs during plugin deactivation.
  */
  function deactivation_hook() {}

	/*
		Load the required dependencies for Admin pages.
    @action admin_init
	*/
	function admin_init() {
	}

	/*
		Load the required dependencies for Public pages.
    @action init
	*/
	function init() {
    require_once 'admin/hoo-init.php';
    new \hoo\Init();
	}

  /*
    Load JS to front-end
    @action wp_enqueue_scripts
  */
  function enqueue_scripts( $hook ) {
    wp_enqueue_script( 'hoo-script', HOO_DIR . '/assets/js/hoo.js' );
  }
}
