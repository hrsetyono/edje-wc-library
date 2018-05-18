<?php

class Hoo_Settings {

  function __construct() {
    add_filter( 'woocommerce_payment_gateways_settings', array($this, 'privacy_page_select') );
  }

  /*
    Add "Privacy Policy" setting to Checkout setting
    @filter woocommerce_checkout_settings
  */
  function privacy_page_select( $settings ) {
    $terms_index = array_search( 'woocommerce_terms_page_id', array_column($settings, 'id') );

    $privacy_args = array(
      'title'    => __( 'Privacy Policy', 'h' ),
      'desc'     => __( 'EDJE Settings. A page to let your visitor know what you will do with their data. Shown besides the Copyright info of Checkout page.', 'h' ),
      'id'       => 'woocommerce_privacy_page_id',
      'default'  => '',
      'class'    => 'wc-enhanced-select-nostd',
      'css'      => 'min-width:300px;',
      'type'     => 'single_select_page',
      'desc_tip' => true,
      'autoload' => false,
    );

    array_splice( $settings, $terms_index + 1, 0, array( $privacy_args ) );
    return $settings;
  }
}
