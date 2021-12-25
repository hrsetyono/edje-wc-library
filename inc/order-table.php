<?php

add_filter('woocommerce_cart_item_name', '_hwc_add_thumbnail_to_order_table', 10, 3);
add_filter('woocommerce_order_item_name', '_hwc_add_thumbnail_to_order_table', 10, 3);

/**
 * Add thumbnail to CART and ORDER table
 * @filter woocommerce_cart_item_name
 * 
 * @param $name
 * @param $cart_item - The product data
 * @param $cart_item_key
 * @return - The HTML tag for item name
 */
function _hwc_add_thumbnail_to_order_table(string $name, $cart_item, $cart_item_key) : string {
  if (is_checkout() || is_wc_endpoint_url('view-order')) {
    $image = get_the_post_thumbnail($cart_item['product_id'], 'thumbnail');
    $image = $image ? $image : sprintf("<img src='%s'>", wc_placeholder_img_src());

    return $image . $name;
  } else {
    return $name;
  }
}
