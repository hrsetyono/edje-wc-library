<?php
/*
  Heavily customize part of Checkout page
*/

class Hoo_Checkout {

  function __construct() {
    // Add wrapper and extra content
    add_action('woocommerce_checkout_before_customer_details', array($this, 'before_customer_details') );
    add_action('woocommerce_checkout_after_customer_details', array($this, 'after_customer_details') );
    add_action('woocommerce_checkout_after_order_review', array($this, 'after_order_review') );

    add_action('woocommerce_before_checkout_form', array($this, 'wrap_side_details_open'), 9);
    add_action('woocommerce_before_checkout_form', array($this, 'wrap_side_details_close'), 11);

    // Manage fields
    add_filter('woocommerce_billing_fields', array($this, 'reorder_billing_fields'), 10, 1 );
    add_filter('woocommerce_default_address_fields', array($this, 'reorder_address_fields'), 10);

    // Disable WooCommerce style
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    add_action('wp_enqueue_scripts', array($this, 'customize_script_style'), 100);

    // TODO: get the image using 'product_id'
    add_filter('woocommerce_cart_item_name', function($name, $cart_item, $cart_item_key) {
      return $name;
    }, 10, 3);

    // Send mail after order
    add_action('woocommerce_order_status_completed_notification', array($this, 'send_invoice_after_order') );

    // Reduce password requirement
    add_filter('woocommerce_min_password_strength', array($this, 'reduce_password_requirement') );
  }

  /*
    Additional content for Customer Details and wrap Order Review

    @action woocommerce_checkout_before_customer_details
    @action woocommerce_checkout_after_customer_details
    @action woocommerce_checkout_after_order_review
  */
  function before_customer_details() {
    echo '<div class="checkout-customer">';
    jetpack_breadcrumbs();
  }
  function after_customer_details() {
    $this->output_legal_terms();
    echo '</div>';
    echo '<div class="checkout-order">';
  }
  function after_order_review() {
    echo '</div>';
  }

  /*
    Add wrapper to Coupon Form and Info
    @action woocommerce_before_checkout_form
    @action woocommerce_before_checkout_form
  */
  function wrap_side_details_open() {
    echo '<div class="checkout-side-form">';
  }
  function wrap_side_details_close() {
    echo '</div>';
  }



  /////

  /*
    Reorder billing field
    @filter woocommerce_billing_fields

    @param array $fields - The fields in billing
    @return array - The modified list of fields.
  */
  function reorder_billing_fields($fields) {
    $fields['billing_email']['priority'] = 1;
    $fields['billing_email']['placeholder'] = $fields['billing_email']['label'];

    $fields['billing_phone']['required'] = false;
    $fields['billing_phone']['placeholder'] = $fields['billing_phone']['label'];

    return $fields;
  }

  /*
    Reorder address field (Billing and Shipping) to be more like Shopify
    @filter woocommerce_default_address_fields

    @param array $fields - The current list of fields
    @return array - The ordered list of fields
  */
  function reorder_address_fields($fields) {
    unset($fields['company']);

    $fields['first_name']['placeholder'] = $fields['first_name']['label'];
    $fields['last_name']['placeholder'] = $fields['last_name']['label'];

    $fields['address_1']['priority'] = 22;
    $fields['address_1']['placeholder'] = $fields['address_1']['label'];
    $fields['address_2']['priority'] = 24;
    $fields['address_2']['label'] = __('Apartment, suite, unit etc.', 'my');

    $fields['state']['priority'] = 42;
    $fields['state']['placeholder'] = $fields['state']['label'];
    $fields['country']['class'][] = 'form-row--active form-row--select';

    $fields['postcode']['priority'] = 46;
    $fields['postcode']['placeholder'] = $fields['postcode']['label'];

    $fields['city']['priority'] = 50;
    $fields['city']['placeholder'] = $fields['city']['label'];

    return $fields;
  }

  /*
    Customize JS and CSS queued for checkout
  */
  function customize_script_style($hook) {
    wp_dequeue_style( 'select2' );
    wp_deregister_style( 'select2' );

    wp_dequeue_script( 'select2');
    wp_deregister_script('select2');

    // custom css and js
    wp_enqueue_style('hoo-style', HOO_DIR . '/assets/css/hoo.css');
    wp_enqueue_script('hoo-script', HOO_DIR . '/assets/js/hoo.js');
  }


  /*
    Send invoice to customer automatically after order

    @param $order_id (int) - The new order that's just created
  */
  function send_invoice_after_order($order_id) {
    $email = new WC_Email_Customer_Invoice();
    $email->trigger($order_id);
  }

  /*
    Set the minimum requirement for password during registration
    1: bad, 2: medium, 3: strong
    @filter woocommerce_min_password_strength

    @return int - The minimum strength level allowed
  */
  function reduce_password_requirement() {
    return 1;
  }


  /////

  /*
    Add copyright, legal, and terms condition at the bottom of Customer Detail
  */
  private function output_legal_terms() {
    ?>
    <div class="checkout-legal">
      <span>All rights reserved <?php bloginfo('name'); ?></span> • <a>Terms &amp; Condition</a> • <a>Privacy Policy</a>
    </div>
    <?php
  }
}
