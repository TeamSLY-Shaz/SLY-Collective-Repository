<?php
/**
 * Template Name: Refund & Returns Policy (Teal Gradient)
 * Slug: refund-returns-policy
 *
 * Restyles the WooCommerce-generated Refund & Returns Policy page.
 * IMPORTANT: pulls the_content() directly from the database so every line
 * of the existing policy is preserved — only the surrounding shell and the
 * styling of standard elements (h2/h3/ul/ol/blockquote/table) is enhanced.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ── SEO meta ──────────────────────────────────────────────────────────────────
add_action( 'wp_head', function () {
	$canonical = home_url( '/refund-returns-policy/' );
	?>
	<meta name="robots" content="index, follow">
	<link rel="canonical" href="<?php echo esc_url( $canonical ); ?>">
	<?php
}, 1 );

// ── Page CSS ──────────────────────────────────────────────────────────────────
add_action( 'wp_head', function () {
	?>
	<style>
	/* ── Gradient teal hero ────────────────────────────────────────── */
	.sly-rrp-hero{position:relative;overflow:hidden;padding:5rem 0 4rem;text-align:center;background:linear-gradient(120deg,#146a7b 0%,#197E92 45%,#1a8fa5 100%);color:#fff}
	.sly-rrp-hero::after{content:"";position:absolute;inset:0;background:radial-gradient(circle at 80% 20%,rgba(255,255,255,0.14),transparent 55%);pointer-events:none}
	.sly-rrp-hero__inner{position:relative;z-index:1}
	.sly-rrp-hero__kicker{font-size:.78rem;font-weight:700;letter-spacing:.18em;color:#fff;opacity:.85;text-transform:uppercase;margin:0 0 .85rem}
	.sly-rrp-hero__title{font-size:clamp(2.2rem,5.5vw,3.8rem)!important;font-weight:900;text-transform:uppercase;color:#fff;margin:0 0 1rem;letter-spacing:.04em;line-height:1.1}
	.sly-rrp-hero__sub{font-size:1.05rem!important;color:rgba(255,255,255,.88);opacity:1;margin:0 auto;max-width:62ch;font-weight:300}

	/* ── Quick-glance chips — teal stays dominant; lime + coral land as small accent pops ── */
	.sly-rrp-chips{display:flex;flex-wrap:wrap;justify-content:center;gap:.6rem;margin-top:1.75rem;position:relative;z-index:1}
	.sly-rrp-chip{display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1.15rem;border-radius:999px;background:rgba(255,255,255,.16);border:1px solid rgba(255,255,255,.35);color:#fff;font-size:.82rem;font-weight:600;letter-spacing:.02em;backdrop-filter:blur(4px)}
	.sly-rrp-chip--lime{background:#D7E05A;border-color:#D7E05A;color:#146a7b}
	.sly-rrp-chip--coral{background:#FF6F5B;border-color:#FF6F5B;color:#fff;text-shadow:0 1px 2px rgba(0,0,0,.18)}

	/* ── Content shell ─────────────────────────────────────────────── */
	.sly-rrp-wrap{max-width:880px;margin:0 auto;padding:3.5rem 1.5rem 4.5rem}
	.sly-rrp-card{background:#fff;border:1px solid var(--sly-line);border-radius:var(--sly-radius);padding:clamp(1.75rem,4vw,3.25rem);box-shadow:var(--sly-shadow)}

	/* ── Enhance the_content() typography — preserves all text, restyles it ── */
	.sly-rrp-card .entry-content{font-size:1rem;line-height:1.75;color:var(--sly-ink)}
	.sly-rrp-card .entry-content > *:first-child{margin-top:0}
	.sly-rrp-card .entry-content p{font-size:1rem!important;line-height:1.75!important;font-weight:300!important;margin:0 0 1.25rem}
	.sly-rrp-card .entry-content h1,
	.sly-rrp-card .entry-content h2{font-size:clamp(1.35rem,3vw,1.9rem)!important;font-weight:900!important;text-transform:uppercase;letter-spacing:.03em;color:var(--sly-ink);margin:2.75rem 0 1rem;padding-bottom:.65rem;position:relative}
	.sly-rrp-card .entry-content h1::after,
	.sly-rrp-card .entry-content h2::after{content:"";position:absolute;left:0;bottom:0;width:64px;height:4px;border-radius:999px;background:linear-gradient(100deg,#197E92,#1a8fa5)}
	.sly-rrp-card .entry-content > h1:first-child,
	.sly-rrp-card .entry-content > h2:first-child{margin-top:0}
	.sly-rrp-card .entry-content h3{font-size:1.05rem!important;font-weight:700!important;text-transform:none;letter-spacing:.01em;color:var(--sly-accent);margin:1.85rem 0 .65rem}
	.sly-rrp-card .entry-content h4,
	.sly-rrp-card .entry-content h5,
	.sly-rrp-card .entry-content h6{font-size:.95rem!important;font-weight:700!important;text-transform:uppercase;letter-spacing:.06em;color:var(--sly-ink);opacity:.8;margin:1.5rem 0 .5rem}

	/* Lists — numbered "step" treatment for ordered lists, check-style for unordered */
	.sly-rrp-card .entry-content ul,
	.sly-rrp-card .entry-content ol{margin:0 0 1.5rem;padding:0;list-style:none;display:grid;gap:.55rem}
	.sly-rrp-card .entry-content ul li,
	.sly-rrp-card .entry-content ol li{position:relative;padding:.85rem 1.1rem .85rem 3rem;background:var(--sly-sand);border-radius:10px;font-size:.95rem;line-height:1.65;counter-increment:sly-rrp-li}
	.sly-rrp-card .entry-content ul{counter-reset:none}
	.sly-rrp-card .entry-content ol{counter-reset:sly-rrp-li}
	.sly-rrp-card .entry-content ul li::before{content:"✓";position:absolute;left:.95rem;top:.85rem;width:1.5rem;height:1.5rem;border-radius:50%;background:linear-gradient(135deg,#197E92,#1a8fa5);color:#fff;font-size:.7rem;font-weight:800;display:inline-flex;align-items:center;justify-content:center}
	.sly-rrp-card .entry-content ol li::before{content:counter(sly-rrp-li);position:absolute;left:.85rem;top:.7rem;width:1.65rem;height:1.65rem;border-radius:50%;background:linear-gradient(135deg,#197E92,#1a8fa5);color:#fff;font-size:.78rem;font-weight:800;display:inline-flex;align-items:center;justify-content:center}
	.sly-rrp-card .entry-content li > ul,
	.sly-rrp-card .entry-content li > ol{margin-top:.55rem}
	.sly-rrp-card .entry-content li strong{color:var(--sly-ink)}

	/* Blockquotes — teal gradient callout */
	.sly-rrp-card .entry-content blockquote{margin:1.75rem 0;padding:1.5rem 1.75rem;border:none;border-radius:14px;background:linear-gradient(120deg,rgba(25,126,146,.08),rgba(26,143,165,.14));border-left:4px solid var(--sly-accent);font-size:.97rem;line-height:1.7;color:var(--sly-ink)}
	.sly-rrp-card .entry-content blockquote p:last-child{margin-bottom:0}

	/* Tables */
	.sly-rrp-card .entry-content table{width:100%;border-collapse:collapse;margin:0 0 1.75rem;font-size:.92rem;border-radius:10px;overflow:hidden;box-shadow:0 0 0 1px var(--sly-line)}
	.sly-rrp-card .entry-content th{background:linear-gradient(100deg,#197E92,#1a8fa5);color:#fff;text-transform:uppercase;letter-spacing:.06em;font-size:.78rem;font-weight:700;padding:.85rem 1rem;text-align:left}
	.sly-rrp-card .entry-content td{padding:.8rem 1rem;border-top:1px solid var(--sly-line)}
	.sly-rrp-card .entry-content tr:nth-child(even) td{background:var(--sly-sand)}

	/* Links + emphasis */
	.sly-rrp-card .entry-content a{color:var(--sly-accent);font-weight:600;text-decoration:underline;text-underline-offset:2px}
	.sly-rrp-card .entry-content a:hover{color:var(--sly-accent-hover)}
	.sly-rrp-card .entry-content hr{border:none;border-top:1px solid var(--sly-line);margin:2.5rem 0}
	.sly-rrp-card .entry-content strong{font-weight:700;color:var(--sly-ink)}

	/* ── CTA — gradient teal, with a tiny lime/coral accent-dot flourish ── */
	.sly-rrp-cta{padding:0 0 4.5rem}
	.sly-rrp-cta__inner{max-width:880px;margin:0 auto;padding:0 1.5rem}
	.sly-rrp-cta__panel{background:linear-gradient(120deg,#146a7b 0%,#197E92 50%,#1a8fa5 100%);border-radius:var(--sly-radius);padding:3rem 2.5rem;text-align:center;color:#fff}
	.sly-rrp-cta__dots{display:flex;justify-content:center;align-items:center;gap:.4rem;margin:0 0 1rem}
	.sly-rrp-cta__dots span{display:inline-block;width:8px;height:8px;border-radius:50%}
	.sly-rrp-cta__dots span:nth-child(1){background:rgba(255,255,255,.85)}
	.sly-rrp-cta__dots span:nth-child(2){background:#D7E05A}
	.sly-rrp-cta__dots span:nth-child(3){background:#FF6F5B}
	.sly-rrp-cta__title{font-size:clamp(1.5rem,3.5vw,2.2rem)!important;font-weight:900;text-transform:uppercase;letter-spacing:.04em;margin:0 0 .65rem;color:#fff;line-height:1.2}
	.sly-rrp-cta__sub{font-size:1rem!important;opacity:.9;margin:0 0 1.75rem;color:#fff;font-weight:300}
	.sly-rrp-cta__btns{display:flex;gap:1rem;justify-content:center;flex-wrap:wrap}
	.sly-rrp-cta__btns .sly-button{background:#fff;color:#146a7b;border:2px solid #fff}
	.sly-rrp-cta__btns .sly-button:hover{background:transparent;color:#fff;border-color:#fff}
	.sly-rrp-cta__btns .sly-button--ghost{background:transparent;color:#fff;border:2px solid rgba(255,255,255,.5)}
	.sly-rrp-cta__btns .sly-button--ghost:hover{background:rgba(255,255,255,.16);border-color:#fff}

	/* ── Responsive ────────────────────────────────────────────────── */
	@media(max-width:900px){
		.sly-rrp-hero{padding:3.5rem 0 2.75rem}
		.sly-rrp-card{padding:1.5rem}
		.sly-rrp-cta__panel{padding:2.25rem 1.5rem}
	}
	@media(max-width:600px){
		.sly-rrp-card .entry-content ul li,
		.sly-rrp-card .entry-content ol li{padding-left:2.6rem;font-size:.92rem}
	}
	</style>
	<?php
}, 2 );

get_header();
?>

<!-- ── Hero ──────────────────────────────────────────────────────────────── -->
<section class="sly-rrp-hero" data-reveal>
	<div class="container sly-rrp-hero__inner">
		<p class="sly-rrp-hero__kicker">No Drama. Just Solutions.</p>
		<h1 class="sly-rrp-hero__title">Refund &amp; Returns Policy</h1>
		<p class="sly-rrp-hero__sub">Everything you need to know about returns, exchanges and refunds at SLY Collective — laid out clearly below, exactly as written.</p>
		<div class="sly-rrp-chips">
			<span class="sly-rrp-chip">⏱ 30-Day Window</span>
			<span class="sly-rrp-chip sly-rrp-chip--lime">🔄 Free Size Exchanges</span>
			<span class="sly-rrp-chip sly-rrp-chip--coral">🛡 12-Month Warranty</span>
		</div>
	</div>
</section>

<!-- ── Full policy content — pulled directly from the page, nothing omitted ── -->
<section class="sly-rrp-wrap">
	<div class="sly-rrp-card">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		<?php endwhile; ?>
	</div>
</section>

<!-- ── CTA ───────────────────────────────────────────────────────────────── -->
<section class="sly-rrp-cta">
	<div class="sly-rrp-cta__inner">
		<div class="sly-rrp-cta__panel" data-reveal>
			<div class="sly-rrp-cta__dots" aria-hidden="true"><span></span><span></span><span></span></div>
			<p class="sly-rrp-cta__title">Got a Question About Your Order?</p>
			<p class="sly-rrp-cta__sub">Drop us an email and we'll sort it — no guilt trips, no lectures, just a fix.</p>
			<div class="sly-rrp-cta__btns">
				<a href="mailto:sales@slycollective.com" class="sly-button">Email Us Now</a>
				<a href="<?php echo esc_url( home_url( '/returns/' ) ); ?>" class="sly-button sly-button--ghost">Returns &amp; Exchanges Guide</a>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
