<?php namespace h;

class Wholesale_Admin {
  function __construct() {
    add_action( 'woocommerce_product_options_general_product_data', array($this, 'add_wholesale_fields') );
    add_action( 'woocommerce_process_product_meta', array($this, 'save_wholesale_fields') );

    // add_filter( 'woocommerce_product_visibility_options', array($this, 'add_wholesale_visibility') );

    // add new columns in WooCommerce > Products
    \H::add_column( 'product', array(
      'name' => 'Wholesale Price >price',
      'content' => array($this, 'wholesale_price_column'),
    ) );
  }

  function add_wholesale_fields() {
    global $woocommerce, $post;
    echo '<div class="options_group">';

    woocommerce_wp_text_input(
    	array(
    		'id' => '_wholesale_price',
    		'label' => __( 'Wholesale Price', 'h' ),
    		'desc_tip' => 'true',
    		'description' => __( 'Customers with "Wholesale" role can see this price', 'h' )
    	)
    );

    woocommerce_wp_text_input(
    	array(
    		'id' => '_wholesale_moq',
    		'label' => __( 'Quantity per Carton', 'h' ),
        'desc_tip' => 'true',
    		'description' => __( 'Wholesaler can only buy in multiples of cartons', 'h' ),
    		'type' => 'number',
    	)
    );

    echo '</div>';
  }

  /*
  */
  function save_wholesale_fields( $post_id ) {
    $wholesale_price = $_POST['_wholesale_price'];
  	if( !empty( $wholesale_price ) ) {
  		update_post_meta( $post_id, '_wholesale_price', esc_attr( $wholesale_price ) );
    }

    $per_carton = $_POST['_wholesale_moq'];
  	if( !empty( $wholesale_price ) ) {
  		update_post_meta( $post_id, '_wholesale_moq', esc_attr( $per_carton ) );
    }
  }

  /*

  */
  function wholesale_price_column( $post, $fields ) {
    $wholesale_price = get_post_meta( $post->ID, '_wholesale_price', true );
    $wholesale_moq = get_post_meta( $post->ID, '_wholesale_moq', true );

    return $wholesale_price ?
      wc_price( $wholesale_price ) . ' <br> Min: ' . $wholesale_moq
      :
      '-';
  }
}
