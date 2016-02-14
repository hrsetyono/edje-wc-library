<?php
/*
Plugin Name: Edje WooCommerce Framework
Description: Collection of code to help developers customize WooCommerce site.
Plugin URI: http://github.com/hrsetyono/edje-woo
Author: The Syne Studio
Author URI: http://thesyne.com/
Version: 0.3.0
*/

require_once "lib/all.php";
require_once "vendor/all.php";

// constant
define("HW_PLUGIN_DIR", plugins_url("", __FILE__) );

// ---------------
// Github updater
// ---------------
add_action("init", "hwc_updater");
function hwc_updater() {
  require_once "vendor/updater.php";

  if (is_admin() ) {
    $plugin_repo = "hrsetyono/edje-woo";
    $config = array(
      "slug" => plugin_basename(__FILE__),
      "proper_folder_name" => "edje-wp",
      "api_url" => "https://api.github.com/repos/{$plugin_repo}",
      "raw_url" => "https://raw.github.com/{$plugin_repo}/master",
      "github_url" => "https://github.com/{$plugin_repo}",
      "zip_url" => "https://github.com/{$plugin_repo}/archive/master.zip",
      "sslverify" => true,
      "requires" => "4.4.0",
      "tested" => "4.4.0",
      "readme" => "README.md",
      "access_token" => "", // for private repo, authorize under Appearance > Github Update
     );
     new WP_GitHub_Updater($config);
  }
}
