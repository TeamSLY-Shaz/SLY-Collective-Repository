<?php
/**
 * Article image injection — server-side replacement for the WPCode
 * "Part 3" JavaScript snippets.
 *
 * Inserts promo image pairs (and one single image) at percentage positions
 * through single blog post content, plus a CTA footer block at the end.
 * Runs in PHP via the_content, so the images are part of the page HTML
 * itself — no JavaScript, unaffected by script delaying/combining or
 * caching plugins.
 *
 * @package sly-pebble-lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Image schedule. position = fraction through the post's content blocks.
 * Entries with url1+url2 render as a side-by-side clickable pair;
 * entries with url render as a single clickable image.
 */
function sly_pebble_lite_article_images_config() {
	return array(
		array(
			'url1'      => 'https://slycollective.com/wp-content/uploads/2026/05/Ultra-Flare-5B.png',
			'url2'      => 'https://slycollective.com/wp-content/uploads/2026/06/Your-New-Fave-Underwear-SLY20-Discount.png',
			'link'      => 'https://slycollective.com/product/men-underwear/pocket-underwear/boxers-ultra-flare/',
			'position'  => 0.15,
			'pairWidth' => '80%',
		),
		array(
			'url1'      => 'https://slycollective.com/wp-content/uploads/2026/06/Your-New-Fave-Underwear-SLY20-Discount.png',
			'url2'      => 'https://slycollective.com/wp-content/uploads/2026/06/Inkd-BB-4.1.webp',
			'link'      => 'https://slycollective.com/product/men-underwear/pocket-underwear/inkd-boxer-briefs-no-ride-up-anti-chafe-hammock-pouch/',
			'position'  => 0.30,
			'pairWidth' => '80%',
		),
		array(
			'url1'      => 'https://slycollective.com/wp-content/uploads/2023/01/Zoinky-Banner-1C-1.png',
			'url2'      => 'https://slycollective.com/wp-content/uploads/2026/06/Your-New-Fave-Underwear-SLY20-Discount.png',
			'link'      => 'https://slycollective.com/product/men-underwear/mens-bamboo-underwear/graffiti-by-zoinky/',
			'position'  => 0.45,
			'pairWidth' => '80%',
		),
		array(
			'url1'      => 'https://slycollective.com/wp-content/uploads/2026/06/Your-New-Fave-Underwear-SLY20-Discount.png',
			'url2'      => 'https://slycollective.com/wp-content/uploads/2026/06/Old-New-13-Black-4.1.webp',
			'link'      => 'https://slycollective.com/product/men-underwear/pocket-underwear/black-pinstripe-boxer-briefs/',
			'position'  => 0.60,
			'pairWidth' => '95%',
		),
		array(
			'url1'      => 'https://slycollective.com/wp-content/uploads/2024/02/Bamboo-Diagram-1.1.png',
			'url2'      => 'https://slycollective.com/wp-content/uploads/2026/06/Your-New-Fave-Underwear-SLY20-Discount.png',
			'link'      => 'https://slycollective.com/product/men-underwear/bamboo-underwear/black-bamboo-boxer-brief/',
			'position'  => 0.70,
			'pairWidth' => '95%',
		),
		array(
			'url1'      => 'https://slycollective.com/wp-content/uploads/2026/06/Your-New-Fave-Underwear-SLY20-Discount.png',
			'url2'      => 'https://slycollective.com/wp-content/uploads/2026/04/Bikers-Life-Trunks-Rock-Man-1.jpg',
			'link'      => 'https://slycollective.com/product/men-underwear/pocket-underwear/bikers-life-boxer-briefs/',
			'position'  => 0.80,
			'pairWidth' => '80%',
		),
		array(
			'url'      => 'https://slycollective.com/wp-content/uploads/2026/01/Hayden-Jess-.png',
			'link'     => 'https://slycollective.com/',
			'position' => 0.90,
			'width'    => '100%',
		),
	);
}

/**
 * Render one scheduled image (pair or single) as HTML.
 */
function sly_pebble_lite_render_article_image( $img, $index ) {
	$alt = 'Article image ' . ( $index + 1 );

	if ( ! empty( $img['url1'] ) && ! empty( $img['url2'] ) ) {
		$width = ! empty( $img['pairWidth'] ) ? $img['pairWidth'] : '100%';
		return '<div class="sly-article-image-wrap">'
			. '<a href="' . esc_url( $img['link'] ) . '" target="_blank" rel="noopener noreferrer">'
			. '<div class="sly-dual-image-inner" style="width:' . esc_attr( $width ) . '">'
			. '<img src="' . esc_url( $img['url1'] ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy">'
			. '<img src="' . esc_url( $img['url2'] ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy">'
			. '</div></a></div>';
	}

	if ( ! empty( $img['url'] ) ) {
		$width = ! empty( $img['width'] ) ? $img['width'] : '100%';
		return '<div class="sly-article-image-wrap">'
			. '<a href="' . esc_url( $img['link'] ) . '" target="_blank" rel="noopener noreferrer">'
			. '<div class="sly-single-image-inner">'
			. '<img src="' . esc_url( $img['url'] ) . '" alt="' . esc_attr( $alt ) . '" style="width:' . esc_attr( $width ) . '" loading="lazy">'
			. '</div></a></div>';
	}

	return '';
}

/**
 * CTA footer block appended to the end of every post.
 */
function sly_pebble_lite_article_footer_html() {
	return '<div class="sly-article-footer">'
		. '<div class="wp-block-buttons" style="margin-top:2.5rem;margin-bottom:0">'
		. '<div class="wp-block-button has-custom-width wp-block-button__width-75">'
		. '<a class="wp-block-button__link wp-element-button" href="https://slycollective.com/">FIND YOUR FIT</a>'
		. '</div></div>'
		. '<p class="has-text-align-center">Don\'t let another day go by compromising on your comfort and health. The benefits are clear, and once you try it, you\'ll wonder why you waited so long. It\'s time to feel the difference for yourself.</p>'
		. '<p class="has-text-align-center">If you want to explore our range, why don\'t you <strong>take 20% off your first order &ndash; use SLY20 at the checkout.</strong> Remember you have a <strong>\'first pair guarantee\'</strong> as well, so you\'ve got nothing to lose.</p>'
		. '<div class="sly20-cta-wrap"><a class="sly20-cta" href="https://slycollective.com/">USE SLY20 FOR 20% OFF</a></div>'
		. '<p class="has-text-align-center"><strong>SLY Collective masterfully combines anatomical pouch innovation with premium fabric.</strong>&nbsp;Our pouch is precision-engineered to cradle and support, reducing skin-on-skin friction and delivering all-day comfort with true scrotal support. Paired with luxuriously soft, breathable, and naturally antibacterial bamboo fabric, it\'s the ultimate upgrade for men who value performance, comfort, and wellbeing.</p>'
		. '<p class="has-text-align-center sly-cheeky-line">Cheeky by Nature. Obsessed with Comfort. Proudly Aussie.</p>'
		. '<div class="wp-block-buttons" style="margin-bottom:2.5rem">'
		. '<div class="wp-block-button has-custom-width wp-block-button__width-75">'
		. '<a class="wp-block-button__link wp-element-button" href="https://slycollective.com/">SLY COLLECTIVE HOMEPAGE</a>'
		. '</div></div>'
		. '</div>';
}

/**
 * Inject the scheduled images + footer into single post content.
 */
add_filter( 'the_content', function ( $content ) {
	if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}
	// Guard against double-processing (e.g. plugins applying the_content twice).
	if ( strpos( $content, 'sly-article-image-wrap' ) !== false ) {
		return $content;
	}

	// Split content into blocks, keeping the closing tags of paragraphs/headings.
	$parts = preg_split( '/(<\/p>|<\/h2>|<\/h3>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE );
	if ( false === $parts ) {
		return $content . sly_pebble_lite_article_footer_html();
	}

	$blocks = array();
	$count  = count( $parts );
	for ( $i = 0; $i + 1 < $count; $i += 2 ) {
		$blocks[] = $parts[ $i ] . $parts[ $i + 1 ];
	}
	$tail = ( $count % 2 === 1 ) ? $parts[ $count - 1 ] : '';

	$total = count( $blocks );
	if ( 0 === $total ) {
		return $content . sly_pebble_lite_article_footer_html();
	}

	// Map each scheduled image to the block it should follow.
	$inserts = array();
	foreach ( sly_pebble_lite_article_images_config() as $index => $img ) {
		$at = (int) floor( $total * (float) $img['position'] );
		if ( $at >= $total ) {
			$at = $total - 1;
		}
		$html = sly_pebble_lite_render_article_image( $img, $index );
		if ( $html ) {
			$inserts[ $at ] = ( isset( $inserts[ $at ] ) ? $inserts[ $at ] : '' ) . $html;
		}
	}

	$out = '';
	foreach ( $blocks as $i => $block ) {
		$out .= $block;
		if ( isset( $inserts[ $i ] ) ) {
			$out .= $inserts[ $i ];
		}
	}

	return $out . $tail . sly_pebble_lite_article_footer_html();
}, 20 );

/**
 * Styles for the injected images + footer, printed on single posts only.
 */
add_action( 'wp_head', function () {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	?>
	<style id="sly-article-images-css">
	.sly-article-image-wrap{display:block;width:100%;margin:40px auto;clear:both;text-align:center}
	.sly-article-image-wrap a{display:block;width:100%;border:none;text-decoration:none}
	.sly-dual-image-inner{display:flex;justify-content:center;align-items:center;flex-wrap:wrap;gap:12px;margin:0 auto}
	.sly-dual-image-inner img{display:block;width:calc(50% - 6px);max-width:80%;height:auto;cursor:pointer;flex-shrink:0;transition:opacity .2s ease}
	.sly-single-image-inner img{display:block;max-width:100%;height:auto;margin:0 auto;cursor:pointer;transition:opacity .2s ease}
	.sly-article-image-wrap img:hover{opacity:.85}
	@media(max-width:600px){
		.sly-dual-image-inner{flex-direction:column;align-items:center;width:80%!important;gap:16px}
		.sly-dual-image-inner img{width:80%;max-width:420px}
	}
	.sly-article-footer .wp-block-buttons{display:flex;justify-content:center;width:100%}
	.sly-article-footer .wp-block-button{width:75%;text-align:center}
	.sly-article-footer .wp-block-button__link{display:block;background:var(--sly-accent,#197E92);color:#fff;border-radius:10px;padding:14px 24px;font-weight:700;letter-spacing:.04em;text-decoration:none}
	.sly-article-footer .wp-block-button__link:hover{background:var(--sly-accent-hover,#146a7b);color:#fff}
	.sly-article-footer .sly-cheeky-line{font-size:36px!important;font-weight:700!important;line-height:1.25}
	@media(max-width:600px){.sly-article-footer .sly-cheeky-line{font-size:28px!important}}
	.sly-article-footer .sly20-cta-wrap{text-align:center;margin:16px 0}
	.sly-article-footer .sly20-cta{display:inline-block;padding:12px 24px;border:2px solid #333;border-radius:10px;text-decoration:none;color:inherit;font-weight:700;letter-spacing:.5px;transition:color .2s ease}
	.sly-article-footer .sly20-cta:hover{color:#333}
	.sly-article-footer .has-text-align-center{text-align:center}
	</style>
	<?php
}, 4 );
