<?php
// Custom Admin CSS
add_action('admin_enqueue_scripts', 'h_enqueue_scripts', 999);

function h_enqueue_scripts($hook) {
  global $post;

  // for single product only
  if(isset($post->post_type) && $post->post_type == 'product') {
    wp_register_style('hw_style', HOO_PLUGIN_DIR . '/assets/css/style.css');
    wp_register_script('hw_script', HOO_PLUGIN_DIR . '/assets/js/script.js');
    wp_register_script('hw_handlebars', HOO_PLUGIN_DIR . '/assets/js/handlebars.js');

    wp_enqueue_script('hw_handlebars');
    wp_enqueue_script('hw_script');
    wp_enqueue_style('hw_style');
  }
}
