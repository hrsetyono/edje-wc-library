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

  var NAME = {
    targetForm: ".woocommerce_variation",
    targetPrice: "[name*='variable_regular_price']",
    targetStock: "[name*='variable_stock[']",
    targetManageStock: "[name*='variable_manage_stock']",
    targetSale: "[name*='variable_sale_price[']",

    globalForm: ".global-form",
    globalPrice: "#global-price",
    globalSale: "#global-sale",

    quickForm: ".quick-form",
    quickPrice: "[name*='quick_price']",
    quickSale: "[name*='quick_sale']",
    quickStock: "[name*='quick_stock']",

    mainPrice: "#_regular_price",
    mainSale: "#_sale_price",
  };

  /*
    VARIATION
  */
  var variation = {
    init: function() {
      var $variationTab = $("#variable_product_options");

      // $variation.on("DOMNodeInserted", this.onAdded);
      $("#woocommerce-product-data").on("woocommerce_variations_loaded", this.onLoaded);
      $("#woocommerce-product-data").on("woocommerce_variations_added", this.onAdded);
      $("#woocommerce-product-data").on("woocommerce_variations_saved", this.onSaved);

      $variationTab.on("focus", "h3 input", this.highlightHeader);
      $variationTab.on("blur", "h3 input", this.removeHighlightHeader);

      this.addListener();
    },

    highlightHeader: function(e) {
      $(this).closest(".woocommerce_variation").addClass("active");
    },

    removeHighlightHeader: function(e) {
      $(this).closest(".woocommerce_variation").removeClass("active");
    },

    /*
      After finished loading the Variations tab
    */
    onLoaded: function(e) {
      console.log("onLoaded");
      var that = variation;

      // if no global form yet
      if($(NAME.globalForm).length === 0) {
        that.addGlobalForm();
      }

      $(".woocommerce_variation").each(function() {
        that.addQuickForm($(this) );
      });
    },

    /*
      After adding a new variation using the toolbar
    */
    onAdded: function(e) {
      console.log("onAdded");
      var that = variation;
      var $newVar = $(this).find(".woocommerce_variation:not(:has(.quick-form))");

      // if adding one variation (if multiple, it won't have the class below)
      if($newVar.is(".variation-needs-update") ) {
        that.addQuickForm($newVar);
      }
    },

    /*
      After AJAX Save the variatios
    */
    onSaved: function(e) {
      console.log("onSaved");

      var post = {
        action: "h_after_save_variations",
        data: {
          post_id: woocommerce_admin_meta_boxes.post_id,
          global_price: $(NAME.globalPrice).val(),
          global_sale: $(NAME.globalSale).val()
        }
      };

      $.post(ajaxurl, post, function(response) {
        // success
      });
    },

    /*
      Add a Quick form on top of current variation

      @param int $variation - The outer container of the variation
    */
    addQuickForm: function($variation) {
      var $header = $variation.closest(".woocommerce_variation").find("h3");

      var data = this.parseData($variation);

      // manage stock always on
      $variation.find(NAME.targetManageStock).prop("checked", true).change();

      // append template
      var template = Handlebars.compile($("#h-quick-form").html() );
      var html = template(data);
      $header.append(html);

      // trigger change in target field
      $variation.find(NAME.targetPrice).val(data._regular_price).change();
      $variation.find(NAME.targetSale).val(data._sale_price).change();
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
      data.globalPrice = $(NAME.globalPrice).val();
      data.globalSale = $(NAME.globalSale).val();
      data.isEqualGlobalPrice = data.globalPrice === data._regular_price;
      data.isEqualGlobalSale = data.globalSale === data._sale_price;

      // if price empty
      if(!data._regular_price) {
        data._regular_price = data.globalPrice;
        data._sale_price = data.globalSale;
      }

      // if stock empty
      if(!data._stock) {
        data._stock = 0;
      }

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

      // copy the number from main form to global form
      $(NAME.globalPrice).val( $(NAME.mainPrice).val() );
      $(NAME.globalSale).val( $(NAME.mainSale).val() );
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
    TODO: bug with main price not updating when not clicking Update
  */
  var priceField = {
    main: "#_regular_price",
    global: "#global-price",
    targets: ".woocommerce_variation [name*='variable_regular_price']",
    target: "[name*='variable_regular_price']",
    quick: "h3 input[name*='quick_price']",

    init: function() {
      $("#variable_product_options").on("change", NAME.targetPrice, this.onTargetChange);
      $("#variable_product_options").on("change", NAME.quickPrice, this.onQuickChange);
      $("#variable_product_options").on("change", NAME.globalPrice, this.onGlobalChange);
    },

    onTargetChange: function(e) {
      var val = $(this).val();
      var $quick = $(this).closest(".woocommerce_variation").find(NAME.quickPrice);
      $quick.val(val);

      // if empty, set it to 0
      if(val === null) {
        val = 0;
        $(this).val(val);
      }

      // if same as global value, delete it so it shows the placeholder
      if(val === $(NAME.globalPrice).val() ) {
        $quick.val("");
      }
    },

    onQuickChange: function(e) {
      var val = $(this).val();
      var $target = $(this).closest(".woocommerce_variation").find(NAME.targetPrice);

      $target.val(val);

      // if same as global value, delete it so it shows the placeholder
      if(val === $(NAME.globalPrice).val() ) {
        $(this).val("");
      }
    },

    onGlobalChange: function(e) {
      var globalVal = $(this).val();

      // change placeholder on quick field
      var $quicks = $(".woocommerce_variation " + NAME.quickPrice);

      if(globalVal) {
        $quicks.attr("placeholder", globalVal);
      } else {
        $quicks.attr("placeholder", "Price");
      }

      // change main price
      $(this.main).val(globalVal);

      $(that.targets).each(function() {
        var $target = $(this);
        var $quick = $(this).closest(".woocommerce_variation").find(NAME.quickPrice);

        var isEmpty = !$quick.val();
        var isEqualGlobal = $quick.val() === globalVal;

        // if quick field is empty, it follows the placeholder price, so change the target too
        if(isEmpty) { $target.val(globalVal).change(); }

        // if equal global, remove the quick content
        if(isEqualGlobal) { $quick.val(""); }
      });
    },

  };

  /*
    GLOBAL + QUICK SALE FIELD
  */
  var saleField = {
    main: "#_sale_price",
    global: "#global-sale",
    targets: ".woocommerce_variation [name*='variable_sale_price[']",
    target: "[name*='variable_sale_price[']",
    quick: "h3 input[name*='quick_sale']",

    init: function() {
      $("#variable_product_options").on("change", this.target, this.onTargetChange);
      $("#variable_product_options").on("change", this.quick, this.onQuickChange);

      $("#variable_product_options").on("change", this.global, this.onGlobalChange);
    },

    onTargetChange: function(e) {
      var val = $(this).val();
      var that = saleField;

      var $quick = $(this).closest(".woocommerce_variation").find(that.quick);
      $quick.val(val);

      // if same as global value, delete it so it shows the placeholder
      if($(that.global).val() === val) {
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
      if($(that.global).val() === val) {
        $(this).val("");
      }
    },

    onGlobalChange: function(e) {
      var that = saleField;
      var globalVal = $(this).val();

      // change placeholder on quick field
      var $quicks = $(".woocommerce_variation " + that.quick);
      $quicks.attr("placeholder", globalVal);

      // change main value
      $(this.main).val(globalVal);

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

/* ----------------
  Public Function
------------------ */

var Hoo = {
  addQuickForm: function(index, data) {
    var $ = jQuery;
  }
};
