<?php
// Custom Admin CSS
add_action("admin_enqueue_scripts", "h_enqueue_scripts", 999);

function h_enqueue_scripts($hook) {
  global $post;
  wp_register_style("hw_style", HW_PLUGIN_DIR . "/assets/css/style.css");
  wp_register_script("hw_script", HW_PLUGIN_DIR . "/assets/js/script.js");
  wp_register_script("hw_handlebars", HW_PLUGIN_DIR . "/assets/js/handlebars.js");

  wp_enqueue_script("hw_handlebars");
  wp_enqueue_script("hw_script");
  wp_enqueue_style("hw_style");
}
