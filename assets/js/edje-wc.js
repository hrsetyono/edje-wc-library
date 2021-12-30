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
    if (!e.target.classList.contains('quantity__h-spin')) { return; }

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

/**
 * Changed the coupon and login form in Checkout into Popup
 */
const hCheckoutForm = {
  init() {
    if (!document.querySelector('body').classList.contains('woocommerce-checkout')) { return; }

    const $formLinks = document.querySelectorAll('.showcoupon, .showlogin');
    const $forms = document.querySelectorAll('.woocommerce-form-coupon, .woocommerce-form-login');
    const $couponForm = document.querySelector('.woocommerce-form-coupon');

    [...$formLinks].forEach(($link) => {
      $link.addEventListener('click', this.openForm);
    });

    // prevent closing when clicking inside the form
    [...$forms].forEach(($form) => {
      $form.addEventListener('click', (e) => e.stopPropagation());
    });

    // close the form when clicking outside
    document.addEventListener('click', this.closeForm);

    if ($couponForm) {
      $couponForm.addEventListener('submit', this.closeForm);
    }
  },

  /**
   *
   */
  openForm(e) {
    e.preventDefault();
    e.stopPropagation();
    const formTarget = e.target.classList.contains('showcoupon')
      ? '.woocommerce-form-coupon'
      : '.woocommerce-form-login';

    const $form = document.querySelector(formTarget);

    if ($form) {
      $form.classList.toggle('is-open');
      document.querySelector('body').classList.toggle('has-checkout-form-open');
    }
  },

  /**
   *
   */
  closeForm() {
    const $openedForm = document.querySelector('.woocommerce-form-coupon.is-open, .woocommerce-form-login.is-open');

    if ($openedForm) {
      document.querySelector('body').classList.remove('has-checkout-form-open');
      $openedForm.classList.remove('is-open');
    }
  },
};

function onReady() {
  hQuantity.init();
  hMiniCart.init();
  hCheckoutForm.init();
}

function onLoad() {

}

document.addEventListener('DOMContentLoaded', onReady);
document.addEventListener('load', onLoad);

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