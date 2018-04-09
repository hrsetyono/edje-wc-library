<?php
/*
WooCommerce Edje - Form Billing template

Changes:
1. Move Account fields to top

@from 3.0.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php #1 ?>
<div class="woocommerce-account-fields">
<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
	<?php if ( ! $checkout->is_registration_required() ) : ?>

		<p class="form-row form-row-wide create-account">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
				<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ) ?> type="checkbox" name="createaccount" value="1" /> <span><?php _e( 'Create an account?', 'woocommerce' ); ?></span>
			</label>
		</p>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

	<?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

		<div class="create-account">
			<?php foreach ( $checkout->get_checkout_fields( 'account' )  as $key => $field ) : ?>
				<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
			<?php endforeach; ?>
			<div class="clear"></div>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
<?php endif; ?>
</div>


<div class="woocommerce-billing-fields">
	<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h3><?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h3>

	<?php else : ?>

		<h3><?php _e( 'Billing details', 'woocommerce' ); ?></h3>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<div class="woocommerce-billing-fields__field-wrapper">
		<?php foreach ( $checkout->get_checkout_fields( 'billing' ) as $key => $field ) : ?>
			<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
		<?php endforeach; ?>
	</div>

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
</div>
