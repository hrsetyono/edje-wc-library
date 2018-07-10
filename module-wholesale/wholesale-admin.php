<?php namespace h;

class Wholesale_Admin {
  function __construct() {
    add_action( 'woocommerce_product_options_general_product_data', array($this, 'add_wholesale_fields') );
    add_action( 'woocommerce_process_product_meta', array($this, 'save_wholesale_fields') );
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
    		'id' => '_quantity_per_carton',
    		'label' => __( 'Quantity per Carton', 'h' ),
        'desc_tip' => 'true',
    		'description' => __( 'Wholesaler can only buy in multiples of cartons', 'h' ),
    		'type' => 'number',
    	)
    );

    echo '</div>';
  }

  function save_wholesale_fields( $post_id ) {
    $wholesale_price = $_POST['_wholesale_price'];
  	if( !empty( $wholesale_price ) ) {
  		update_post_meta( $post_id, '_wholesale_price', esc_attr( $wholesale_price ) );
    }

    $per_carton = $_POST['_quantity_per_carton'];
  	if( !empty( $wholesale_price ) ) {
  		update_post_meta( $post_id, '_quantity_per_carton', esc_attr( $per_carton ) );
    }
  }
}
