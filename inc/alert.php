<?php

add_filter('woocommerce_add_success', '_h_alert_disable_remove_cart');

add_filter('woocommerce_add_to_cart_validation', '_h_alert_add_close_button');
add_filter('wc_add_to_cart_message_html', '_h_alert_add_close_button');
add_filter('woocommerce_add_error', '_h_alert_add_close_button');

// change the button in alert to go straight to checkout
add_filter('wc_add_to_cart_message_html', '_h_alert_change_added_to_cart_message', null, 2);


/**
* Remove the alert when removing item from cart
* @filter woocommerce_add_success
*/
function _h_alert_disable_remove_cart(string $message) : string {
 if (strpos($message, 'Undo')) {
   return false;
 }

 return $message;
}

/**
* Add X button to dismiss the message
* @filter woocommerce_add_to_cart_validation
* @filter wc_add_to_cart_message
*/
function _h_alert_add_close_button(string $message) : string {
 $button = '<span class="h-close-toast">×</span>';
 return $button . $message;
}


/**
* Change the alert message after adding to cart
* @filter wc_add_to_cart_message
*/
function _h_alert_change_added_to_cart_message(string $message, $product_id) : string {
 $real_message = preg_replace('/<a.+\/a>/', '', $message); // without <a> tag

 $checkout_link = esc_url(wc_get_page_permalink('checkout'));
 $checkout_text = __('Continue Payment');

 $button = "<a href='$checkout_link' class='button wc-forward'>$checkout_text</a>";
 return $button . $real_message;
}