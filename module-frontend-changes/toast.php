<?php namespace h;
/**
 * Change Alert box
 */
class Frontend_Toast {
  function __construct() {
     add_filter( 'woocommerce_add_success', [$this, 'disable_alert_remove_cart'] );

     add_filter( 'woocommerce_add_to_cart_validation', [$this, 'add_close_button_in_alert'] );
     add_filter( 'wc_add_to_cart_message_html', [$this, 'add_close_button_in_alert'] );
     add_filter( 'woocommerce_add_error', [$this, 'add_close_button_in_alert'] );
 
     // change the button in alert to go straight to checkout
     add_filter( 'wc_add_to_cart_message_html', [$this, 'added_to_cart_message'], null, 2 );
  }

  
  /**
   * Remove the alert when removing item from cart
   * @filter woocommerce_add_success
   */
  function disable_alert_remove_cart( string $message ) : string {
    if( strpos( $message, 'Undo' ) ) {
      return false;
    }

    return $message;
  }

  /**
   * Add X button to dismiss the message
   * @filter woocommerce_add_to_cart_validation
   * @filter wc_add_to_cart_message
   */
  function add_close_button_in_alert( string $message ) : string {
    $button = '<span class="h-close-toast">×</span>';
    return $button . $message;
  }


  /**
   * Change the alert message after adding to cart
   * @filter wc_add_to_cart_message
   */
  function added_to_cart_message( string $message, $product_id ) : string {
    $real_message = preg_replace( '/<a.+\/a>/', '', $message ); // without <a> tag

    $checkout_link = esc_url( wc_get_page_permalink('checkout') );
    $checkout_text = __('Continue Payment');

    $button = "<a href='$checkout_link' class='button wc-forward'>$checkout_text</a>";
    return $button . $real_message;
  }
}