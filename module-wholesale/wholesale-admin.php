<?php namespace h;

class Wholesale_Admin {
  function __construct() {
    add_action( 'woocommerce_product_options_general_product_data', array($this, 'add_wholesale_fields') );
    add_action( 'woocommerce_process_product_meta', array($this, 'save_wholesale_fields') );

    // add new columns in WooCommerce > Products
    \H::add_column( 'product', array(
      'name' => 'Wholesale Price >price',
      'content' => array($this, 'wholesale_price_column'),
    ) );
  }

  /*
    Add wholesale fields in WC Product edit page
    @action woocommerce_product_options_general_product_data
  */
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
    After saving WC Product, save the new field too
    @action woocommerce_process_product_meta
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
    Content of "Wholesale" column in WC Product table
  */
  function wholesale_price_column( $post, $fields ) {
    $wholesale_price = isset( $fields['_wholesale_price'] ) ? $fields['_wholesale_price'][0] : null;
    $wholesale_moq = isset( $fields['_wholesale_price'] ) ? $fields['_wholesale_moq'][0] : null;

    return $wholesale_price ?
      wc_price( $wholesale_price ) . ' <br> Moq: ' . $wholesale_moq
      :
      '-';
  }
}
