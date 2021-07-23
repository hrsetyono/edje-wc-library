<?php

if( is_admin() ) {
  add_action( 'enqueue_block_editor_assets', 'h_shop_editor_assets', 100 );
}

/**
 * Add assets for WooCommerce blocks
 */
function h_shop_editor_assets() {
  if ( !is_admin() ) { return; }
  
  $dir = plugin_dir_url(__FILE__) . 'dist';
  $assets = [
    'h-shop-editor',
    'h-featured-category',
    // 'h-products' // error because it's a dynamic block
  ];

  foreach( $assets as $a ) {
    wp_enqueue_script( $a, $dir . "/$a.js", [ 'wp-blocks', 'wp-dom' ] , H_WC_VERSION, true );
    wp_enqueue_style( $a, $dir . "/$a.css", [ 'wp-edit-blocks' ], H_WC_VERSION );
  }
}