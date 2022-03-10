<?php

add_action('admin_init', 'h_variations_init');
add_action('admin_enqueue_scripts', 'h_variations_enqueue', 999);

add_filter('admin_footer', 'h_variations_js_template');
add_action('woocommerce_product_after_variable_attributes', 'h_variations_js_hidden_data', 10, 3);

/**
 * Remove the "Swatches" tab made by Swatch plugin
 * 
 * @filter admin_init
 */
function h_variations_init() {
  remove_action('woocommerce_product_data_tabs', 'add_wvs_pro_preview_tab');
  remove_action('woocommerce_product_data_panels', 'add_wvs_pro_preview_tab_panel');
}

/**
 * Call the custom CSS and JS
 * 
 * @action admin_enqueue_scripts
 */
function h_variations_enqueue($hook) {
  $screen = get_current_screen();
  if ($screen->base !== 'post' || $screen->post_type !== 'product') { return; }

  $dist = HOO_DIR . '/dist';

  wp_enqueue_style('h-variations', $dist . '/h-variations.css', [], H_WC_VERSION);
  wp_enqueue_script('h-variations', $dist . '/h-variations.js', ['jquery'], H_WC_VERSION);
}

/**
 * Output template to be use by the JS
 * 
 * @filter admin_footer
 */
function h_variations_js_template($views) {
  ?>

  <template id="h-variation-buttons">
    <div class="h-variation-buttons">
      <a class="button" data-action="set-price">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="20" height="20"><path d="M320 160.55c-44.18 0-80 43.16-80 96.41 0 53.24 35.81 96.41 80 96.41 44.17 0 80-43.15 80-96.41 0-53.25-35.82-96.41-80-96.41zM621.16 54.46C582.37 38.19 543.55 32 504.75 32c-123.17-.01-246.33 62.34-369.5 62.34-30.89 0-61.76-3.92-92.65-13.72-3.47-1.1-6.95-1.62-10.35-1.62C15.04 79 0 92.32 0 110.81v317.26c0 12.63 7.23 24.6 18.84 29.46C57.63 473.81 96.45 480 135.25 480c123.17 0 246.34-62.35 369.51-62.35 30.89 0 61.76 3.92 92.65 13.72 3.47 1.1 6.95 1.62 10.35 1.62 17.21 0 32.25-13.32 32.25-31.81V83.93c-.01-12.64-7.24-24.6-18.85-29.47zM592 322.05c-26.89 3.4-48.58 23.31-54.38 49.48-10.8-.92-21.56-1.88-32.87-1.88-67.56 0-133.13 16.59-196.53 32.64C247.86 417.57 190.85 432 135.25 432c-8.02 0-15.85-.32-23.51-.94-1.42-34.23-29.29-61.61-63.73-61.61V192.69c31.07 0 56.93-22.25 62.74-51.75 8.14.51 16.08 1.4 24.51 1.4 67.56 0 133.12-16.59 196.52-32.64C392.13 94.43 449.14 80 504.75 80c10.84 0 21.22.78 31.42 1.91.85 31.96 24.87 57.84 55.83 61.76v178.38z"/></svg>
        <?php _e('Set Price'); ?>
      </a>
      <a class="button" data-action="set-sale-price">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="20" height="20"><path d="M109.25 173.25c24.99-24.99 24.99-65.52 0-90.51-24.99-24.99-65.52-24.99-90.51 0-24.99 24.99-24.99 65.52 0 90.51 25 25 65.52 25 90.51 0zm256 165.49c-24.99-24.99-65.52-24.99-90.51 0-24.99 24.99-24.99 65.52 0 90.51 24.99 24.99 65.52 24.99 90.51 0 25-24.99 25-65.51 0-90.51zm-1.94-231.43l-22.62-22.62c-12.5-12.5-32.76-12.5-45.25 0L20.69 359.44c-12.5 12.5-12.5 32.76 0 45.25l22.62 22.62c12.5 12.5 32.76 12.5 45.25 0l274.75-274.75c12.5-12.49 12.5-32.75 0-45.25z"/></svg>
        <?php _e('Set Sale Price'); ?>
      </a>
      <a class="button" data-action="set-stock">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20"><path d="M509.5 184.6L458.9 32.8C452.4 13.2 434.1 0 413.4 0H98.6c-20.7 0-39 13.2-45.5 32.8L2.5 184.6c-1.6 4.9-2.5 10-2.5 15.2V464c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48V199.8c0-5.2-.8-10.3-2.5-15.2zm-48.1 7.4H280V48h133.4l48 144zM98.6 48H232v144H50.6l48-144zM48 464V240h416v224H48z"/></svg>
        <?php _e('Set Stock'); ?>
      </a>
    </div>
  </template>

  <template id="h-variation-overview">
    <div class="h-variation-overview">
      <p class="hidden" data-info="price">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="20" height="20"><path d="M320 160.55c-44.18 0-80 43.16-80 96.41 0 53.24 35.81 96.41 80 96.41 44.17 0 80-43.15 80-96.41 0-53.25-35.82-96.41-80-96.41zM621.16 54.46C582.37 38.19 543.55 32 504.75 32c-123.17-.01-246.33 62.34-369.5 62.34-30.89 0-61.76-3.92-92.65-13.72-3.47-1.1-6.95-1.62-10.35-1.62C15.04 79 0 92.32 0 110.81v317.26c0 12.63 7.23 24.6 18.84 29.46C57.63 473.81 96.45 480 135.25 480c123.17 0 246.34-62.35 369.51-62.35 30.89 0 61.76 3.92 92.65 13.72 3.47 1.1 6.95 1.62 10.35 1.62 17.21 0 32.25-13.32 32.25-31.81V83.93c-.01-12.64-7.24-24.6-18.85-29.47zM592 322.05c-26.89 3.4-48.58 23.31-54.38 49.48-10.8-.92-21.56-1.88-32.87-1.88-67.56 0-133.13 16.59-196.53 32.64C247.86 417.57 190.85 432 135.25 432c-8.02 0-15.85-.32-23.51-.94-1.42-34.23-29.29-61.61-63.73-61.61V192.69c31.07 0 56.93-22.25 62.74-51.75 8.14.51 16.08 1.4 24.51 1.4 67.56 0 133.12-16.59 196.52-32.64C392.13 94.43 449.14 80 504.75 80c10.84 0 21.22.78 31.42 1.91.85 31.96 24.87 57.84 55.83 61.76v178.38z"/></svg>
        <span>
          -
        </span>
      </p>
      <p class="hidden" data-info="sale-price">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="20" height="20"><path d="M109.25 173.25c24.99-24.99 24.99-65.52 0-90.51-24.99-24.99-65.52-24.99-90.51 0-24.99 24.99-24.99 65.52 0 90.51 25 25 65.52 25 90.51 0zm256 165.49c-24.99-24.99-65.52-24.99-90.51 0-24.99 24.99-24.99 65.52 0 90.51 24.99 24.99 65.52 24.99 90.51 0 25-24.99 25-65.51 0-90.51zm-1.94-231.43l-22.62-22.62c-12.5-12.5-32.76-12.5-45.25 0L20.69 359.44c-12.5 12.5-12.5 32.76 0 45.25l22.62 22.62c12.5 12.5 32.76 12.5 45.25 0l274.75-274.75c12.5-12.49 12.5-32.75 0-45.25z"/></svg>
        <span>
          -
        </span>
      </p>
      <p class="hidden" data-info="stock">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20"><path d="M509.5 184.6L458.9 32.8C452.4 13.2 434.1 0 413.4 0H98.6c-20.7 0-39 13.2-45.5 32.8L2.5 184.6c-1.6 4.9-2.5 10-2.5 15.2V464c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48V199.8c0-5.2-.8-10.3-2.5-15.2zm-48.1 7.4H280V48h133.4l48 144zM98.6 48H232v144H50.6l48-144zM48 464V240h416v224H48z"/></svg>
        <span>
          -
        </span>
      </p>
    </div>
  </template>

  <?php return $views;
}





/**
 * Add Quick Form to each Variation
 * 
 * @action woocommerce_product_after_variable_attributes
 */
function h_variations_js_hidden_data($index, $variation_data, $variation) {
  ?>
  <div class='h-variation-data' data-variation='<?php echo htmlspecialchars(json_encode($variation_data), ENT_QUOTES, 'UTF-8'); ?>'></div>
  <?php
}