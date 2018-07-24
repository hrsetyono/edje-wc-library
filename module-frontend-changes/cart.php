<?php namespace h;
/*
  Configure Cart page
*/
class Frontend_Cart {

  function __construct() {
    // disable shipping calculator
    add_filter( 'woocommerce_cart_ready_to_calc_shipping', '__return_false', 99 );
    add_filter( 'woocommerce_coupons_enabled', '__return_false' );

    // replace thumbnail
    add_filter( 'woocommerce_cart_item_thumbnail', array($this, 'change_thumbnail_size'), 111, 2 );

    // add subtotal
    add_action( 'woocommerce_cart_contents', array($this, 'add_subtotal' ), 999 );

    // add checkout button
    remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
    add_action( 'woocommerce_cart_actions', array($this, 'add_proceed_checkout_button'), 999 );

    ///// ALERT BOX

    add_filter( 'woocommerce_add_success', array($this, 'disable_alert_remove_cart') );

    add_filter( 'woocommerce_add_to_cart_validation', array($this, 'add_close_button_in_alert') );
    add_filter( 'wc_add_to_cart_message_html', array($this, 'add_close_button_in_alert') );
    add_filter( 'woocommerce_add_error', array($this, 'add_close_button_in_alert') );

    // change the button in alert to go straight to checkout
    add_filter( 'wc_add_to_cart_message_html', array($this, 'added_to_cart_message'), null, 2 );
  }

  /*
    Add subtotal count within the Cart table
    @action woocommerce_cart_contents 999
  */
  function add_subtotal() {
    ?>
    <tr>
      <td colspan="6" class="actions">
        <h4 class="hoo-subtotal">
          <span><?php echo __( 'Subtotal', 'edje' ); ?>:</span>
          <strong><?php wc_cart_totals_subtotal_html(); ?></strong>
        </h4>
        <em class="hoo-subtotal-note"><?php echo __('Shipping, taxes, and discounts will be calculated at checkout.', 'edje'); ?></em>
      </td>
    </tr>
    <?php
  }

  /*
    Change the thumbnail size of product image in cart
    @filter woocommerce_cart_item_thumbnail
  */
  function change_thumbnail_size( $img, $cart_item ) {
    if( isset( $cart_item['product_id'] ) ) {
      return get_the_post_thumbnail( $cart_item['product_id'], 'thumbnail' );
    }

    return $img;
  }

  /*
    Add checkout button within the Cart table
    @action woocommerce_cart_actions 999
  */
  function add_proceed_checkout_button() {
    do_action( 'woocommerce_proceed_to_checkout' );
  }

  /*
    Remove the alert when removing item from cart
    @filter woocommerce_add_success

    @param $message (str) - Default message
    @return str - Modified message
  */
  function disable_alert_remove_cart( $message ) {
    if( strpos( $message, 'Undo' ) ) {
      return false;
    }

    return $message;
  }

  /*
    Add X button to dismiss the message

    @filter woocommerce_add_to_cart_validation
    @filter wc_add_to_cart_message
  */
  function add_close_button_in_alert( $message ) {
    $button = '<span class="woocommerce-message-close">×</span>';
    return $button . $message;
  }

  /*
    Change the alert message after adding to cart
    @filter wc_add_to_cart_message

    @param $message (str) - The default message
    @param $product_id (int) - The product that's just added to cart
    @return str - Modified message
  */
  function added_to_cart_message( $message, $product_id ) {
    $real_message = preg_replace( '/<a\D+a>/', '', $message ); // without <a> tag
    $button = sprintf(
      '<a href="%s" class="button wc-forward">%s</a> ',
      esc_url( wc_get_page_permalink('checkout') ), esc_html__( 'Continue Payment', 'my' )
    );

    return $button . $real_message;
  }
}
