<?php

class Hoo_Save {
  function __construct() {
    add_action('woocommerce_process_product_meta', array($this, 'edit_save'), 100);
  }

  /*
    Update the variation data to follow the Main field
  */
  function edit_save($post_id) {
    // if variation product AND global price not empty
    if(!empty($_POST['global_price']) ) {
      update_post_meta($post_id, '_regular_price', $_POST['global_price']);
      update_post_meta($post_id, '_sale_price', $_POST['global_sale']);
    }
  }
}
