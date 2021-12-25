<?php

if (is_account_page()) {
  require_once HOO_PATH . '/module-checkout-ui/form-fields.php';

  add_action('wp_enqueue_scripts', 'h_myaccount_enqueue_assets', 99);

  add_filter('woocommerce_account_menu_items', 'h_myaccount_remove_download_menu');

  add_action('woocommerce_before_customer_login_form', 'h_myaccount_add_form_wrapper');
  add_action('woocommerce_after_customer_login_form', 'h_myaccount_close_form_wrapper');

  add_action('woocommerce_before_lost_password_form', 'h_myaccount_add_form_wrapper');
  add_action('woocommerce_after_lost_password_form', 'h_myaccount_close_form_wrapper');

  add_action('woocommerce_before_reset_password_form', 'h_myaccount_add_form_wrapper');
  add_action('woocommerce_after_reset_password_form', 'h_myaccount_close_form_wrapper');

  add_action('h_after_login_form', 'h_myaccount_add_toggle_register');
  add_action('h_after_register_form', 'h_myaccount_add_toggle_login');
}


/**
 * Customize JS and CSS in My Account page
 * @action wp_enqueue_scripts
 */
function h_myaccount_enqueue_assets($hook) {
  wp_enqueue_style('h-myaccount', HOO_DIR . '/assets/css/h-myaccount.css');
}

/*
  If the user has no Downloadable purchase, hide it
  @filter woocommerce_account_menu_items
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
 * Add wrapper to Login and Register form
 * @action woocommerce_before_customer_login_form
 */
function h_myaccount_add_form_wrapper() {
  echo '<div class="h-login-wrapper">';
}

/**
 * Close the Login and Register form wrapper
 * @action woocommerce_after_customer_login_form
 */
function h_myaccount_close_form_wrapper() {
  echo '</div>';
}


/**
 * @action h_after_login_form
 */
function h_myaccount_add_toggle_register() {
  echo '<a class="button --passive" href="#register">Register »</a>';
}

/**
 * @action h_after_register_form
 */
function h_myaccount_add_toggle_login() {
  echo '<a class="button --passive" href="#login">« Login</a>';
}
