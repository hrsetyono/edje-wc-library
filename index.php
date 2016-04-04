<?php
/*
Plugin Name: Edje WooCommerce Framework
Description: Collection of code to help developers customize WooCommerce site.
Plugin URI: http://github.com/hrsetyono/edje-woo
Author: The Syne Studio
Author URI: http://thesyne.com/
Version: 0.4.1
*/

require_once 'lib/all.php';
require_once 'vendor/all.php';

// constant
define('HOO_PLUGIN_DIR', plugins_url('', __FILE__) );

// Main portal for calling all methods
class Hoo {

  /*
    Get post alongside all Product metadata.

    @param array $query - WP Query, leave empty to get current object
    @return TimberPost - post with additional product metadata
  */
  static function get_post($query = false, $PostClass = 'TimberPost') {
    if($query) { $query['post_type'] = 'product'; }

    $post = TimberPostGetter::get_post($query, $PostClass);
		return self::attach_product_data($post);
	}

  /*
    Get posts alongside all Product metadata.

    @param array $query - WP Query, leave empty to get current object
    @return array - posts with additional product metadata
  */
  static function get_posts($query = false, $PostClass = 'TimberPost', $return_collection = false) {
    if($query) { $query['post_type'] = 'product'; }

		$posts = TimberPostGetter::get_posts($query, $PostClass, $return_collection);

    // loop each post and attach the product
    foreach($posts as &$p) {
      $p = self::attach_product_data($p);
    }

    return $posts;
	}

  /*
    Get all Product metadata and attach it to Post.

    @param object $post
    @return object $post - Post with additional WC meta data
  */
  private static function attach_product_data($post) {
    $post->product = self::get_product($post);
    $post->attributes = self::get_attributes($post);
    $post->variations = self::get_variations($post->product);

    return $post;
  }

  /*
    Get product data from post

    @param TimberPost $post
    @return WC_Product - The product data
  */
  static function get_product($post) {
    return get_product($post->ID);
  }

  /*
    Get product attributes

    @param TimberPost $post
    @return array - All of the attributes in this product.
  */
  static function get_attributes($post) {
    $attributes = array();
    foreach($post->_product_attributes as $key => $value) {
      $raw_terms = wp_get_post_terms($post->id, $key);

      $terms = array();
      foreach($raw_terms as $t) {
        $terms[$t->slug] = $t;
      }

      $attributes[$key] = $terms;
    }

    return $attributes;
  }

  /*
    Get product variations

    @param WC_Product $product
    @return array - All of the variations in this product.
  */
  static function get_variations($product) {
    if($product->product_type === 'variable') {
      $variations = $product->get_available_variations();

      return $variations;
    }

    return null;
  }
}

// ---------------
// Github updater
// ---------------
add_action('init', 'hoo_updater');
function hoo_updater() {
  require_once 'vendor/updater.php';

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
