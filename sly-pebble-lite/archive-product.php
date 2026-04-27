<?php
/**
 * The Template for displaying product archives.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package sly-pebble-lite
 * @version 8.6.0
 */

defined('ABSPATH') || exit;

get_header();
?>
<section class="container commerce-shell">
	<header class="shop-header" data-reveal>
		<?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
			<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
		<?php endif; ?>
		<?php do_action('woocommerce_archive_description'); ?>
	</header>

	<?php if (woocommerce_product_loop()) : ?>
		<?php do_action('woocommerce_before_shop_loop'); ?>

		<ul class="products sly-shop-grid columns-4">
			<?php while (have_posts()) : the_post(); ?>
				<?php global $product; ?>
				<?php
				$card_video_mp4    = $product ? get_post_meta($product->get_id(), '_sly_video_mp4', true) : '';
				$card_video_webm   = $product ? get_post_meta($product->get_id(), '_sly_video_webm', true) : '';
				$card_video_poster = $product ? get_post_meta($product->get_id(), '_sly_video_poster', true) : '';
				$card_has_video    = !empty($card_video_mp4);
				?>
				<li <?php wc_product_class('product sly-shop-card' . ($card_has_video ? ' sly-shop-card--has-video' : ''), $product); ?> data-reveal>
					<a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="<?php the_permalink(); ?>">
						<div class="sly-shop-card__media">
							<?php
							if ($product) {
								echo $product->get_image('woocommerce_thumbnail');
							}
							?>
							<?php if ($card_has_video) : ?>
								<video class="sly-shop-card__video" muted loop playsinline preload="none"
									<?php if ($card_video_poster) : ?>poster="<?php echo esc_url($card_video_poster); ?>"<?php endif; ?>
									data-card-video>
									<?php if ($card_video_webm) : ?>
										<source data-src="<?php echo esc_url($card_video_webm); ?>" type="video/webm">
									<?php endif; ?>
									<source data-src="<?php echo esc_url($card_video_mp4); ?>" type="video/mp4">
								</video>
							<?php endif; ?>
						</div>
						<h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2>
					</a>
					<span class="price"><?php echo wp_kses_post($product ? $product->get_price_html() : ''); ?></span>
					<?php woocommerce_template_loop_add_to_cart(); ?>
				</li>
			<?php endwhile; ?>
		</ul>

		<?php do_action('woocommerce_after_shop_loop'); ?>
	<?php else : ?>
		<?php do_action('woocommerce_no_products_found'); ?>
	<?php endif; ?>
</section>
<?php
get_footer();
