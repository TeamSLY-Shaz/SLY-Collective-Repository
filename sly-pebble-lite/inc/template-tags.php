<?php
if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('sly_pebble_lite_fallback_menu')) {
	function sly_pebble_lite_fallback_menu() {
		echo '<ul class="nav-list">';
		echo '<li><a href="' . esc_url(home_url('/shop')) . '">Shop</a></li>';
		echo '<li><a href="' . esc_url(home_url('/product-category/men-underwear/')) . '">Men Underwear</a></li>';
		echo '<li><a href="' . esc_url(home_url('/about-us')) . '">About</a></li>';
		echo '<li><a href="' . esc_url(home_url('/contact')) . '">Contact</a></li>';
		echo '</ul>';
	}
}

if (!function_exists('sly_pebble_lite_product_card')) {
	/**
	 * Render a lightweight product card with ratings and urgency.
	 *
	 * @param int $product_id Product ID.
	 */
	function sly_pebble_lite_product_card($product_id) {
		$product = wc_get_product($product_id);
		if (!$product) {
			return;
		}

		$image_id = $product->get_image_id();
		$image    = $image_id ? wp_get_attachment_image($image_id, 'sly_product_card', false, array('loading' => 'lazy')) : wc_placeholder_img('sly_product_card');

		$rating_count = $product->get_rating_count();
		$avg_rating   = (float) $product->get_average_rating();

		$stock_badge = '';
		if ($product->managing_stock()) {
			$qty = (int) $product->get_stock_quantity();
			if ($qty > 0 && $qty <= 5) {
				$stock_badge = sprintf(__('Only %d left', 'sly-pebble-lite'), $qty);
			} elseif ($qty > 5 && $qty <= 15) {
				$stock_badge = __('Selling fast', 'sly-pebble-lite');
			}
		}
		?>
		<article class="sly-product-card" data-reveal>
			<a class="sly-product-card__media" href="<?php echo esc_url(get_permalink($product_id)); ?>">
				<?php echo wp_kses_post($image); ?>
				<?php if ('' !== $stock_badge) : ?>
					<span class="sly-product-card__badge"><?php echo esc_html($stock_badge); ?></span>
				<?php endif; ?>
			</a>
			<div class="sly-product-card__body">
				<h3 class="sly-product-card__title"><a href="<?php echo esc_url(get_permalink($product_id)); ?>"><?php echo esc_html($product->get_name()); ?></a></h3>
				<?php if ($rating_count > 0) : ?>
					<div class="sly-product-card__rating">
						<span class="sly-stars" aria-label="<?php echo esc_attr(sprintf(__('Rated %s out of 5', 'sly-pebble-lite'), number_format($avg_rating, 1))); ?>">
							<?php echo wp_kses_post(sly_pebble_lite_star_html($avg_rating)); ?>
						</span>
						<span class="sly-rating-count">(<?php echo esc_html($rating_count); ?>)</span>
					</div>
				<?php endif; ?>
				<p class="sly-product-card__price"><?php echo wp_kses_post($product->get_price_html()); ?></p>
				<a class="sly-button sly-button--ghost" href="<?php echo esc_url(get_permalink($product_id)); ?>"><?php esc_html_e('View', 'sly-pebble-lite'); ?></a>
			</div>
		</article>
		<?php
	}
}

if (!function_exists('sly_pebble_lite_star_html')) {
	/**
	 * Return inline SVG star markup for a given rating.
	 *
	 * @param float $rating Average rating (0-5).
	 * @return string HTML string of 5 stars.
	 */
	function sly_pebble_lite_star_html($rating) {
		$html = '';
		for ($i = 1; $i <= 5; $i++) {
			if ($rating >= $i) {
				$html .= '<svg class="sly-star sly-star--full" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
			} elseif ($rating >= $i - 0.5) {
				$html .= '<svg class="sly-star sly-star--half" width="14" height="14" viewBox="0 0 24 24" aria-hidden="true"><defs><linearGradient id="half' . $i . '"><stop offset="50%" stop-color="currentColor"/><stop offset="50%" stop-color="transparent"/></linearGradient></defs><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="url(#half' . $i . ')" stroke="currentColor" stroke-width="1"/></svg>';
			} else {
				$html .= '<svg class="sly-star sly-star--empty" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
			}
		}
		return $html;
	}
}
