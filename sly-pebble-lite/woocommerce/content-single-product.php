<?php
/**
 * Custom single product layout for SLY Pebble Lite.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package sly-pebble-lite
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

do_action('woocommerce_before_single_product');

if (post_password_required()) {
	echo get_the_password_form();
	return;
}

if (!$product instanceof WC_Product || !$product->is_visible()) {
	return;
}

$main_image_id = $product->get_image_id();
$gallery_ids   = $product->get_gallery_image_ids();
$image_ids     = array_values(array_unique(array_filter(array_merge(array($main_image_id), $gallery_ids))));

if (empty($image_ids)) {
	$image_ids = array(0);
}

$display_attribute_label = '';
$display_attribute_value = '';
$materials_value         = '';

foreach ($product->get_attributes() as $attribute) {
	if (!$attribute->get_visible()) {
		continue;
	}

	$name  = $attribute->get_name();
	$label = wc_attribute_label($name);

	if ($attribute->is_taxonomy()) {
		$values = wc_get_product_terms($product->get_id(), $name, array('fields' => 'names'));
	} else {
		$values = $attribute->get_options();
	}

	if (empty($values)) {
		continue;
	}

	$value = implode(', ', array_map('wc_clean', $values));

	if ('' === $display_attribute_value) {
		$display_attribute_label = $label;
		$display_attribute_value = $value;
	}

	if (false !== stripos($label, 'material')) {
		$materials_value = $value;
	}
}

$color_reference = strtolower($display_attribute_value);
$swatch_color    = '#6c7f96';

if (false !== strpos($color_reference, 'black')) {
	$swatch_color = '#232323';
} elseif (false !== strpos($color_reference, 'blue') || false !== strpos($color_reference, 'navy')) {
	$swatch_color = '#4e7399';
} elseif (false !== strpos($color_reference, 'green')) {
	$swatch_color = '#648069';
} elseif (false !== strpos($color_reference, 'red')) {
	$swatch_color = '#a35353';
} elseif (false !== strpos($color_reference, 'grey') || false !== strpos($color_reference, 'gray')) {
	$swatch_color = '#7f7f82';
}

$stock_warning = '';

if ($product->managing_stock()) {
	$stock_quantity = (int) $product->get_stock_quantity();
	if ($stock_quantity > 0 && $stock_quantity <= 10) {
		/* translators: %d: stock quantity */
		$stock_warning = sprintf(__('Only %d items in stock!', 'sly-pebble-lite'), $stock_quantity);
	}
}

$related_ids = wc_get_related_products($product->get_id(), 3);
if (empty($related_ids)) {
	$fallback_products = wc_get_products(array(
		'limit'   => 3,
		'exclude' => array($product->get_id()),
		'orderby' => 'date',
		'order'   => 'DESC',
		'status'  => 'publish',
	));
	$related_ids = wp_list_pluck($fallback_products, 'id');
}

// Product video
$sly_video_mp4    = get_post_meta($product->get_id(), '_sly_video_mp4', true);
$sly_video_webm   = get_post_meta($product->get_id(), '_sly_video_webm', true);
$sly_video_poster = get_post_meta($product->get_id(), '_sly_video_poster', true);
$sly_video_pos    = get_post_meta($product->get_id(), '_sly_video_position', true);
$sly_has_video    = !empty($sly_video_mp4);

if ('' === $sly_video_pos) {
	$sly_video_pos = '1';
}
?>

<article id="product-<?php the_ID(); ?>" <?php wc_product_class('sly-product-layout', $product); ?>>
	<section class="sly-product-top">
		<?php
		/**
		 * Build gallery items array — images + optional video at chosen position.
		 * Each item: [ 'type' => 'image'|'video', 'id' => attachment_id, ... ]
		 */
		$gallery_items = array();
		foreach ($image_ids as $image_id) {
			$gallery_items[] = array('type' => 'image', 'id' => $image_id);
		}

		if ($sly_has_video) {
			$video_item = array(
				'type'   => 'video',
				'mp4'    => $sly_video_mp4,
				'webm'   => $sly_video_webm,
				'poster' => $sly_video_poster,
			);
			if ('0' === $sly_video_pos) {
				array_unshift($gallery_items, $video_item);
			} elseif ('last' === $sly_video_pos) {
				$gallery_items[] = $video_item;
			} else {
				$insert_pos = min((int) $sly_video_pos, count($gallery_items));
				array_splice($gallery_items, $insert_pos, 0, array($video_item));
			}
		}
		?>
		<div class="sly-product-gallery" data-product-gallery>
			<div class="sly-product-thumbs">
				<?php foreach ($gallery_items as $gi_index => $gi_item) : ?>
					<?php $target_id = 'sly-product-image-' . (string) $gi_index; ?>
					<?php if ('video' === $gi_item['type']) : ?>
						<a href="#<?php echo esc_attr($target_id); ?>" class="sly-product-thumb sly-product-thumb--video<?php echo 0 === $gi_index ? ' is-active' : ''; ?>" data-gallery-thumb>
							<?php if (!empty($gi_item['poster'])) : ?>
								<img src="<?php echo esc_url($gi_item['poster']); ?>" alt="<?php esc_attr_e('Product video', 'sly-pebble-lite'); ?>" loading="lazy" width="100" height="100">
							<?php endif; ?>
							<span class="sly-thumb-play" aria-hidden="true">&#9654;</span>
						</a>
					<?php else : ?>
						<?php
						$thumb_markup = $gi_item['id']
							? wp_get_attachment_image($gi_item['id'], 'woocommerce_gallery_thumbnail', false, array('loading' => 'lazy'))
							: wc_placeholder_img('woocommerce_thumbnail');
						?>
						<a href="#<?php echo esc_attr($target_id); ?>" class="sly-product-thumb<?php echo 0 === $gi_index ? ' is-active' : ''; ?>" data-gallery-thumb>
							<?php echo wp_kses_post($thumb_markup); ?>
						</a>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>

			<div class="sly-product-image-stack" data-product-image-stack>
				<?php foreach ($gallery_items as $gi_index => $gi_item) : ?>
					<?php $target_id = 'sly-product-image-' . (string) $gi_index; ?>
					<?php if ('video' === $gi_item['type']) : ?>
						<figure id="<?php echo esc_attr($target_id); ?>" class="sly-product-image sly-product-image--video<?php echo 0 === $gi_index ? ' is-active' : ''; ?>" data-gallery-image data-is-video>
							<video class="sly-gallery-video" autoplay muted loop playsinline preload="metadata"
								<?php if (!empty($gi_item['poster'])) : ?>poster="<?php echo esc_url($gi_item['poster']); ?>"<?php endif; ?>>
								<?php if (!empty($gi_item['webm'])) : ?>
									<source src="<?php echo esc_url($gi_item['webm']); ?>" type="video/webm">
								<?php endif; ?>
								<source src="<?php echo esc_url($gi_item['mp4']); ?>" type="video/mp4">
							</video>
						</figure>
					<?php else : ?>
						<?php
						$image = $gi_item['id']
							? wp_get_attachment_image($gi_item['id'], 'woocommerce_single', false, array('loading' => 0 === $gi_index ? 'eager' : 'lazy'))
							: wc_placeholder_img('woocommerce_single');
						?>
						<figure id="<?php echo esc_attr($target_id); ?>" class="sly-product-image<?php echo 0 === $gi_index ? ' is-active' : ''; ?>" data-gallery-image>
							<?php echo wp_kses_post($image); ?>
						</figure>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>

		<aside class="sly-product-summary">
			<div class="sly-product-breadcrumb">
				<?php
				woocommerce_breadcrumb(array(
					'delimiter'   => ' / ',
					'wrap_before' => '<nav aria-label="' . esc_attr__('Breadcrumb', 'sly-pebble-lite') . '">',
					'wrap_after'  => '</nav>',
				));
				?>
			</div>

			<h1 class="sly-product-title"><?php the_title(); ?></h1>
			<p class="sly-product-price"><?php echo wp_kses_post($product->get_price_html()); ?></p>

			<?php
			$rating_count = $product->get_rating_count();
			$avg_rating   = (float) $product->get_average_rating();
			if ($rating_count > 0 && function_exists('sly_pebble_lite_star_html')) :
			?>
				<div class="sly-product-rating">
					<span class="sly-stars"><?php echo wp_kses_post(sly_pebble_lite_star_html($avg_rating)); ?></span>
					<span class="sly-product-rating__text">
						<?php echo esc_html(number_format($avg_rating, 1)); ?>
						(<?php echo esc_html(sprintf(_n('%d review', '%d reviews', $rating_count, 'sly-pebble-lite'), $rating_count)); ?>)
					</span>
				</div>
			<?php endif; ?>

			<?php
			$short_description = preg_replace('/\[1_2_3_u_pouch[^\]]*\]/i', '', (string) $product->get_short_description());
			$short_description = null === $short_description ? '' : $short_description;
			$short_description = trim($short_description);
			?>
			<?php if ('' !== $short_description) : ?>
				<div class="sly-product-excerpt">
					<?php echo wp_kses_post(wpautop($short_description)); ?>
				</div>
			<?php endif; ?>



			<?php if ('' !== $stock_warning) : ?>
				<p class="sly-stock-warning"><?php echo esc_html($stock_warning); ?></p>
			<?php endif; ?>

			<div class="sly-size-guide-row">
				<?php
				$has_size_attribute = false;
				foreach ($product->get_attributes() as $attr) {
					if ($attr->get_visible() && false !== stripos(wc_attribute_label($attr->get_name()), 'size')) {
						$has_size_attribute = true;
						break;
					}
				}
				if ($has_size_attribute) :
				?>
					<a href="#" class="sly-size-guide-link" data-size-guide aria-haspopup="dialog"><?php esc_html_e('Size Guide', 'sly-pebble-lite'); ?></a>
				<?php endif; ?>
			</div>

			<div class="sly-add-to-cart" data-atc-zone>
				<?php woocommerce_template_single_add_to_cart(); ?>
			</div>

			<div class="sly-product-trust">
				<div><span class="sly-trust-icon" aria-hidden="true">&#10003;</span><?php esc_html_e('Free AU shipping over $100', 'sly-pebble-lite'); ?></div>
				<div><span class="sly-trust-icon" aria-hidden="true">&#8617;</span><?php esc_html_e('Easy returns', 'sly-pebble-lite'); ?></div>
				<div><span class="sly-trust-icon" aria-hidden="true">&#9919;</span><?php esc_html_e('Secure checkout', 'sly-pebble-lite'); ?></div>
			</div>

			<div class="sly-pickup-note">
				<strong><?php esc_html_e('Fast Dispatch from Australia', 'sly-pebble-lite'); ?></strong>
				<span><?php esc_html_e('Usually dispatched within 1-2 business days', 'sly-pebble-lite'); ?></span>
			</div>

			<div class="sly-product-accordion">
				<details open>
					<summary><?php esc_html_e('Product Details', 'sly-pebble-lite'); ?></summary>
					<div class="sly-accordion-content">
						<?php echo wp_kses_post(wpautop($product->get_description() ? $product->get_description() : __('Premium construction and all-day support for daily comfort.', 'sly-pebble-lite'))); ?>
					</div>
				</details>
				<details>
					<summary><?php esc_html_e('Materials', 'sly-pebble-lite'); ?></summary>
					<div class="sly-accordion-content">
						<p><?php echo esc_html('' !== $materials_value ? $materials_value : __('Soft-touch fabric blend built for breathability and durability.', 'sly-pebble-lite')); ?></p>
					</div>
				</details>
				<details>
					<summary><?php esc_html_e('Shipping & Returns', 'sly-pebble-lite'); ?></summary>
					<div class="sly-accordion-content">
						<p><?php esc_html_e('Fast dispatch with tracked delivery. Easy return window for unworn items.', 'sly-pebble-lite'); ?></p>
					</div>
				</details>
			</div>

			<section class="sly-complete-look">
				<header>
					<h3><?php esc_html_e('Complete The Look', 'sly-pebble-lite'); ?></h3>
				</header>
				<div class="sly-complete-grid">
					<?php foreach ($related_ids as $related_id) : ?>
						<?php
						$related_product = wc_get_product($related_id);
						if (!$related_product) {
							continue;
						}
						?>
						<article class="sly-complete-item">
							<a href="<?php echo esc_url(get_permalink($related_id)); ?>">
								<?php echo wp_kses_post($related_product->get_image('woocommerce_thumbnail')); ?>
								<h4><?php echo esc_html($related_product->get_name()); ?></h4>
								<p><?php echo wp_kses_post($related_product->get_price_html()); ?></p>
							</a>
						</article>
					<?php endforeach; ?>
				</div>
			</section>
		</aside>
	</section>

	<section class="sly-product-story">
		<div class="sly-product-story__lead">
			<p><?php esc_html_e('Style & Comfort', 'sly-pebble-lite'); ?></p>
			<h2>
				<span><?php esc_html_e('Cheeky by nature.', 'sly-pebble-lite'); ?></span>
				<span><?php esc_html_e('Obsessed with comfort.', 'sly-pebble-lite'); ?></span>
				<span><?php esc_html_e('Proudly Aussie.', 'sly-pebble-lite'); ?></span>
			</h2>
		</div>
		<div class="sly-product-story__details">
			<details open>
				<summary><?php esc_html_e('Specific Features', 'sly-pebble-lite'); ?></summary>
				<div class="sly-accordion-content">
					<ul>
						<li><?php esc_html_e('Snug but flexible waistband for secure movement.', 'sly-pebble-lite'); ?></li>
						<li><?php esc_html_e('Breathable fabric structure with all-day comfort.', 'sly-pebble-lite'); ?></li>
						<li><?php esc_html_e('Built for travel, training, and long daily wear.', 'sly-pebble-lite'); ?></li>
					</ul>
				</div>
			</details>
			<details>
				<summary><?php esc_html_e('Care & Cleaning', 'sly-pebble-lite'); ?></summary>
				<div class="sly-accordion-content">
					<p><?php esc_html_e('Cold wash, gentle cycle, line dry for longest lifespan.', 'sly-pebble-lite'); ?></p>
				</div>
			</details>
			<details>
				<summary><?php esc_html_e('Materials', 'sly-pebble-lite'); ?></summary>
				<div class="sly-accordion-content">
					<p><?php echo esc_html('' !== $materials_value ? $materials_value : __('Premium fabric blend selected for softness and stretch recovery.', 'sly-pebble-lite')); ?></p>
				</div>
			</details>
		</div>
	</section>

	<section class="sly-product-banner">
		<div class="sly-product-banner__inner">
			<h3><?php esc_html_e('Offers effortless comfort with a laid-back silhouette that feels inviting.', 'sly-pebble-lite'); ?></h3>
			<a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="sly-button"><?php esc_html_e('Shop Now', 'sly-pebble-lite'); ?></a>
		</div>
	</section>
</article>

<div class="sly-sticky-atc" data-sticky-atc aria-hidden="true">
	<div class="sly-sticky-atc__inner container">
		<div class="sly-sticky-atc__info">
			<span class="sly-sticky-atc__title"><?php echo esc_html($product->get_name()); ?></span>
			<span class="sly-sticky-atc__price"><?php echo wp_kses_post($product->get_price_html()); ?></span>
		</div>
		<?php if ($product->is_type('simple') && $product->is_purchasable() && $product->is_in_stock()) : ?>
			<button type="button" class="sly-button sly-sticky-atc__button" data-sticky-atc-btn data-product-id="<?php echo esc_attr($product->get_id()); ?>"><?php esc_html_e('Add to Cart', 'sly-pebble-lite'); ?></button>
		<?php else : ?>
			<a class="sly-button sly-sticky-atc__button" href="#product-<?php the_ID(); ?>"><?php esc_html_e('Select Options', 'sly-pebble-lite'); ?></a>
		<?php endif; ?>
	</div>
</div>

<?php do_action('woocommerce_after_single_product'); ?>
