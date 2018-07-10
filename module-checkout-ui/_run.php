<?php
/*
  Replace Checkout interface with our UI
*/

// run
add_action( 'template_redirect', '_run_h_checkout_ui' );

/////

function _run_h_checkout_ui() {
  if( is_checkout() && get_theme_support('h-wc-checkout') ) {
    require_once HOO_PATH . '/module-checkout-ui/checkout-ui.php';
    require_once HOO_PATH . '/module-checkout-ui/form-fields.php';
    new \h\Checkout_UI();
    new \h\Checkout_Fields();
  }

  if( is_wc_endpoint_url( 'order-received' ) ) {
    require_once HOO_PATH . '/module-checkout-ui/thankyou-page.php';
    new \h\Checkout_Thankyou();
  }
}


/**
 * Locate the called template in /plugins/your-plugin/templates/$template_name.
 * http://jeroensormani.com/how-to-add-template-files-in-your-plugin/
 *
 * @param 	string 	$template_name			Template to load.
 * @param 	string	$default_path			Default path to template files.
 * @return 	string 							Path to the template file.
 */
function hoo_locate_template($template_name, $default_path = '') {
	// Set default plugin templates path.
	if(!$default_path) {
		$default_path = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/woocommerce-edje/templates/'; // Path to the template folder
	}

	$template = $default_path . $template_name;

	return apply_filters('hoo_locate_template', $template, $template_name, $default_path);
}
