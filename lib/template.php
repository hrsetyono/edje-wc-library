<?php

add_filter("admin_head", "h_handlebars_template");

function h_handlebars_template($views) {
  ?>

  <!-- Global Form -->
  <script id="h-global-form" type="text/x-handlebars-template">

    <div class="toolbar quick-form global-form">
      <span>Regular Price</span>
      <label>{{ currency }}</label><input type="text" id="global-price" name="global_price">

      <span>Sale Price</span>
      <label>{{ currency }}</label><input type="text" id="global-sale" name="global_sale">
    </div>

  </script>

  <!-- Quick Form -->
  <script id="h-quick-form" type="text/x-handlebars-template">

    <div class="quick-form {{#if _sale_price }} has-sale {{/if }}">
      {{#if isEqualGlobalPrice }}
        <label>{{ currency }}</label><input type="text" placeholder="{{ _regular_price }}" name="quick_price">
      {{else }}
        <label>{{ currency }}</label><input type="text" placeholder="{{ globalPrice }}" value="{{ _regular_price }}" name="quick_price">
      {{/if }}

      {{#if isEqualGlobalSale }}
        <label><i class="dashicons dashicons-arrow-right-alt2"></i></label><input type="text" placeholder="{{ _sale_price }}" name="quick_sale">
      {{else }}
        <label><i class="dashicons dashicons-arrow-right-alt2"></i></label><input type="text" placeholder="{{ globalSale }}" value="{{ _sale_price }}" name="quick_sale">
      {{/if }}

      <input type="number" placeholder="Stock" value="{{ _stock }}" name="quick_stock">
    </div>

  </script>



  <?php return $views;
}
