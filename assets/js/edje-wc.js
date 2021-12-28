// const $ = jQuery;

// function onReady() {
//   var bodyClassList = document.querySelector( 'body' ).classList;

//   // on any woocommerce page
//   wooGeneral.init();

//   // If account page
//   if( bodyClassList.contains('woocommerce-account') ) {
//     wooAccount.init();
//   }
//   // If checkout page
//   else if( bodyClassList.contains('woocommerce-checkout') ) {
//     wooCheckout.init();
//     wooThankyou.init();
//   }
//   // If Single product
//   else if( bodyClassList.contains('single-product') ) {
//     wooSingle.init();
//   }
// }

// // functions that needs to run only after everything loads
// function onLoad() {
//   wooCheckout.moveEmailField();
// }

/**
 * Added close button to Alert box. This is the listener for it.
 */
 const hAlert = {
  init() {
    const $toasts = document.querySelectorAll('.h-close-toast');

    [...$toasts].forEach(($t) => {
      $t.addEventListener('click', this.closeToast);
    });
  },

  closeToast(e) {
    const $toast = e.currentTarget.closest('.woocommerce-notices-wrapper');
    $toast.style.display = 'none';
  },
};

/**
 * Added (+) and (-) button to Quantity box. This is the listener for it.
 */
const hQuantity = {
  init() {
    const $cartForm = document.querySelector('.woocommerce-cart .woocommerce, form.cart');
    if ($cartForm) {
      $cartForm.addEventListener('click', this.changeQuantity);
    }
  },

  changeQuantity(e) {
    if (!e.target.classList.contains('quantity__spin')) { return; }

    e.preventDefault();
    const $field = e.target.closest('.quantity').querySelector('input[type="number"]');
    const change = e.target.classList.contains('is-plus') ? 1 : -1;
    const result = parseInt($field.value, 10) + change;

    if (result <= 0) { return; }

    $field.value = result;

    // trigger change event to check whether to hide (-) button or not
    const changeEvent = new Event('change');
    $field.dispatchEvent(changeEvent);

    // trigger input event to enable "Update Cart" button in Cart page
    const event = new Event('input', { bubbles: true });
    $field.dispatchEvent(event);
  },
};

/**
 * Added custom Mini Cart widget. This is the listener to keep it open.
 */
const hMiniCart = {
  init() {
    const $minicarts = document.querySelectorAll('.h-cart');

    [...$minicarts].forEach(($cart) => {
      $cart.addEventListener('click', this.openPopup);
    });

    document.addEventListener('click', this.closePopup);
  },

  openPopup(e) {
    if (!e.target.classList.contains('h-cart__button') && !e.target.closest('.h-cart__button')) { return; }

    e.preventDefault();
    e.target.closest('.h-cart').classList.toggle('is-active');
  },

  closePopup(e) {
    if (e.target.closest('.widget_shopping_cart') || e.target.closest('.h-cart__button')) { return; }

    const $openMinicart = document.querySelector('.h-cart.is-active');

    if ($openMinicart) {
      $openMinicart.classList.remove('is-active');
    }
  },
};

function onReady() {
  hAlert.init();
  hQuantity.init();
  hMiniCart.init();
}

function onLoad() {

}

document.addEventListener('DOMContentLoaded', onReady);
document.addEventListener('load', onLoad);

/**
 * SINGLE PRODUCT page
 * /

// var wooSingle = {
//   init() {
//     var $form = $( 'form.variations_form' );

//     $form.on( 'update_variation_values', this.onUpdateVariation );
//     $form.on( 'found_variation', this.onFoundVariation );
//     $form.on( 'reset_data', this.onClear );
//   },

//   onUpdateVariation() {

//   },

//  /**
//   * After finished choosing all selection
//   */
//   onFoundVariation( e, variation ) {
//     var $firstPrice = e.currentTarget.parentNode.querySelector( '.price' );

//     // if product has price range, hide it to show that variation's price
//     if( $firstPrice.querySelectorAll( '.amount' ).length >= 2 ) {
//       $firstPrice.style.display = 'none';
//     }
//   },

//  /**
//   * After pressing "Clear" to remove all variant selection 
//   */
//   onClear( e ) {
//     e.currentTarget.parentNode.querySelector( '.price' ).style.display = '';
//   },

// };

/**
 * CHECKOUT Page
 */

// var wooCheckout = {
//   init() {
//     // add select wrapper
//     $(document).on( 'country_to_state_changed', this._onCountryChanged.bind( this ) );

//     // add active state to field
//     $('.form-row input').each( this._checkActiveField );
//     $('.form-row').on( 'change', 'input, select, textarea', this._checkActiveField );

//     $(document.body).on( 'checkout_error', this._moveErrorMessages );
//   },


//   /**
//    * Move the Email field to Account fieldset
//    */
//   moveEmailField() {
//     var $field = $('.woocommerce-account-fields');
//     $('#billing_email_field').prependTo( $field );
//   },

//   /**
//    * Add active state to field with value
//    */
//   addActiveState( $input ) {
//     let $row = $input.closest( '.form-row' );
    
//     if( $input.value ) {
//       $row.classList.add( 'form-row--active' );
//     } else {
//       $row.classList.remove( 'form-row--active' );
//     }
//   },


//   /**
//    * Check whether the State of this country has dropdown, if it does, add extra class
//    */
//   _onCountryChanged( e, country, $wrapper ) {
//     var $stateFields = $wrapper.find( '#billing_state_field, #shipping_state_field' );
//     setTimeout( afterDelay, 200 );

//     function afterDelay() {
//       if( $stateFields.find('select').length ) {
//         $stateFields.addClass( 'form-row--select' );
//       } else {
//         $stateFields.removeClass( 'form-row--select form-row--active' );
//       }
//     }
//   },

//   /**
//    * Add active class if field has value 
//    */
//   _checkActiveField( e ) {
//     var $input = $(this);
//     var $row = $input.closest('.form-row');

//     if($input.val() ) { // if not empty
//       $row.addClass( 'form-row--active' );
//     } else {
//       $row.removeClass( 'form-row--active' );
//     }
//   },

//   /**
//    * Move the error message inside the wrapper to maintain Flex layout
//    */
//   _moveErrorMessages( e ) {
//     var $notice = $( '.woocommerce-NoticeGroup' );
//     $notice.prependTo( $( '.column-main' ) );
//   }
// };

/**
 * THANK YOU Page
 */
// var wooThankyou = {
//   init() {
//     // Break if not in thank you page
//     if( document.querySelector('.woocommerce-order-received').length <= 0) { return; }

//     if( document.querySelector('.woocommerce-bacs-bank-details').length > 0 ) {
//       this.bacsMoveName();
//       this.bacsDeleteColon();
//     }
//   },

//  /**
//   * BACS Move Account name to within the <ul>
//   */
//   bacsMoveName() {
//     var $sources = $('.wc-bacs-bank-details-account-name');

//     $sources.each(function() {
//       var $destination = $(this).next('.wc-bacs-bank-details');

//       $(this).prependTo($destination);
//       $(this).wrap('<li class="account_name"></li>');
//     });
//   },

//   /*
//     Delete the colon that appears in Account Name
//   */
//   bacsDeleteColon() {
//     var $accountNames = $('.woocommerce-bacs-bank-details h3');

//     $accountNames.each( function() {
//       var name = $(this).text();
//       $(this).text(name.replace(':', '') );
//     });
//   },
// };

/**
 * ACCOUNT Page
 */
// var wooAccount = {
//   init() {

//   },
// };