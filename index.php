<?php
/*
Plugin Name: Edje WooCommerce
Description: Collection of code to help developers customize WooCommerce site.
Plugin URI: http://github.com/hrsetyono/edje-woo
Author: The Syne Studio
Author URI: http://thesyne.com/
Version: 0.5.0
*/

require_once 'lib/all.php';
require_once 'vendor/all.php';

// constant
define('HOO_PLUGIN_DIR', plugins_url('', __FILE__) );

$hoo =  new Hoo();

// Main portal for calling all methods
class Hoo {
  function __construct() {
    add_action('admin_init', array($this, 'init_admin_script') );
    // add_action('admin_init', array($this, 'init_updater') );
  }

  function init_admin_script() {
    $hoo_save = new Hoo_Save();
    $hoo_admin = new Hoo_Admin();
  }

  /*
    Github Updater
  */
  function init_updater() {
    require_once 'updater.php';

    if (is_admin() ) {
      $plugin_repo = 'hrsetyono/edje-woo';
      $config = array(
        'slug' => plugin_basename(__FILE__),
        'proper_folder_name' => 'edje-wp',
        'api_url' => "https://api.github.com/repos/$plugin_repo",
        'raw_url' => "https://raw.github.com/$plugin_repo/master",
        'github_url' => "https://github.com/$plugin_repo",
        'zip_url' => "https://github.com/$plugin_repo/archive/master.zip",
        'sslverify' => true,
        'requires' => '4.4.0',
        'tested' => '4.4.0',
        'readme' => 'README.md',
        'access_token' => '', // for private repo, authorize under Appearance > Github Update
       );

      new WP_GitHub_Updater($config);
    }
  }
}
