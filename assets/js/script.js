(function($) {
  "use strict";

  var changeDefault = {
    init: function() {
      this.variation();
    },

    variation: function() {
      var that = this;

      // remove default toggle
      $("#variable_product_options").off("click", ".wc-metabox h3");
      $("#variable_product_options").off("click", ".wc-metabox > h3");

      // toggle only if clicking the Edit button
      $("#variable_product_options").on("click", "h3 .handlediv", that.toggleVariation);
    },

    toggleVariation: function() {
      var $container = $(this).closest(".woocommerce_variation");
      $container.toggleClass("open closed");
      $container.find(".wc-metabox-content").slideToggle();
    }
  };

  var variation = {
    priceField: "[name*='variable_regular_price']",
    stockField: "[name*='variable_stock[']",

    init: function() {
      var $variation = $(".woocommerce_variations");
      $variation.on("DOMNodeInserted", this.onAdded.bind(this) );

      $variation.on("focus", "h3 input", this.highlightHeader);
      $variation.on("blur", "h3 input", this.removeHighlightHeader);

      this.addGlobalForm();
    },

    highlightHeader: function(e) {
      $(this).closest(".woocommerce_variation").addClass("active");
    },

    removeHighlightHeader: function(e) {
      $(this).closest(".woocommerce_variation").removeClass("active");
    },

    // After loading the variation, add quick form at the header
    onAdded: function(e) {
      var that = this;
      var $target = $(e.target);

      if($target.hasClass("woocommerce_variation") ) {
        var $header = $target.closest(".woocommerce_variation").find("h3");

        // manage stock always on
        $target.find("[name*='variable_manage_stock']").prop("checked", true).change();

        var data = {
          currency: woocommerce_admin_meta_boxes.currency_format_symbol,
          price: $target.find(that.priceField).val(),
          stock: $target.find(that.stockField).val()
        };

        var template = Handlebars.compile($("#h-quick-form").html() );
        var html = template(data);
        $header.append(html);

        // field.quickLink($priceField, $newPriceField);
        // field.quickLink($stockField, $newStockField);
      }
    },

    // Add global price and sale fields
    addGlobalForm: function() {
      var data = { currency: woocommerce_admin_meta_boxes.currency_format_symbol };

      var template = Handlebars.compile($("#h-global-form").html() );
      var html = template(data);
      $("#variable_product_options .toolbar-top").after(html);

      // link the main price field to our custom one
      field.globalLink($("#global-price"), ".woocommerce_variation [name*='variable_regular_price']");
    }
  };

  var field = {
    // link two fields, one changed, the other one also changed
    link: function($fieldA, $fieldB) {
      $fieldA.on("change", function(e) {
        $fieldB.val($(this).val() );
      });

      $fieldB.on("change", function(e) {
        $fieldA.val($(this).val() );
      });

      // initially copy the value;
      if($fieldA.val() ) {
        $fieldB.val($fieldA.val() );
      }
    },

    // if field A changed, the other follow. But not the other way around
    globalLink: function($field, otherFields) {
      $field.on("change", function(e) {
        var $otherFields = $(otherFields);
        var val = $(this).val();

        $otherFields.each(function() {
          var targetVal = $(this).val();
        });
      });
    },

    // link between the quick form at the header with the main form
    quickLink: function($fieldMain, $fieldQuick) {
      $fieldMain.on("change", function(e) {
        var val = $(this).val();

        // if same as global price, change the placeholder
        if($("#global-price").val() === val) {
          $fieldQuick.attr("placeholder", val);
        } else {
          $fieldQuick.val(val);
        }
      })
    }
  };

  var start = function() {
    changeDefault.init();
    variation.init();
  };

  $(document).ready(start);
  $(document).on("page:load", start);
})(jQuery);
