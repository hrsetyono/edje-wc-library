<?php
add_action("woocommerce_process_product_meta", "h_product_update", 100);

function h_product_update($post_id) {
  // exit(var_dump($post_id) );
  // update_post_meta($post_id, "_regular_price", $_POST["global_price"]);
  // $_POST["_regular_price"] = "1200";
  update_post_meta($post_id, "_regular_price", $_POST["global_price"]);
  update_post_meta($post_id, "_sale_price", $_POST["global_sale"]);
  // update_post_meta($post_id, "_sale_price", "800");
}
