<?php

add_filter("admin_head", "h_handlebars_template");

function h_handlebars_template($views) {
  ?>

  <!-- Global Form -->
  <script id="h-global-form" type="text/x-handlebars-template">

    <div class="toolbar quick-form">
      <span>Regular Price</span>
      <label>{{ currency }}</label><input type="text" id="global-price" name="global_price">

      <span>Sale Price</span>
      <label>{{ currency }}</label><input type="text" id="global-sale-price" name="global_sale_price">
    </div>

  </script>

  <!-- Quick Form -->
  <script id="h-quick-form" type="text/x-handlebars-template">

    <div class="quick-form">
      <label>{{ currency }}</label><input type="text" placeholder="Price" value="{{ price }}">

      <input type="number" placeholder="Stock" value="{{ stock }}">
    </div>

  </script>



  <?php return $views;
}
