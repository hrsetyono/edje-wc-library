<?php

add_action('woocommerce_checkout_before_order_review_heading', 'h_order_review_add_wrapper');
add_action('woocommerce_checkout_after_order_review', 'h_order_review_add_closing_wrapper');

add_filter('woocommerce_cart_item_name', 'h_order_review_add_thumbnail', 10, 3);
add_filter('woocommerce_order_item_name', 'h_order_review_add_thumbnail', 10, 3);
add_filter('woocommerce_checkout_cart_item_quantity', 'h_order_review_add_thumb_closing_wrapper');
// TODO: check how to close the order_item_name


add_filter('woocommerce_checkout_fields', 'h_checkout_reorder_fields');
add_filter('woocommerce_default_address_fields', 'h_checkout_reorder_fields_locale');

/**
 * @action woocommerce_checkout_before_order_review_heading
 */
function h_order_review_add_wrapper() {
  echo "<div class='h-order-review__wrapper'>";
}

/**
 * @action woocommerce_checkout_after_order_review
 */
function h_order_review_add_closing_wrapper() {
  echo "</div>";
}

/**
 * Add thumbnail to CART and ORDER table
 * @filter woocommerce_cart_item_name
 * 
 * @param $name
 * @param $cart_item - The product data
 * @param $cart_item_key
 * @return - The HTML tag for item name
 */
function h_order_review_add_thumbnail(string $name, $cart_item, $cart_item_key) : string {
  if (is_checkout() || is_wc_endpoint_url('view-order')) {
    $image = get_the_post_thumbnail($cart_item['product_id'], 'thumbnail');
    $image = $image ? $image : sprintf("<img src='%s'>", wc_placeholder_img_src());

    return "<figure class='h-order-review__figure'>{$image} <figcaption>{$name}";
  } else {
    return "<figure class='h-order-review__figure'>$name <figcaption>";
  }
}

/**
 * @filter woocommerce_checkout_cart_item_quantity
 */
function h_order_review_add_thumb_closing_wrapper($qty) {
  return "{$qty} </figcaption></figure>";
}

/**
 * @filter woocommerce_checkout_fields
 */
function h_checkout_reorder_fields($fields) {
  $fields['billing']['billing_email']['priority'] = 4;
  return $fields;
}

/**
 * @filter woocommerce_default_address_fields
 */
function h_checkout_reorder_fields_locale( $fields ) {
  $fields['address_1']['priority'] = 40;
  $fields['address_2']['priority'] = 41;
  $fields['address_2']['label'] = __('Unit no.');
  $fields['address_2']['label_class'] = [];

  $fields['country']['priority'] = 62;
  $fields['state']['priority'] = 64;
  $fields['city']['priority'] = 66;

  return $fields;
}