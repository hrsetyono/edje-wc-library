(function($) {
'use strict';

$(document).ready(start);
$(document).on('page:load', start);
$(window).load(startOnLoad);

function start() {
  var $body = $('body');

  if( $body.hasClass('woocommerce-checkout') ) {
    wooCheckout.init();
    wooThankyou.init();
  }

  if( $body.hasClass('single-product') ) {
    // wooSingle.init();
  }
}

// functions that needs to run only after everything loads
function startOnLoad() {
  wooCheckout.moveEmailField();
}

///// SINGLE PRODUCT page

var wooSingle = {
  init: function() {
    var $form = $('form.variations_form');
    $form.on( 'update_variation_values', this.onUpdateVariation );
    $form.on( 'found_variation', this.onFoundVariation );
    $form.on( 'reset_data', this.onClear );
  },

  onUpdateVariation: function() {

  },

  /*
    After finished choosing all selection
  */
  onFoundVariation: function( e, variation ) {
    $(this).siblings('.price').hide();
  },

  /*
    After pressing "Clear" to remove all variant selection
  */
  onClear: function( e ) {
    $(this).siblings('.price').show();
  },

};

///// CHECKOUT Page /////

var wooCheckout = {
  init: function() {
    var self = this;

    // add select wrapper
    $(document).on('country_to_state_changed', self._onCountryChanged.bind(self) );

    // add active state to field
    $('.form-row input').each(this._checkActiveField);
    $('.form-row').on('change', 'input, select, textarea', this._checkActiveField);

    $(document.body).on('checkout_error', this._moveErrorMessages);
  },

  /*
    Move the Email field to Account fieldset
  */
  moveEmailField: function() {
    var $field = $('.woocommerce-account-fields');
    $('#billing_email_field').prependTo($field);
  },


  /*
    Check whether the State of this country has dropdown, if it does, add extra class
  */
  _onCountryChanged: function(e, country, $wrapper) {
    var $stateFields = $wrapper.find('#billing_state_field, #shipping_state_field');
    setTimeout(afterDelay, 200);

    function afterDelay() {
      if($stateFields.find('select').length ) {
        $stateFields.addClass('form-row--select');
      } else {
        $stateFields.removeClass('form-row--select form-row--active');
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
    console.log( 'on error' );
    var $notice = $('.woocommerce-NoticeGroup');

    $notice.prependTo( $('.column-main') );
  }
};


///// THANK YOU Page /////

var wooThankyou = {
  init: function() {
    // Break if not in thank you page
    if($('.woocommerce-order-received').length <= 0) { return false; }

    if($('.woocommerce-bacs-bank-details').length > 0) {
      this.bacsMoveName();
      this.bacsDeleteColon();
    }
  },

  /*
    BACS Move Account name to within the <ul>
  */
  bacsMoveName: function() {
    var $sources = $('.wc-bacs-bank-details-account-name');

    $sources.each(function() {
      var $destination = $(this).next('.wc-bacs-bank-details');

      $(this).prependTo($destination);
      $(this).wrap('<li class="account_name"></li>');
    });
  },

  /*
    Delete the colon that appears in Account Name
  */
  bacsDeleteColon: function() {
    var $accountNames = $('.woocommerce-bacs-bank-details h3');

    $accountNames.each(function() {
      var name = $(this).text();
      $(this).text(name.replace(':', '') );
    });
  },

}

})(jQuery);
