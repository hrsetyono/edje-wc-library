<?php

class H_Frontend_MyAccount {

  function __construct() {
    add_filter( 'woocommerce_account_menu_items', array($this, 'remove_account_menu_items') );
  }

  /*
    @filter woocommerce_account_menu_items
  */
  function remove_account_menu_items( $items ) {
    // remove Dashboard because it's useless
    unset( $items['dashboard'] );

    // remove Downloads if there's nothing
    if( !WC()->customer->get_downloadable_products() ) {
      unset( $items['downloads'] );
    }

    return $items;
  }

}
