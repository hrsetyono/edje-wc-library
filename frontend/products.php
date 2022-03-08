<?php

if (is_shop()) {
  remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
  remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

  // Remove wrapper
  remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
  remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end');

  add_filter( 'single_product_archive_thumbnail_size', 'h_shop_change_thumbnail_size');
  add_action('woocommerce_before_shop_loop_item_title', 'h_show_product_outfstock_flash', 15);
}

if (is_product()) {
  add_action('woocommerce_before_single_product_summary', 'h_show_product_outfstock_flash', 15);
}

add_filter('woocommerce_sale_flash', 'h_shop_change_badge', 10, 3);
add_filter('woocommerce_blocks_product_grid_item_html', 'h_show_product_badge_in_block', 10, 3);



/**
 * Change the thumbnail size in Shop page
 * @filter single_product_archive_thumbnail_size
 */
function h_shop_change_thumbnail_size(string $current_size) : string {
  return 'medium';
}

/**
 * Output "out of stock" badge for Product list
 * 
 * @filter woocommerce_before_single_product_summary
 */
function h_show_product_outfstock_flash() {
  global $product;

  $badge = _h_get_outofstock_badge($product);
  echo $badge;
}

/**
 * Change "Sale!" to "10% Off"
 * 
 * @filter woocommerce_sale_flash
 */
function h_shop_change_badge($badge, $post, $product) {
  $new_badge = _h_get_sale_badge($product);

  if ($new_badge) {
    return $new_badge;
  }

  return $badge;
}

/**
 * Change the sale badge in WC Blocks
 * 
 * @filter woocommerce_blocks_product_grid_item_html
 */
function h_show_product_badge_in_block($html, $data, $product) {
  $new_badge = _h_get_outofstock_badge($product);

  // if not outofstock, check if has sale
  if (!$new_badge) {
    $new_badge = _h_get_sale_badge($product);
  }

  return "<li class='wc-block-grid__product'>
    <a href='{$data->permalink}' class='wc-block-grid__product-link'>
      {$data->image}
      {$data->title}
    </a>
    {$new_badge}
    {$data->price}
    {$data->rating}
    {$data->button}
  </li>";
}


/**
 * Get a Sale badge saying "% Off"
 * 
 * @param WC_Product $product
 * @return string - HTML of the badge
 */
function _h_get_sale_badge($product) : string {
  $percentage = 100;

  if ($product->is_type('variable')) {
    $percentages = [];

    $prices = $product->get_variation_prices();

    foreach ($prices['price'] as $key => $price) {
      if ($prices['regular_price'][$key] !== $price) {
        $percentages[] = round(
          100 - (
            $prices['sale_price'][$key] / $prices['regular_price'][$key] * 100
          )
        );
      }
    }

    if (count($percentages) >= 1) {
      $percentage = max($percentages);
    }
  } else {
    $regular_price = (float) $product->get_regular_price();
    $sale_price = (float) $product->get_sale_price();

    if ($regular_price > 0) {
      $percentage = round(100 - ($sale_price / $regular_price * 100));
    }
  }

  // if has discount
  if ($percentage < 100) {
    $label = sprintf(__('%s%% Off'), $percentage);
    $label = apply_filters('h_product_onsale_label', $label, $percentage);
    return "<span class='wc-block-grid__product-badge onsale'>{$label}</span>";
  }

  return '';
}

/**
 * Get an "Out of Stock" badge
 */
function _h_get_outofstock_badge($product) : string {
  if (!$product->is_in_stock()) {
    $label = __('Out of Stock');
    return "<span class='wc-block-grid__product-badge h-outofstock'>{$label}</span>";
  }

  return '';
}