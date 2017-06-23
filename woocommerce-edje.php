<?php
/*
Plugin Name: WooCommerce Edje
Description: Library that helps customize WooCommerce. Designed to work with Timber.
Plugin URI: http://github.com/hrsetyono/woocommerce-edje
Author: The Syne Studio
Author URI: http://thesyne.com/
Version: 1.0.0-beta
*/

// exit if accessed directly
if(!defined('ABSPATH') ) { exit; }

require_once 'admin/all.php';
require_once 'public/all.php';
define('HOO_DIR', plugins_url('', __FILE__) );


function run_hoo() {
  $hoo = new Hoo();
}
run_hoo();


// Main portal for calling all methods
class Hoo {
  function __construct() {
    global $post;

    // disable everything if WC not installed
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    if(!is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
      var_dump('wc not active');
      return false;
    }

    // for product edit only
    if(isset($post->post_type) && $post->post_type == 'product') {
      add_action('admin_init', array($this, 'init_admin') );
    }

    // for front-end woocommerce page
    // $this->init_public();
  }

  function init_admin() {
    $hoo_save = new Hoo_Save();
    $hoo_metabox = new Hoo_Metabox();
    $hoo_template = new Hoo_Template();
  }

  function init_public() {
    $hoo_checkout = new Hoo_Checkout();
  }
}
