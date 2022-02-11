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
    if (!e.target.classList.contains('is-cart-button') && !e.target.closest('.is-cart-button')) { return; }

    e.preventDefault();
    e.target.closest('.h-cart').classList.toggle('is-active');
  },

  closePopup(e) {
    if (e.target.closest('.widget_shopping_cart') || e.target.closest('.is-cart-button')) { return; }

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

/**
 * Listener for custom Mobile tab in Single Product page
 */
const hMobileTabs = {
  init() {
    const $tabButtons = document.querySelectorAll('.h-tab-mobile a');

    [...$tabButtons].forEach(($b) => {
      $b.addEventListener('click', this.onClick);
    });
  },

  onClick(e) {
    e.preventDefault();
    const tabId = e.currentTarget.getAttribute('href');
    const $tab = document.querySelector(tabId);
    const $button = e.currentTarget.closest('.h-tab-mobile');

    if (!$tab) { return; }

    if ($button.classList.contains('active')) {
      $tab.style.display = 'none';
    } else {
      $tab.style.display = '';
    }

    $button.classList.toggle('active');

    // if ($tab) {
    //   $tab.style.display = '';
    // }

    // // deactivate other tab buttons
    // const $activeButton = document.querySelector('.h-tab-mobile.active');
    // if ($activeButton) {
    //   $activeButton.classList.remove('active');
    // }

    // // hide other tabs
    // const $tabs = document.querySelectorAll('.wc-tab');
    // [...$tabs].forEach(($t) => {
    //   $t.style.display = 'none';
    // });

    // // highlight button
    // $button.classList.add('active');

    // // show selected tab
    // if ($tab) {
    //   $tab.style.display = '';
    // }
  },
};

function onReady() {
  hQuantity.init();
  hMiniCart.init();
  hCheckoutForm.init();
  hMobileTabs.init();
}

function onLoad() {

}

document.addEventListener('DOMContentLoaded', onReady);
document.addEventListener('load', onLoad);