<?php

// Rearrange the Before Checkout part
remove_action('woocommerce_before_checkout_form_cart_notices', 'woocommerce_checkout_login_form', 10);
remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10);
remove_action('woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10);

add_action('woocommerce_before_checkout_form', 'h_before_checkout_add_wrapper', 9);
add_action('woocommerce_before_checkout_form', 'h_before_checkout_add_middle_wrapper', 11);
add_action('woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 12);
add_action('woocommerce_before_checkout_form', 'h_before_checkout_add_closing_wrapper', 13);

// Add wrapper & Thumbnail in the Order Review box
add_action('woocommerce_checkout_before_order_review_heading', 'h_order_review_add_wrapper');
add_action('woocommerce_checkout_after_order_review', 'h_order_review_add_closing_wrapper');
add_filter('woocommerce_cart_item_name', 'h_order_review_add_thumbnail', 10, 3);
add_filter('woocommerce_order_item_name', 'h_order_review_add_thumbnail', 10, 3);
add_filter('woocommerce_checkout_cart_item_quantity', 'h_order_review_add_thumb_closing_wrapper');

// Reorder the Billing fields
add_filter('woocommerce_checkout_fields', 'h_checkout_reorder_fields');
add_filter('woocommerce_default_address_fields', 'h_checkout_reorder_fields_locale');

// Change the coupon button
add_filter('woocommerce_checkout_coupon_message', 'h_coupon_change_toggle_message');

// Add legal message
add_action('woocommerce_checkout_shipping', 'h_checkout_add_legal_message', 20);


/**
 * @filter woocommerce_before_checkout_form - 5
 */
function h_before_checkout_add_wrapper() {
  echo "<div class='h-before-checkout / wp-block-columns'><div class='wp-block-column'>";
}

function h_before_checkout_add_middle_wrapper() {
  echo "</div><div class='wp-block-column'>";
}

/**
 * @filter woocommerce_before_checkout_form - 15
 */
function h_before_checkout_add_closing_wrapper() {
  echo "</div></div>";
}

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
  }
  
  return $name;
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

  $fields['billing']['billing_phone']['required'] = false;
  $fields['shipping']['shipping_phone'] = [
    'type' => 'text',
    'label' => __('Phone'),
    'required' => false,
    'priority' => 100,
  ];
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
  $fields['city']['priority'] = 91; // after postcode (90)

  return $fields;
}

/**
 * @filter woocommerce_checkout_coupon_message
 */
function h_coupon_change_toggle_message($message) {
  $new_text = __('Have a coupon?', 'woocommerce') . ' <a href="#" class="showcoupon">' . __('Click here') . '</a>';
  return $new_text;
}

/**
 * @action woocommerce_checkout_after_customer_details
 */
function h_checkout_add_legal_message() {
  global $post;
  $tnc_url = get_permalink(wc_get_page_id('terms'));
  $privacy_url = get_permalink(get_option('wp_page_for_privacy_policy', 0));
  ?>
  <footer class="h-checkout-legal">
    <span>
      <?php echo sprintf(__('All rights reserved %s'), get_bloginfo('name')); ?>
    </span>
  
    <?php if ($tnc_url): ?>
      •
      <a href='<?php _e($tnc_url); ?>' target='_blank'>
        <?php _e('Terms &amp; Conditions'); ?>
      </a>
    <?php endif; ?>
    <?php if ($privacy_url): ?>
      •
      <a href='$privacy_url' target='_blank'>
        <?php _e('Privacy Policy'); ?>
      </a>
    <?php endif; ?>
  </footer>
  <?php
}