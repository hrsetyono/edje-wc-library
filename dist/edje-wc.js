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
/******/ 	return __webpack_require__(__webpack_require__.s = "../../../../../../../_open/edje-wc-library/src/js/edje-wc.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "../../../../../../../_open/edje-wc-library/src/js/edje-wc.js":
/*!**************************************************!*\
  !*** H:/_open/edje-wc-library/src/js/edje-wc.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("/**\r\n * Added (+) and (-) button to Quantity box. This is the listener for it.\r\n */\r\nconst hQuantity = {\r\n  init() {\r\n    const $cartForm = document.querySelector('.woocommerce-cart .woocommerce, form.cart');\r\n    if ($cartForm) {\r\n      $cartForm.addEventListener('click', this.changeQuantity);\r\n    }\r\n  },\r\n\r\n  changeQuantity(e) {\r\n    if (!e.target.classList.contains('quantity__h-spin')) { return; }\r\n\r\n    e.preventDefault();\r\n    const $field = e.target.closest('.quantity').querySelector('input[type=\"number\"]');\r\n    const change = e.target.classList.contains('is-plus') ? 1 : -1;\r\n    const result = parseInt($field.value, 10) + change;\r\n\r\n    if (result <= 0) { return; }\r\n\r\n    $field.value = result;\r\n\r\n    // trigger change event to check whether to hide (-) button or not\r\n    const changeEvent = new Event('change');\r\n    $field.dispatchEvent(changeEvent);\r\n\r\n    // trigger input event to enable \"Update Cart\" button in Cart page\r\n    const event = new Event('input', { bubbles: true });\r\n    $field.dispatchEvent(event);\r\n  },\r\n};\r\n\r\n/**\r\n * Added custom Mini Cart widget. This is the listener to keep it open.\r\n */\r\nconst hMiniCart = {\r\n  init() {\r\n    const $minicarts = document.querySelectorAll('.h-cart');\r\n\r\n    [...$minicarts].forEach(($cart) => {\r\n      $cart.addEventListener('click', this.openPopup);\r\n    });\r\n\r\n    document.addEventListener('click', this.closePopup);\r\n  },\r\n\r\n  openPopup(e) {\r\n    if (!e.target.classList.contains('is-cart-button') && !e.target.closest('.is-cart-button')) { return; }\r\n\r\n    e.preventDefault();\r\n    e.target.closest('.h-cart').classList.toggle('is-active');\r\n  },\r\n\r\n  closePopup(e) {\r\n    if (e.target.closest('.widget_shopping_cart') || e.target.closest('.is-cart-button')) { return; }\r\n\r\n    const $openMinicart = document.querySelector('.h-cart.is-active');\r\n\r\n    if ($openMinicart) {\r\n      $openMinicart.classList.remove('is-active');\r\n    }\r\n  },\r\n};\r\n\r\n/**\r\n * Changed the coupon and login form in Checkout into Popup\r\n */\r\nconst hCheckoutForm = {\r\n  init() {\r\n    if (!document.querySelector('body').classList.contains('woocommerce-checkout')) { return; }\r\n\r\n    const $formLinks = document.querySelectorAll('.showcoupon, .showlogin');\r\n    const $forms = document.querySelectorAll('.woocommerce-form-coupon, .woocommerce-form-login');\r\n    const $couponForm = document.querySelector('.woocommerce-form-coupon');\r\n\r\n    [...$formLinks].forEach(($link) => {\r\n      $link.addEventListener('click', this.openForm);\r\n    });\r\n\r\n    // prevent closing when clicking inside the form\r\n    [...$forms].forEach(($form) => {\r\n      $form.addEventListener('click', (e) => e.stopPropagation());\r\n    });\r\n\r\n    // close the form when clicking outside\r\n    document.addEventListener('click', this.closeForm);\r\n\r\n    if ($couponForm) {\r\n      $couponForm.addEventListener('submit', this.closeForm);\r\n    }\r\n  },\r\n\r\n  /**\r\n   *\r\n   */\r\n  openForm(e) {\r\n    e.preventDefault();\r\n    e.stopPropagation();\r\n    const formTarget = e.target.classList.contains('showcoupon')\r\n      ? '.woocommerce-form-coupon'\r\n      : '.woocommerce-form-login';\r\n\r\n    const $form = document.querySelector(formTarget);\r\n\r\n    if ($form) {\r\n      $form.classList.toggle('is-open');\r\n      document.querySelector('body').classList.toggle('has-checkout-form-open');\r\n    }\r\n  },\r\n\r\n  /**\r\n   *\r\n   */\r\n  closeForm() {\r\n    const $openedForm = document.querySelector('.woocommerce-form-coupon.is-open, .woocommerce-form-login.is-open');\r\n\r\n    if ($openedForm) {\r\n      document.querySelector('body').classList.remove('has-checkout-form-open');\r\n      $openedForm.classList.remove('is-open');\r\n    }\r\n  },\r\n};\r\n\r\n/**\r\n * Listener for custom Mobile tab in Single Product page\r\n */\r\nconst hMobileTabs = {\r\n  init() {\r\n    const $tabButtons = document.querySelectorAll('.h-tab-mobile a');\r\n\r\n    [...$tabButtons].forEach(($b) => {\r\n      $b.addEventListener('click', this.onClick);\r\n    });\r\n  },\r\n\r\n  onClick(e) {\r\n    e.preventDefault();\r\n    const tabId = e.currentTarget.getAttribute('href');\r\n    const $tab = document.querySelector(tabId);\r\n    const $button = e.currentTarget.closest('.h-tab-mobile');\r\n\r\n    if (!$tab) { return; }\r\n\r\n    if ($button.classList.contains('active')) {\r\n      $tab.style.display = 'none';\r\n    } else {\r\n      $tab.style.display = '';\r\n    }\r\n\r\n    $button.classList.toggle('active');\r\n\r\n    // if ($tab) {\r\n    //   $tab.style.display = '';\r\n    // }\r\n\r\n    // // deactivate other tab buttons\r\n    // const $activeButton = document.querySelector('.h-tab-mobile.active');\r\n    // if ($activeButton) {\r\n    //   $activeButton.classList.remove('active');\r\n    // }\r\n\r\n    // // hide other tabs\r\n    // const $tabs = document.querySelectorAll('.wc-tab');\r\n    // [...$tabs].forEach(($t) => {\r\n    //   $t.style.display = 'none';\r\n    // });\r\n\r\n    // // highlight button\r\n    // $button.classList.add('active');\r\n\r\n    // // show selected tab\r\n    // if ($tab) {\r\n    //   $tab.style.display = '';\r\n    // }\r\n  },\r\n};\r\n\r\nfunction onReady() {\r\n  hQuantity.init();\r\n  hMiniCart.init();\r\n  hCheckoutForm.init();\r\n  hMobileTabs.init();\r\n}\r\n\r\nfunction onLoad() {\r\n\r\n}\r\n\r\ndocument.addEventListener('DOMContentLoaded', onReady);\r\ndocument.addEventListener('load', onLoad);\n\n//# sourceURL=webpack:///H:/_open/edje-wc-library/src/js/edje-wc.js?");

/***/ })

/******/ });