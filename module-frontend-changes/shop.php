<?php namespace h;

class Frontend_Shop {
  function __construct() {
    // remove default wrapper
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );
    
    add_filter( 'loop_shop_per_page', array($this, 'change_products_per_page') );
    add_filter( 'single_product_archive_thumbnail_size', [$this, 'change_thumbnail_size'] );
  }

  
  /**
   * Change Products-per-page
   * @filter loop_shop_per_page
   */
  function change_products_per_page( int $current_per_page ) : int {
    return get_option( 'posts_per_page' );
  }

  /**
   * Change the thumbnail size in Shop page
   * @filter single_product_archive_thumbnail_size
   */
  function change_thumbnail_size( string $current_size ) : string {
    return 'medium';
  }
}