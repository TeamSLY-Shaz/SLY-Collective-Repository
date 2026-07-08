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
<!-- ── Global homepage Poppins override ──────────────────────────────────── -->
<style>
.home .site-main p,
.home .site-main li,
.home .site-main span:not(.brandmark__primary):not(.brandmark__secondary),
.home .site-main a,
.home .site-main label,
.home .site-main small,
.home .site-main td,
.home .site-main th,
.home .site-main blockquote,
.home .site-main figcaption{font-family:"Poppins",Arial,sans-serif!important}
</style>
<section class="hero-full" style="background-image:url('<?php echo esc_url($hero_bg_desktop); ?>');" data-reveal>
	<div class="hero-full__overlay"></div>
	<div class="hero-full__content container">
		<p class="hero__kicker"><?php echo esc_html($hero_kicker); ?></p>
		<h1 class="hero__title--bold"><span class="hero__line">STOP ADJUSTING.</span><span class="hero__line hero__line--accent">START LIVING.</span></h1>

		<div class="hero__actions">
			<a class="sly-button" href="<?php echo esc_url($hero_cta_url); ?>"><?php echo esc_html($hero_cta_label); ?></a>
			<a class="sly-button sly-button--ghost hero-ghost" href="<?php echo esc_url(get_theme_mod('sly_hero_cta2_url', home_url('/about-us'))); ?>"><?php echo esc_html(get_theme_mod('sly_hero_cta2_label', 'Why SLY?')); ?></a>
		</div>
	</div>
</section>

<!-- ── The Problem section ───────────────────────────────────────────────── -->
<style>
.sly-problem{background:#111;padding:72px 0 32px;font-family:Poppins,Arial,sans-serif}
.sly-problem__eyebrow{margin:0 0 18px;font-size:12px!important;font-weight:700!important;letter-spacing:3px;text-transform:uppercase;color:#FF4419}
.sly-problem__headline{margin:0 0 56px;font-family:"Anton",Impact,"Arial Narrow",sans-serif!important;font-size:clamp(38px,6vw,80px)!important;font-weight:400!important;line-height:1.0!important;letter-spacing:-0.01em!important;text-transform:uppercase!important;color:#fff!important}
.sly-problem__headline .strike{color:#555;text-decoration:line-through;text-decoration-color:#FF4419;text-decoration-thickness:3px}
.sly-problem__grid{display:grid;grid-template-columns:repeat(4,1fr);gap:0;border-top:1px solid rgba(255,255,255,0.1)}
.sly-problem__card{padding:32px 28px;border-right:1px solid rgba(255,255,255,0.1)}
.sly-problem__card:last-child{border-right:none}
.sly-problem__icon{margin-bottom:20px;color:#FF4419;font-size:22px;line-height:1}
.sly-problem__card-title{margin:0 0 10px;font-size:17px!important;font-weight:700!important;line-height:1.25;color:#fff;text-transform:none;letter-spacing:0}
.sly-problem__card-text{margin:0;font-family:"Poppins",Arial,sans-serif!important;font-size:13.5px!important;font-weight:300!important;line-height:1.55;color:#fff!important}
@media(max-width:860px){
  .sly-problem{padding:52px 0 20px}
  .sly-problem__grid{grid-template-columns:repeat(2,1fr)}
  .sly-problem__card{border-right:none;border-bottom:1px solid rgba(255,255,255,0.1);padding:28px 20px}
  .sly-problem__card:nth-child(odd){border-right:1px solid rgba(255,255,255,0.1)}
  .sly-problem__card:nth-last-child(-n+2){border-bottom:none}
}
@media(max-width:480px){
  .sly-problem{padding:40px 0 8px}
  .sly-problem__headline{margin-bottom:36px}
  .sly-problem__grid{grid-template-columns:1fr}
  .sly-problem__card{border-right:none!important;border-bottom:1px solid rgba(255,255,255,0.1);padding:24px 0}
  .sly-problem__card:last-child{border-bottom:none}
}
</style>
<section class="sly-problem">
  <div class="container">
    <p class="sly-problem__eyebrow">The Problem</p>
    <h2 class="sly-problem__headline">Standard Underwear <span class="strike">Lies</span> Fails You.</h2>
    <div class="sly-problem__grid">
      <div class="sly-problem__card">
        <div class="sly-problem__icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
        </div>
        <h3 class="sly-problem__card-title">Skin-on-skin friction</h3>
        <p class="sly-problem__card-text">Everything bunches, sticks and shifts. By midday, you're doing the undie shuffle - and downstairs is officially in crisis.</p>
      </div>
      <div class="sly-problem__card">
        <div class="sly-problem__icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <h3 class="sly-problem__card-title">Trapped heat</h3>
        <p class="sly-problem__card-text">Cotton holds the sweat. Synthetics trap the heat. Either way, the boys are slow-roasting — and performance is off the menu.</p>
      </div>
      <div class="sly-problem__card">
        <div class="sly-problem__icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
        </div>
        <h3 class="sly-problem__card-title">Constant readjusting</h3>
        <p class="sly-problem__card-text">The sneaky crotch shuffle. Everyone does it. Nobody enjoys it. But flat-front pouches leave the boys crammed into economy.</p>
      </div>
      <div class="sly-problem__card">
        <div class="sly-problem__icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg>
        </div>
        <h3 class="sly-problem__card-title">Zero support structure</h3>
        <p class="sly-problem__card-text">Everything dangles. Nothing supports. By 3pm, gravity's running the show — and the chafe won't clock off until your undies do.</p>
      </div>
    </div>
  </div>
</section>

<?php $benefits_img = get_template_directory_uri() . '/assets/images/benefits/'; ?>
<!-- ── Benefits + Product split ───────────────────────────────────────────── -->
<style>
.sly-benefits-split{display:grid;grid-template-columns:1fr 1fr;align-items:stretch;gap:0}
.sly-benefits-split__left{background:#fff;padding:28px 0 28px 28px;box-sizing:border-box;display:flex;align-items:center;justify-content:center}
.sly-benefits-split__right{overflow:hidden;min-height:420px;display:flex;align-items:center;justify-content:flex-start;background:#fff}
.sly-benefits-split__right img{display:block;width:70%;height:auto;object-fit:contain}
.sly-benefits-split .sly-benefits__grid{display:grid;grid-template-columns:1fr 1fr;gap:16px 24px;width:100%;max-width:420px}
.sly-benefits-split .sly-benefit{display:flex;flex-direction:column;align-items:center;text-align:center}
.sly-benefits-split .sly-benefit__note{width:63%;margin:0 auto}
.sly-benefits-split .sly-benefit__note img{display:block;width:100%;height:auto}
.sly-benefits-split .sly-benefit__desc{margin:6px 0 0;font-family:"Poppins",Arial,sans-serif;font-size:12px;font-weight:400;line-height:1.35;color:#444;text-align:center}
@media(max-width:780px){
  .sly-benefits-split{grid-template-columns:1fr}
  .sly-benefits-split__left{padding:16px 12px;justify-content:center}
  .sly-benefits-split__right{min-height:240px;justify-content:center}
  .sly-benefits-split__right img{margin:0 auto}
  .sly-benefits-split .sly-benefits__grid{gap:10px 14px;max-width:100%}
  .sly-benefits-split .sly-benefit__note{width:58%}
  .sly-benefits-split .sly-benefit__desc{font-size:11px;margin-top:4px}
}
@media(max-width:480px){
  .sly-benefits-split__left{padding:12px 8px;justify-content:center}
  .sly-benefits-split .sly-benefits__grid{gap:8px 10px}
  .sly-benefits-split .sly-benefit__note{width:55%}
  .sly-benefits-split .sly-benefit__desc{font-size:10.5px;margin-top:3px}
}
</style>
<?php
$benefits_product_img = get_theme_mod('sly_benefits_product_image', 'https://slycollective.com/wp-content/uploads/2026/07/Pouch-Diagram-2.jpg');
?>
<section class="sly-benefits-split">
  <div class="sly-benefits-split__left">
    <div class="sly-benefits__grid">
      <div class="sly-benefit">
        <div class="sly-benefit__note">
          <img src="<?php echo esc_url($benefits_img . 'no-ball-chafe.webp'); ?>" alt="No ball-chafe. EVER!" width="400" height="391" loading="lazy" decoding="async">
        </div>
        <p class="sly-benefit__desc">Cleverly designed inner pouch that separates. No leg contact. No chafe ever again.</p>
      </div>
      <div class="sly-benefit">
        <div class="sly-benefit__note">
          <img src="<?php echo esc_url($benefits_img . 'more-space.webp'); ?>" alt="More space... like a man-cave for your balls" width="400" height="383" loading="lazy" decoding="async">
        </div>
        <p class="sly-benefit__desc">Nothing worse than tight sweaty spaces. Our pouch rolls out the red carpet to spacious comfort.</p>
      </div>
      <div class="sly-benefit">
        <div class="sly-benefit__note">
          <img src="<?php echo esc_url($benefits_img . 'support.webp'); ?>" alt="Support. Especially during exercise" width="400" height="402" loading="lazy" decoding="async">
        </div>
        <p class="sly-benefit__desc">Proper structured scrotum support that keeps everything in place and reduces discomfort.</p>
      </div>
      <div class="sly-benefit">
        <div class="sly-benefit__note">
          <img src="<?php echo esc_url($benefits_img . 'sperm-health.webp'); ?>" alt="A better chance of healthier sperm" width="400" height="384" loading="lazy" decoding="async">
        </div>
        <p class="sly-benefit__desc">Prevent overheating. Regulates temperature. A crucial factor for the healthiest swimmers.</p>
      </div>
    </div>
  </div>
  <div class="sly-benefits-split__right">
    <img src="<?php echo esc_url($benefits_product_img); ?>" alt="SLY Collective pouch underwear" loading="lazy" decoding="async">
  </div>
</section>

<!-- ── Upgrade section ───────────────────────────────────────────────────── -->
<style>
.sly-upgrade{background:#fff;padding:0 0 64px;font-family:Poppins,Arial,sans-serif;text-align:center}
.sly-upgrade__eyebrow{margin:0 0 18px;font-size:22px!important;font-weight:300!important;letter-spacing:0.08em;text-transform:uppercase;color:#00b8c4!important}
.sly-upgrade__headline{margin:0 0 28px;font-family:"Anton",Impact,"Arial Narrow",sans-serif!important;font-size:clamp(38px,6vw,80px)!important;font-weight:400!important;line-height:1.0!important;letter-spacing:-0.01em!important;text-transform:uppercase!important;color:#000!important;text-align:center!important}
.sly-upgrade__body{margin:0 auto;font-family:"Poppins",Arial,sans-serif!important;font-size:15px!important;font-weight:400!important;line-height:1.4;color:#000!important;max-width:640px;text-align:center}
@media(max-width:860px){.sly-upgrade{padding:0 0 48px}.sly-upgrade__headline{font-size:clamp(32px,7vw,60px)!important}.sly-upgrade__eyebrow{font-size:18px!important}}
@media(max-width:480px){.sly-upgrade{padding:0 0 36px}.sly-upgrade__headline{margin-bottom:20px}.sly-upgrade__eyebrow{font-size:clamp(14px,5vw,18px)!important}}
</style>
<section class="sly-upgrade">
  <div class="container">
    <p class="sly-upgrade__eyebrow">Lifted. Separated. Supported.</p>
    <h2 class="sly-upgrade__headline">Experience the Upgrade for Yourself.</h2>
    <p class="sly-upgrade__body">SLY Collective underwear isn't about fashion. It's about solving a problem that every man has but nobody talks about. Built by Australians, for Australians — and anyone else who's done with discomfort.</p>
  </div>
</section>

<!-- ── Feature pillars ───────────────────────────────────────────────────── -->
<style>
.sly-pillars{background:#111;padding:72px 0;font-family:Poppins,Arial,sans-serif}
.sly-pillars__grid{display:grid;grid-template-columns:repeat(4,1fr);border-top:1px solid rgba(255,255,255,0.08)}
.sly-pillar{padding:36px 28px;border-right:1px solid rgba(255,255,255,0.08);position:relative}
.sly-pillar:last-child{border-right:none}
.sly-pillar__num{position:absolute;top:24px;right:20px;font-size:56px;font-weight:700;line-height:1;color:rgba(180,60,20,0.35);font-family:Poppins,Arial,sans-serif;letter-spacing:-0.02em}
.sly-pillar__title{margin:0 0 16px;font-size:17px!important;font-weight:600!important;color:#fff;line-height:1.25;text-transform:none;letter-spacing:0;padding-right:48px}
.sly-pillar__text{margin:0;font-size:13.5px!important;font-weight:300!important;line-height:1.65;color:rgba(255,255,255,0.5)}
@media(max-width:860px){
  .sly-pillars{padding:52px 0}
  .sly-pillars__grid{grid-template-columns:repeat(2,1fr)}
  .sly-pillar{border-right:none;border-bottom:1px solid rgba(255,255,255,0.08);padding:28px 20px}
  .sly-pillar:nth-child(odd){border-right:1px solid rgba(255,255,255,0.08)}
  .sly-pillar:nth-last-child(-n+2){border-bottom:none}
}
@media(max-width:480px){
  .sly-pillars{padding:40px 0}
  .sly-pillars__grid{grid-template-columns:1fr}
  .sly-pillar{border-right:none!important;border-bottom:1px solid rgba(255,255,255,0.08);padding:24px 0}
  .sly-pillar:last-child{border-bottom:none}
  .sly-pillar__num{font-size:44px;top:16px;right:0}
}
</style>
<section class="sly-pillars">
  <div class="container">
    <div class="sly-pillars__grid">
      <div class="sly-pillar">
        <span class="sly-pillar__num">01</span>
        <h3 class="sly-pillar__title">Separation Technology</h3>
        <p class="sly-pillar__text">The engineered inner pouch creates a dedicated zone for everything to sit — lifted, separated, supported. No leg contact. No friction. No chafe. Ever.</p>
      </div>
      <div class="sly-pillar">
        <span class="sly-pillar__num">02</span>
        <h3 class="sly-pillar__title">Bamboo Performance</h3>
        <p class="sly-pillar__text">95% bamboo viscose. Naturally moisture-wicking. Antibacterial without chemical treatment. Thermo-regulating — keeps you cool in Queensland summers and warm in winter.</p>
      </div>
      <div class="sly-pillar">
        <span class="sly-pillar__num">03</span>
        <h3 class="sly-pillar__title">Built-in Pocket</h3>
        <p class="sly-pillar__text">The only pouch underwear brand with a hidden stash pocket. Keys, cards, emergency cash — kept secure and out of your pockets. Perfect for the gym, travel, or a night out.</p>
      </div>
      <div class="sly-pillar">
        <span class="sly-pillar__num">04</span>
        <h3 class="sly-pillar__title">Australian Made</h3>
        <p class="sly-pillar__text">Proudly manufactured in Australia. Reduced carbon footprint, exceptional quality control, and support for local industry. Some things are worth keeping local.</p>
      </div>
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
		<span class="social-proof-bar__icon">&#128197;</span>
		<span class="social-proof-bar__stat"><?php echo esc_html(get_theme_mod('sly_proof_customers', '20+ Years')); ?></span>
		<span class="social-proof-bar__label"><?php echo esc_html(get_theme_mod('sly_proof_customers_label', 'Est. 2005')); ?></span>
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
