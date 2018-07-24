<?php namespace h;

class Frontend_MyAccount {

  function __construct() {
    add_filter( 'woocommerce_account_menu_items', array($this, 'remove_account_menu_items') );

    add_action( 'woocommerce_before_customer_login_form', array($this, 'add_form_wrapper') );
    add_action( 'woocommerce_after_customer_login_form', array($this, 'close_form_wrapper') );

    add_action( 'h_after_login_form', array($this, 'add_toggle_register') );
    add_action( 'h_before_register_form', array($this, 'add_toggle_login') );
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
  function add_form_wrapper() {
    echo '<div class="h-myaccount-wrapper">';
  }

  /*
    @action woocommerce_after_customer_login_form
  */
  function close_form_wrapper() {
    echo '</div>';
  }

  /*
    @action h_after_login_form
  */
  function add_toggle_register() {
    echo '<p class="text-center"><a class="button-passive h-toggle-form">Register »</a></p>';
  }

  /*
    @action h_before_register_form
  */
  function add_toggle_login() {
    echo '<a class="button-passive h-toggle-form">« Login</a>';
  }
}
