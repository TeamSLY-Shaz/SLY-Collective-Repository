<?php
if (!defined('ABSPATH')) {
	exit;
}

get_header();

// ── Hero vars ────────────────────────────────────────────────────────────────
$hero_kicker    = '> NO CHAFE. NO COMPROMISE. NO EXCEPTIONS.';
$hero_cta_label = get_theme_mod('sly_hero_cta_label', 'Shop Best Sellers');
$hero_cta_url   = get_theme_mod('sly_hero_cta_url', home_url('/shop'));
$hero_image_id  = absint(get_theme_mod('sly_hero_image'));
$hero_bg        = get_template_directory_uri() . '/assets/images/hero-model.webp';
if ($hero_image_id) {
	$hero_bg = wp_get_attachment_image_url($hero_image_id, 'full') ?: $hero_bg;
}

// ── Page vars ────────────────────────────────────────────────────────────────
$home_feature_tiles           = array(
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
$home_best_sellers_heading    = get_theme_mod('sly_home_best_sellers_heading', 'Best Sellers');
$home_best_sellers_cta        = get_theme_mod('sly_home_best_sellers_cta', 'View All');
$home_best_sellers_empty_text = get_theme_mod('sly_home_best_sellers_empty_text', 'Add products in WooCommerce to populate this section.');
$home_trust_heading           = get_theme_mod('sly_home_trust_heading', 'Comfort You Can Trust');
$home_trust_text              = get_theme_mod('sly_home_trust_text', 'Free AU shipping over $100. Hassle-free returns. Secure checkout with encrypted payments. Thousands of happy customers across Australia.');
$benefits_img                 = get_template_directory_uri() . '/assets/images/benefits/';
$benefits_product_img         = get_theme_mod('sly_benefits_product_image', 'https://slycollective.com/wp-content/uploads/2026/07/Pouch-Diagram-2.jpg');
?>

<!-- ── All homepage styles (single block) ───────────────────────────────── -->
<style>
/* Poppins override */
.home .site-main p,.home .site-main li,.home .site-main span:not(.brandmark__primary):not(.brandmark__secondary),.home .site-main a,.home .site-main label,.home .site-main small,.home .site-main td,.home .site-main th,.home .site-main blockquote,.home .site-main figcaption{font-family:"Poppins",Arial,sans-serif!important}
/* Hero title — Anton to match section headlines */
.hero__title--bold,.hero__title--bold .hero__line{font-family:"Anton",Impact,"Arial Narrow",sans-serif!important;font-weight:400!important;letter-spacing:-0.01em!important;text-transform:uppercase!important}
/* Problem section */
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
/* Benefits split */
.sly-benefits-split{display:grid;grid-template-columns:1fr 1fr;align-items:stretch;gap:0}
.sly-benefits-split__left{background:#fff;padding:28px 0 28px 28px;box-sizing:border-box;display:flex;align-items:center;justify-content:center}
.sly-benefits-split__right{overflow:hidden;min-height:420px;display:flex;align-items:center;justify-content:flex-start;background:#fff}
.sly-benefits-split__right img{display:block;width:70%;height:auto;object-fit:contain}
.sly-benefits-split .sly-benefits__grid{display:grid;grid-template-columns:1fr 1fr;gap:16px 24px;width:100%;max-width:420px}
.sly-benefits-split .sly-benefit{display:flex;flex-direction:column;align-items:center;text-align:center}
.sly-benefits-split .sly-benefit__note{width:63%;margin:0 auto}
.sly-benefits-split .sly-benefit__note img{display:block;width:100%;height:auto}
.sly-benefits-split .sly-benefit__desc{margin:6px 0 0;font-family:"Poppins",Arial,sans-serif;font-size:12px;font-weight:400;line-height:1.35;color:#444;text-align:center}
/* Upgrade section */
.sly-upgrade{background:#fff;padding:0 0 64px;font-family:Poppins,Arial,sans-serif;text-align:center}
.sly-upgrade__eyebrow{margin:0 0 18px;font-size:22px!important;font-weight:300!important;letter-spacing:0.08em;text-transform:uppercase;color:#00b8c4!important}
.sly-upgrade__headline{margin:0 0 28px;font-family:"Anton",Impact,"Arial Narrow",sans-serif!important;font-size:clamp(38px,6vw,80px)!important;font-weight:400!important;line-height:1.0!important;letter-spacing:-0.01em!important;text-transform:uppercase!important;color:#000!important;text-align:center!important}
.sly-upgrade__body{margin:0 auto;font-family:"Poppins",Arial,sans-serif!important;font-size:15px!important;font-weight:400!important;line-height:1.4;color:#000!important;max-width:640px;text-align:center}
/* Feature pillars */
.sly-pillars{background:#111;padding:72px 0;font-family:Poppins,Arial,sans-serif}
.sly-pillars__grid{display:grid;grid-template-columns:repeat(4,1fr);border-top:1px solid rgba(255,255,255,0.08)}
.sly-pillar{padding:36px 28px;border-right:1px solid rgba(255,255,255,0.08);position:relative}
.sly-pillar:last-child{border-right:none}
.sly-pillar__num{position:absolute;top:24px;right:20px;font-size:56px;font-weight:700;line-height:1;color:#4E87A0;font-family:Poppins,Arial,sans-serif;letter-spacing:-0.02em}
.sly-pillar__title{margin:0 0 16px;font-size:17px!important;font-weight:600!important;color:#fff;line-height:1.25;text-transform:none;letter-spacing:0;padding-right:48px;padding-bottom:12px;border-bottom:2px solid #4E87A0}
.sly-pillar__text{margin:0;font-size:13.5px!important;font-weight:300!important;line-height:1.65;color:#fff!important}
/* Responsive */
@media(max-width:860px){
  .sly-problem{padding:52px 0 20px}
  .sly-problem__grid{grid-template-columns:repeat(2,1fr)}
  .sly-problem__card{border-right:none;border-bottom:1px solid rgba(255,255,255,0.1);padding:28px 20px}
  .sly-problem__card:nth-child(odd){border-right:1px solid rgba(255,255,255,0.1)}
  .sly-problem__card:nth-last-child(-n+2){border-bottom:none}
  .sly-benefits-split{grid-template-columns:1fr}
  .sly-benefits-split__left{padding:16px 12px;justify-content:center}
  .sly-benefits-split__right{min-height:240px;justify-content:center}
  .sly-benefits-split__right img{margin:0 auto}
  .sly-benefits-split .sly-benefits__grid{gap:10px 14px;max-width:100%}
  .sly-benefits-split .sly-benefit__note{width:58%}
  .sly-benefits-split .sly-benefit__desc{font-size:11px;margin-top:4px}
  .sly-upgrade{padding:0 0 48px}
  .sly-upgrade__headline{font-size:clamp(32px,7vw,60px)!important}
  .sly-upgrade__eyebrow{font-size:18px!important}
  .sly-pillars{padding:52px 0}
  .sly-pillars__grid{grid-template-columns:repeat(2,1fr)}
  .sly-pillar{border-right:none;border-bottom:1px solid rgba(255,255,255,0.08);padding:28px 20px}
  .sly-pillar:nth-child(odd){border-right:1px solid rgba(255,255,255,0.08)}
  .sly-pillar:nth-last-child(-n+2){border-bottom:none}
}
@media(max-width:480px){
  .sly-problem{padding:40px 0 8px}
  .sly-problem__headline{margin-bottom:36px}
  .sly-problem__grid{grid-template-columns:1fr}
  .sly-problem__card{border-right:none!important;border-bottom:1px solid rgba(255,255,255,0.1);padding:24px 0}
  .sly-problem__card:last-child{border-bottom:none}
  .sly-benefits-split__left{padding:12px 8px;justify-content:center}
  .sly-benefits-split .sly-benefits__grid{gap:8px 10px}
  .sly-benefits-split .sly-benefit__note{width:55%}
  .sly-benefits-split .sly-benefit__desc{font-size:10.5px;margin-top:3px}
  .sly-upgrade{padding:0 0 36px}
  .sly-upgrade__headline{margin-bottom:20px}
  .sly-upgrade__eyebrow{font-size:clamp(14px,5vw,18px)!important}
  .sly-pillars{padding:40px 0}
  .sly-pillars__grid{grid-template-columns:1fr}
  .sly-pillar{border-right:none!important;border-bottom:1px solid rgba(255,255,255,0.08);padding:24px 0}
  .sly-pillar:last-child{border-bottom:none}
  .sly-pillar__num{font-size:44px;top:16px;right:0}
}
</style>

<section class="hero-full" style="background-image:url('<?php echo esc_url($hero_bg); ?>');" data-reveal>
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
          <img src="<?php echo esc_url($benefits_img . 'more-space.webp'); ?>" alt="More space like a man-cave for your balls" width="400" height="383" loading="lazy" decoding="async">
        </div>
        <p class="sly-benefit__desc">Nothing worse than tight sweaty spaces. Our pouch rolls out the red carpet to spacious comfort.</p>
      </div>
      <div class="sly-benefit">
        <div class="sly-benefit__note">
          <img src="<?php echo esc_url($benefits_img . 'support.webp'); ?>" alt="Support especially during exercise" width="400" height="402" loading="lazy" decoding="async">
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
    <img src="<?php echo esc_url($benefits_product_img); ?>" alt="SLY Collective adaptive pouch underwear" width="800" height="800" loading="lazy" decoding="async">
  </div>
</section>

<section class="sly-upgrade">
  <div class="container">
    <p class="sly-upgrade__eyebrow">Lifted. Separated. Supported.</p>
    <h2 class="sly-upgrade__headline">Experience the Upgrade for Yourself.</h2>
    <p class="sly-upgrade__body">SLY Collective underwear isn't about fashion. It's about solving a problem that every man has but nobody talks about. Built by Australians, for Australians — and anyone else who's done with discomfort.</p>
  </div>
</section>

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

<?php
get_footer();
