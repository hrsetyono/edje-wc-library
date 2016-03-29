(function($) {
'use strict';

/* --------------
  GLOBAL FORM
-------------- */

function GlobalForm(args) {
  this.field = args.field;
  this.defaultPlaceholder = args.defaultPlaceholder;
}

GlobalForm.prototype = {
  addListener: function() {
    var that = this;
    var globalVal = 0;
    $('#variable_product_options').on('change', GLOBAL[that.field], _onChange);

    /*
      Listener
    */
    function _onChange(e) {
      globalVal = $(this).val();

      // change placeholder on quick field
      var placeholder = (globalVal) ? globalVal : that.defaultPlaceholder;
      $(QUICK[that.field]).attr('placeholder', placeholder);

      $(MAIN[that.field] ).val(globalVal); // change main field
      $(TARGET[that.field] ).each(_applyToVariation); // change all variations field
    }

    function _applyToVariation() {
      var $target = $(this);
      var $quick = $(this).closest('.woocommerce_variation').find(QUICK[that.field] );

      var isEmpty = !$quick.val();
      var isEqualGlobal = $quick.val() === globalVal;

      // if quick field is empty, it follows the global price
      if(isEmpty) { $target.val(globalVal).change(); }

      // if equal global, remove the content so it shows only the placeholder
      if(isEqualGlobal) { $quick.val(''); }
    }
  },
};

GlobalForm.create = function() {
  // remove existing global form
  $(GLOBAL.form).remove();

  var data = { currency: woocommerce_admin_meta_boxes.currency_format_symbol };

  var template = Handlebars.compile($('#h-global-form').html() );
  var html = template(data);
  $('#variable_product_options .toolbar-top').after(html);

  // copy the number from main form to global form
  $(GLOBAL.price).val( $(MAIN.price).val() );
  $(GLOBAL.sale).val( $(MAIN.sale).val() );
};

/* -------------
  QUICK FORM
------------- */

function QuickForm(args) {
  this.field = args.field;
}

QuickForm.prototype = {
  addListener: function() {
    var that = this;
    $('#variable_product_options').on('change', QUICK[that.field], _onChange);

    /*
      Listener
    */
    function _onChange(e) {
      var newVal = $(this).val();
      var $target = $(this).closest('.woocommerce_variation').find(TARGET[that.field]);

      if(that.field === 'price' || that.field === 'sale') {
        // if same as globalVal, empty out the quick field so it shows the placeholder
        var globalVal = $(GLOBAL[that.field] ).val();
        if(newVal === globalVal) {
          $(this).val('');
        }
        // if empty but global val not empty, assign the globalVal to target
        else if(!newVal && globalVal) {
          newVal = globalVal;
        }
      }

      // change the target field to be the same
      $target.val(newVal);
    } // _onChange

  },
};

/*
  Add a Quick form on top of current variation

  @param int $variation - The outer container of the variation
*/
QuickForm.create = function($variation) {
  var $header = $variation.closest('.woocommerce_variation').find('h3');

  var data = _parseData($variation);

  // manage stock always on
  $variation.find(TARGET.manageStock).prop('checked', true).change();

  // append template
  var template = Handlebars.compile($('#h-quick-form').html() );
  var html = template(data);
  $header.append(html);

  // trigger change in target field
  // $variation.find(TARGET.price).val(data._regular_price).change();
  // $variation.find(TARGET.sale).val(data._sale_price).change();

  /*
    Get the raw data and process it

    @return array - Parsed data ready to be used
  */
  function _parseData() {
    // parse data
    var data = $variation.find('.h-variation-data').data('variation');

    data.currency = woocommerce_admin_meta_boxes.currency_format_symbol;
    data.globalPrice = $(GLOBAL.price).val();
    data.globalSale = $(GLOBAL.sale).val();

    data._regular_price = parseInt(data._regular_price);
    data._sale_price = parseInt(data._sale_price);

    data.isEqualGlobalPrice = data.globalPrice == data._regular_price;
    data.isEqualGlobalSale = data.globalSale == data._sale_price;

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
  }
}


/* --------------
  TARGET FORM
-------------- */

function TargetForm(args) {
  this.field = args.field;
}

TargetForm.prototype = {
  addListener: function() {
    var that = this;
    $('#variable_product_options').on('change', TARGET[that.field], _onChange);

    /*
      Listener
    */
    function _onChange(e) {
      var targetVal = $(this).val();

      // change the quick field to be the same
      var $quick = $(this).closest('.woocommerce_variation').find(QUICK[that.field] );
      $quick.val(targetVal);

      switch(that.field) {
        case 'price':
          // if empty, set it to 0
          if(!targetVal) {
            targetVal = 0;
            $(this).val(targetVal);
          }
          break;

        case 'sale':
          var $form = $quick.closest('.quick-form');

          // if empty, remove the has-sale class
          if(!targetVal) {
            $form.removeClass('has-sale');
          } else {
            $form.addClass('has-sale');
          }
          break;
      }

      if(that.field === 'price' || that.field === 'sale') {
        // if same as global value, empty out the quick field so it shows the placeholder
        var globalVal = $(GLOBAL[that.field]).val();
        if(targetVal === globalVal) {
          $quick.val('');
        }
      }
    }  // _onChange

  },
};


/*
  Replacing Default WooCommerce behavior
*/
var changeDefault = {
  init: function() {
    this.variation();
  },

  variation: function() {
    var that = this;

    // remove default toggle
    $('#variable_product_options').off('click', '.wc-metabox h3');
    $('#variable_product_options').off('click', '.wc-metabox > h3');

    // toggle only if clicking the Edit button
    $('#variable_product_options').on('click', 'h3 .handlediv', that.toggleVariation);
  },

  toggleVariation: function() {
    var $container = $(this).closest('.woocommerce_variation');
    $container.toggleClass('open closed');
    $container.find('.wc-metabox-content').slideToggle();
  }
};

/* ----------
  CONSTANT
----------- */

var TARGET = {
  form: '.woocommerce_variation',
  price: '[name*="variable_regular_price"]',
  stock: '[name*="variable_stock["]',
  manageStock: '[name*="variable_manage_stock"]',
  sale: '[name*="variable_sale_price["]',
};

var GLOBAL = {
  form: '.global-form',
  price: '#global-price',
  sale: '#global-sale',
};

var QUICK = {
  form: '.quick-form',
  price: '[name*="quick_price"]',
  sale: '[name*="quick_sale"]',
  stock: '[name*="quick_stock"]',
};

var MAIN = {
  price: '#_regular_price',
  sale: '#_sale_price',
};

var BACKORDER = {
  main: '#_backorders',
  target: '[name*="variable_backorders["]'
}

/* -----------------
  VARIATION Handler
----------------- */
var variation = {
  init: function() {
    var $variationTab = $('#variable_product_options');

    GlobalForm.create();

    // $variation.on('DOMNodeInserted', this.onAdded);
    $('#woocommerce-product-data').on('woocommerce_variations_loaded', this.onLoaded);
    $('#woocommerce-product-data').on('woocommerce_variations_added', this.onAdded);
    $('#woocommerce-product-data').on('woocommerce_variations_saved', this.onSaved);

    $variationTab.on('focus', 'h3 input', this.highlightHeader);
    $variationTab.on('blur', 'h3 input', this.removeHighlightHeader);

    this.addListener();
  },

  highlightHeader: function(e) {
    $(this).closest('.woocommerce_variation').addClass('active');
  },

  removeHighlightHeader: function(e) {
    $(this).closest('.woocommerce_variation').removeClass('active');
  },

  /*
    After finished loading the Variations tab
  */
  onLoaded: function(e) {
    var that = variation;

    // if no global form yet
    if($(GLOBAL.form).length === 0) {
      GlobalForm.create();
    }

    $('.woocommerce_variation').each(function() {
      QuickForm.create($(this) );
    });
  },

  /*
    After adding a new variation using the toolbar
  */
  onAdded: function(e) {
    var that = variation;
    var $newVar = $(this).find('.woocommerce_variation:not(:has(.quick-form))');

    // if adding one variation (if multiple, it won't have the class below)
    if($newVar.is('.variation-needs-update') ) {
      QuickForm.create($newVar);
    }
  },

  /*
    After AJAX Save the variatios
  */
  onSaved: function(e) {

    var post = {
      action: 'h_after_save_variations',
      data: {
        post_id: woocommerce_admin_meta_boxes.post_id,
        global_price: $(GLOBAL.price).val(),
        global_sale: $(GLOBAL.sale).val()
      }
    };

    $.post(ajaxurl, post, function(response) {
      // success
    });
  },

  addListener: function() {
    // initiate global price field listener
    this.globalListener();
    this.quickListener();
    this.targetListener();
  },

  globalListener: function() {
    var priceField = new GlobalForm({ field: 'price', defaultPlaceholder: 'Price' });
    var saleField = new GlobalForm({ field: 'sale', defaultPlaceholder: 'Sale' });

    priceField.addListener();
    saleField.addListener();
  },

  targetListener: function() {
    var priceField = new TargetForm({ field: 'price' });
    var saleField = new TargetForm({ field: 'sale' });
    var stockField = new TargetForm({ field: 'stock' });

    priceField.addListener();
    saleField.addListener();
    stockField.addListener();
  },

  quickListener: function() {
    var priceField = new QuickForm({ field: 'price' });
    var saleField = new QuickForm({ field: 'sale' });
    var stockField = new QuickForm({ field: 'stock' });

    priceField.addListener();
    saleField.addListener();
    stockField.addListener();
  }
};


/* -------------------
  ATTRIBUTE Handler
------------------ */
var attribute = {
  init: function() {
    $(document.body).on('woocommerce_added_attribute', this.onAdded);
  },

  /*
    After adding new attribute, auto check the 'Used for variations'
  */
  onAdded: function(e) {
    $('#product_attributes').find('[name*="attribute_variation["]').prop('checked', true).change();
  }
};

/* ----------------
  BACKORDER Handler
---------------- */

var backorder = {
  init: function() {
    $(BACKORDER.main).on('change', this.onChange);
  },

  onChange: function(e) {
    var newVal = $(this).val();
    $(BACKORDER.target).val(newVal);
  }
};

var start = function() {
  changeDefault.init();
  variation.init();
  attribute.init();
  // backorder.init();
};

$(document).ready(start);
$(document).on('page:load', start);

})(jQuery);
