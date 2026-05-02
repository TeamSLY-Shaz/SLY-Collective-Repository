<?php
/**
 * Single product template — SLY Pebble Lite.
 *
 * @package sly-pebble-lite
 */

defined( 'ABSPATH' ) || exit;

global $product;

do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}

if ( ! $product instanceof WC_Product || ! $product->is_visible() ) {
	return;
}

// ── Gallery items ─────────────────────────────────────────────────────────────
$main_image_id = $product->get_image_id();
$gallery_ids   = $product->get_gallery_image_ids();
$image_ids     = array_values( array_filter( array_merge( [ $main_image_id ], $gallery_ids ) ) );

if ( empty( $image_ids ) ) {
	$image_ids = [ 0 ];
}

$sly_video_mp4    = get_post_meta( $product->get_id(), '_sly_video_mp4', true );
$sly_video_webm   = get_post_meta( $product->get_id(), '_sly_video_webm', true );
$sly_video_poster = get_post_meta( $product->get_id(), '_sly_video_poster', true );
$sly_video_pos    = get_post_meta( $product->get_id(), '_sly_video_position', true );
$sly_has_video    = ! empty( $sly_video_mp4 );

if ( '' === $sly_video_pos ) {
	$sly_video_pos = '1';
}

$gallery_items = array_map( function ( $id ) {
	return [ 'type' => 'image', 'id' => $id ];
}, $image_ids );

if ( $sly_has_video ) {
	$video_item = [
		'type'   => 'video',
		'mp4'    => $sly_video_mp4,
		'webm'   => $sly_video_webm,
		'poster' => $sly_video_poster,
	];
	if ( '0' === $sly_video_pos ) {
		array_unshift( $gallery_items, $video_item );
	} elseif ( 'last' === $sly_video_pos ) {
		$gallery_items[] = $video_item;
	} else {
		$pos = min( (int) $sly_video_pos, count( $gallery_items ) );
		array_splice( $gallery_items, $pos, 0, [ $video_item ] );
	}
}

$gallery_items = array_slice( $gallery_items, 0, 6 );
$total_items   = count( $gallery_items );

// ── Product features (3 editable checkmarks) ─────────────────────────────────
$sly_features = array_filter( [
	get_post_meta( $product->get_id(), '_sly_feat_1', true ),
	get_post_meta( $product->get_id(), '_sly_feat_2', true ),
	get_post_meta( $product->get_id(), '_sly_feat_3', true ),
] );

// ── Review meta (summary + 4 individual reviews) ─────────────────────────────
$_sly_rev_summary = get_post_meta( $product->get_id(), '_sly_review_summary', true );
if ( '' === $_sly_rev_summary ) {
	$_avg   = number_format( (float) $product->get_average_rating(), 1 );
	$_count = (int) $product->get_rating_count();
	$_sly_rev_summary = $_count > 0
		? sprintf( '%s out of 5 (%d %s)', $_avg, $_count, _n( 'review', 'reviews', $_count, 'sly-pebble-lite' ) )
		: '4.8 out of 5 (127 reviews)';
}
$_sly_default_reviews = [
	[ 'stars' => 5, 'quote' => 'The support pouch is a bloody big upgrade from regular briefs. No more awkward slipping, no more subtle public repacking missions.', 'author' => '— Trev, Melbourne' ],
	[ 'stars' => 5, 'quote' => 'Finally found underwear that actually fits properly. The pouch support is next level — haven\'t looked back since.', 'author' => '— Jake, Brisbane' ],
	[ 'stars' => 4, 'quote' => 'Super comfortable for long rides. The anti-chafe design actually works — wore these for 6 hours straight with zero complaints.', 'author' => '— Marcus, Perth' ],
	[ 'stars' => 5, 'quote' => 'Great quality, fast shipping. My whole pack has converted. The fabric is so much better than the big brands.', 'author' => '— Dean, Sydney' ],
];
$sly_reviews = [];
for ( $__i = 1; $__i <= 4; $__i++ ) {
	$__stars  = get_post_meta( $product->get_id(), "_sly_rv_{$__i}_stars", true );
	$__quote  = get_post_meta( $product->get_id(), "_sly_rv_{$__i}_quote", true );
	$__author = get_post_meta( $product->get_id(), "_sly_rv_{$__i}_author", true );
	$sly_reviews[] = [
		'stars'  => ( '' !== $__stars )  ? (int) $__stars  : $_sly_default_reviews[ $__i - 1 ]['stars'],
		'quote'  => ( '' !== $__quote )  ? $__quote        : $_sly_default_reviews[ $__i - 1 ]['quote'],
		'author' => ( '' !== $__author ) ? $__author       : $_sly_default_reviews[ $__i - 1 ]['author'],
	];
}

// ── Product price (for bulk buy per-pair calculations) ────────────────────────
$sly_price = (float) $product->get_price();

// ── Stock warning ─────────────────────────────────────────────────────────────
$stock_warning = '';
if ( $product->managing_stock() ) {
	$sq = (int) $product->get_stock_quantity();
	if ( $sq > 0 && $sq <= 10 ) {
		/* translators: %d: number of items in stock */
		$stock_warning = sprintf( __( 'Only %d left in stock — order soon.', 'sly-pebble-lite' ), $sq );
	}
}

// ── Descriptions ─────────────────────────────────────────────────────────────
$full_desc  = $product->get_description();
$short_desc = preg_replace( '/\[1_2_3_u_pouch[^\]]*\]/i', '', (string) $product->get_short_description() );
$short_desc = trim( (string) $short_desc );
?>

<article id="product-<?php the_ID(); ?>" <?php wc_product_class( 'sly-pd-layout', $product ); ?>>

<div class="sly-pd">

	<!-- ═══════════════ GALLERY COLUMN ═══════════════ -->
	<div class="sly-pd-gallery-col">

		<!-- Single image set — 2-col 9:16 grid on desktop, 1:1 carousel on mobile -->
		<div class="sly-pd-slides" data-pd-slides>
			<?php foreach ( $gallery_items as $ci => $ci_item ) : ?>
				<div class="sly-pd-slide <?php echo $ci < 2 ? 'sly-pd-slide--portrait' : 'sly-pd-slide--square'; ?>" data-pd-slide="<?php echo (int) $ci; ?>">
					<?php if ( 'video' === $ci_item['type'] ) : ?>
						<video autoplay muted loop playsinline
							<?php if ( ! empty( $ci_item['poster'] ) ) : ?>poster="<?php echo esc_url( $ci_item['poster'] ); ?>"<?php endif; ?>>
							<source src="<?php echo esc_url( $ci_item['mp4'] ); ?>" type="video/mp4">
							<?php if ( ! empty( $ci_item['webm'] ) ) : ?>
								<source src="<?php echo esc_url( $ci_item['webm'] ); ?>" type="video/webm">
							<?php endif; ?>
						</video>
					<?php else : ?>
						<?php echo $ci_item['id']
							? wp_get_attachment_image( $ci_item['id'], 'woocommerce_single', false, [ 'loading' => 0 === $ci ? 'eager' : 'lazy' ] )
							: wc_placeholder_img( 'woocommerce_single' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>

		<!-- Dots — visible on both desktop and mobile -->
		<?php if ( $total_items > 1 ) : ?>
		<div class="sly-pd-dots" data-pd-dots>
			<?php for ( $d = 0; $d < $total_items; $d++ ) : ?>
				<button type="button"
					class="sly-pd-dot<?php echo 0 === $d ? ' is-active' : ''; ?>"
					data-pd-dot="<?php echo (int) $d; ?>"
					aria-label="<?php printf( esc_attr__( 'Image %1$d of %2$d', 'sly-pebble-lite' ), $d + 1, $total_items ); ?>">
				</button>
			<?php endfor; ?>
		</div>
		<?php endif; ?>

		<!-- Mobile carousel arrows -->
		<button type="button" class="sly-slide-arrow sly-slide-arrow--prev" aria-label="<?php esc_attr_e( 'Previous image', 'sly-pebble-lite' ); ?>">&#8249;</button>
		<button type="button" class="sly-slide-arrow sly-slide-arrow--next" aria-label="<?php esc_attr_e( 'Next image', 'sly-pebble-lite' ); ?>">&#8250;</button>

	</div><!-- .sly-pd-gallery-col -->


	<!-- ═══════════════ INFO COLUMN ═══════════════ -->
	<div class="sly-pd-info">

		<!-- Title -->
		<h1 class="sly-pd-title"><?php the_title(); ?></h1>

		<!-- Price + features row -->
		<div class="sly-pd-price-row">
			<div class="sly-pd-price">
				<?php echo wp_kses_post( $product->get_price_html() ); ?>
			</div>
			<?php if ( ! empty( $sly_features ) ) : ?>
			<div class="sly-pd-features sly-pd-features--inline">
				<?php foreach ( $sly_features as $feat ) : ?>
					<span class="sly-pd-feature">&#10003; <?php echo esc_html( $feat ); ?></span>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>

		<!-- Review carousel — summary + 4 cards -->
		<div class="sly-pd-review">
			<?php if ( $_sly_rev_summary ) : ?>
			<p class="sly-rv-summary">&#9733; <?php echo esc_html( $_sly_rev_summary ); ?></p>
			<?php endif; ?>
			<div class="sly-rv-track" data-rv-track>
				<?php foreach ( $sly_reviews as $__ri => $__rv ) : ?>
				<div class="sly-rv-card" data-rv-card="<?php echo (int) $__ri; ?>">
					<div class="sly-rv-stars" aria-label="<?php printf( esc_attr__( '%d out of 5 stars', 'sly-pebble-lite' ), $__rv['stars'] ); ?>">
						<?php for ( $__s = 1; $__s <= 5; $__s++ ) : ?>
						<span class="sly-pd-star<?php echo $__s <= $__rv['stars'] ? ' is-filled' : ''; ?>" aria-hidden="true">&#9733;</span>
						<?php endfor; ?>
					</div>
					<blockquote class="sly-rv-quote">
						<p><?php echo esc_html( $__rv['quote'] ); ?></p>
						<cite><?php echo esc_html( $__rv['author'] ); ?></cite>
					</blockquote>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="sly-rv-dots" data-rv-dots>
				<?php foreach ( $sly_reviews as $__ri => $__rv ) : ?>
				<button type="button" class="sly-rv-dot<?php echo 0 === $__ri ? ' is-active' : ''; ?>" data-rv-dot="<?php echo (int) $__ri; ?>" aria-label="<?php printf( esc_attr__( 'Review %d', 'sly-pebble-lite' ), $__ri + 1 ); ?>"></button>
				<?php endforeach; ?>
			</div>
		</div>

		<?php if ( empty( $sly_features ) && '' !== $short_desc ) : ?>
		<div class="sly-pd-excerpt">
			<?php echo wp_kses_post( wpautop( $short_desc ) ); ?>
		</div>
		<?php endif; ?>

		<!-- Stock warning -->
		<?php if ( '' !== $stock_warning ) : ?>
		<p class="sly-pd-stock-warning"><?php echo esc_html( $stock_warning ); ?></p>
		<?php endif; ?>

		<!-- ── Purchase zone ──────────────────────────────────────────── -->
		<div class="sly-pd-purchase" data-atc-zone>

			<!-- Size guide link -->
			<a href="<?php echo esc_url( home_url( '/size_chart/size-guide/' ) ); ?>"
				class="sly-pd-sg-link"
				target="_blank"
				rel="noopener noreferrer">
				<?php esc_html_e( 'Size Guide &rarr;', 'sly-pebble-lite' ); ?>
			</a>

			<!-- WooCommerce add-to-cart form -->
			<div class="sly-add-to-cart sly-pd-wc">
				<?php woocommerce_template_single_add_to_cart(); ?>
			</div>

			<!-- Bulk buy card grid -->
			<?php if ( $sly_price > 0 ) :
				$_bb = [
					[ 'qty' => 7,  'label' => '7 PAIRS',  'pct' => 0.15, 'badge' => 'MOST POPULAR' ],
					[ 'qty' => 14, 'label' => '14 PAIRS', 'pct' => 0.20, 'badge' => '' ],
					[ 'qty' => 21, 'label' => '21 PAIRS', 'pct' => 0.25, 'badge' => '' ],
				];
			?>
			<div class="sly-bb" data-bb>
				<p class="sly-bb__heading"><?php esc_html_e( 'BULK BUY — Mix &amp; Match Any Underwear', 'sly-pebble-lite' ); ?></p>
				<p class="sly-bb__note"><?php esc_html_e( 'Discount automatically applied at cart.', 'sly-pebble-lite' ); ?></p>
				<div class="sly-bb__grid">
					<?php foreach ( $_bb as $_bi => $_bc ) : ?>
					<div class="sly-bb__card<?php echo 0 === $_bi ? ' is-selected' : ''; ?>"
						data-bb-qty="<?php echo (int) $_bc['qty']; ?>">
						<?php if ( $_bc['badge'] ) : ?>
						<span class="sly-bb__badge"><?php echo esc_html( $_bc['badge'] ); ?></span>
						<?php endif; ?>
						<span class="sly-bb__pairs"><?php echo esc_html( $_bc['label'] ); ?></span>
						<span class="sly-bb__discount"><?php printf( esc_html__( '%d%% OFF', 'sly-pebble-lite' ), (int) ( $_bc['pct'] * 100 ) ); ?></span>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endif; ?>

		</div><!-- .sly-pd-purchase -->

		<!-- Trust strip -->
		<div class="sly-pd-trust">
			<span class="sly-pd-trust-item">&#10003; <?php esc_html_e( 'Free AU shipping over $100', 'sly-pebble-lite' ); ?></span>
			<span class="sly-pd-trust-item">&#8617; <?php esc_html_e( 'Easy returns', 'sly-pebble-lite' ); ?></span>
			<span class="sly-pd-trust-item">&#9733; <?php esc_html_e( 'First pair guarantee', 'sly-pebble-lite' ); ?></span>
		</div>

		<!-- Brand tagline + expandable tabs -->
		<div class="sly-pd-brand">

			<div class="sly-pd-brand-tagline">
				<p><?php esc_html_e( 'Cheeky by nature.', 'sly-pebble-lite' ); ?></p>
				<p><?php esc_html_e( 'Obsessed with comfort.', 'sly-pebble-lite' ); ?></p>
				<p><?php esc_html_e( 'Proudly Aussie.', 'sly-pebble-lite' ); ?></p>
			</div>

			<div class="sly-pd-tabs">

				<div class="sly-pd-tab">
					<button type="button" class="sly-pd-tab-trigger" aria-expanded="false">
						<?php esc_html_e( 'Care &amp; Cleaning', 'sly-pebble-lite' ); ?>
						<span class="sly-pd-tab-icon" aria-hidden="true">+</span>
					</button>
					<div class="sly-pd-tab-content" hidden>
						<p><?php esc_html_e( 'Machine wash cold (30°C) on a gentle cycle. Do not bleach. Do not tumble dry — hang to dry for best results. SLY fabrics are pre-shrunk and wash-stable; they soften with every wash without losing their shape.', 'sly-pebble-lite' ); ?></p>
					</div>
				</div>

				<div class="sly-pd-tab">
					<button type="button" class="sly-pd-tab-trigger" aria-expanded="false">
						<?php esc_html_e( 'Fabric', 'sly-pebble-lite' ); ?>
						<span class="sly-pd-tab-icon" aria-hidden="true">+</span>
					</button>
					<div class="sly-pd-tab-content" hidden>
						<p><?php esc_html_e( '87% Recycled Nylon, 13% Elastane. Our signature SLY-Flex fabric is engineered for all-day comfort with exceptional stretch recovery. The four-way stretch eliminates ride-up and maintains its shape through hundreds of washes.', 'sly-pebble-lite' ); ?></p>
					</div>
				</div>

				<div class="sly-pd-tab">
					<button type="button" class="sly-pd-tab-trigger" aria-expanded="false">
						<?php esc_html_e( 'Shipping', 'sly-pebble-lite' ); ?>
						<span class="sly-pd-tab-icon" aria-hidden="true">+</span>
					</button>
					<div class="sly-pd-tab-content" hidden>
						<p><?php esc_html_e( 'We ship from Melbourne, Australia. Standard shipping 3–7 business days. Express 1–3 business days. Free standard shipping on orders over $100. International shipping available to NZ, UK, US, CA.', 'sly-pebble-lite' ); ?></p>
					</div>
				</div>

				<div class="sly-pd-tab">
					<button type="button" class="sly-pd-tab-trigger" aria-expanded="false">
						<?php esc_html_e( 'Returns', 'sly-pebble-lite' ); ?>
						<span class="sly-pd-tab-icon" aria-hidden="true">+</span>
					</button>
					<div class="sly-pd-tab-content" hidden>
						<p><?php esc_html_e( '30-day returns on unworn, unwashed items in original packaging. Simply contact our team and we\'ll arrange a hassle-free return or exchange. Hygiene items must be tried on over underwear.', 'sly-pebble-lite' ); ?></p>
					</div>
				</div>

			</div><!-- .sly-pd-tabs -->

		</div><!-- .sly-pd-brand -->

		<!-- Homepage button -->
		<div class="sly-pd-home-btn">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button sly-button"><?php esc_html_e( 'Back to Homepage', 'sly-pebble-lite' ); ?></a>
		</div>

	</div><!-- .sly-pd-info -->

</div><!-- .sly-pd -->

<?php
$sticky_product_id = $product->get_id();
$sticky_title      = $product->get_name();
$sticky_price      = $product->get_price_html();
?>
<div class="sly-sticky-atc" data-sticky-atc>
	<div class="sly-sticky-atc__inner">
		<div class="sly-sticky-atc__info">
			<span class="sly-sticky-atc__title"><?php echo esc_html( $sticky_title ); ?></span>
			<span class="sly-sticky-atc__price"><?php echo wp_kses_post( $sticky_price ); ?></span>
		</div>
		<button type="button" class="sly-sticky-atc__btn" data-product-id="<?php echo esc_attr( $sticky_product_id ); ?>">
			<?php esc_html_e( 'Add to Cart', 'sly-pebble-lite' ); ?>
		</button>
	</div>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
</article>
