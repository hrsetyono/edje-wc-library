# Edje WooCommerce Library

![Edje Wordpress](https://raw.github.com/hrsetyono/cdn/master/edje-wp-library/logo.jpg)

This is a library plugin for our starter theme: [Edje](https://github.com/hrsetyono/edje-wp-theme). We don't recommend using this with your theme.

Last tested working on:

- WordPress 5.8
- WooCommerce 6.3.1
- PHP 7.3.5

## [DEMO](https://test.pixelstudio.id/shop)

# Main Features

## 1. Variation UI

The original variation interface is really lacking. We did a slight rearrangement and styling changes to make it much easier to use.

![](https://raw.github.com/hrsetyono/cdn/master/edje-wc-library/variation-ui.jpg)

## 2. Widgets

Our Edje Theme uses widget for Header and Footer (we like it the old way), so this plugin adds two widgets:

- **Cart** - The revamped Cart widget with better markup for styling.
- **MyAccount** - Button to login when signed-out and to MyAccount when signed-in.

## Other Changes

These are the list of modifications by this plugin:

- [Alert] Changed the button in alert box when adding new item from "View Cart" to "Go to Checkout".
- [Shop] Changed the "On Sale" label into "X% Off".
- [Shop] Added "Out of Stock" label when the product is out of stock.
- [Shop] Changed the thumbnail size into Medium.
- [Shop] Removed all the custom WooCommerce image sizings.
- [Single Product] Added (-) and (+) button to the Quantity input.
- [Single Product] Changed the Review template so it is easier to style.
- [Checkout] Added multiple wrapper to make styling easier.
- [Checkout] Added thumbnail to the Order Review table.
- [Checkout] Changed the order of billing fields. Email is first so it has higher chance to be filled before being abandoned, so we can contact them. (Only useful for Cart Abandon plugin)
- [Checkout] Added legal message to Privacy Policy below the Shipping fields.
- [Thank You] Added multiple wrapper to make styling easier.
- [Register] Added most of the billing fields like Address, Country, Postcode, and more to Register form.
- [Register] Added a toggle button to switch between Login and Register form.

# Hooks

### [Widget] MyAccount

```
apply_filters('h_myaccount_button_args', $args)
```

`$args` (array)

- `label` (string) - Label when logged out.  
    Default: what's provided in the setting.

- `label_logged_in` (string) - Label when logged in.  
    Default: what's provided in the setting.

- `icon` (string) - raw SVG markup of the icon.

### [Widget] Cart

```
apply_filters('h_cart_button_args', $args)
```

`$args` (array)

- `label` (string) - the button label.
    Default: `<span>Cart</span>`

- `icon` (string) - raw SVG markup of the icon.

### [Widget] Disabled Widgets

```
apply_filters('h_disabled_woocommerce_widgets', $list)
```

`$list` (array) - List of widget to be disabled.

Default:

```php
[
  'WC_Widget_Product_Tag_Cloud',
  'WC_Widget_Product_Categories'
  'WC_Widget_Top_Rated_Products',
  'WC_Widget_Recent_Reviews',
  'WC_Widget_Rating_Filter',
  'WC_Widget_Recently_Viewed',
]
```

### [Cart Page] Footnote below Checkout Button

```
apply_filters('h_cart_total_footnote', $text);
```

`$text` (string) - Default: "Shipping cost, taxes, and payment method will be shown at checkout."

### [Product] On Sale Label

```
apply_filters('h_product_onsale_label', $text, $percentage);
```

`$text` (string) - The label that replaced "On Sale".  
Default: "xx% Off"