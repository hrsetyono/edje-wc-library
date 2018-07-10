<?php namespace h;
/*
  Functions for Thank You page
*/
class Checkout_Thankyou {

  function __construct() {
    add_action('woocommerce_before_thankyou', array($this, 'before_thankyou'), 1);
    add_action('woocommerce_thankyou', array($this, 'between_thankyou'), 1);
    add_action('woocommerce_thankyou', array($this, 'after_thankyou'), 1000);
  }

  /*
    Add wrapper for Thank you page

    @action woocommerce_before_thankyou
    @action woocommerce_thankyou
  */
  function before_thankyou($order_id) {
    echo '<div class="woocommerce-order">';
    echo '<section class="column-main">';
      // jetpack_breadcrumbs();
  }

  function between_thankyou($order_id) {
    $order = wc_get_order($order_id);
    $show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
    if ($show_customer_details) {
		  wc_get_template('order/order-details-customer.php', array('order' => $order) );
	  }

    echo '</section>';
    echo '<section class="column-aside">';
  }

  function after_thankyou($order_id) {
    echo '</section>';
  }
}
