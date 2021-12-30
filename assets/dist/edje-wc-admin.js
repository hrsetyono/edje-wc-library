/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./assets/js/edje-wc-admin.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./assets/js/edje-wc-admin.js":
/*!************************************!*\
  !*** ./assets/js/edje-wc-admin.js ***!
  \************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _sass_edje_wc_admin_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../sass/edje-wc-admin.scss */ \"./assets/sass/edje-wc-admin.scss\");\n/* harmony import */ var _sass_edje_wc_admin_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_sass_edje_wc_admin_scss__WEBPACK_IMPORTED_MODULE_0__);\n\r\n\r\n(function($) {\r\n'use strict';\r\n\r\n/* --------------\r\n  GLOBAL FORM\r\n-------------- */\r\n\r\nfunction GlobalForm(args) {\r\n  this.field = args.field;\r\n  this.defaultPlaceholder = args.defaultPlaceholder;\r\n}\r\n\r\nGlobalForm.prototype = {\r\n  addListener: function() {\r\n    var that = this;\r\n    var globalVal = 0;\r\n    $('#variable_product_options').on('change', GLOBAL[that.field], _onChange);\r\n\r\n    /*\r\n      Listener\r\n    */\r\n    function _onChange(e) {\r\n      globalVal = $(this).val();\r\n\r\n      // change placeholder on quick field\r\n      var placeholder = (globalVal) ? globalVal : that.defaultPlaceholder;\r\n      $(QUICK[that.field]).attr('placeholder', placeholder);\r\n\r\n      $(MAIN[that.field] ).val(globalVal); // change main field\r\n      $(TARGET[that.field] ).each(_applyToVariation); // change all variations field\r\n    }\r\n\r\n    function _applyToVariation() {\r\n      var $target = $(this);\r\n      var $quick = $(this).closest('.woocommerce_variation').find(QUICK[that.field] );\r\n\r\n      var isEmpty = !$quick.val();\r\n      var isEqualGlobal = $quick.val() === globalVal;\r\n\r\n      // if quick field is empty, it follows the global price\r\n      if(isEmpty) { $target.val(globalVal).change(); }\r\n\r\n      // if equal global, remove the content so it shows only the placeholder\r\n      if(isEqualGlobal) { $quick.val(''); }\r\n    }\r\n  },\r\n};\r\n\r\nGlobalForm.create = function() {\r\n  // remove existing global form\r\n  $(GLOBAL.form).remove();\r\n\r\n  var data = { currency: woocommerce_admin_meta_boxes.currency_format_symbol };\r\n\r\n  var template = Handlebars.compile($('#hoo-global-form').html() );\r\n  var html = template(data);\r\n  $('#variable_product_options .toolbar-top').after(html);\r\n\r\n  // copy the number from main form to global form\r\n  $(GLOBAL.price).val( $(MAIN.price).val() );\r\n  $(GLOBAL.sale).val( $(MAIN.sale).val() );\r\n};\r\n\r\n/* -------------\r\n  QUICK FORM\r\n------------- */\r\n\r\nfunction QuickForm(args) {\r\n  this.field = args.field;\r\n}\r\n\r\nQuickForm.prototype = {\r\n  addListener: function() {\r\n    var that = this;\r\n    $('#variable_product_options').on('change', QUICK[that.field], _onChange);\r\n\r\n    /*\r\n      Listener\r\n    */\r\n    function _onChange(e) {\r\n      var newVal = $(this).val();\r\n      var $target = $(this).closest('.woocommerce_variation').find(TARGET[that.field]);\r\n\r\n      switch(that.field) {\r\n        case 'price':\r\n        case 'sale':\r\n          // if same as globalVal, empty out the quick field so it shows the placeholder\r\n          var globalVal = $(GLOBAL[that.field] ).val();\r\n          if(newVal === globalVal) {\r\n            $(this).val('');\r\n          }\r\n          // if empty but global val not empty, assign the globalVal to target\r\n          else if(!newVal && globalVal) {\r\n            newVal = globalVal;\r\n          }\r\n          break;\r\n\r\n        // TODO: after entering 0 and delete it, the status is Out of Stock\r\n        case 'stock':\r\n          newVal = parseInt(newVal);\r\n          var $manage = $(this).closest('.woocommerce_variation').find(TARGET.manageStock);\r\n          var $status = $(this).closest('.woocommerce_variation').find(TARGET.stockStatus);\r\n\r\n          if(newVal > 0 || newVal < 0) {\r\n            $manage.prop('checked', true).change();\r\n          }\r\n          else if(newVal === 0) {\r\n            $manage.prop('checked', false).change();\r\n            $status.find('option:nth-child(2)').attr('selected', 'selected');\r\n          }\r\n          else {\r\n            $manage.prop('checked', false).change();\r\n            $status.find('option:nth-child(1)').attr('selected', 'selected');\r\n          }\r\n      }\r\n\r\n      // change the target field to be the same\r\n      $target.val(newVal);\r\n    } // _onChange\r\n\r\n  },\r\n};\r\n\r\n/*\r\n  Add a Quick form on top of current variation\r\n\r\n  @param int $variation - The outer container of the variation\r\n*/\r\nQuickForm.create = function($variation) {\r\n  var $header = $variation.closest('.woocommerce_variation').find('h3');\r\n\r\n  var data = _parseData($variation);\r\n\r\n  // manage stock always on\r\n  // $variation.find(TARGET.manageStock).prop('checked', true);\r\n\r\n  // append template\r\n  var template = Handlebars.compile($('#hoo-quick-form').html() );\r\n  var html = template(data);\r\n  $header.append(html);\r\n\r\n  // trigger change in target field\r\n  $header.find(QUICK.price).change();\r\n  $header.find(QUICK.sale).change();\r\n\r\n  // $variation.find(TARGET.price).val(data._regular_price);\r\n  // $variation.find(TARGET.sale).val(data._sale_price);\r\n\r\n  /*\r\n    Get the raw data and process it\r\n\r\n    @return array - Parsed data ready to be used\r\n  */\r\n  function _parseData() {\r\n    // parse data\r\n    var data = $variation.find('.h-variation-data').data('variation');\r\n\r\n    data.currency = woocommerce_admin_meta_boxes.currency_format_symbol;\r\n    data.globalPrice = $(GLOBAL.price).val();\r\n    data.globalSale = $(GLOBAL.sale).val();\r\n\r\n    data._regular_price = parseInt(data._regular_price);\r\n    data._sale_price = parseInt(data._sale_price);\r\n\r\n    data.isEqualGlobalPrice = data.globalPrice == data._regular_price;\r\n    data.isEqualGlobalSale = data.globalSale == data._sale_price;\r\n\r\n    // if price empty\r\n    if(!data._regular_price) {\r\n      data._regular_price = parseInt(data.globalPrice);\r\n    }\r\n\r\n    // if sale empty\r\n    if(!data._sale_price) {\r\n      data._sale_price = parseInt(data.globalSale);\r\n    }\r\n\r\n    // if stock is 0 AND stock status is empty\r\n    if(data._stock === 0 && data._stock_status === '') {\r\n      data._stock = null;\r\n    }\r\n    // if stock is false AND out of stock\r\n    else if(!data._stock && data._stock_status === 'outofstock') {\r\n      data._stock = 0;\r\n    }\r\n\r\n    return data;\r\n  }\r\n}\r\n\r\n\r\n/* --------------\r\n  TARGET FORM\r\n-------------- */\r\n\r\nfunction TargetForm(args) {\r\n  this.field = args.field;\r\n}\r\n\r\nTargetForm.prototype = {\r\n  addListener: function() {\r\n    var that = this;\r\n    $('#variable_product_options').on('change', TARGET[that.field], _onChange);\r\n\r\n    /*\r\n      Listener\r\n    */\r\n    function _onChange(e) {\r\n      var targetVal = $(this).val();\r\n\r\n      // change the quick field to be the same\r\n      var $quick = $(this).closest('.woocommerce_variation').find(QUICK[that.field] );\r\n      $quick.val(targetVal);\r\n\r\n      switch(that.field) {\r\n        case 'price':\r\n          // if empty, set it to 0\r\n          if(!targetVal) {\r\n            targetVal = 0;\r\n            $(this).val(targetVal);\r\n          }\r\n          break;\r\n\r\n        case 'sale':\r\n          var $form = $quick.closest('.quick-form');\r\n\r\n          // if empty, remove the has-sale class\r\n          if(!targetVal) {\r\n            $form.removeClass('has-sale');\r\n          } else {\r\n            $form.addClass('has-sale');\r\n          }\r\n          break;\r\n      }\r\n\r\n      if(that.field === 'price' || that.field === 'sale') {\r\n        // if same as global value, empty out the quick field so it shows the placeholder\r\n        var globalVal = $(GLOBAL[that.field]).val();\r\n        if(targetVal === globalVal) {\r\n          $quick.val('');\r\n        }\r\n      }\r\n    }  // _onChange\r\n\r\n  },\r\n};\r\n\r\n\r\n/*\r\n  Replacing Default WooCommerce behavior\r\n*/\r\nvar changeDefault = {\r\n  init: function() {\r\n    this.variation();\r\n  },\r\n\r\n  variation: function() {\r\n    var that = this;\r\n\r\n    // remove default toggle\r\n    $('#variable_product_options').off('click', '.wc-metabox h3');\r\n    $('#variable_product_options').off('click', '.wc-metabox > h3');\r\n\r\n    // toggle only if clicking the Edit button\r\n    $('#variable_product_options').on('click', 'h3 .handlediv', that.toggleVariation);\r\n  },\r\n\r\n  toggleVariation: function() {\r\n    var $container = $(this).closest('.woocommerce_variation');\r\n    $container.toggleClass('open closed');\r\n    $container.find('.wc-metabox-content').slideToggle();\r\n  }\r\n};\r\n\r\n/* ----------\r\n  CONSTANT\r\n----------- */\r\n\r\nvar TARGET = {\r\n  form: '.woocommerce_variation',\r\n  price: '[name*=\"variable_regular_price\"]',\r\n  stock: '[name*=\"variable_stock[\"]',\r\n  stockStatus: '[name*=\"variable_stock_status\"]',\r\n  manageStock: '[name*=\"variable_manage_stock\"]',\r\n  sale: '[name*=\"variable_sale_price[\"]',\r\n};\r\n\r\nvar GLOBAL = {\r\n  form: '.global-form',\r\n  price: '#global-price',\r\n  sale: '#global-sale',\r\n};\r\n\r\nvar QUICK = {\r\n  form: '.quick-form',\r\n  price: '[name*=\"quick_price\"]',\r\n  sale: '[name*=\"quick_sale\"]',\r\n  stock: '[name*=\"quick_stock\"]',\r\n};\r\n\r\nvar MAIN = {\r\n  price: '#_regular_price',\r\n  sale: '#_sale_price',\r\n};\r\n\r\nvar BACKORDER = {\r\n  main: '#_backorders',\r\n  target: '[name*=\"variable_backorders[\"]'\r\n}\r\n\r\n/* -----------------\r\n  VARIATION Handler\r\n----------------- */\r\nvar variation = {\r\n  init: function() {\r\n    var $variationTab = $('#variable_product_options');\r\n\r\n    GlobalForm.create();\r\n\r\n    // $variation.on('DOMNodeInserted', this.onAdded);\r\n    $('#woocommerce-product-data').on('woocommerce_variations_loaded', this.onLoaded);\r\n    $('#woocommerce-product-data').on('woocommerce_variations_added', this.onAdded);\r\n    $('#woocommerce-product-data').on('woocommerce_variations_saved', this.onSaved);\r\n\r\n    $variationTab.on('focus', 'h3 input', this.highlightHeader);\r\n    $variationTab.on('blur', 'h3 input', this.removeHighlightHeader);\r\n\r\n    this.addListener();\r\n  },\r\n\r\n  highlightHeader: function(e) {\r\n    $(this).closest('.woocommerce_variation').addClass('active');\r\n  },\r\n\r\n  removeHighlightHeader: function(e) {\r\n    $(this).closest('.woocommerce_variation').removeClass('active');\r\n  },\r\n\r\n  /*\r\n    After finished loading the Variations tab\r\n  */\r\n  onLoaded: function(e) {\r\n    var that = variation;\r\n\r\n    // if no global form yet\r\n    if($(GLOBAL.form).length === 0) {\r\n      GlobalForm.create();\r\n    }\r\n\r\n    $('.woocommerce_variation').each(function() {\r\n      QuickForm.create($(this) );\r\n    });\r\n  },\r\n\r\n  /*\r\n    After adding a new variation using the toolbar\r\n  */\r\n  onAdded: function(e) {\r\n    var that = variation;\r\n    var $newVar = $(this).find('.woocommerce_variation:not(:has(.quick-form))');\r\n\r\n    // if adding one variation (if multiple, it won't have the class below)\r\n    if($newVar.is('.variation-needs-update') ) {\r\n      QuickForm.create($newVar);\r\n    }\r\n  },\r\n\r\n  /*\r\n    After AJAX Save the variatios\r\n  */\r\n  onSaved: function(e) {\r\n\r\n    var post = {\r\n      action: 'h_after_save_variations',\r\n      data: {\r\n        post_id: woocommerce_admin_meta_boxes.post_id,\r\n        global_price: $(GLOBAL.price).val(),\r\n        global_sale: $(GLOBAL.sale).val()\r\n      }\r\n    };\r\n\r\n    $.post(ajaxurl, post, function(response) {\r\n      // success\r\n    });\r\n  },\r\n\r\n  addListener: function() {\r\n    // initiate global price field listener\r\n    this.globalListener();\r\n    this.quickListener();\r\n    this.targetListener();\r\n  },\r\n\r\n  globalListener: function() {\r\n    var priceField = new GlobalForm({ field: 'price', defaultPlaceholder: 'Price' });\r\n    var saleField = new GlobalForm({ field: 'sale', defaultPlaceholder: 'Sale' });\r\n\r\n    priceField.addListener();\r\n    saleField.addListener();\r\n  },\r\n\r\n  targetListener: function() {\r\n    var priceField = new TargetForm({ field: 'price' });\r\n    var saleField = new TargetForm({ field: 'sale' });\r\n    var stockField = new TargetForm({ field: 'stock' });\r\n\r\n    priceField.addListener();\r\n    saleField.addListener();\r\n    stockField.addListener();\r\n  },\r\n\r\n  quickListener: function() {\r\n    var priceField = new QuickForm({ field: 'price' });\r\n    var saleField = new QuickForm({ field: 'sale' });\r\n    var stockField = new QuickForm({ field: 'stock' });\r\n\r\n    priceField.addListener();\r\n    saleField.addListener();\r\n    stockField.addListener();\r\n  }\r\n};\r\n\r\n\r\n/* -------------------\r\n  ATTRIBUTE Handler\r\n------------------ */\r\nvar attribute = {\r\n  init: function() {\r\n    $(document.body).on('woocommerce_added_attribute', this.onAdded);\r\n  },\r\n\r\n  /*\r\n    After adding new attribute, auto check the 'Used for variations'\r\n  */\r\n  onAdded: function(e) {\r\n    $('#product_attributes').find('[name*=\"attribute_variation[\"]').prop('checked', true).change();\r\n  }\r\n};\r\n\r\n/* ----------------\r\n  BACKORDER Handler\r\n---------------- */\r\n\r\nvar backorder = {\r\n  init: function() {\r\n    $(BACKORDER.main).on('change', this.onChange);\r\n  },\r\n\r\n  onChange: function(e) {\r\n    var newVal = $(this).val();\r\n    $(BACKORDER.target).val(newVal);\r\n  }\r\n};\r\n\r\n\r\n///// RUNNER\r\n\r\nvar start = function() {\r\n  // if in product edit page\r\n  if($('#woocommerce-product-data').length ) {\r\n    changeDefault.init();\r\n    variation.init();\r\n    attribute.init();\r\n    // backorder.init();\r\n  }\r\n};\r\n\r\n$(document).ready(start);\r\n$(document).on('page:load', start);\r\n\r\n})(jQuery);\r\n\n\n//# sourceURL=webpack:///./assets/js/edje-wc-admin.js?");

/***/ }),

/***/ "./assets/sass/edje-wc-admin.scss":
/*!****************************************!*\
  !*** ./assets/sass/edje-wc-admin.scss ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("// extracted by mini-css-extract-plugin\n\n//# sourceURL=webpack:///./assets/sass/edje-wc-admin.scss?");

/***/ })

/******/ });