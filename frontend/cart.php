<?php

if (is_cart()) {
  add_filter('woocommerce_cart_item_thumbnail', 'h_cart_change_thumbnail_size', 111, 2);
  add_action('woocommerce_cart_collaterals', 'h_cart_add_total_footnote', 20);
}

if (is_product() || is_cart()) {
  add_action('woocommerce_before_quantity_input_field', 'h_add_order_quantity_control');
}


/**
 * @action woocommerce_cart_collaterals - 20
 */
function h_cart_add_total_footnote() {
  $message = apply_filters(
    'h_cart_total_footnote',
    __('Shipping cost, taxes, and payment method will be shown at checkout.')
  );
  echo "<p class='cart-collaterals__h-footnote'>{$message}</p>";
}


/**
 * Change the thumbnail size of product image in cart
 * 
 * @filter woocommerce_cart_item_thumbnail
 */
function h_cart_change_thumbnail_size($img, $cart_item) {
  if(isset($cart_item['product_id'])) {
    return get_the_post_thumbnail($cart_item['product_id'], 'thumbnail');
  }

  return $img;
}

/**
 * Add button to increment and decrement the Order Form
 * 
 * @action woocommerce_before_quantity_input_field
 */
function h_add_order_quantity_control() {
  echo '<button class="quantity__h-spin is-minus">–</button>';
  echo '<button class="quantity__h-spin is-plus">+</button>';
}