<?php
/*
  Generic function OR those that can't be run in template_redirect action.
*/
class Hoo_General {

  function __construct() {
    // Order Review
    add_filter('woocommerce_cart_item_name', array($this, 'modify_cart_item_name'), 10, 3);
    add_filter('woocommerce_order_item_name', array($this, 'modify_cart_item_name'), 10, 3);

    // Templating
    add_filter('woocommerce_locate_template', array($this, 'woocommerce_locate_template'), 1, 3);

    // Hide HELP tab
    add_filter('woocommerce_enable_admin_help_tab', '__return_false');
  }


  /*
    Allow WooCommerce template to be placed within this plugin's /template/ directory

    source: https://wisdmlabs.com/blog/override-woocommerce-templates-plugin/
  */
  function woocommerce_locate_template($template, $template_name, $template_path) {
    global $woocommerce;
    $_template = $template;
    if(!$template_path) {
      $template_path = $woocommerce->template_url;
    }

    $plugin_path  = HOO_PATH . '/templates/';

    // Look within passed path within the theme - this is priority
    $template = locate_template(
      array($template_path . $template_name, $template_name)
    );

    if(!$template && file_exists( $plugin_path . $template_name ) ) {
      $template = $plugin_path . $template_name;
    }

    if(!$template ) {
      $template = $_template;
    }

    return $template;
  }

  /*
    Add thumbnail to Order Review table
    @filter woocommerce_cart_item_name

    @param $name (str)
    @param $cart_item (obj) - The product data
    @param $cart_item_key (int)

    @return str - The HTML tag for item name
  */
  function modify_cart_item_name($name, $cart_item, $cart_item_key) {
    if(is_checkout() ) {
      $image = get_the_post_thumbnail($cart_item['product_id']);
      return $image . $name;
    } else {
      return $name;
    }
  }

}