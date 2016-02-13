<?php

/*
  Update the Simple Price even if inside Variable product
*/
add_action("woocommerce_process_product_meta", "h_product_update", 100);
function h_product_update($post_id) {
  if(!empty($_POST["global_price"]) ) {
    update_post_meta($post_id, "_regular_price", $_POST["global_price"]);
    update_post_meta($post_id, "_sale_price", $_POST["global_sale"]);
  }
}

/*
  Add Quick Form to each Variation
*/
add_action("woocommerce_product_after_variable_attributes", "hw_add_quick_form", 10, 3);
function hw_add_quick_form($index, $variation_data, $variation) {
  ?>
  <div class="h-variation-data" data-variation="<?php echo htmlspecialchars(json_encode($variation_data), ENT_QUOTES, 'UTF-8'); ?>"></div>
  <script>
    var hVariationIndex = "<?php echo $index; ?>";
    var hVariationData = <?php echo json_encode($variation_data); ?>;

    Hoo.addQuickForm(hVariationIndex, hVariationData);
  </script>
  <?php
}
