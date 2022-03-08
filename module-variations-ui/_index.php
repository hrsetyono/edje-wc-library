<?php

require_once __DIR__ . '/var-ui.php';
require_once __DIR__ . '/var-template.php';

new \h\Variations_UI();
new \h\Variations_Template();

// Remove the "Swatches" tab made by Swatch plugin
add_action('admin_init', function() {
  remove_action('woocommerce_product_data_tabs', 'add_wvs_pro_preview_tab');
  remove_action('woocommerce_product_data_panels', 'add_wvs_pro_preview_tab_panel');
});