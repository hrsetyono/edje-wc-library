<?php

add_filter('woocommerce_locate_template', 'hoo_allow_template_in_plugin', 1, 3);

/**
 * Allow WooCommerce template to be placed within this plugin's /template/ directory
 * Credit: https://wisdmlabs.com/blog/override-woocommerce-templates-plugin/
 */
function hoo_allow_template_in_plugin( $template, $template_name, $template_path ) {
  global $woocommerce;
  $_template = $template;
  if(!$template_path) {
    $template_path = $woocommerce->template_url;
  }

  $plugin_path  = HWC_PATH . '/templates/';

  // Look within passed path within the theme - this is priority
  $template = locate_template(
    array($template_path . $template_name, $template_name)
  );

  if(!$template && file_exists( $plugin_path . $template_name ) ) {
    $template = $plugin_path . $template_name;
  }

  if(!$template ) {
    $template = $_template;
  }

  return $template;
}

/**
 * Locate the called template in /plugins/your-plugin/templates/$template_name.
 * http://jeroensormani.com/how-to-add-template-files-in-your-plugin/
 *
 * @param string $template_name - Template to load.
 * @param string $default_path - Default path to template files.
 * @return string - Path to the template file.
 */
function hoo_locate_template( $template_name, $default_path = '' ) {
	// Set default plugin templates path.
	if(!$default_path) {
		$default_path = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/edje-wc-library/templates/'; // Path to the template folder
	}

	$template = $default_path . $template_name;

	return apply_filters( 'hoo_locate_template', $template, $template_name, $default_path );
}