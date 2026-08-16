<?php
/**
 * Shipping Calculator (SLY override)
 *
 * Adds street address + unit fields inside the calculator form.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package SLY Pebble Lite
 * @version 9.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_shipping_calculator' );
?>

<form class="woocommerce-shipping-calculator" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

	<?php printf( '<a href="#" class="shipping-calculator-button">%s</a>', esc_html__( 'Change address', 'sly-pebble-lite' ) ); ?>

	<section class="shipping-calculator-form" style="display:none;">

		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_country', true ) ) : ?>
			<p class="form-row form-row-wide" id="calc_shipping_country_field">
				<label for="calc_shipping_country"><?php esc_html_e( 'Country / region', 'sly-pebble-lite' ); ?></label>
				<select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state country_select" rel="calc_shipping_state">
					<option value="default"><?php esc_html_e( 'Select a country / region&hellip;', 'sly-pebble-lite' ); ?></option>
					<?php
					foreach ( WC()->countries->get_shipping_countries() as $key => $value ) {
						echo '<option value="' . esc_attr( $key ) . '"' . selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
					}
					?>
				</select>
			</p>
		<?php endif; ?>

		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_state', true ) ) : ?>
			<p class="form-row form-row-wide" id="calc_shipping_state_field">
				<?php
				$current_cc   = WC()->customer->get_shipping_country();
				$current_r    = WC()->customer->get_shipping_state();
				$states       = WC()->countries->get_states( $current_cc );

				if ( is_array( $states ) && empty( $states ) ) :
					?>
					<input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_attr_e( 'State / County', 'sly-pebble-lite' ); ?>" />
				<?php elseif ( is_array( $states ) ) : ?>
					<label for="calc_shipping_state"><?php esc_html_e( 'State', 'sly-pebble-lite' ); ?></label>
					<select name="calc_shipping_state" class="state_select" id="calc_shipping_state" data-placeholder="<?php esc_attr_e( 'State / County', 'sly-pebble-lite' ); ?>">
						<option value=""><?php esc_html_e( 'Select an option&hellip;', 'sly-pebble-lite' ); ?></option>
						<?php
						foreach ( $states as $ckey => $cvalue ) {
							echo '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' . esc_html( $cvalue ) . '</option>';
						}
						?>
					</select>
				<?php else : ?>
					<label for="calc_shipping_state"><?php esc_html_e( 'State', 'sly-pebble-lite' ); ?></label>
					<input type="text" class="input-text" value="<?php echo esc_attr( $current_r ); ?>" placeholder="<?php esc_attr_e( 'State / County', 'sly-pebble-lite' ); ?>" name="calc_shipping_state" id="calc_shipping_state" />
				<?php endif; ?>
			</p>
		<?php endif; ?>

		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', true ) ) : ?>
			<p class="form-row form-row-wide" id="calc_shipping_city_field">
				<label for="calc_shipping_city"><?php esc_html_e( 'Suburb', 'sly-pebble-lite' ); ?></label>
				<input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_city() ); ?>" placeholder="<?php esc_attr_e( 'Suburb', 'sly-pebble-lite' ); ?>" name="calc_shipping_city" id="calc_shipping_city" />
			</p>
		<?php endif; ?>

		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>
			<p class="form-row form-row-wide" id="calc_shipping_postcode_field">
				<label for="calc_shipping_postcode"><?php esc_html_e( 'Postcode', 'sly-pebble-lite' ); ?></label>
				<input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" placeholder="<?php esc_attr_e( 'Postcode', 'sly-pebble-lite' ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
			</p>
		<?php endif; ?>

		<!-- Street address fields INSIDE the form -->
		<p class="form-row form-row-wide" id="calc_shipping_address_1_field">
			<label for="calc_shipping_address_1"><?php esc_html_e( 'Street address', 'sly-pebble-lite' ); ?></label>
			<input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_address_1() ); ?>" placeholder="<?php esc_attr_e( 'Street number and name', 'sly-pebble-lite' ); ?>" name="calc_shipping_address_1" id="calc_shipping_address_1" />
		</p>
		<p class="form-row form-row-wide" id="calc_shipping_address_2_field">
			<label for="calc_shipping_address_2"><?php esc_html_e( 'Unit / Apartment', 'sly-pebble-lite' ); ?></label>
			<input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_address_2() ); ?>" placeholder="<?php esc_attr_e( 'Unit, apartment, suite (optional)', 'sly-pebble-lite' ); ?>" name="calc_shipping_address_2" id="calc_shipping_address_2" />
		</p>

		<p><button type="submit" name="calc_shipping" value="1" class="button"><?php esc_html_e( 'Update', 'sly-pebble-lite' ); ?></button></p>
		<?php wp_nonce_field( 'woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce' ); ?>
	</section>
</form>

<?php do_action( 'woocommerce_after_shipping_calculator' ); ?>
