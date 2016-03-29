<?php
// Page save
add_action('woocommerce_process_product_meta', 'hoo_edit_save', 100, 2);
// Quick Save
add_action('woocommerce_product_quick_edit_save', 'hoo_quick_edit_save', 100);

/*
  Update the variation data to follow the Main field
*/
function hoo_edit_save($post_id, $post) {

  // if variation product AND global price not empty
  if(!empty($_POST['global_price']) ):
    update_post_meta($post_id, '_regular_price', $_POST['global_price']);
    update_post_meta($post_id, '_sale_price', $_POST['global_sale']);

    // if saved after toggling variation tag
    if(isset($_POST['variable_post_id']) ) {
      _hoo_update_backorders(
        $_POST['variable_post_id'],
        $_POST['variable_backorders'],
        $_POST['_backorders']
      );
    }
    // if saved before toggling variation tab
    else {
      $product = get_product($post_id);
      _hoo_get_variation_and_update_backorders($product);
    }
  endif;
}

/*
  Update the variation data to follow the Main field during QUICK EDIT
*/
function hoo_quick_edit_save($product) {
  _hoo_get_variation_and_update_backorders($product);
}

function _hoo_get_variation_and_update_backorders($product) {
  $variations = $product->get_available_variations();

  $var_ids = array();
  $var_backorders = array();

  foreach($variations as $v) {
    $var_ids[] = $v['variation_id'];
    $var_backorders[] = $v['backorders_allowed'] ? 'notify' : 'no';
  }

  _hoo_update_backorders(
    $var_ids,
    $var_backorders,
    $_POST['_backorders']
  );
}

/*
  Update the variation's backorder status to follow the Main field

  @param array $var_ids - Id of this product's variations
  @param array $var_backorders - Backorder Status of this product's variations
  @param string $backorders - The main product's Backorder Status
*/
function _hoo_update_backorders($var_ids, $var_backorders, $backorders) {
  for($i = 0, $len = count($var_ids); $i < $len; $i++) {
    $backorders_not_same = $var_backorders[$i] !== $backorders;
    if($backorders_not_same) {
      update_post_meta($var_ids[$i], '_backorders', $backorders);
    }
  }
}

/*
  Add Quick Form to each Variation
*/
add_action('woocommerce_product_after_variable_attributes', 'hoo_add_variation_data', 10, 3);
function hoo_add_variation_data($index, $variation_data, $variation) {
  ?>
  <div class='h-variation-data' data-variation='<?php echo htmlspecialchars(json_encode($variation_data), ENT_QUOTES, 'UTF-8'); ?>'></div>
  <?php
}

/*
  Save Main regular and sale price when AJAX-saving the variations
*/
add_action('wp_ajax_h_after_save_variations', 'hoo_after_save_variations');
function hoo_after_save_variations() {
  $data = $_POST['data'];

  $post_id = $data['post_id'];
  update_post_meta($post_id, '_regular_price', $data['global_price']);
  update_post_meta($post_id, '_sale_price', $data['global_sale']);
}
