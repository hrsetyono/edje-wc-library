<?php

class Hoo_Save {
  function __construct() {
    add_action('woocommerce_process_product_meta', array($this, 'edit_save'), 100);
    add_action('woocommerce_product_quick_edit_save', array($this, 'quick_edit_save'), 100);
  }

  /*
    Update the variation data to follow the Main field
  */
  function edit_save($post_id) {

    // if variation product AND global price not empty
    if(!empty($_POST['global_price']) ):
      update_post_meta($post_id, '_regular_price', $_POST['global_price']);
      update_post_meta($post_id, '_sale_price', $_POST['global_sale']);

      // if saved after toggling variation tab
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
        self::_get_variation_and_update_backorders($product);
      }
    endif;
  }

  /*
    Update the variation data to follow the Main field during QUICK EDIT
  */
  function quick_edit_save($product) {
    self::_get_variation_and_update_backorders($product);
  }

  /////

  function _get_variation_and_update_backorders($product) {
    if($product->product_type !== 'variable') {
      return false;
    }

    $variations = $product->get_available_variations();

    $var_ids = array();
    $var_backorders = array();

    foreach($variations as $v) {
      $var_ids[] = $v['variation_id'];

      if($v['backorders_allowed']) {
        $var_backorders[] = (strpos($v['availability_html'], 'in-stock') > 0) ? 'yes' : 'notify';
      }
      else {
        $var_backorders[] = 'no';
      }
    }

    self::_update_backorders(
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
  function _update_backorders($var_ids, $var_backorders, $backorders) {
    for($i = 0, $len = count($var_ids); $i < $len; $i++) {
      $backorders_not_same = $var_backorders[$i] !== $backorders;
      if($backorders_not_same) {
        update_post_meta($var_ids[$i], '_backorders', $backorders);
      }
    }
  }

}
