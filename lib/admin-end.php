<?php

class Hoo_Admin {
  function __construct() {
    add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'), 999);

    add_action('woocommerce_product_after_variable_attributes', array($this, 'add_variation_data'), 10, 3);
    add_action('wp_ajax_h_after_save_variations', array($this, 'after_save_variations') );
  }

  /*
    Call the custom CSS and JS
  */
  function enqueue_scripts($hook) {
    global $post;

    // for single product only
    if(isset($post->post_type) && $post->post_type == 'product') {
      wp_register_style('hoo_style', HOO_PLUGIN_DIR . '/assets/css/style.css');
      wp_register_script('hoo_script', HOO_PLUGIN_DIR . '/assets/js/script.js');
      wp_register_script('hoo_handlebars', HOO_PLUGIN_DIR . '/assets/js/handlebars.js');

      wp_enqueue_script('hoo_handlebars');
      wp_enqueue_script('hoo_script');
      wp_enqueue_style('hoo_style');
    }
  }

  /*
    Add Quick Form to each Variation
  */
  function add_variation_data($index, $variation_data, $variation) {
    ?>
    <div class='h-variation-data' data-variation='<?php echo htmlspecialchars(json_encode($variation_data), ENT_QUOTES, 'UTF-8'); ?>'></div>
    <?php
  }

  /*
    Save Main regular and sale price when AJAX-saving the variations
  */
  function after_save_variations() {
    $data = $_POST['data'];

    $post_id = $data['post_id'];
    update_post_meta($post_id, '_regular_price', $data['global_price']);
    update_post_meta($post_id, '_sale_price', $data['global_sale']);
  }
}
