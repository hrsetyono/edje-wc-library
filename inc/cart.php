<?php

if (is_cart()) {
  // Cart Page
  add_action('woocommerce_cart_contents', '_h_cart_add_subtotal', 999);
  add_filter('woocommerce_cart_item_thumbnail', '_h_cart_change_thumbnail_size', 111, 2);

  remove_action('woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10);

  add_filter('woocommerce_cart_ready_to_calc_shipping', '__return_false', 99);
  add_filter('woocommerce_coupons_enabled', '__return_false');

  // Cart Widgets
  add_action('woocommerce_cart_actions', '_h_cart_add_proceed_checkout_button', 999);
}

/**
 * Add subtotal count within the Cart table
 * @action woocommerce_cart_contents 999
 */
function _h_cart_add_subtotal() {
  ?>
  <tr>
    <td colspan="6" class="actions">
      <h4 class="hoo-subtotal">
        <span><?php echo __('Subtotal', 'h'); ?>:</span>
        <strong><?php wc_cart_totals_subtotal_html(); ?></strong>
      </h4>
      <em class="hoo-subtotal-note"><?php echo __('Shipping, taxes, and discounts will be calculated at checkout.', 'h'); ?></em>
    </td>
  </tr>
  <?php
}


/**
 * Change the thumbnail size of product image in cart
 * @filter woocommerce_cart_item_thumbnail
 */
function _h_cart_change_thumbnail_size($img, $cart_item) {
  if(isset($cart_item['product_id'])) {
    return get_the_post_thumbnail($cart_item['product_id'], 'thumbnail');
  }

  return $img;
}


/**
 * Add checkout button within the Cart table
 * @action woocommerce_cart_actions 999
 */
function _h_cart_add_proceed_checkout_button() {
  do_action('woocommerce_proceed_to_checkout');
}
