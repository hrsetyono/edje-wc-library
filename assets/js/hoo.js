(function($) {
'use strict';

$(document).ready(start);
$(document).on('page:load', start);
$(window).load(startOnLoad);

function start() {
  wooCheckout.init();
}

// functions that needs to run only after everything loads
function startOnLoad() {
  wooCheckout.moveAccountFields();
}

var wooCheckout = {
  init: function() {
    // add select wrapper
    $('#billing_country_field, #shipping_country_field').on('change', 'select', this._onChangeCountry);

    // add active state to field
    $('.form-row input').each(this._checkActiveField);
    $('.form-row').on('change', 'input, select, textarea', this._checkActiveField);

    $(document.body).on('checkout_error', this._moveErrorMessages);
  },

  /*
    Move the Account Wrapper to top and insert the email field to it.
  */
  moveAccountFields: function() {
    var $field = $('.woocommerce-account-fields');
    if(!$field) { return false; } // abort if not found

    // put account wrapper at top
    $field.insertBefore($('.woocommerce-billing-fields') );

    // insert email field to account wrapper
    $('#billing_email_field').prependTo($field);
  },

  /*
    Check whether the State of this country has dropdown, if it does, add extra class
  */
  _onChangeCountry: function() {
    var $country = $(this);
    var $countryRow = $country.closest('.form-row');
    var $stateRow = $countryRow.siblings('#billing_state_field, #shipping_state_field');

    setTimeout(afterDelay, 200);

    function afterDelay() {
      if($stateRow.find('select').length ) {
        $stateRow.addClass('form-row--select');
      } else {
        $stateRow.removeClass('form-row--select form-row--active');
      }
    }
  },

  /*
    Add active class if field has value
  */
  _checkActiveField: function(e) {
    var $input = $(this);
    var $row = $input.closest('.form-row');

    if($input.val() ) { // if not empty
      $row.addClass('form-row--active');
    } else {
      $row.removeClass('form-row--active');
    }
  },

  /*
    Move the error message inside the wrapper to maintain Flex layout
  */
  _moveErrorMessages: function(e) {
    var $notice = $('.woocommerce-NoticeGroup');

    $notice.insertAfter($('.checkout-customer .entry-breadcrumbs') );
  }
};

})(jQuery);
