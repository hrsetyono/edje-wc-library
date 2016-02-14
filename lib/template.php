<?php

add_filter("admin_head", "h_handlebars_template");

function h_handlebars_template($views) {
  ?>

  <!-- Global Form -->
  <script id="h-global-form" type="text/x-handlebars-template">

    <div class="toolbar hwc-form global-form">
      <span>Regular Price</span>
      <label>{{ currency }}</label><input type="text" id="global-price" name="global_price">

      <span>Sale Price</span>
      <label>{{ currency }}</label><input type="text" id="global-sale" name="global_sale">
    </div>

  </script>

  <!-- Quick Form -->
  <script id="h-quick-form" type="text/x-handlebars-template">

    <div class="hwc-form quick-form {{#if _sale_price }} has-sale {{/if }}">
      <label>{{ currency }}</label><input type="text" name="quick_price" data-default-placeholder="Price"
        {{#if isEqualGlobalPrice }}
          placeholder="{{ globalPrice }}"
        {{else }}
          placeholder="{{ globalPrice }}" value="{{ _regular_price }}"
        {{/if }}>

      <label><i class="dashicons dashicons-arrow-right-alt2"></i></label><input type="text" name="quick_sale" data-default-placeholder="Sale"
        {{#if isEqualGlobalSale }}
          placeholder="{{ globalSale }}"
        {{else }}
          placeholder="{{ globalSale }}" value="{{ _sale_price }}"
        {{/if }}>

      <input type="number" placeholder="Stock" value="{{ _stock }}" name="quick_stock" data-default-placeholder="Stock">
    </div>

  </script>


  <?php return $views;
}
