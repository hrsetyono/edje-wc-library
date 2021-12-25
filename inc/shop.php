<?php

if (is_shop()) {
  add_filter( 'single_product_archive_thumbnail_size', '_h_shop_change_thumbnail_size');
}

/**
 * Change the thumbnail size in Shop page
 * @filter single_product_archive_thumbnail_size
 */
function _h_shop_change_thumbnail_size(string $current_size) : string {
  return 'medium';
}