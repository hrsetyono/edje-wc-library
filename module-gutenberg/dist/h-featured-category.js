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
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/featured-category.jsx");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/featured-category.jsx":
/*!***********************************!*\
  !*** ./src/featured-category.jsx ***!
  \***********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ \"@wordpress/element\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _featured_category_sass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./featured-category.sass */ \"./src/featured-category.sass\");\n/* harmony import */ var _featured_category_sass__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_featured_category_sass__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! lodash */ \"lodash\");\n/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/hooks */ \"@wordpress/hooks\");\n/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_hooks__WEBPACK_IMPORTED_MODULE_3__);\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/data */ \"@wordpress/data\");\n/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_4__);\n/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/block-editor */ \"@wordpress/block-editor\");\n/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__);\n\n// Add Vertical Alignment to woocommerce/featured-category block\n\n\n\n\n\n\nObject(_wordpress_hooks__WEBPACK_IMPORTED_MODULE_3__[\"addFilter\"])('blocks.registerBlockType', 'wc-featured-category/attributes', addAttribute);\nObject(_wordpress_hooks__WEBPACK_IMPORTED_MODULE_3__[\"addFilter\"])('editor.BlockEdit', 'wc-featured-category/edit', addControl);\n/**\r\n * Add the Vertical Align attribute\r\n */\n\nfunction addAttribute(settings, name) {\n  // abort if not our targetted block\n  var targetBlocks = ['woocommerce/featured-category', 'woocommerce/featured-product'];\n\n  if (!targetBlocks.includes(name)) {\n    return settings;\n  }\n\n  settings.attributes = Object(lodash__WEBPACK_IMPORTED_MODULE_2__[\"assign\"])(settings.attributes, {\n    verticalAlignment: {\n      type: 'string',\n      default: 'center'\n    },\n    textColor: {\n      type: 'string',\n      default: 'white'\n    }\n  });\n  return settings;\n}\n/**\r\n * Add the Vertical Align option to the toolbar\r\n */\n\n\nfunction addControl(BlockEdit) {\n  return function (props) {\n    // abort if not our targetted block\n    var targetBlocks = ['woocommerce/featured-category', 'woocommerce/featured-product'];\n\n    if (!targetBlocks.includes(props.name)) {\n      return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(BlockEdit, props);\n    }\n\n    var atts = props.attributes;\n    return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"Fragment\"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(BlockEdit, props), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__[\"BlockControls\"], {\n      key: \"controls\"\n    }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__[\"BlockVerticalAlignmentToolbar\"], {\n      onChange: updateAlignment,\n      value: atts.verticalAlignment\n    })), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__[\"InspectorControls\"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__[\"PanelColorSettings\"], {\n      title: \"Text Color\",\n      initialOpen: \"true\",\n      colorSettings: [{\n        label: 'Text Color',\n        value: atts.textColor,\n        disableCustomColors: false,\n        onChange: updateTextColor\n      }]\n    }))); //\n\n    function updateAlignment(newValue) {\n      newValue = newValue || '';\n      props.setAttributes({\n        verticalAlignment: newValue\n      }); // remove existing VAlign class\n\n      if (atts.className) {\n        atts.className = atts.className.replace(/is-vertically-aligned-\\w+/, '');\n      } else {\n        atts.className = ''; // initialize\n      } // add VAlign class\n\n\n      if (newValue) {\n        props.setAttributes({\n          className: \"\".concat(atts.className, \" is-vertically-aligned-\").concat(newValue)\n        });\n      }\n    }\n    /**\r\n     *  \r\n     */\n\n\n    function updateTextColor(newColor) {\n      newColor = newColor || 'white';\n      props.setAttributes({\n        textColor: newColor\n      }); // remove existing color class\n\n      if (atts.className) {\n        atts.className = atts.className.replace(/has-text-color has-[\\w-]+-color/, '').trim();\n      } else {\n        atts.className = ''; // initialize\n      } // if none selected\n\n\n      if (newColor === 'white') {\n        props.setAttributes({\n          className: atts.className.trim()\n        });\n      } else {\n        var settings = Object(_wordpress_data__WEBPACK_IMPORTED_MODULE_4__[\"select\"])('core/editor').getEditorSettings();\n        var colorObject = Object(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__[\"getColorObjectByColorValue\"])(settings.colors, newColor);\n        props.setAttributes({\n          className: \"\".concat(atts.className, \" has-text-color has-\").concat(colorObject.slug, \"-color\")\n        });\n      }\n    }\n  };\n}\n\n//# sourceURL=webpack:///./src/featured-category.jsx?");

/***/ }),

/***/ "./src/featured-category.sass":
/*!************************************!*\
  !*** ./src/featured-category.sass ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("// extracted by mini-css-extract-plugin\n\n//# sourceURL=webpack:///./src/featured-category.sass?");

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("(function() { module.exports = window[\"wp\"][\"blockEditor\"]; }());\n\n//# sourceURL=webpack:///external_%5B%22wp%22,%22blockEditor%22%5D?");

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("(function() { module.exports = window[\"wp\"][\"data\"]; }());\n\n//# sourceURL=webpack:///external_%5B%22wp%22,%22data%22%5D?");

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("(function() { module.exports = window[\"wp\"][\"element\"]; }());\n\n//# sourceURL=webpack:///external_%5B%22wp%22,%22element%22%5D?");

/***/ }),

/***/ "@wordpress/hooks":
/*!*******************************!*\
  !*** external ["wp","hooks"] ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("(function() { module.exports = window[\"wp\"][\"hooks\"]; }());\n\n//# sourceURL=webpack:///external_%5B%22wp%22,%22hooks%22%5D?");

/***/ }),

/***/ "lodash":
/*!*************************!*\
  !*** external "lodash" ***!
  \*************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("(function() { module.exports = window[\"lodash\"]; }());\n\n//# sourceURL=webpack:///external_%22lodash%22?");

/***/ })

/******/ });