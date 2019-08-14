<?php namespace h;

class Frontend_Shop {
  function __construct() {
    // Remove all default actions
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
    remove_action( 'woocommerce_before_shop_loop', 'wc_setup_loop', 10 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

    remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
    remove_action( 'woocommerce_after_shop_loop', 'woocommerce_reset_loop', 999 );

    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );

    //
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