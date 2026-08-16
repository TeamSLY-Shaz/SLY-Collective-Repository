<?php
/**
 * Empty Cart (SLY override)
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package SLY Pebble Lite
 * @version 9.7.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="sly-cart-empty" data-reveal>
	<div class="sly-cart-empty__icon" aria-hidden="true">🩲</div>
	<h1 class="sly-cart-empty__title"><?php esc_html_e( 'Your Cart Is Feeling Pretty Bare', 'sly-pebble-lite' ); ?></h1>
	<p class="sly-cart-empty__sub"><?php esc_html_e( "No pouch underwear in here yet — and honestly, that's a crime against comfort. Let's fix that.", 'sly-pebble-lite' ); ?></p>
	<a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>" class="sly-cart-empty__btn">
		<?php esc_html_e( 'Start Shopping', 'sly-pebble-lite' ); ?>
	</a>
</div>
