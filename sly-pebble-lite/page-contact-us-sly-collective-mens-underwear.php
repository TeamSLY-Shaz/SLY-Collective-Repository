<?php
/**
 * Template Name: Contact Us
 * Slug: contact-us-sly-collective-mens-underwear
 *
 * Contact page. Pulls the_content() to preserve any existing contact form,
 * then adds branded channel cards and a pre-contact FAQ strip.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ── SEO meta ──────────────────────────────────────────────────────────────────
add_action( 'wp_head', function () {
	$canonical = home_url( '/contact-us-sly-collective-mens-underwear/' );
	?>
	<meta name="description" content="Get in touch with SLY Collective. Real humans, no bots — email us at sales@slycollective.com for orders, returns, sizing questions, and anything else.">
	<meta name="robots" content="index, follow">
	<link rel="canonical" href="<?php echo esc_url( $canonical ); ?>">
	<?php
}, 1 );

// ── Page CSS ──────────────────────────────────────────────────────────────────
add_action( 'wp_head', function () {
	?>
	<style>
	.site-main {
		padding-top: 0 !important;
	}

	/* ── Gradient teal hero ────────────────────────────────────────── */
	.sly-cu-hero{position:relative;overflow:hidden;padding:5rem 0 4rem;text-align:center;background:linear-gradient(120deg,#146a7b 0%,#197E92 45%,#1a8fa5 100%);color:#fff}
	.sly-cu-hero::after{content:"";position:absolute;inset:0;background:radial-gradient(circle at 80% 20%,rgba(255,255,255,0.14),transparent 55%);pointer-events:none}
	.sly-cu-hero__inner{position:relative;z-index:1}
	.sly-cu-hero__kicker{font-size:.78rem;font-weight:700;letter-spacing:.18em;color:#fff;opacity:.85;text-transform:uppercase;margin:0 0 .85rem}
	.sly-cu-hero__title{font-size:clamp(2.2rem,5.5vw,3.8rem)!important;font-weight:900;text-transform:uppercase;color:#fff;margin:0 0 1rem;letter-spacing:.04em;line-height:1.1}
	.sly-cu-hero__sub{font-size:1.05rem!important;color:rgba(255,255,255,.88);margin:0 auto;max-width:58ch;font-weight:300}

	/* ── Quick chips — teal glass + lime accent pop ────────────────── */
	.sly-cu-chips{display:flex;flex-wrap:wrap;justify-content:center;gap:.6rem;margin-top:1.75rem;position:relative;z-index:1}
	.sly-cu-chip{display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1.15rem;border-radius:999px;background:rgba(255,255,255,.16);border:1px solid rgba(255,255,255,.35);color:#fff;font-size:.82rem;font-weight:600;letter-spacing:.02em;backdrop-filter:blur(4px)}
	.sly-cu-chip--lime{background:#D7E05A;border-color:#D7E05A;color:#146a7b}

	/* ── Content card — full-width, transparent, no borders ───────── */
	.sly-cu-wrap{width:100%;max-width:none;margin:0;padding:3rem clamp(1rem,4vw,3rem)}
	.sly-cu-card{background:transparent;border:none;border-radius:0;padding:0;box-shadow:none}
	.sly-cu-card .entry-content{font-size:1rem;line-height:1.75;color:var(--sly-ink)}
	.sly-cu-card .entry-content > *:first-child{margin-top:0}
	.sly-cu-card .entry-content p{font-size:1rem!important;line-height:1.75!important;font-weight:300!important;margin:0 0 1.25rem}
	.sly-cu-card .entry-content h2{font-size:clamp(1.2rem,2.5vw,1.65rem)!important;font-weight:900!important;text-transform:uppercase;letter-spacing:.03em;color:var(--sly-ink);margin:2.5rem 0 .9rem;padding-bottom:.6rem;position:relative}
	.sly-cu-card .entry-content h2::after{content:"";position:absolute;left:0;bottom:0;width:48px;height:4px;border-radius:999px;background:linear-gradient(100deg,#197E92,#1a8fa5)}
	.sly-cu-card .entry-content > h2:first-child{margin-top:0}
	.sly-cu-card .entry-content a{color:var(--sly-accent);font-weight:600;text-decoration:underline;text-underline-offset:2px}
	.sly-cu-card .entry-content a:hover{color:var(--sly-accent-hover)}
	/* Contact form fields — CF7 / WPForms / Gravity / native */
	.sly-cu-card input[type=text],
	.sly-cu-card input[type=email],
	.sly-cu-card input[type=tel],
	.sly-cu-card textarea,
	.sly-cu-card select{width:100%;padding:.75rem 1rem;border:1px solid var(--sly-line);border-radius:10px;font-size:.95rem;color:var(--sly-ink);background:#fff;transition:border-color var(--sly-speed),box-shadow var(--sly-speed);margin-bottom:1rem}
	.sly-cu-card input[type=text]:focus,
	.sly-cu-card input[type=email]:focus,
	.sly-cu-card input[type=tel]:focus,
	.sly-cu-card textarea:focus,
	.sly-cu-card select:focus{outline:none;border-color:var(--sly-accent);box-shadow:0 0 0 3px rgba(25,126,146,.12)}
	.sly-cu-card textarea{resize:vertical;min-height:140px}
	.sly-cu-card input[type=submit],
	.sly-cu-card .wpcf7-submit,
	.sly-cu-card .wpforms-submit{background:linear-gradient(100deg,#197E92,#1a8fa5);color:#fff;border:none;padding:.85rem 2.25rem;border-radius:999px;font-size:.95rem;font-weight:700;letter-spacing:.04em;text-transform:uppercase;cursor:pointer;transition:opacity var(--sly-speed)}
	.sly-cu-card input[type=submit]:hover,
	.sly-cu-card .wpcf7-submit:hover,
	.sly-cu-card .wpforms-submit:hover{opacity:.88}

	/* ── Contact channel cards ─────────────────────────────────────── */
	.sly-cu-channels{width:100%;max-width:none;margin:0;padding:3rem clamp(1rem,4vw,3rem)}
	.sly-cu-channels__title{font-size:clamp(1.25rem,3vw,1.65rem)!important;font-weight:900;text-transform:uppercase;letter-spacing:.03em;color:var(--sly-ink);margin:0 0 1.5rem}
	.sly-cu-channels__grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem}
	.sly-cu-channel{background:#fff;border:1px solid var(--sly-line);border-radius:var(--sly-radius);padding:2rem 1.5rem;box-shadow:var(--sly-shadow)}
	.sly-cu-channel__num{font-size:2.5rem;font-weight:900;line-height:1;margin-bottom:.75rem;background:linear-gradient(120deg,#197E92,#1a8fa5);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;letter-spacing:-.04em}
	.sly-cu-channel__title{font-size:.88rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--sly-ink);margin:0 0 .55rem}
	.sly-cu-channel__body{font-size:.88rem;line-height:1.65;color:var(--sly-ink);opacity:.78;margin:0 0 1.1rem}
	.sly-cu-channel__link{display:inline-flex;align-items:center;gap:.3rem;color:var(--sly-accent);font-size:.85rem;font-weight:700;text-decoration:none;letter-spacing:.02em}
	.sly-cu-channel__link::after{content:"→"}
	.sly-cu-channel__link:hover{color:var(--sly-accent-hover)}

	/* ── Pre-contact FAQ — lime left-border accent ─────────────────── */
	.sly-cu-faq{width:100%;max-width:none;margin:0;padding:3rem clamp(1rem,4vw,3rem)}
	.sly-cu-faq__title{font-size:clamp(1.25rem,3vw,1.65rem)!important;font-weight:900;text-transform:uppercase;letter-spacing:.03em;color:var(--sly-ink);margin:0 0 1.25rem}
	.sly-cu-faq__list{display:flex;flex-direction:column;gap:.85rem}
	.sly-cu-faq__item{padding:1.25rem 1.5rem 1.25rem 1.75rem;border-left:4px solid #D7E05A;background:var(--sly-sand);border-radius:0 12px 12px 0}
	.sly-cu-faq__q{font-size:.9rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--sly-ink);margin:0 0 .4rem}
	.sly-cu-faq__a{font-size:.9rem;line-height:1.65;color:var(--sly-ink);opacity:.78;margin:0}
	.sly-cu-faq__a a{color:var(--sly-accent);font-weight:600}
	.sly-cu-faq__a a:hover{color:var(--sly-accent-hover)}

	/* ── CTA — gradient teal with square corners ──────────────────── */
	.sly-cu-cta{width:100%;max-width:none;margin:0;padding:3rem clamp(1rem,4vw,3rem)}
	.sly-cu-cta__inner{width:100%;max-width:none;margin:0;padding:0}
	.sly-cu-cta__panel{background:linear-gradient(120deg,#146a7b 0%,#197E92 50%,#1a8fa5 100%);border-radius:0;padding:3rem 2.5rem;text-align:center;color:#fff}
	.sly-cu-cta__dots{display:flex;justify-content:center;align-items:center;gap:.4rem;margin:0 0 1rem}
	.sly-cu-cta__dots span{display:inline-block;width:8px;height:8px;border-radius:50%}
	.sly-cu-cta__dots span:nth-child(1){background:rgba(255,255,255,.85)}
	.sly-cu-cta__dots span:nth-child(2){background:#D7E05A}
	.sly-cu-cta__dots span:nth-child(3){background:rgba(255,255,255,.4)}
	.sly-cu-cta__title{font-size:clamp(1.5rem,3.5vw,2.2rem)!important;font-weight:900;text-transform:uppercase;letter-spacing:.04em;margin:0 0 .65rem;color:#fff;line-height:1.2}
	.sly-cu-cta__sub{font-size:1rem!important;opacity:.9;margin:0 0 1.75rem;color:#fff;font-weight:300}
	.sly-cu-cta__btns{display:flex;gap:1rem;justify-content:center;flex-wrap:wrap}
	.sly-cu-cta__btns .sly-button{background:#fff;color:#146a7b;border:2px solid #fff}
	.sly-cu-cta__btns .sly-button:hover{background:transparent;color:#fff;border-color:#fff}
	.sly-cu-cta__btns .sly-button--ghost{background:transparent;color:#fff;border:2px solid rgba(255,255,255,.5)}
	.sly-cu-cta__btns .sly-button--ghost:hover{background:rgba(255,255,255,.16);border-color:#fff}

	/* ── Responsive ────────────────────────────────────────────────── */
	@media(max-width:900px){
		.sly-cu-hero{padding:3.5rem 0 2.75rem}
		.sly-cu-channels__grid{grid-template-columns:1fr}
		.sly-cu-cta__panel{padding:2.25rem 1.5rem}
	}
	@media(max-width:600px){
		.sly-cu-channel{padding:1.5rem 1.25rem}
		.sly-cu-faq__item{padding:1rem 1.25rem 1rem 1.35rem}
	}
	</style>
	<?php
}, 2 );

get_header();
?>

<!-- ── Hero ──────────────────────────────────────────────────────────────── -->
<section class="sly-cu-hero" data-reveal>
	<div class="container sly-cu-hero__inner">
		<p class="sly-cu-hero__kicker">Talk to Real Humans</p>
		<h1 class="sly-cu-hero__title">We're Listening</h1>
		<p class="sly-cu-hero__sub">No bots. No scripts. No waiting on hold to talk to someone who has no idea what they're talking about. Just actual humans who read emails and know their stuff.</p>
		<div class="sly-cu-chips">
			<span class="sly-cu-chip">📧 Usually Within 24 Hrs</span>
			<span class="sly-cu-chip sly-cu-chip--lime">✅ Real People, Real Answers</span>
		</div>
	</div>
</section>

<!-- ── Contact form — pulled directly from the page, nothing omitted ────── -->
<section class="sly-cu-wrap">
	<div class="sly-cu-card">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		<?php endwhile; ?>
	</div>
</section>

<!-- ── Contact channel cards ─────────────────────────────────────────────── -->
<section class="sly-cu-channels" data-reveal>
	<h2 class="sly-cu-channels__title">Got Another Question?</h2>
	<div class="sly-cu-channels__grid">

		<div class="sly-cu-channel" data-reveal>
			<div class="sly-cu-channel__num">01</div>
			<h3 class="sly-cu-channel__title">Hit Us Up via Email</h3>
			<p class="sly-cu-channel__body">The fastest way to get a real answer from someone who actually knows what they're doing. Tell us what's up and we'll get back to you — for real.</p>
			<a href="mailto:sales@slycollective.com" class="sly-cu-channel__link">sales@slycollective.com</a>
		</div>

		<div class="sly-cu-channel" data-reveal>
			<div class="sly-cu-channel__num">02</div>
			<h3 class="sly-cu-channel__title">Returns Portal</h3>
			<p class="sly-cu-channel__body">Wrong size? No problem. Our returns portal has answers to basically every question we get asked — and if it doesn't, we'll take care of you.</p>
			<a href="<?php echo esc_url( home_url( '/returns/' ) ); ?>" class="sly-cu-channel__link">Returns Portal</a>
		</div>

		<div class="sly-cu-channel" data-reveal>
			<div class="sly-cu-channel__num">03</div>
			<h3 class="sly-cu-channel__title">Check Our Size Guide</h3>
			<p class="sly-cu-channel__body">Seriously, check this before you order. We've mapped everything out with measurements, charts, and international sizing so you don't end up with the wrong fit.</p>
			<a href="<?php echo esc_url( home_url( '/size_chart/size-guide/' ) ); ?>" class="sly-cu-channel__link">Size Guide</a>
		</div>

	</div>
</section>

<!-- ── Before you hit send ───────────────────────────────────────────────── -->
<section class="sly-cu-faq" data-reveal>
	<h2 class="sly-cu-faq__title">FAQs Worth Reading</h2>
	<div class="sly-cu-faq__list">

		<div class="sly-cu-faq__item" data-reveal>
			<p class="sly-cu-faq__q">Where's my order?</p>
			<p class="sly-cu-faq__a">Log into your account or check that confirmation email we sent you — the tracking link's right there. Still can't find it? Email us and we'll dig it up for you.</p>
		</div>

		<div class="sly-cu-faq__item" data-reveal>
			<p class="sly-cu-faq__q">Can I swap for a different size?</p>
			<p class="sly-cu-faq__a">Absolutely. Free exchanges, zero guilt. Head over to our <a href="<?php echo esc_url( home_url( '/returns/' ) ); ?>">Returns &amp; Exchanges page</a> and we'll get you sorted.</p>
		</div>

		<div class="sly-cu-faq__item" data-reveal>
			<p class="sly-cu-faq__q">Do you ship internationally?</p>
			<p class="sly-cu-faq__a">Yeah, we ship worldwide. Duties and taxes on international orders? That's your government's thing, not ours — unfortunately for your wallet.</p>
		</div>

	</div>
</section>

<!-- ── CTA ───────────────────────────────────────────────────────────────── -->
<section class="sly-cu-cta">
	<div class="sly-cu-cta__inner">
		<div class="sly-cu-cta__panel" data-reveal>
			<div class="sly-cu-cta__dots" aria-hidden="true"><span></span><span></span><span></span></div>
			<p class="sly-cu-cta__title">While You're Here...</p>
			<p class="sly-cu-cta__sub">Pouch underwear built for the way men actually move, pockets where they matter, and quick-dry tech so you're never caught waiting. Basically, the underwear you should've had years ago.</p>
			<div class="sly-cu-cta__btns">
				<a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="sly-button">Shop Now</a>
				<a href="<?php echo esc_url( home_url( '/size_chart/size-guide/' ) ); ?>" class="sly-button sly-button--ghost">Size Guide</a>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
