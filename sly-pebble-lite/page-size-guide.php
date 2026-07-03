<?php
/**
 * Template Name: Size Guide
 * Slug: size-guide
 *
 * Automatically used for any page with the slug "size-guide".
 * Serves the size guide at /size_chart/size-guide/
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ── SEO meta & Open Graph ─────────────────────────────────────────────────────
add_action( 'wp_head', function () {
	$canonical = home_url( '/size_chart/size-guide/' );
	?>
	<meta name="description" content="Not sure what size to grab? SLY's size guide sorts it out fast — waist &amp; hip measurements in cm and inches, fit notes for every style, and international sizing for AU, US, UK &amp; EU. Get it right first time.">
	<meta name="robots" content="index, follow">
	<meta property="og:title" content="SLY Size Guide — Find Your Perfect Fit | SLY Collective">
	<meta property="og:description" content="Measure once, order right. SLY Collective's size guide covers pouch underwear, pocket styles &amp; quick-dry ranges — in cm, inches and international sizes.">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?php echo esc_url( $canonical ); ?>">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:title" content="SLY Size Guide — Find Your Perfect Fit">
	<meta name="twitter:description" content="Measure once, order right. SLY's size guide covers every style — in cm, inches, and international sizes.">
	<link rel="canonical" href="<?php echo esc_url( $canonical ); ?>">
	<?php
}, 1 );

// ── FAQ structured data (JSON-LD) ─────────────────────────────────────────────
add_action( 'wp_head', function () {
	$schema = array(
		'@context' => 'https://schema.org',
		'@type'    => 'FAQPage',
		'mainEntity' => array(
			array(
				'@type'          => 'Question',
				'name'           => 'What if I am between two sizes?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => 'Size up, always. SLY underwear is built to be snug but not restrictive. Going up a size means the waistband won\'t dig in and the pouch has room to do its job properly.',
				),
			),
			array(
				'@type'          => 'Question',
				'name'           => 'Do SLY sizes run true to size?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => 'Yes. SLY underwear is engineered to Australian sizing standards. If you normally wear a Large in quality men\'s underwear, you\'ll wear a Large with SLY.',
				),
			),
			array(
				'@type'          => 'Question',
				'name'           => 'Will SLY fabric stretch out after washing?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => 'SLY fabrics are pre-shrunk and wash-stable. Bamboo and microfibre blends soften with wear but hold their shape. Wash cold, hang to dry.',
				),
			),
			array(
				'@type'          => 'Question',
				'name'           => 'What is your returns policy if the fit is not right?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => 'SLY stands behind the fit. If your size isn\'t right, contact the team and we\'ll sort it out.',
				),
			),
		),
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}, 3 );

// ── Page-specific CSS ─────────────────────────────────────────────────────────
add_action( 'wp_head', function () {
	?>
	<style>
	/* ── Size Guide Hero ──────────────────────────────────────────── */
	.sly-sg-hero{background:var(--sly-sand);padding:4.5rem 0 3rem;text-align:center}
	.sly-sg-hero__kicker{font-size:.78rem;font-weight:700;letter-spacing:.16em;color:var(--sly-accent);text-transform:uppercase;margin:0 0 .75rem}
	.sly-sg-hero__title{font-size:clamp(2.2rem,5.5vw,3.8rem)!important;font-weight:900;text-transform:uppercase;color:var(--sly-ink);margin:0 0 1rem;letter-spacing:.04em;line-height:1.1}
	.sly-sg-hero__sub{font-size:1.05rem!important;color:var(--sly-ink);opacity:.78;margin:0;font-weight:300}

	/* ── Intro ────────────────────────────────────────────────────── */
	.sly-sg-intro{max-width:780px;margin-inline:auto;padding-block:3rem 2rem;text-align:center}
	.sly-sg-intro p{font-size:1.05rem!important;line-height:1.75;opacity:.9}

	/* ── How to Measure ───────────────────────────────────────────── */
	.sly-sg-measure{padding-block:2.5rem 3.5rem}
	.sly-sg-measure>h2,.sly-sg-chart>h2,.sly-sg-intl>h2,.sly-sg-fitnotes>h2,.sly-sg-faq>h2{font-size:clamp(1.35rem,3vw,2rem)!important;margin-bottom:1.25rem}
	.sly-sg-measure__grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;margin-top:2rem}
	.sly-sg-measure__step{background:var(--sly-sand);border-radius:var(--sly-radius);padding:2rem 1.5rem}
	.sly-sg-measure__num{font-size:2.8rem;font-weight:900;color:var(--sly-accent);line-height:1;margin-bottom:.75rem;letter-spacing:-.03em}
	.sly-sg-measure__step h3{font-size:.9rem!important;font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin:0 0 .5rem;color:var(--sly-ink)}
	.sly-sg-measure__step p{font-size:.88rem!important;opacity:.82;margin:0;line-height:1.6}

	/* ── Size Tables ──────────────────────────────────────────────── */
	.sly-sg-chart,.sly-sg-intl{padding-block:3rem}
	.sly-sg-chart__note{font-size:.85rem!important;opacity:.65;margin-bottom:1.75rem}
	.sly-sg-table-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch;border-radius:var(--sly-radius-sm);box-shadow:var(--sly-shadow)}
	.sly-sg-table{width:100%;border-collapse:collapse;background:#fff;min-width:520px}
	.sly-sg-table thead{background:var(--sly-ink);color:#fff}
	.sly-sg-table th{padding:.9rem 1.25rem;text-align:left;font-size:.75rem!important;font-weight:700;letter-spacing:.08em;text-transform:uppercase;white-space:nowrap}
	.sly-sg-table td{padding:.85rem 1.25rem;border-bottom:1px solid var(--sly-sand);white-space:nowrap;font-size:.9rem!important;vertical-align:middle}
	.sly-sg-table tbody tr:last-child td{border-bottom:none}
	.sly-sg-table tbody tr:nth-child(even){background:rgba(235,235,235,.45)}
	.sly-sg-table tbody tr:hover{background:rgba(25,126,146,.07);transition:background var(--sly-speed)}
	.sly-sg-table strong{font-weight:700;color:var(--sly-accent);font-size:.95rem}

	/* ── Fit Notes ────────────────────────────────────────────────── */
	.sly-sg-fitnotes{padding-block:3rem}
	.sly-sg-fitnotes__grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1.5rem;margin-top:1.75rem}
	.sly-sg-fitnote{background:var(--sly-sand);border-radius:var(--sly-radius);padding:2rem 1.75rem}
	.sly-sg-fitnote h3{font-size:.92rem!important;font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin:0 0 .75rem;color:var(--sly-ink)}
	.sly-sg-fitnote p{font-size:.9rem!important;opacity:.85;margin:0;line-height:1.65}
	.sly-sg-fitnote a{color:var(--sly-accent);font-weight:600;white-space:nowrap}
	.sly-sg-fitnote a:hover{color:var(--sly-accent-hover)}

	/* ── FAQ ──────────────────────────────────────────────────────── */
	.sly-sg-faq{padding-block:3rem}
	.sly-sg-faq__list{margin-top:1.75rem;display:flex;flex-direction:column;gap:1rem}
	.sly-sg-faq__item{border:1px solid var(--sly-line);border-radius:var(--sly-radius-sm);padding:1.5rem 2rem}
	.sly-sg-faq__item h3{font-size:.92rem!important;font-weight:700;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .5rem;color:var(--sly-ink)}
	.sly-sg-faq__item p{font-size:.9rem!important;opacity:.85;margin:0;line-height:1.65}
	.sly-sg-faq__item a{color:var(--sly-accent);font-weight:600}
	.sly-sg-faq__item a:hover{color:var(--sly-accent-hover)}

	/* ── CTA ──────────────────────────────────────────────────────── */
	.sly-sg-cta{padding-block:4rem}
	.sly-sg-cta__inner{background:var(--sly-ink);color:#fff;border-radius:var(--sly-radius);padding:3.5rem 2.5rem;text-align:center}
	.sly-sg-cta__headline{font-size:clamp(1.6rem,4vw,2.6rem)!important;font-weight:900;text-transform:uppercase;letter-spacing:.04em;margin:0 0 .75rem;color:#fff;line-height:1.15}
	.sly-sg-cta__sub{font-size:1rem!important;opacity:.82;margin:0 0 2rem;color:#fff;font-weight:300}
	.sly-sg-cta__btns{display:flex;gap:1rem;justify-content:center;flex-wrap:wrap}
	.sly-sg-cta__btns .sly-button{background:#fff;color:var(--sly-ink);border:2px solid #fff}
	.sly-sg-cta__btns .sly-button:hover{background:var(--sly-accent);color:#fff;border-color:var(--sly-accent)}
	.sly-sg-cta__btns .sly-button--ghost{background:transparent;color:#fff;border:2px solid rgba(255,255,255,.45)}
	.sly-sg-cta__btns .sly-button--ghost:hover{background:rgba(255,255,255,.12);border-color:#fff}

	/* ── Responsive ───────────────────────────────────────────────── */
	@media(max-width:1080px){
		.sly-sg-measure__grid{grid-template-columns:repeat(2,1fr)}
	}
	@media(max-width:900px){
		.sly-sg-hero{padding:3rem 0 2.25rem}
		.sly-sg-fitnotes__grid{grid-template-columns:1fr}
		.sly-sg-cta__inner{padding:2.75rem 1.75rem}
	}
	@media(max-width:600px){
		.sly-sg-measure__grid{grid-template-columns:1fr}
		.sly-sg-cta__inner{padding:2.25rem 1.25rem}
		/* Card-style responsive table on mobile */
		.sly-sg-table{min-width:0}
		.sly-sg-table thead{display:none}
		.sly-sg-table,.sly-sg-table tbody,.sly-sg-table tr,.sly-sg-table td{display:block;width:100%}
		.sly-sg-table tr{margin-bottom:1rem;border:1px solid var(--sly-sand);border-radius:var(--sly-radius-sm);overflow:hidden}
		.sly-sg-table td{padding:.6rem 1rem;border-bottom:1px solid var(--sly-sand);display:flex;justify-content:space-between;align-items:center;white-space:normal;font-size:.85rem!important;gap:.5rem}
		.sly-sg-table td::before{content:attr(data-label);font-weight:700;font-size:.72rem!important;text-transform:uppercase;letter-spacing:.06em;opacity:.6;flex-shrink:0}
		.sly-sg-table td:first-child{background:var(--sly-ink);justify-content:center}
		.sly-sg-table td:first-child::before{display:none}
		.sly-sg-table td:first-child strong{color:#fff;font-size:1.05rem}
		.sly-sg-table tbody tr:nth-child(even){background:#fff}
		.sly-sg-table td:last-child{border-bottom:none}
	}
	</style>
	<?php
}, 2 );

get_header();
?>

<!-- ── Hero ──────────────────────────────────────────────────────────────── -->
<section class="sly-sg-hero" data-reveal>
	<div class="container">
		<p class="sly-sg-hero__kicker">Your Fit. Your Rules.</p>
		<h1 class="sly-sg-hero__title">SLY Size Guide</h1>
		<p class="sly-sg-hero__sub">No guessing. No returns. Just the right fit — first time.</p>
	</div>
</section>

<!-- ── Intro ─────────────────────────────────────────────────────────────── -->
<section class="container sly-sg-intro" data-reveal>
	<p>Getting the right size isn't rocket science, but getting it wrong is a genuine pain in the arse. SLY underwear is engineered for fit — the pouch needs to sit right, the waistband needs to hold firm, and the whole lot needs to move with you, not against you. Spend 60 seconds with this guide and you'll be sorted.</p>
</section>

<!-- ── How to Measure ────────────────────────────────────────────────────── -->
<section class="container sly-sg-measure" data-reveal>
	<h2>How to Measure Up</h2>
	<div class="sly-sg-measure__grid">

		<div class="sly-sg-measure__step" data-reveal>
			<div class="sly-sg-measure__num">01</div>
			<h3>Grab a Tape Measure</h3>
			<p>Get a flexible measuring tape — the kind a tailor uses. Not a ruler, not a piece of string. An actual fabric tape.</p>
		</div>

		<div class="sly-sg-measure__step" data-reveal>
			<div class="sly-sg-measure__num">02</div>
			<h3>Measure Your Waist</h3>
			<p>Wrap the tape around the narrowest part of your waist, roughly 2–3&nbsp;cm above your belly button. Keep it level, keep it snug — and don't hold your breath.</p>
		</div>

		<div class="sly-sg-measure__step" data-reveal>
			<div class="sly-sg-measure__num">03</div>
			<h3>Measure Your Hips</h3>
			<p>Wrap the tape around the fullest part of your hips and backside. Feet together, standing straight. Note the number down.</p>
		</div>

		<div class="sly-sg-measure__step" data-reveal>
			<div class="sly-sg-measure__num">04</div>
			<h3>Cross-Check the Chart</h3>
			<p>Find your waist below. Sitting between two sizes? Always size up — SLY is built to hug, not strangle.</p>
		</div>

	</div>
</section>

<!-- ── Main Size Chart ───────────────────────────────────────────────────── -->
<section class="container sly-sg-chart" data-reveal>
	<h2>Men's Underwear Size Chart</h2>
	<p class="sly-sg-chart__note">All measurements in centimetres (cm) and inches (in). When in doubt, size up.</p>

	<div class="sly-sg-table-wrap">
		<table class="sly-sg-table" role="table" aria-label="SLY Collective Men's Underwear Size Chart">
			<thead>
				<tr>
					<th scope="col">SLY Size</th>
					<th scope="col">Waist (cm)</th>
					<th scope="col">Waist (in)</th>
					<th scope="col">Hip (cm)</th>
					<th scope="col">Hip (in)</th>
					<th scope="col">AU Clothing</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td data-label="SLY Size"><strong>XS</strong></td>
					<td data-label="Waist (cm)">76–81</td>
					<td data-label="Waist (in)">30–32&Prime;</td>
					<td data-label="Hip (cm)">91–96</td>
					<td data-label="Hip (in)">36–38&Prime;</td>
					<td data-label="AU Clothing">XS</td>
				</tr>
				<tr>
					<td data-label="SLY Size"><strong>S</strong></td>
					<td data-label="Waist (cm)">81–86</td>
					<td data-label="Waist (in)">32–34&Prime;</td>
					<td data-label="Hip (cm)">96–101</td>
					<td data-label="Hip (in)">38–40&Prime;</td>
					<td data-label="AU Clothing">S</td>
				</tr>
				<tr>
					<td data-label="SLY Size"><strong>M</strong></td>
					<td data-label="Waist (cm)">86–91</td>
					<td data-label="Waist (in)">34–36&Prime;</td>
					<td data-label="Hip (cm)">101–106</td>
					<td data-label="Hip (in)">40–42&Prime;</td>
					<td data-label="AU Clothing">M</td>
				</tr>
				<tr>
					<td data-label="SLY Size"><strong>L</strong></td>
					<td data-label="Waist (cm)">91–97</td>
					<td data-label="Waist (in)">36–38&Prime;</td>
					<td data-label="Hip (cm)">106–112</td>
					<td data-label="Hip (in)">42–44&Prime;</td>
					<td data-label="AU Clothing">L</td>
				</tr>
				<tr>
					<td data-label="SLY Size"><strong>XL</strong></td>
					<td data-label="Waist (cm)">97–102</td>
					<td data-label="Waist (in)">38–40&Prime;</td>
					<td data-label="Hip (cm)">112–117</td>
					<td data-label="Hip (in)">44–46&Prime;</td>
					<td data-label="AU Clothing">XL</td>
				</tr>
				<tr>
					<td data-label="SLY Size"><strong>2XL</strong></td>
					<td data-label="Waist (cm)">102–107</td>
					<td data-label="Waist (in)">40–42&Prime;</td>
					<td data-label="Hip (cm)">117–122</td>
					<td data-label="Hip (in)">46–48&Prime;</td>
					<td data-label="AU Clothing">2XL</td>
				</tr>
				<tr>
					<td data-label="SLY Size"><strong>3XL</strong></td>
					<td data-label="Waist (cm)">107–112</td>
					<td data-label="Waist (in)">42–44&Prime;</td>
					<td data-label="Hip (cm)">122–127</td>
					<td data-label="Hip (in)">48–50&Prime;</td>
					<td data-label="AU Clothing">3XL</td>
				</tr>
			</tbody>
		</table>
	</div>
</section>

<!-- ── Fit Notes by Style ────────────────────────────────────────────────── -->
<section class="container sly-sg-fitnotes" data-reveal>
	<h2>Fit Notes by Style</h2>
	<div class="sly-sg-fitnotes__grid">

		<div class="sly-sg-fitnote" data-reveal>
			<h3>Pouch Underwear</h3>
			<p>The pouch is the main event. It's engineered to separate and support without squishing. If your waist sits right on the border of two sizes, go up — the pouch needs room to do its thing properly. <a href="<?php echo esc_url( home_url( '/product-category/men-underwear/mens-pouch-underwear/' ) ); ?>">Shop Pouch Underwear &rarr;</a></p>
		</div>

		<div class="sly-sg-fitnote" data-reveal>
			<h3>Pocket Underwear</h3>
			<p>Snug but not restrictive. The phone pocket sits flat and stays put. If you're between sizes, size up to keep the pocket accessible without the waistband pulling. <a href="<?php echo esc_url( home_url( '/product-category/men-underwear/pocket-underwear/' ) ); ?>">Shop Pocket Underwear &rarr;</a></p>
		</div>

		<div class="sly-sg-fitnote" data-reveal>
			<h3>Quick-Dry Underwear</h3>
			<p>Our quick-dry fabric carries a touch of stretch and moves with you. True to size across the board — if you're at the top of your size bracket and active, size up for max comfort. <a href="<?php echo esc_url( home_url( '/product-category/men-underwear/quick-dry-underwear/' ) ); ?>">Shop Quick-Dry &rarr;</a></p>
		</div>

		<div class="sly-sg-fitnote" data-reveal>
			<h3>Black Bamboo Range</h3>
			<p>Proudly made in Australia from natural bamboo fabric. Holds its shape well and softens beautifully with every wash. Size true — by the third wash it'll feel like a second skin. Prefer a relaxed feel? Size up.</p>
		</div>

	</div>
</section>

<!-- ── International Sizing ──────────────────────────────────────────────── -->
<section class="container sly-sg-intl" data-reveal>
	<h2>International Sizing — Where We Stack Up</h2>
	<p>Ordering from the US, UK, or Europe? Here's how SLY sizes compare across the major markets.</p>

	<div class="sly-sg-table-wrap" style="margin-top:1.75rem">
		<table class="sly-sg-table" role="table" aria-label="SLY Collective International Size Comparison">
			<thead>
				<tr>
					<th scope="col">SLY Size</th>
					<th scope="col">Australia (AU)</th>
					<th scope="col">USA (US)</th>
					<th scope="col">United Kingdom (UK)</th>
					<th scope="col">Europe (EU)</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td data-label="SLY Size"><strong>XS</strong></td>
					<td data-label="Australia (AU)">XS</td>
					<td data-label="USA (US)">XS</td>
					<td data-label="United Kingdom (UK)">XS</td>
					<td data-label="Europe (EU)">42–44</td>
				</tr>
				<tr>
					<td data-label="SLY Size"><strong>S</strong></td>
					<td data-label="Australia (AU)">S</td>
					<td data-label="USA (US)">S</td>
					<td data-label="United Kingdom (UK)">S</td>
					<td data-label="Europe (EU)">44–46</td>
				</tr>
				<tr>
					<td data-label="SLY Size"><strong>M</strong></td>
					<td data-label="Australia (AU)">M</td>
					<td data-label="USA (US)">M</td>
					<td data-label="United Kingdom (UK)">M</td>
					<td data-label="Europe (EU)">46–48</td>
				</tr>
				<tr>
					<td data-label="SLY Size"><strong>L</strong></td>
					<td data-label="Australia (AU)">L</td>
					<td data-label="USA (US)">L</td>
					<td data-label="United Kingdom (UK)">L</td>
					<td data-label="Europe (EU)">48–50</td>
				</tr>
				<tr>
					<td data-label="SLY Size"><strong>XL</strong></td>
					<td data-label="Australia (AU)">XL</td>
					<td data-label="USA (US)">XL</td>
					<td data-label="United Kingdom (UK)">XL</td>
					<td data-label="Europe (EU)">50–52</td>
				</tr>
				<tr>
					<td data-label="SLY Size"><strong>2XL</strong></td>
					<td data-label="Australia (AU)">2XL&nbsp;/ XXL</td>
					<td data-label="USA (US)">XXL</td>
					<td data-label="United Kingdom (UK)">XXL</td>
					<td data-label="Europe (EU)">52–54</td>
				</tr>
				<tr>
					<td data-label="SLY Size"><strong>3XL</strong></td>
					<td data-label="Australia (AU)">3XL&nbsp;/ XXXL</td>
					<td data-label="USA (US)">XXXL</td>
					<td data-label="United Kingdom (UK)">XXXL</td>
					<td data-label="Europe (EU)">54–56</td>
				</tr>
			</tbody>
		</table>
	</div>
</section>

<!-- ── FAQ ───────────────────────────────────────────────────────────────── -->
<section class="container sly-sg-faq" data-reveal>
	<h2>Got Questions? We've Got Answers.</h2>
	<div class="sly-sg-faq__list">

		<div class="sly-sg-faq__item" data-reveal>
			<h3>What if I'm between two sizes?</h3>
			<p>Size up, always. SLY underwear is built to be snug but not restrictive. Going up a size means the waistband won't dig in after lunch and the pouch has room to do its job properly.</p>
		</div>

		<div class="sly-sg-faq__item" data-reveal>
			<h3>Do SLY sizes run true to size?</h3>
			<p>Yep. Our underwear is engineered to Australian sizing standards. If you normally wear a Large in quality men's underwear, you'll wear a Large with SLY. No funny business, no sizing games.</p>
		</div>

		<div class="sly-sg-faq__item" data-reveal>
			<h3>Will the fabric stretch out after washing?</h3>
			<p>SLY fabrics are pre-shrunk and wash-stable. Bamboo and microfibre blends soften with wear but hold their shape. Wash cold, hang to dry — job done.</p>
		</div>

		<div class="sly-sg-faq__item" data-reveal>
			<h3>What's your returns policy if the size isn't right?</h3>
			<p>We stand behind the fit. Browse our <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>">full range</a>, or head to our <a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>">About page</a> to reach the team — we'll get you sorted.</p>
		</div>

		<div class="sly-sg-faq__item" data-reveal>
			<h3>Which style should I start with?</h3>
			<p>If you've never tried pouch underwear, the <a href="<?php echo esc_url( home_url( '/product-category/men-underwear/mens-pouch-underwear/' ) ); ?>">Men's Pouch Range</a> is the obvious first move. If you're active or travel a lot, go <a href="<?php echo esc_url( home_url( '/product-category/men-underwear/quick-dry-underwear/' ) ); ?>">Quick-Dry</a>. Need pockets? You know where to look.</p>
		</div>

	</div>
</section>

<!-- ── CTA ───────────────────────────────────────────────────────────────── -->
<section class="container sly-sg-cta" data-reveal>
	<div class="sly-sg-cta__inner">
		<p class="sly-sg-cta__headline">Got Your Size? Let's Go.</p>
		<p class="sly-sg-cta__sub">Pouch underwear, pocket styles, quick-dry options — all engineered for the way men actually live.</p>
		<div class="sly-sg-cta__btns">
			<a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="sly-button">
				<?php esc_html_e( 'Shop the Range', 'sly-pebble-lite' ); ?>
			</a>
			<a href="<?php echo esc_url( home_url( '/product-category/men-underwear/mens-pouch-underwear/' ) ); ?>" class="sly-button sly-button--ghost">
				<?php esc_html_e( 'Pouch Underwear', 'sly-pebble-lite' ); ?>
			</a>
		</div>
	</div>
</section>

<?php
get_footer();
