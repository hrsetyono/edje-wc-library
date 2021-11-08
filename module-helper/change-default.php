<?php namespace hoo;

class Change_Default {
  function __construct() {
    if( is_admin() ) {

    } else {
      // disable WooCommerce CSS
      add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

      // disable breadcrumb
      add_filter( 'woocommerce_get_breadcrumb', '__return_false' );

      add_filter('woocommerce_cart_item_name', array($this, 'add_thumbnail_to_order_table'), 10, 3);
      add_filter('woocommerce_order_item_name', array($this, 'add_thumbnail_to_order_table'), 10, 3);
    }

    // Disable auto regenerate thumbnail
    add_filter( 'woocommerce_background_image_regeneration', '__return_false' );
  }

  /**
   * Add thumbnail to CART and ORDER table
   * @filter woocommerce_cart_item_name
   * 
   * @param $name
   * @param $cart_item - The product data
   * @param $cart_item_key
   * @return - The HTML tag for item name
   */
  function add_thumbnail_to_order_table( string $name, $cart_item, $cart_item_key ) : string {
    if( is_checkout() || is_wc_endpoint_url( 'view-order' )  ) {
      $image = get_the_post_thumbnail( $cart_item['product_id'], 'thumbnail' );
      $image = $image ? $image : sprintf("<img src='%s'>", wc_placeholder_img_src() );

      return $image . $name;
    } else {
      return $name;
    }
  }

}
