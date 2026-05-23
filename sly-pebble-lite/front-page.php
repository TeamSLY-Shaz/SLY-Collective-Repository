<?php
if (!defined('ABSPATH')) {
	exit;
}

get_header();

$hero_kicker    = '> NO CHAFE. NO COMPROMISE. NO EXCEPTIONS.';
$hero_title     = 'STOP ADJUSTING. START LIVING.';
$hero_text      = 'Pouch Underwear built for the way men actually move.';
$hero_cta_label = get_theme_mod('sly_hero_cta_label', 'Shop Best Sellers');
$hero_cta_url   = get_theme_mod('sly_hero_cta_url', home_url('/shop'));
$hero_image_id  = absint(get_theme_mod('sly_hero_image'));

$interactive_defaults = array(
	array(
		'id'         => 'travel',
		'label'      => 'Travel Underwear',
		'kicker'     => 'Travel Collection',
		'title'      => 'Built To Move Through Every Trip',
		'text'       => 'Pack-light comfort with anti-chafe support, breathable fabric, and fit that holds all day in transit.',
		'link_label' => 'Shop Travel Underwear',
		'url'        => home_url('/product-category/men-underwear/pocket-underwear/'),
		'image'      => get_template_directory_uri() . '/assets/images/interactive/travel.svg',
	),
	array(
		'id'         => 'urologist',
		'label'      => 'Urologist Recommended',
		'kicker'     => 'Expert Approved',
		'title'      => 'Support Science, Not Compression',
		'text'       => 'Structured pouch support and airflow-first construction designed to reduce pressure and daily discomfort.',
		'link_label' => 'Explore Recommended Styles',
		'url'        => home_url('/product-category/men-underwear/mens-pouch-underwear/'),
		'image'      => get_template_directory_uri() . '/assets/images/interactive/urologist.svg',
	),
	array(
		'id'         => 'pouch',
		'label'      => 'Pouch Underwear',
		'kicker'     => 'Pouch Collection',
		'title'      => 'Room In Front. Stability Everywhere Else.',
		'text'       => 'Engineered pouch geometry eliminates squeeze while keeping everything centered and supported.',
		'link_label' => 'Shop Pouch Underwear',
		'url'        => home_url('/product-category/men-underwear/mens-pouch-underwear/'),
		'image'      => get_template_directory_uri() . '/assets/images/interactive/pouch.svg',
	),
	array(
		'id'         => 'quickdry',
		'label'      => 'Quick-Dry Underwear',
		'kicker'     => 'Quick-Dry Collection',
		'title'      => 'Dry Faster. Stay Ready.',
		'text'       => 'Moisture-wicking performance for heat, workouts, and long days, without bulk or cling.',
		'link_label' => 'Shop Quick-Dry Underwear',
		'url'        => home_url('/product-category/men-underwear/quick-dry-underwear/'),
		'image'      => get_template_directory_uri() . '/assets/images/interactive/quickdry.svg',
	),
);

$interactive_items = array();

foreach ($interactive_defaults as $index => $item_defaults) {
	$item_number = $index + 1;
	$image_id    = absint(get_theme_mod('sly_home_focus_' . $item_number . '_image'));
	$image_url   = $image_id ? wp_get_attachment_image_url($image_id, 'large') : '';

	$interactive_items[] = array(
		'id'         => $item_defaults['id'],
		'label'      => get_theme_mod('sly_home_focus_' . $item_number . '_label', $item_defaults['label']),
		'kicker'     => get_theme_mod('sly_home_focus_' . $item_number . '_kicker', $item_defaults['kicker']),
		'title'      => get_theme_mod('sly_home_focus_' . $item_number . '_title', $item_defaults['title']),
		'text'       => get_theme_mod('sly_home_focus_' . $item_number . '_text', $item_defaults['text']),
		'link_label' => get_theme_mod('sly_home_focus_' . $item_number . '_link_label', $item_defaults['link_label']),
		'url'        => get_theme_mod('sly_home_focus_' . $item_number . '_url', $item_defaults['url']),
		'image'      => $image_url ? $image_url : $item_defaults['image'],
	);
}

$home_category_heading         = get_theme_mod('sly_home_category_heading', 'Explore Categories');
$home_category_chip_1          = get_theme_mod('sly_home_category_chip_1', 'Men');
$home_category_chip_2          = get_theme_mod('sly_home_category_chip_2', 'New');
$home_feature_tiles            = array(
	array(
		'title' => get_theme_mod('sly_home_feature_1_title', 'ANTI-CHAFE. NO RIDE UP.'),
		'text'  => get_theme_mod('sly_home_feature_1_text', 'For blokes who\'ve had enough of the old thigh rub, ball chafe, and constant awkward adjustments.'),
	),
	array(
		'title' => get_theme_mod('sly_home_feature_2_title', 'SUPPORTIVE POUCH'),
		'text'  => get_theme_mod('sly_home_feature_2_text', 'Built to lift, support and keep the boys in their comfort zone — secure, comfortable and ready for workouts, ageing bodies, and recovery days that need a little extra TLC.'),
	),
	array(
		'title' => get_theme_mod('sly_home_feature_3_title', 'ROOM TO BREATHE'),
		'text'  => get_theme_mod('sly_home_feature_3_text', 'Extra space up front means less sticking and less squeezing because downstairs traffic jams are not a vibe.'),
	),
);
$home_best_sellers_heading     = get_theme_mod('sly_home_best_sellers_heading', 'Best Sellers');
$home_best_sellers_cta         = get_theme_mod('sly_home_best_sellers_cta', 'View All');
$home_best_sellers_empty_text  = get_theme_mod('sly_home_best_sellers_empty_text', 'Add products in WooCommerce to populate this section.');
$home_trust_heading            = get_theme_mod('sly_home_trust_heading', 'Comfort You Can Trust');
$home_trust_text               = get_theme_mod('sly_home_trust_text', 'Free AU shipping over $100. Hassle-free returns. Secure checkout with encrypted payments. Thousands of happy customers across Australia.');

$category_placeholder_images = array(
	get_template_directory_uri() . '/assets/images/categories/category-1.svg',
	get_template_directory_uri() . '/assets/images/categories/category-2.svg',
	get_template_directory_uri() . '/assets/images/categories/category-3.svg',
	get_template_directory_uri() . '/assets/images/categories/category-4.svg',
	get_template_directory_uri() . '/assets/images/categories/category-5.svg',
	get_template_directory_uri() . '/assets/images/categories/category-6.svg',
	get_template_directory_uri() . '/assets/images/categories/category-7.svg',
	get_template_directory_uri() . '/assets/images/categories/category-8.svg',
);

$category_items = array();

if (class_exists('WooCommerce')) {
	$category_terms = get_terms(array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => false,
		'parent'     => 0,
		'number'     => 12,
		'orderby'    => 'count',
		'order'      => 'DESC',
	));

	if (!is_wp_error($category_terms) && !empty($category_terms)) {
		$placeholder_index = 0;

		foreach ($category_terms as $term) {
			if (!($term instanceof WP_Term) || 'uncategorized' === $term->slug) {
				continue;
			}

			$image_id  = absint(get_term_meta($term->term_id, 'thumbnail_id', true));
			$image_url = $image_id ? wp_get_attachment_image_url($image_id, 'woocommerce_thumbnail') : '';

			if (!$image_url) {
				$image_url = $category_placeholder_images[$placeholder_index % count($category_placeholder_images)];
			}

			$term_link = get_term_link($term);
			if (is_wp_error($term_link)) {
				continue;
			}

			$category_items[] = array(
				'name'  => $term->name,
				'count' => absint($term->count),
				'url'   => $term_link,
				'image' => $image_url,
			);

			$placeholder_index++;

			if (count($category_items) >= 12) {
				break;
			}
		}
	}
}

if (empty($category_items)) {
	$fallback_names = array(
		'Boxer Briefs',
		'Trunks',
		'Briefs',
		'Pocket Underwear',
		'Pouch Underwear',
		'Bamboo Underwear',
		'Long Leg',
		'Underwear Packs',
	);

	foreach ($fallback_names as $index => $name) {
		$category_items[] = array(
			'name'  => $name,
			'count' => wp_rand(8, 36),
			'url'   => home_url('/shop'),
			'image' => $category_placeholder_images[$index % count($category_placeholder_images)],
		);
	}
}
?>

<?php
$hero_bg_desktop = get_template_directory_uri() . '/assets/images/hero-model.webp';
$hero_bg_mobile  = get_template_directory_uri() . '/assets/images/hero-model-mobile.webp';
if ($hero_image_id) {
	$hero_bg_desktop = wp_get_attachment_image_url($hero_image_id, 'full') ?: $hero_bg_desktop;
	$hero_bg_mobile  = wp_get_attachment_image_url($hero_image_id, 'large') ?: $hero_bg_mobile;
}
?>
<section class="hero-full" style="background-image:url('<?php echo esc_url($hero_bg_desktop); ?>');" data-reveal>
	<div class="hero-full__overlay"></div>
	<div class="hero-full__content container">
		<p class="hero__kicker"><?php echo esc_html($hero_kicker); ?></p>
		<h1><span class="hero__arrow">&rsaquo;</span> STOP ADJUSTING.<br/><span class="hero__arrow">&rsaquo;</span> START LIVING.</h1>
		<p class="hero__text"><?php echo esc_html($hero_text); ?></p>
		<div class="hero__actions">
			<a class="sly-button" href="<?php echo esc_url($hero_cta_url); ?>"><?php echo esc_html($hero_cta_label); ?></a>
			<a class="sly-button sly-button--ghost hero-ghost" href="<?php echo esc_url(get_theme_mod('sly_hero_cta2_url', home_url('/about-us'))); ?>"><?php echo esc_html(get_theme_mod('sly_hero_cta2_label', 'Why SLY?')); ?></a>
		</div>
	</div>
</section>

<!-- Hidden until images/content are ready -->
<?php if (false) : ?>
<section class="interactive-focus container" data-interactive-focus data-reveal>
	<div class="interactive-focus__media">
		<div class="interactive-focus__image-wrap">
			<img
				src="<?php echo esc_url($interactive_items[3]['image']); ?>"
				alt="<?php echo esc_attr($interactive_items[3]['label']); ?>"
				data-focus-image
				loading="lazy"
				decoding="async"
			/>
		</div>
		<div class="interactive-focus__overlay">
			<p class="interactive-focus__kicker" data-focus-kicker><?php echo esc_html($interactive_items[3]['kicker']); ?></p>
			<h3 class="interactive-focus__title" data-focus-title><?php echo esc_html($interactive_items[3]['title']); ?></h3>
			<a class="interactive-focus__cta" href="<?php echo esc_url($interactive_items[3]['url']); ?>" data-focus-link><?php echo esc_html($interactive_items[3]['link_label']); ?></a>
		</div>
	</div>
	<div class="interactive-focus__panel">
		<div class="interactive-focus__links" role="tablist" aria-label="<?php esc_attr_e('Explore underwear focus links', 'sly-pebble-lite'); ?>">
			<?php foreach ($interactive_items as $index => $item) : ?>
				<button
					type="button"
					class="interactive-focus__trigger<?php echo 3 === $index ? ' is-active' : ''; ?>"
					role="tab"
					aria-selected="<?php echo 3 === $index ? 'true' : 'false'; ?>"
					data-focus-trigger
					data-image="<?php echo esc_url($item['image']); ?>"
					data-kicker="<?php echo esc_attr($item['kicker']); ?>"
					data-title="<?php echo esc_attr($item['title']); ?>"
					data-link="<?php echo esc_url($item['url']); ?>"
					data-link-label="<?php echo esc_attr($item['link_label']); ?>"
					data-summary="<?php echo esc_attr($item['text']); ?>"
					data-alt="<?php echo esc_attr($item['label']); ?>"
				>
					<?php echo esc_html($item['label']); ?>
				</button>
			<?php endforeach; ?>
		</div>
		<div class="interactive-focus__summary">
			<h3 data-focus-summary-title><?php echo esc_html($interactive_items[3]['kicker']); ?></h3>
			<p data-focus-summary-text><?php echo esc_html($interactive_items[3]['text']); ?></p>
		</div>
	</div>
</section>

<section class="category-carousel container" data-carousel-shell data-reveal>
	<div class="category-carousel__head">
		<h2><?php echo esc_html($home_category_heading); ?></h2>
		<div class="category-carousel__chips" aria-hidden="true">
			<span class="is-active"><?php echo esc_html($home_category_chip_1); ?></span>
			<span><?php echo esc_html($home_category_chip_2); ?></span>
		</div>
	</div>

	<div class="category-carousel__viewport" data-carousel>
		<div class="category-carousel__track">
			<?php foreach ($category_items as $item) : ?>
				<article class="category-carousel__item">
					<a class="category-carousel__item-link" href="<?php echo esc_url($item['url']); ?>">
						<div class="category-carousel__thumb">
							<img
								src="<?php echo esc_url($item['image']); ?>"
								alt="<?php echo esc_attr($item['name']); ?>"
								loading="lazy"
								decoding="async"
							/>
						</div>
						<div class="category-carousel__meta">
							<h3><?php echo esc_html($item['name']); ?></h3>
							<span><?php echo esc_html($item['count']); ?></span>
						</div>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="category-carousel__footer">
		<div class="category-carousel__progress">
			<span data-carousel-progress></span>
		</div>
		<div class="category-carousel__controls">
			<button type="button" class="category-carousel__button" data-carousel-prev aria-label="<?php esc_attr_e('Previous categories', 'sly-pebble-lite'); ?>">&#8249;</button>
			<button type="button" class="category-carousel__button" data-carousel-next aria-label="<?php esc_attr_e('Next categories', 'sly-pebble-lite'); ?>">&#8250;</button>
		</div>
	</div>
</section>
<?php endif; ?>

<?php $benefits_img = get_template_directory_uri() . '/assets/images/benefits/'; ?>
<section class="sly-benefits container" data-reveal>
	<div class="sly-benefits__box">
		<div class="sly-benefits__grid">
			<div class="sly-benefit" data-reveal>
				<div class="sly-benefit__note">
					<img src="<?php echo esc_url($benefits_img . 'no-ball-chafe.webp'); ?>" alt="No ball-chafe. EVER!" width="400" height="391" loading="lazy" decoding="async">
				</div>
				<p class="sly-benefit__desc">Cleverly designed inner pouch that separates. No leg contact. No chafe ever again.</p>
			</div>
			<div class="sly-benefit" data-reveal>
				<div class="sly-benefit__note">
					<img src="<?php echo esc_url($benefits_img . 'more-space.webp'); ?>" alt="More space... like a man-cave for your balls" width="400" height="383" loading="lazy" decoding="async">
				</div>
				<p class="sly-benefit__desc">Nothing worse than tight sweaty spaces. Our pouch rolls out the red carpet to spacious comfort.</p>
			</div>
			<div class="sly-benefit" data-reveal>
				<div class="sly-benefit__note">
					<img src="<?php echo esc_url($benefits_img . 'support.webp'); ?>" alt="Support. Especially during exercise" width="400" height="402" loading="lazy" decoding="async">
				</div>
				<p class="sly-benefit__desc">Proper structured scrotum support that keeps everything in place and reduces discomfort.</p>
			</div>
			<div class="sly-benefit" data-reveal>
				<div class="sly-benefit__note">
					<img src="<?php echo esc_url($benefits_img . 'sperm-health.webp'); ?>" alt="A better chance of healthier sperm" width="400" height="384" loading="lazy" decoding="async">
				</div>
				<p class="sly-benefit__desc">Prevent overheating. Regulates temperature. A crucial factor for the healthiest swimmers.</p>
			</div>
		</div>
	</div>
</section>

<?php if (class_exists('WooCommerce')) : ?>
	<section class="container product-strip">
		<div class="section-head" data-reveal>
			<h2><?php echo esc_html($home_best_sellers_heading); ?></h2>
			<a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"><?php echo esc_html($home_best_sellers_cta); ?></a>
		</div>
		<div class="product-grid">
			<?php
			$products = wc_get_products(array(
				'limit'      => 8,
				'status'     => 'publish',
				'orderby'    => 'date',
				'order'      => 'DESC',
				'visibility' => 'visible',
			));

			if (!empty($products)) {
				foreach ($products as $product) {
					sly_pebble_lite_product_card($product->get_id());
				}
			} else {
				echo '<p>' . esc_html($home_best_sellers_empty_text) . '</p>';
			}
			?>
		</div>
	</section>
<?php endif; ?>

<!-- ── Pouch comparison ──────────────────────────────────────────────────── -->
<style>
.sly-pouch-wrap{width:70%;max-width:900px;margin:2rem auto;display:grid;grid-template-columns:1fr 1fr;gap:0.75rem}
.sly-pouch-wrap img{width:100%;height:auto;display:block}
@media(max-width:600px){.sly-pouch-wrap{grid-template-columns:1fr}}
</style>
<div class="sly-pouch-wrap">
	<img src="https://slycollective.com/wp-content/uploads/2026/05/Old-Pouch-1-copy-2.jpg" alt="Old Pouch — standard construction">
	<img src="https://slycollective.com/wp-content/uploads/2026/05/Old-Pouch-1-copy.jpg" alt="New Pouch — SLY construction">
</div>

<section class="feature-tiles container">
	<?php foreach ($home_feature_tiles as $feature_tile) : ?>
		<article class="feature-tile" data-reveal>
			<h2><?php echo esc_html($feature_tile['title']); ?></h2>
			<p><?php echo esc_html($feature_tile['text']); ?></p>
		</article>
	<?php endforeach; ?>
</section>

<section class="container social-proof-bar" data-reveal>
	<div class="social-proof-bar__item">
		<span class="social-proof-bar__icon">&#9733;</span>
		<span class="social-proof-bar__stat"><?php echo esc_html(get_theme_mod('sly_proof_rating', '4.8/5')); ?></span>
		<span class="social-proof-bar__label"><?php echo esc_html(get_theme_mod('sly_proof_rating_label', 'Average Rating')); ?></span>
	</div>
	<div class="social-proof-bar__item">
		<span class="social-proof-bar__icon">&#10003;</span>
		<span class="social-proof-bar__stat"><?php echo esc_html(get_theme_mod('sly_proof_customers', '12,000+')); ?></span>
		<span class="social-proof-bar__label"><?php echo esc_html(get_theme_mod('sly_proof_customers_label', 'Happy Customers')); ?></span>
	</div>
	<div class="social-proof-bar__item">
		<span class="social-proof-bar__icon">&#128230;</span>
		<span class="social-proof-bar__stat"><?php echo esc_html(get_theme_mod('sly_proof_dispatch', '1-2 Days')); ?></span>
		<span class="social-proof-bar__label"><?php echo esc_html(get_theme_mod('sly_proof_dispatch_label', 'Fast Dispatch')); ?></span>
	</div>
	<div class="social-proof-bar__item">
		<span class="social-proof-bar__icon">&#8617;</span>
		<span class="social-proof-bar__stat"><?php echo esc_html(get_theme_mod('sly_proof_returns', '30 Days')); ?></span>
		<span class="social-proof-bar__label"><?php echo esc_html(get_theme_mod('sly_proof_returns_label', 'Easy Returns')); ?></span>
	</div>
</section>

<section class="container trust-band" data-reveal>
	<h2><?php echo esc_html($home_trust_heading); ?></h2>
	<p><?php echo esc_html($home_trust_text); ?></p>
</section>

<?php if ( false ) : /* email capture hidden — SMTP not configured */ ?>
<section class="container sly-email-capture" data-reveal>
	<div class="sly-email-capture__copy">
		<h2><?php echo esc_html(get_theme_mod('sly_email_heading', 'Get 10% Off Your First Order')); ?></h2>
		<p><?php echo esc_html(get_theme_mod('sly_email_text', 'Join the SLY crew for exclusive drops, deals, and comfort tips. Unsubscribe anytime.')); ?></p>
	</div>
	<div class="sly-email-capture__form-wrap">
		<?php
		$wpforms_id = get_theme_mod('sly_email_wpforms_id', '');
		if ($wpforms_id && function_exists('wpforms_display')) {
			wpforms_display($wpforms_id, true, true);
		} elseif ($wpforms_id && shortcode_exists('wpforms')) {
			echo do_shortcode('[wpforms id="' . absint($wpforms_id) . '" title="false" description="false"]');
		} else {
			echo '<p class="sly-email-capture__setup">' . esc_html__('Create a WPForms email form, then enter the form ID in Customize → SLY Homepage → Email Capture Form ID.', 'sly-pebble-lite') . '</p>';
		}
		?>
	</div>
</section>
<?php endif; ?>

<?php
get_footer();
