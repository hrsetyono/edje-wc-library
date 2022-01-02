<?php

if (is_account_page()) {
  add_filter('woocommerce_account_menu_items', 'h_myaccount_remove_download_menu');
  add_action('h_after_customer_login_form', 'h_myaccount_add_login_toggle');
}

/**
 * @filter woocommerce_account_menu_items
 */
function h_myaccount_remove_download_menu($items) {
  // remove Dashboard because it's useless
  unset($items['dashboard']);

  // remove Downloads if there's nothing
  if (!WC()->customer->get_downloadable_products()) {
    unset($items['downloads']);
  }

  return $items;
}

/**
 * @action woocommerce_after_customer_login_form
 */
function h_myaccount_add_login_toggle() {
  ?>
  <div class="h-toggle-buttons / wp-block-buttons is-content-justification-center">
    <div class="wp-block-button is-style-outline">
      <a class="wp-block-button__link" href="#login">
        <?php _e('Login'); ?>
      </a>
    </div>
    <div class="wp-block-button is-style-outline is-active">
      <a class="wp-block-button__link" href="#register">
        <?php _e('Register'); ?>
      </a>
    </div>
  </div>
  <?php
}