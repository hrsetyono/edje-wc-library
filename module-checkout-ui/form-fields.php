<?php
/*
  Handle form fields for CHECKOUT and MY-ACCOUNT page
*/
class H_CheckoutUI_Fields {
  function __construct() {
    // Form Fields
    add_filter('woocommerce_billing_fields', array($this, 'reorder_billing_fields'), 10, 1 );
    add_filter('woocommerce_default_address_fields', array($this, 'reorder_address_fields'), 10);
  }

  /*
    Reorder billing field
    @filter woocommerce_billing_fields

    @param array $fields - The fields in billing
    @return array - The modified list of fields.
  */
  function reorder_billing_fields($fields) {
    $fields['billing_email']['priority'] = 1;
    $fields['billing_email']['placeholder'] = $fields['billing_email']['label'];

    $fields['billing_phone']['required'] = false;
    $fields['billing_phone']['placeholder'] = $fields['billing_phone']['label'];

    return $fields;
  }

  /*
    Reorder address field (Billing and Shipping) to be more like Shopify
    @filter woocommerce_default_address_fields

    @param array $fields - The current list of fields
    @return array - The ordered list of fields
  */
  function reorder_address_fields($fields) {
    unset($fields['company']);

    $fields['first_name']['placeholder'] = $fields['first_name']['label'];
    $fields['last_name']['placeholder'] = $fields['last_name']['label'];

    $fields['address_1']['priority'] = 22;
    $fields['address_1']['placeholder'] = $fields['address_1']['label'];
    $fields['address_2']['priority'] = 24;
    $fields['address_2']['label'] = __('Apartment, suite, unit etc.', 'hoo');

    $fields['state']['priority'] = 42;
    $fields['state']['placeholder'] = $fields['state']['label'];
    $fields['country']['class'][] = 'form-row--active form-row--select';

    $fields['postcode']['priority'] = 46;
    $fields['postcode']['placeholder'] = $fields['postcode']['label'];

    $fields['city']['priority'] = 50;
    $fields['city']['placeholder'] = $fields['city']['label'];

    return $fields;
  }

}
