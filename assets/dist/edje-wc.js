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
/******/ 	return __webpack_require__(__webpack_require__.s = "./assets/js/edje-wc.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./assets/js/edje-wc.js":
/*!******************************!*\
  !*** ./assets/js/edje-wc.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("/**\r\n * Added (+) and (-) button to Quantity box. This is the listener for it.\r\n */\r\nconst hQuantity = {\r\n  init() {\r\n    const $cartForm = document.querySelector('.woocommerce-cart .woocommerce, form.cart');\r\n    if ($cartForm) {\r\n      $cartForm.addEventListener('click', this.changeQuantity);\r\n    }\r\n  },\r\n\r\n  changeQuantity(e) {\r\n    if (!e.target.classList.contains('quantity__h-spin')) { return; }\r\n\r\n    e.preventDefault();\r\n    const $field = e.target.closest('.quantity').querySelector('input[type=\"number\"]');\r\n    const change = e.target.classList.contains('is-plus') ? 1 : -1;\r\n    const result = parseInt($field.value, 10) + change;\r\n\r\n    if (result <= 0) { return; }\r\n\r\n    $field.value = result;\r\n\r\n    // trigger change event to check whether to hide (-) button or not\r\n    const changeEvent = new Event('change');\r\n    $field.dispatchEvent(changeEvent);\r\n\r\n    // trigger input event to enable \"Update Cart\" button in Cart page\r\n    const event = new Event('input', { bubbles: true });\r\n    $field.dispatchEvent(event);\r\n  },\r\n};\r\n\r\n/**\r\n * Added custom Mini Cart widget. This is the listener to keep it open.\r\n */\r\nconst hMiniCart = {\r\n  init() {\r\n    const $minicarts = document.querySelectorAll('.h-cart');\r\n\r\n    [...$minicarts].forEach(($cart) => {\r\n      $cart.addEventListener('click', this.openPopup);\r\n    });\r\n\r\n    document.addEventListener('click', this.closePopup);\r\n  },\r\n\r\n  openPopup(e) {\r\n    if (!e.target.classList.contains('h-cart__button') && !e.target.closest('.h-cart__button')) { return; }\r\n\r\n    e.preventDefault();\r\n    e.target.closest('.h-cart').classList.toggle('is-active');\r\n  },\r\n\r\n  closePopup(e) {\r\n    if (e.target.closest('.widget_shopping_cart') || e.target.closest('.h-cart__button')) { return; }\r\n\r\n    const $openMinicart = document.querySelector('.h-cart.is-active');\r\n\r\n    if ($openMinicart) {\r\n      $openMinicart.classList.remove('is-active');\r\n    }\r\n  },\r\n};\r\n\r\n/**\r\n * Changed the coupon and login form in Checkout into Popup\r\n */\r\nconst hCheckoutForm = {\r\n  init() {\r\n    if (!document.querySelector('body').classList.contains('woocommerce-checkout')) { return; }\r\n\r\n    const $formLinks = document.querySelectorAll('.showcoupon, .showlogin');\r\n    const $forms = document.querySelectorAll('.woocommerce-form-coupon, .woocommerce-form-login');\r\n    const $couponForm = document.querySelector('.woocommerce-form-coupon');\r\n\r\n    [...$formLinks].forEach(($link) => {\r\n      $link.addEventListener('click', this.openForm);\r\n    });\r\n\r\n    // prevent closing when clicking inside the form\r\n    [...$forms].forEach(($form) => {\r\n      $form.addEventListener('click', (e) => e.stopPropagation());\r\n    });\r\n\r\n    // close the form when clicking outside\r\n    document.addEventListener('click', this.closeForm);\r\n\r\n    if ($couponForm) {\r\n      $couponForm.addEventListener('submit', this.closeForm);\r\n    }\r\n  },\r\n\r\n  /**\r\n   *\r\n   */\r\n  openForm(e) {\r\n    e.preventDefault();\r\n    e.stopPropagation();\r\n    const formTarget = e.target.classList.contains('showcoupon')\r\n      ? '.woocommerce-form-coupon'\r\n      : '.woocommerce-form-login';\r\n\r\n    const $form = document.querySelector(formTarget);\r\n\r\n    if ($form) {\r\n      $form.classList.toggle('is-open');\r\n      document.querySelector('body').classList.toggle('has-checkout-form-open');\r\n    }\r\n  },\r\n\r\n  /**\r\n   *\r\n   */\r\n  closeForm() {\r\n    const $openedForm = document.querySelector('.woocommerce-form-coupon.is-open, .woocommerce-form-login.is-open');\r\n\r\n    if ($openedForm) {\r\n      document.querySelector('body').classList.remove('has-checkout-form-open');\r\n      $openedForm.classList.remove('is-open');\r\n    }\r\n  },\r\n};\r\n\r\nfunction onReady() {\r\n  hQuantity.init();\r\n  hMiniCart.init();\r\n  hCheckoutForm.init();\r\n}\r\n\r\nfunction onLoad() {\r\n\r\n}\r\n\r\ndocument.addEventListener('DOMContentLoaded', onReady);\r\ndocument.addEventListener('load', onLoad);\r\n\r\n/**\r\n * CHECKOUT Page\r\n */\r\n\r\n// var wooCheckout = {\r\n//   init() {\r\n//     // add select wrapper\r\n//     $(document).on( 'country_to_state_changed', this._onCountryChanged.bind( this ) );\r\n\r\n//     // add active state to field\r\n//     $('.form-row input').each( this._checkActiveField );\r\n//     $('.form-row').on( 'change', 'input, select, textarea', this._checkActiveField );\r\n\r\n//     $(document.body).on( 'checkout_error', this._moveErrorMessages );\r\n//   },\r\n\r\n\r\n//   /**\r\n//    * Move the Email field to Account fieldset\r\n//    */\r\n//   moveEmailField() {\r\n//     var $field = $('.woocommerce-account-fields');\r\n//     $('#billing_email_field').prependTo( $field );\r\n//   },\r\n\r\n//   /**\r\n//    * Add active state to field with value\r\n//    */\r\n//   addActiveState( $input ) {\r\n//     let $row = $input.closest( '.form-row' );\r\n    \r\n//     if( $input.value ) {\r\n//       $row.classList.add( 'form-row--active' );\r\n//     } else {\r\n//       $row.classList.remove( 'form-row--active' );\r\n//     }\r\n//   },\r\n\r\n\r\n//   /**\r\n//    * Check whether the State of this country has dropdown, if it does, add extra class\r\n//    */\r\n//   _onCountryChanged( e, country, $wrapper ) {\r\n//     var $stateFields = $wrapper.find( '#billing_state_field, #shipping_state_field' );\r\n//     setTimeout( afterDelay, 200 );\r\n\r\n//     function afterDelay() {\r\n//       if( $stateFields.find('select').length ) {\r\n//         $stateFields.addClass( 'form-row--select' );\r\n//       } else {\r\n//         $stateFields.removeClass( 'form-row--select form-row--active' );\r\n//       }\r\n//     }\r\n//   },\r\n\r\n//   /**\r\n//    * Add active class if field has value \r\n//    */\r\n//   _checkActiveField( e ) {\r\n//     var $input = $(this);\r\n//     var $row = $input.closest('.form-row');\r\n\r\n//     if($input.val() ) { // if not empty\r\n//       $row.addClass( 'form-row--active' );\r\n//     } else {\r\n//       $row.removeClass( 'form-row--active' );\r\n//     }\r\n//   },\r\n\r\n//   /**\r\n//    * Move the error message inside the wrapper to maintain Flex layout\r\n//    */\r\n//   _moveErrorMessages( e ) {\r\n//     var $notice = $( '.woocommerce-NoticeGroup' );\r\n//     $notice.prependTo( $( '.column-main' ) );\r\n//   }\r\n// };\r\n\r\n/**\r\n * THANK YOU Page\r\n */\r\n// var wooThankyou = {\r\n//   init() {\r\n//     // Break if not in thank you page\r\n//     if( document.querySelector('.woocommerce-order-received').length <= 0) { return; }\r\n\r\n//     if( document.querySelector('.woocommerce-bacs-bank-details').length > 0 ) {\r\n//       this.bacsMoveName();\r\n//       this.bacsDeleteColon();\r\n//     }\r\n//   },\r\n\r\n//  /**\r\n//   * BACS Move Account name to within the <ul>\r\n//   */\r\n//   bacsMoveName() {\r\n//     var $sources = $('.wc-bacs-bank-details-account-name');\r\n\r\n//     $sources.each(function() {\r\n//       var $destination = $(this).next('.wc-bacs-bank-details');\r\n\r\n//       $(this).prependTo($destination);\r\n//       $(this).wrap('<li class=\"account_name\"></li>');\r\n//     });\r\n//   },\r\n\r\n//   /*\r\n//     Delete the colon that appears in Account Name\r\n//   */\r\n//   bacsDeleteColon() {\r\n//     var $accountNames = $('.woocommerce-bacs-bank-details h3');\r\n\r\n//     $accountNames.each( function() {\r\n//       var name = $(this).text();\r\n//       $(this).text(name.replace(':', '') );\r\n//     });\r\n//   },\r\n// };\r\n\r\n/**\r\n * ACCOUNT Page\r\n */\r\n// var wooAccount = {\r\n//   init() {\r\n\r\n//   },\r\n// };\n\n//# sourceURL=webpack:///./assets/js/edje-wc.js?");

/***/ })

/******/ });