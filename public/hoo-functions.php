<?php

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
