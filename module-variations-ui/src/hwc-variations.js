import './hwc-variations.sass';

const $ = jQuery;

/**
 * PRODUCT TYPE SELECTION
 */
const hProductType = {
  init() {
    // on change product type
    const $select = document.querySelector('#product-type');
    if (!$select) { return; }

    this.addTypeClass($select);

    $select.addEventListener('change', (e) => {
      this.addTypeClass(e.currentTarget);
    });
  },

  /**
   * Add extra class to <body> so it's easier to target and style
   */
  addTypeClass($select) {
    const typeName = $select.value;
    const $wrapper = document.querySelector('body');

    if (!$wrapper) { return; }

    const re = new RegExp(/is-product-type-\w+/, 'g');

    if ($wrapper.className.match(re)) {
      $wrapper.className = $wrapper.className.replace(re, `is-product-type-${typeName}`);
    } else {
      $wrapper.classList.add(`is-product-type-${typeName}`);
    }
  },
};

/**
 * ATTRIBUTE Tab
 */
const hAttributes = {
  init() {
    this.onAdded();
    this.onSaved();
    this.moveFields();
  },

  /**
   * Tick the "Use as Variations" checkbox whenever new attribute is added
   */
  onAdded() {
    $('body').on('woocommerce_added_attribute', () => {
      // @note - currently no need for check because we hide the Attribute tab when it's not variable
      // if (!document.body.classList.contains('is-product-type-variable')) {
      //   return;
      // }

      const $variationToggles = document.querySelectorAll('#product_attributes [name*="attribute_variation["]');

      [...$variationToggles].forEach(($t) => {
        $t.checked = true;
        $t.dispatchEvent(new Event('change'));

        this.moveField($t.closest('.wc-metabox'));
      });
    });
  },

  /**
   * Move all fields after saving
   */
  onSaved() {
    $('#variable_product_options').on('reload', () => {
      this.moveFields();
    });
  },

  /**
   * Move all input field to Heading
   */
  moveFields() {
    const $atts = document.querySelectorAll('#product_attributes .wc-metabox');

    [...$atts].forEach(($a) => {
      this.moveField($a);
    });
  },

  /**
   * Move an input field to Heading
   */
  moveField($att) {
    const $heading = $att.querySelector('h3');

    // if doesn't contain "taxonomy", move the attribute name field too
    if (!$att.classList.contains('taxonomy')) {
      const $nameWrapper = $att.querySelector('td.attribute_name');
      if ($nameWrapper) {
        $heading.append(...$nameWrapper.childNodes);
      }
    }

    const $termsWrapper = $att.querySelector('td[rowspan="3"]');
    if ($termsWrapper) {
      $heading.append(...$termsWrapper.childNodes);
    }
  },
};

/**
 * VARIATIONS
 */
const hVariationButtons = {
  init() {
    // this.moveActionSelect();
    // this.renderToolbarButtons();

    this.changeNoticeButton();

    this.initSetPrice();
    this.initSetSalePrice();
    this.initSetStock();

    this.initCreateVariations();

    $('#woocommerce-product-data').on('woocommerce_variations_loaded', () => {
      this.moveActionSelect();
      this.renderToolbarButtons();
    });
  },

  /**
   * Move the Action Dropdown to the Default Toolbar
   */
  moveActionSelect() {
    const $movedSelect = document.querySelector('.toolbar-variations-defaults .variation_actions');

    // abort if already moved
    if ($movedSelect) { return; }

    const $select = document.querySelector('.variation_actions');
    const $selectButton = document.querySelector('.do_variation_action');
    const $wrapper = document.querySelector('.toolbar-variations-defaults');

    if (!$select || !$wrapper) { return; }

    $wrapper.appendChild($select);
    $wrapper.appendChild($selectButton);
  },

  /**
   * Create buttons in toolbar that mimic the action from the dropdown
   */
  renderToolbarButtons() {
    const $wrapper = document.querySelector('#variable_product_options .toolbar-top');

    // Abort if no toolbar
    if (!$wrapper) { return; }

    const $buttons = $wrapper.querySelector('.h-variation-buttons');

    // abort if already has buttons
    if ($buttons) { return; }

    const $template = document.querySelector('#h-variation-buttons');

    if ($template) {
      $wrapper.innerHTML += $template.innerHTML;
    }
  },

  /**
   * Change the "Learn More" button when variation is empty to open Attributes tab instead of opening documentation.
   */
  changeNoticeButton() {
    $('#variable_product_options').on('click', '#variable_product_options_inner > .woocommerce-message a', _onClick);

    function _onClick(e) {
      e.preventDefault();

      const $targetTab = document.querySelector('.wc-tabs .attribute_tab a');
      $targetTab.dispatchEvent(new MouseEvent('click', {
        view: window,
        bubbles: true,
        cancelable: true,
      }));
    }
  },

  /**
   * Prompt user for global price
   */
  initSetPrice() {
    $('#variable_product_options').on('click', '.button[data-action="set-price"]', _onClick.bind(this));

    function _onClick() {
      this.doAction('variable_regular_price');
    }
  },

  /**
   * Prompt user for global sale price
   */
  initSetSalePrice() {
    $('#variable_product_options').on('click', '.button[data-action="set-sale-price"]', _onClick.bind(this));

    function _onClick() {
      const price = prompt('Enter the discounted price (leave empty to remove sale)');

      // Abort if cancelled
      if (price === null) { return; }

      this.fillFields('input[name*="variable_sale_price"]', price);

      // _setSchedule(price);
    }

    function _setSchedule(price) {
      // Sale schedule
      let startDate = '';
      let endDate = '';

      // Ask whether to set schedule or not (only when sale is not empty)
      if (price !== '' && window.confirm('Set Sale Schedule?')) {
        startDate = prompt('Enter start date (YYYY-MM-DD or leave blank)');
        endDate = prompt('Enter end date (YYYY-MM-DD or leave blank)');

        // if format is wrong, empty it
        if (!startDate.match(/\d{4}-\d{2}-\d{2}$/)) {
          startDate = '';
        }

        if (!endDate.match(/\d{4}-\d{2}-\d{2}$/)) {
          endDate = '';
        }

        // show the hidden schedule fields
        if (startDate) {
          const $hiddenFields = document.querySelectorAll('.form-field.sale_price_dates_fields');
          [...$hiddenFields].forEach(($f) => {
            $f.classList.remove('hidden');
            $f.style.display = 'block';
          });
        }
      }

      this.fillFields('input[name*="variable_sale_price_dates_from"]', startDate);
      this.fillFields('input[name*="variable_sale_price_dates_to"]', endDate);
    }
  },

  /**
   * Prompt user for stock number
   */
  initSetStock() {
    $('#variable_product_options').on('click', '.button[data-action="set-stock"]', _onClick.bind(this));

    function _onClick() {
      const amount = prompt('Enter stock amount (leave empty if not managing stock)');

      // Abort if cancelled
      if (amount === null) { return; }

      const isManagingStock = amount !== '';
      this.tickCheckboxes('[name*="variable_manage_stock"]', isManagingStock);

      if (amount === '') { return; }

      this.fillFields('[name*="variable_stock"]', amount);
    }
  },

  /**
   * Init create variations button (only appear when there's no variation)
   */
  initCreateVariations() {
    $('#variable_product_options').on('click', '.button[data-action="create-variations"]', _onClick.bind(this));

    function _onClick() {
      this.doAction('link_all_variations');
    }
  },

  /**
   * Change the Action Select value and trigger it
   */
  doAction(value) {
    const $select = document.querySelector('#variable_product_options #field_to_edit');
    const $button = document.querySelector('#variable_product_options .do_variation_action');

    // @todo - add a check whether value exist or not
    $select.value = value;
    $button.dispatchEvent(new MouseEvent('click', {
      view: window,
      bubbles: true,
      cancelable: true,
    }));
  },

  /**
   * Fill all variation fields
   */
  fillFields(query, value) {
    const $fields = document.querySelectorAll(query);

    [...$fields].forEach(($f) => {
      $f.value = value;
      $($f).trigger('change'); // has to be jQuery trigger to activate other behavior
    });
  },

  /**
   * Tick or Untick all checkboxes
   */
  tickCheckboxes(query, value) {
    const $checkboxes = document.querySelectorAll(query);
    [...$checkboxes].forEach(($cb) => {
      $cb.checked = value;
      $($cb).trigger('change'); // has to be jQuery trigger to toggle the hidden fields
    });
  },
};

/**
 * Add a quick info for Price, Sale Price, and Stock
 */
const hVariationOverview = {
  init() {
    $('#woocommerce-product-data').on('woocommerce_variations_loaded', this.render);
    $('#woocommerce-product-data').on('woocommerce_variations_added', this.render);

    const $fieldTargets = [
      {
        field: '[name*="regular_price["]',
        overview: '[data-info="price"]',
      },
      {
        field: '[name*="sale_price["]',
        overview: '[data-info="sale-price"]',
      },
      {
        field: '[name*="variable_stock["]',
        overview: '[data-info="stock"]',
      },
    ];

    $fieldTargets.forEach((target) => {
      // add listener to change the overview
      $('#variable_product_options').on('change', target.field, (e) => {
        this._updateOverview(e.currentTarget, target.overview);
      });

      // initially populate the overiew
      $('#woocommerce-product-data').on('woocommerce_variations_loaded', () => {
        const $fields = document.querySelectorAll(target.field);
        [...$fields].forEach(($f) => {
          this._updateOverview($f, target.overview);
        });
      });
    });

    // If untick "Manage Stock"
    $('#variable_product_options').on('change', '[name*="variable_manage_stock["]', (e) => {
      // abort if checked
      if (e.currentTarget.checked) { return; }

      this._updateOverview(e.currentTarget, '[data-info="stock"]');
    });
  },

  /**
   * Render the overview into each variation heading
   */
  render() {
    const $headings = document.querySelectorAll('#variable_product_options .wc-metabox h3');
    const template = document.querySelector('#h-variation-overview').innerHTML;

    [...$headings].forEach(($h) => {
      // Abort if already have overview
      if ($h.innerHTML.match(/h-variation-overview/)) { return; }

      $h.innerHTML += template;
    });
  },

  /**
   * Update the overview label
   */
  _updateOverview(target, query) {
    const $wrapper = target.closest('.wc-metabox').querySelector('.h-variation-overview');

    if (!$wrapper) { return; }

    const $label = $wrapper.querySelector(query);

    if (target.value > 0) {
      $label.classList.remove('hidden');
    } else {
      $label.classList.add('hidden');
    }

    $label.querySelector('span').textContent = target.value;
  },
};

function onReady() {
  hProductType.init();
  hAttributes.init();
  hVariationButtons.init();
  hVariationOverview.init();
}

function onLoad() {
  // script that runs when everything is loaded
}

document.addEventListener('DOMContentLoaded', onReady);
window.addEventListener('load', onLoad);
