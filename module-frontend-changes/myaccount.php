<?php namespace h;

class Frontend_MyAccount {

  function __construct() {
    add_filter( 'woocommerce_account_menu_items', array($this, 'remove_account_menu_items') );

    add_action( 'woocommerce_before_customer_login_form', array($this, 'add_login_wrapper') );
    add_action( 'woocommerce_after_customer_login_form', array($this, 'close_login_wrapper') );
  }

  /*
    If the user has no Downloadable purchase, hide it
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

  /*
    @action woocommerce_before_customer_login_form
  */
  function add_login_wrapper() {
    echo '<div class="woocommerce-account-wrapper">';
  }

  /*
    @action woocommerce_after_customer_login_form
  */
  function close_login_wrapper() {
    echo '</div>';
  }
}
