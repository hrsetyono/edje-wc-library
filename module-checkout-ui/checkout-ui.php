<?php namespace h;

class Checkout_UI {

  function __construct() {
    // Template
    add_filter('template_include', array($this, 'replace_page_template'), 100);

    // Wrapper
    add_action('woocommerce_before_checkout_form', array($this, 'wrap_side_form'), 8);
    add_action('woocommerce_before_checkout_form', array($this, 'wrap_side_form_close'), 12);

    // Order Review
    add_action('woocommerce_checkout_before_customer_details', array($this, 'before_customer_details') );
    add_action('woocommerce_checkout_after_customer_details', array($this, 'after_customer_details') );
    add_action('woocommerce_checkout_after_order_review', array($this, 'after_order_review') );

    // CSS JS
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    add_action('wp_enqueue_scripts', array($this, 'enqueue_script_style'), 999999);

    // Email
    add_action('woocommerce_order_status_completed_notification', array($this, 'send_invoice_after_order') );

    // Account
    add_filter('woocommerce_min_password_strength', array($this, 'reduce_password_requirement') );
  }


  /*
    Replace the Page template with the one provided by this plugin

    @filter template_include

    @param $page_template (str) - Path to the PHP template file
    @return str - The new path to PHP template file
  */
  function replace_page_template( $template ) {
    $file = 'page-checkout.php';
    if( file_exists(hoo_locate_template( $file ) ) ) {
  		$template = hoo_locate_template( $file );
  	}

    return $template;
  }

  /*
    Add wrapper to Coupon Form and Login

    @action woocommerce_before_checkout_form
    @action woocommerce_before_checkout_form
  */
  function wrap_side_form() {
    echo '<div class="checkout-side-form">';
  }
  function wrap_side_form_close() {
    echo '</div>';
  }


  /*
    Additional content for Customer Details and wrap Order Review

    @action woocommerce_checkout_before_customer_details
    @action woocommerce_checkout_after_customer_details
    @action woocommerce_checkout_after_order_review
  */
  function before_customer_details() {
    echo '<div class="column-main">';
      if( class_exists('Jetpack') ) { jetpack_breadcrumbs(); }
  }
  function after_customer_details() {
      $this->output_legal_terms();
    echo '</div>';
    echo '<div class="column-aside">';
  }
  function after_order_review() {
    echo '</div>';
  }


  /////

  /*
    Customize JS and CSS queued for checkout

    @action wp_enqueue_scripts
  */
  function enqueue_script_style( $hook ) {
    // remove all previous CSS
    global $wp_styles;
  	foreach( $wp_styles->registered as $handle => $data ) {
      if( in_array($handle, array('admin-bar', 'select2') ) ) { continue; }
  		wp_dequeue_style( $handle );
  	}

    // custom css and js
    wp_enqueue_style( 'hoo-style', HOO_DIR . '/assets/css/hoo.css' );
  }


  /*
    Send invoice to customer automatically after order

    @param $order_id (int) - The new order that's just created
  */
  function send_invoice_after_order( $order_id ) {
    $email = new WC_Email_Customer_Invoice();
    $email->trigger( $order_id );
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
    global $post;
    $tnc_url = get_permalink( wc_get_page_id( 'terms' ) );
    $privacy_url = get_permalink( get_option( 'wp_page_for_privacy_policy', 0 ) );

    ?>
    <div class="checkout-legal">
      <span>All rights reserved <?php bloginfo('name'); ?></span>
      <?php if( $tnc_url ) {
        echo "<span><a href='$tnc_url' target='_blank'>" . __('Terms &amp; Conditions', 'hoo') . '</a></span>';
      } ?>
      <?php if( $privacy_url ) {
        echo "<span><a href='$privacy_url' target='_blank'>" .  __('Privacy Policy', 'hoo') . '</a></span>';
      } ?>
    </div>
    <?php
  }
}
