# Edje WooCommerce Library

![Edje Wordpress](https://raw.github.com/hrsetyono/cdn/master/edje-wp-library/logo.jpg)

WooCommerce is a fantastic shopping platform, but complicated to use and develop. This plugin helps simplifying many features.

**REQUIREMENT**

- PHP 7.0+
- WordPress 5.0+
- WooCommerce 3.5+

**TABLE OF CONTENTS**

1. [Intuitive Variations UI](#1-intuitive-variations-ui)
1. [Clean Checkout Page](#2-clean-checkout-page)
1. [Changelog](https://github.com/hrsetyono/edje-wc-library/wiki/Changelog)


## 1. Intuitive Variations UI

![Edje Woo - New Variation Interface](https://raw.github.com/hrsetyono/cdn/master/edje-wc-library/variation.jpg)

Important information at a glance, editable without toggling each variation.

**HOW TO USE**:

This feature is automatically activated.

Also we don't add any new metadata. So even if you disable this plugin, your variation price is still there.

-----

## 2. Clean Checkout Page

![Edje Woo - New Checkout Page](https://raw.github.com/hrsetyono/cdn/master/edje-wc-library/checkout-design.jpg)

Checkout page is very important to seal the deal. So we automatically transform yours into as seen above.

Simply add this in your functions.php: `add_theme_support('h-checkout');`.

**HOW TO USE**:

Add this in your functions.php:

```
add_theme_support('h-checkout');
add_theme_support('custom-logo');
```

**CUSTOMIZATION**:

- **Logo** - Add it in Appearance > Customize > Site Identity.

- **Banner Image** - Add featured image in Checkout page.
