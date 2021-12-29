<?php

// change the button in alert to go straight to checkout
add_filter('wc_add_to_cart_message_html', 'h_alert_change_added_to_cart_message', null, 2);


/**
* Change the alert message after adding to cart
* @filter wc_add_to_cart_message
*/
function h_alert_change_added_to_cart_message(string $message, $product_id) : string {
 $real_message = preg_replace('/<a.+\/a>/', '', $message); // without <a> tag

 $checkout_link = esc_url(wc_get_page_permalink('checkout'));
 $checkout_text = __('Checkout');

 $button = "<a href='$checkout_link' class='button wc-forward'>$checkout_text</a>";
 return $button . $real_message;
}