<?php namespace h;

class Variations_UI {
  function __construct() {
    add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 999 );

    add_action( 'woocommerce_product_after_variable_attributes', array( $this, 'add_variation_data' ), 10, 3 );

    // save global price when saving via Submit or Ajax
    add_action( 'woocommerce_process_product_meta', array($this, 'after_save_via_submit'), 100 );
    add_action( 'wp_ajax_h_after_save_variations', array( $this, 'after_save_via_ajax' ) );
  }

  /*
    Call the custom CSS and JS
    @action admin_enqueue_scripts
  */
  function admin_enqueue_scripts( $hook ) {
    if( in_array( $hook, array( 'post.php', 'post-new.php', 'edit.php' ) ) ) {
      wp_enqueue_style( 'hoo-admin-css', HOO_DIR . '/assets/css/hoo-admin.css' );
      wp_enqueue_script( 'hoo-admin-js', HOO_DIR . '/assets/js/hoo-admin.js', array('jquery') );
      wp_enqueue_script( 'handlebars', HOO_DIR . '/assets/js/handlebars.js' );
    }
  }

  /*
    Add Quick Form to each Variation
    @action woocommerce_product_after_variable_attributes
  */
  function add_variation_data( $index, $variation_data, $variation ) {
    ?>
    <div class='h-variation-data' data-variation='<?php echo htmlspecialchars(json_encode($variation_data), ENT_QUOTES, 'UTF-8'); ?>'></div>
    <?php
  }

  /*
    Update the variation data to follow the Main field
  */
  function after_save_via_submit( $post_id ) {
    // if variation product AND global price not empty
    if( !empty($_POST['global_price'] ) ) {
      update_post_meta( $post_id, '_regular_price', $_POST['global_price'] );
      update_post_meta( $post_id, '_sale_price', $_POST['global_sale'] );
    }
  }

  /*
    Save Main regular and sale price when AJAX-saving the variations
    @action wp_ajax_h_after_save_variations
  */
  function after_save_via_ajax() {
    $data = $_POST['data'];

    $post_id = $data['post_id'];
    update_post_meta( $post_id, '_regular_price', $data['global_price'] );
    update_post_meta( $post_id, '_sale_price', $data['global_sale'] );
  }
}
