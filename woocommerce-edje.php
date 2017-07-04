<?php
/*
Plugin Name: WooCommerce Edje
Description: Library that helps customize WooCommerce. Designed to work with Timber.
Plugin URI: http://github.com/hrsetyono/woocommerce-edje
Author: The Syne Studio
Author URI: http://thesyne.com/
Version: 1.0.1-beta
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
    // disable everything if WC not installed
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    if(!is_plugin_active('woocommerce/woocommerce.php') ) {
      return false;
    }

    // for product edit only
    global $post;
    if(isset($post->post_type) && $post->post_type == 'product') {
      add_action('admin_init', array($this, 'init_admin') );
    }

    // front end woocommerce page
    add_action('template_redirect', array($this, 'init_public'));
  }

  function init_admin() {
    $hoo_save = new Hoo_Save();
    $hoo_metabox = new Hoo_Metabox();
    $hoo_template = new Hoo_Template();
  }

  function init_public() {
    if(is_checkout() ) {
      $hoo_checkout = new Hoo_Checkout();
    }
  }
}
