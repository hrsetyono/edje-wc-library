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

  /*
    VARIATION
  */
  var variation = {
    priceField: "[name*='variable_regular_price']",
    stockField: "[name*='variable_stock[']",
    saleField: "[name*='variable_sale_price']",

    globalPrice: 0,
    globalSale: 0,

    init: function() {
      var $variation = $("#variable_product_options");

      // initiate global value
      this.globalPrice = $("#_regular_price").val();
      this.globalSale = $("#_sale_price").val();

      // $variation.on("DOMNodeInserted", this.onAdded);
      $("#woocommerce-product-data").on("woocommerce_variations_loaded", this.onVariationLoaded);
      $("#woocommerce-product-data").on("woocommerce_variations_added", this.onVariationAdded);

      $variation.on("focus", "h3 input", this.highlightHeader);
      $variation.on("blur", "h3 input", this.removeHighlightHeader);

      // this.addGlobalForm();
      this.addListener();
    },

    highlightHeader: function(e) {
      $(this).closest(".woocommerce_variation").addClass("active");
    },

    removeHighlightHeader: function(e) {
      $(this).closest(".woocommerce_variation").removeClass("active");
    },

    onVariationLoaded: function(e) {
      var that = variation;
      that.addGlobalForm();

      $(".woocommerce_variation").each(function() {
        var index = $(this).index();

        that.addQuickForm(index);
      });
    },

    onVariationAdded: function(e) {
      var that = variation;

      that.addQuickForm(index);
    },

    /*
      Add a Quick form on top of current variation

      @param int index - The loop index of current variation
    */
    addQuickForm: function(index) {
      var $target = $(".woocommerce_variation").eq(index);
      var $header = $target.closest(".woocommerce_variation").find("h3");

      var data = this.parseData($target);

      // manage stock always on
      $target.find("[name*='variable_manage_stock']").prop("checked", true).change();

      // append template
      var template = Handlebars.compile($("#h-quick-form").html() );
      var html = template(data);
      $header.append(html);
    },

    /*
      Get the raw data and process it
      @param dom $variation - The container of the variation

      @return array - Parsed data ready to be used
    */
    parseData: function($variation) {
      // parse data
      var data = $variation.find(".h-variation-data").data("variation");

      data.currency = woocommerce_admin_meta_boxes.currency_format_symbol;
      data.globalPrice = this.globalPrice;
      data.globalSale = this.globalSale;
      data.isEqualGlobalPrice = data.globalPrice === data._regular_price;
      data.isEqualGlobalSale = data.globalSale === data._sale_price;

      return data;
    },

    // Add global price and sale fields
    addGlobalForm: function() {
      // remove existing global form
      $(".quick-form.toolbar").remove();

      var data = { currency: woocommerce_admin_meta_boxes.currency_format_symbol };

      var template = Handlebars.compile($("#h-global-form").html() );
      var html = template(data);
      $("#variable_product_options .toolbar-top").after(html);

      // copy the WC simple product's price to global form
      $("#global-price").val( $("#_regular_price").val() );
      $("#global-sale").val( $("#_sale_price").val() );
    },

    addListener: function() {
      // initiate global price field listener
      priceField.init();
      saleField.init();
      stockField.init();
    }
  };

  /*
    GLOBAL + QUICK PRICE FIELD
  */
  var priceField = {
    main: "#global-price",
    targets: ".woocommerce_variation [name*='variable_regular_price']",
    target: "[name*='variable_regular_price']",
    quick: "h3 input[name*='quick_price']",

    init: function() {
      $("#variable_product_options").on("change", this.target, this.onTargetChange);
      $("#variable_product_options").on("change", this.quick, this.onQuickChange);

      $("#variable_product_options").on("change", this.main, this.onGlobalChange);
    },

    onTargetChange: function(e) {
      var val = $(this).val();
      var that = priceField;

      var $quick = $(this).closest(".woocommerce_variation").find(that.quick);
      $quick.val(val);

      // if same as global value, delete it so it shows the placeholder
      if($(that.main).val() === val) {
        $quick.val("");
      }
    },

    onQuickChange: function(e) {
      var val = $(this).val();
      var that = priceField;

      var $target = $(this).closest(".woocommerce_variation").find(that.target);
      $target.val(val );

      // if same as global value, delete it so it shows the placeholder
      if($(that.main).val() === val) {
        $(this).val("");
      }
    },

    onGlobalChange: function(e) {
      var that = priceField;
      var globalVal = $(this).val();

      // change placeholder on quick field
      var $quicks = $(".woocommerce_variation " + that.quick);
      $quicks.attr("placeholder", globalVal);

      $(that.targets).each(function() {
        var $target = $(this);
        var $quick = $(this).closest(".woocommerce_variation").find(that.quick);

        var isEmpty = !$quick.val();
        var isEqualGlobal = $quick.val() === globalVal;

        // if empty, it follows the placeholder price, so change the target too
        if(isEmpty) { $target.val(globalVal).change() ; }

        // if equal global, remove the quick content
        if(isEqualGlobal) { $quick.val(""); }
      });
    },

  };

  /*
    GLOBAL + QUICK SALE FIELD
  */
  var saleField = {
    main: "#global-sale",
    targets: ".woocommerce_variation [name*='variable_sale_price[']",
    target: "[name*='variable_sale_price[']",
    quick: "h3 input[name*='quick_sale']",

    init: function() {
      $("#variable_product_options").on("change", this.target, this.onTargetChange);
      $("#variable_product_options").on("change", this.quick, this.onQuickChange);

      $("#variable_product_options").on("change", this.main, this.onGlobalChange);
    },

    onTargetChange: function(e) {
      var val = $(this).val();
      var that = saleField;

      var $quick = $(this).closest(".woocommerce_variation").find(that.quick);
      $quick.val(val);

      // if same as global value, delete it so it shows the placeholder
      if($(that.main).val() === val) {
        $quick.val("");
      }

      // if empty, remove the has-sale class
      var $form = $quick.closest(".quick-form");
      if(val === "") {
        $form.removeClass("has-sale");
      } else {
        $form.addClass("has-sale");
      }
    },

    onQuickChange: function(e) {
      var val = $(this).val();
      var that = saleField;

      var $target = $(this).closest(".woocommerce_variation").find(that.target);
      $target.val(val);

      // if same as global value, delete it so it shows the placeholder
      if($(that.main).val() === val) {
        $(this).val("");
      }
    },

    onGlobalChange: function(e) {
      var that = saleField;
      var globalVal = $(this).val();

      // change placeholder on quick field
      var $quicks = $(".woocommerce_variation " + that.quick);
      $quicks.attr("placeholder", globalVal);

      $(that.targets).each(function() {
        var $target = $(this);
        var $quick = $(this).closest(".woocommerce_variation").find(that.quick);

        var isEmpty = !$quick.val();
        var isEqualGlobal = $quick.val() === globalVal;

        var $form = $quick.closest(".quick-form");
        // show or hide the Quick sale field
        if(globalVal) {
          $form.addClass("has-sale");
        }
        else if(!$quick.val() ) {
          $form.removeClass("has-sale");
        }

        // if empty, it follows the placeholder price, so change the target too
        if(isEmpty) { $target.val(globalVal).change() ; }

        // if equal global, remove the quick content
        if(isEqualGlobal) { $quick.val(""); }
      });
    },
  };

  /*
    QUICK STOCK FIELD
  */
  var stockField = {
    targets: ".woocommerce_variation [name*='variable_stock[']",
    target: "[name*='variable_stock[']",
    quick: "h3 input[name*='quick_stock']",

    init: function() {
      $("#variable_product_options").on("change", this.target, this.onTargetChange);
      $("#variable_product_options").on("change", this.quick, this.onQuickChange);
    },

    onTargetChange: function(e) {
      var val = $(this).val();
      var that = stockField;

      var $quick = $(this).closest(".woocommerce_variation").find(that.quick);
      $quick.val(val);
    },

    onQuickChange: function(e) {
      var val = $(this).val();
      var that = stockField;

      var $target = $(this).closest(".woocommerce_variation").find(that.target);
      $target.val(val);
    }
  };

  var start = function() {
    changeDefault.init();
    variation.init();
  };

  $(document).ready(start);
  $(document).on("page:load", start);
})(jQuery);
