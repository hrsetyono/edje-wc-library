<?php
/*
WooCommerce Edje - Variable product add to cart

Changes:
1. If product is variation, move the ADD TO CART button above the Select Dropdown.
2. [JS] If product is variation, after selection, hide the base price because the variant price is displayed.

@from 3.0.0
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$attribute_keys = array_keys( $attributes );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( get_permalink() ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
	<?php else : ?>

    <?php #1
		do_action( 'woocommerce_before_add_to_cart_button' ); ?>
    <div class="single_variation_wrap">
      <?php
        do_action( 'woocommerce_before_single_variation' );
        do_action( 'woocommerce_single_variation' );
        do_action( 'woocommerce_after_single_variation' );
      ?>
    </div>
		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

		<table class="variations" cellspacing="0">
			<tbody>
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<tr>
						<td class="label"><label for="<?php echo sanitize_title( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?></label></td>
						<td class="value">
							<?php
								$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( stripslashes( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) ) : $product->get_variation_default_attribute( $attribute_name );
								wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected ) );
							?>
						</td>
					</tr>
				<?php endforeach;?>
          <?php // NOTE: Moved clear button to new row ?>
          <tr>
            <td colspan="2">
              <?php echo end( $attribute_keys ) === $attribute_name ? apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) : ''; ?>
            </td>
          </tr>
			</tbody>
		</table>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
