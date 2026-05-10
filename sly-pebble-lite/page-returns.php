<?php
/**
 * Template Name: Returns & Exchanges
 * Slug: returns
 *
 * Returns & exchange policy page — SLY Collective.
 * In WordPress: create a page with slug "returns", then set this as its template.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ── SEO meta ──────────────────────────────────────────────────────────────────
add_action( 'wp_head', function () {
	$canonical = home_url( '/returns/' );
	?>
	<meta name="description" content="SLY Collective returns &amp; exchange policy. 30-day returns window, free size swaps, 12-month warranty on manufacturer defects, and a Comfort Guarantee. Hassle-free.">
	<meta name="robots" content="index, follow">
	<meta property="og:title" content="Returns &amp; Exchanges — No Drama | SLY Collective">
	<meta property="og:description" content="Bought the wrong size? Changed your mind? SLY's return process is built to be painless — 30 days, free size swaps, tracked postage. We'll sort it.">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?php echo esc_url( $canonical ); ?>">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:title" content="Returns &amp; Exchanges | SLY Collective">
	<meta name="twitter:description" content="30-day returns, free size swaps, 12-month warranty. SLY Collective makes returns painless.">
	<link rel="canonical" href="<?php echo esc_url( $canonical ); ?>">
	<?php
}, 1 );

// ── Page CSS ───────────────────────────────────────────────────────────────────
add_action( 'wp_head', function () {
	?>
	<style>
	/* ── Hero ──────────────────────────────────────────────────────── */
	.sly-rp-hero{background:var(--sly-sand);padding:4.5rem 0 3rem;text-align:center}
	.sly-rp-hero__kicker{font-size:.78rem;font-weight:700;letter-spacing:.16em;color:var(--sly-accent);text-transform:uppercase;margin:0 0 .75rem}
	.sly-rp-hero__title{font-size:clamp(2.2rem,5.5vw,3.8rem)!important;font-weight:900;text-transform:uppercase;color:var(--sly-ink);margin:0 0 1rem;letter-spacing:.04em;line-height:1.1}
	.sly-rp-hero__sub{font-size:1.05rem!important;color:var(--sly-ink);opacity:.78;margin:0;font-weight:300}

	/* ── At-a-Glance stats ─────────────────────────────────────────── */
	.sly-rp-stats{padding:2.5rem 0;border-bottom:1px solid var(--sly-line)}
	.sly-rp-stats__grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem}
	.sly-rp-stat{text-align:center;padding:1.5rem 1rem;background:#fff;border:1px solid var(--sly-line);border-radius:var(--sly-radius-sm)}
	.sly-rp-stat__value{font-size:clamp(1.8rem,3.5vw,2.6rem);font-weight:900;color:var(--sly-accent);line-height:1;letter-spacing:-.02em;margin-bottom:.4rem}
	.sly-rp-stat__label{font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;opacity:.7}
	.sly-rp-stat__note{font-size:.78rem;opacity:.5;margin-top:.2rem}

	/* ── Intro ─────────────────────────────────────────────────────── */
	.sly-rp-intro{max-width:780px;margin-inline:auto;padding-block:3rem 2rem;text-align:center}
	.sly-rp-intro p{font-size:1.05rem!important;line-height:1.75;opacity:.9}

	/* ── Section ───────────────────────────────────────────────────── */
	.sly-rp-section{padding-block:2.5rem}
	.sly-rp-section>h2{font-size:clamp(1.35rem,3vw,2rem)!important;margin-bottom:.4rem}
	.sly-rp-section__sub{font-size:.95rem!important;opacity:.7;margin:0 0 1.75rem;font-weight:300}

	/* ── Steps ─────────────────────────────────────────────────────── */
	.sly-rp-steps{display:grid;gap:.75rem;margin-top:1.5rem}
	.sly-rp-step{display:grid;grid-template-columns:3rem 1fr;gap:1rem;align-items:start;background:var(--sly-sand);border-radius:var(--sly-radius-sm);padding:1.25rem 1.5rem}
	.sly-rp-step__num{font-size:1.6rem;font-weight:900;color:var(--sly-accent);line-height:1;letter-spacing:-.03em}
	.sly-rp-step__body h3{font-size:.88rem!important;font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin:0 0 .35rem;color:var(--sly-ink)}
	.sly-rp-step__body p{font-size:.88rem!important;opacity:.82;margin:0;line-height:1.6}
	.sly-rp-step__body a{color:var(--sly-accent);font-weight:600}

	/* ── Checklist ─────────────────────────────────────────────────── */
	.sly-rp-checklist{list-style:none;margin:1.5rem 0 0;padding:0;display:grid;gap:.6rem}
	.sly-rp-checklist li{display:flex;align-items:flex-start;gap:.75rem;font-size:.92rem;line-height:1.55;padding:.85rem 1.1rem;border:1px solid var(--sly-line);border-radius:10px;background:#fff}
	.sly-rp-checklist li::before{content:"✓";flex-shrink:0;width:1.4rem;height:1.4rem;border-radius:50%;background:var(--sly-accent);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:800;margin-top:.1rem}

	/* ── No-list ───────────────────────────────────────────────────── */
	.sly-rp-nolist{list-style:none;margin:1.5rem 0 0;padding:0;display:grid;gap:.5rem}
	.sly-rp-nolist li{display:flex;align-items:flex-start;gap:.65rem;font-size:.92rem;line-height:1.55;padding:.8rem 1.1rem;border-left:3px solid #c0392b;background:#fff8f8;border-radius:0 10px 10px 0}
	.sly-rp-nolist li::before{content:"✕";flex-shrink:0;color:#c0392b;font-weight:800;font-size:.8rem;margin-top:.15rem}

	/* ── Two-col ───────────────────────────────────────────────────── */
	.sly-rp-two-col{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-top:1.75rem}
	.sly-rp-card{background:var(--sly-sand);border-radius:var(--sly-radius);padding:2rem 1.75rem}
	.sly-rp-card h3{font-size:.9rem!important;font-weight:700;text-transform:uppercase;letter-spacing:.07em;margin:0 0 .7rem;color:var(--sly-ink)}
	.sly-rp-card p{font-size:.9rem!important;opacity:.85;margin:0 0 .55rem;line-height:1.65}
	.sly-rp-card p:last-child{margin-bottom:0}
	.sly-rp-card a{color:var(--sly-accent);font-weight:600}

	/* ── Address card ──────────────────────────────────────────────── */
	.sly-rp-address-wrap{margin-top:1.75rem}
	.sly-rp-address{display:inline-block;background:var(--sly-ink);color:#fff;border-radius:var(--sly-radius-sm);padding:1.75rem 2.25rem;font-size:.95rem;line-height:2;font-family:var(--sly-font-family)}
	.sly-rp-address strong{display:block;font-size:.72rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--sly-accent);margin-bottom:.65rem;line-height:1}

	/* ── Comfort guarantee ─────────────────────────────────────────── */
	.sly-rp-guarantee{margin-top:1.75rem;border:2px solid var(--sly-accent);border-radius:var(--sly-radius);padding:2.5rem 2rem;background:#fff;text-align:center}
	.sly-rp-guarantee__icon{font-size:2.8rem;line-height:1;margin-bottom:.75rem}
	.sly-rp-guarantee__title{font-size:clamp(1.25rem,3vw,1.75rem)!important;font-weight:900;text-transform:uppercase;letter-spacing:.04em;color:var(--sly-accent);margin:0 0 .85rem}
	.sly-rp-guarantee__body{font-size:.95rem!important;opacity:.85;line-height:1.75;margin:0 auto;max-width:58ch}

	/* ── Divider ───────────────────────────────────────────────────── */
	.sly-rp-divider{border:none;border-top:1px solid var(--sly-line);margin:0}

	/* ── CTA ───────────────────────────────────────────────────────── */
	.sly-rp-cta{padding-block:4rem}
	.sly-rp-cta__inner{background:var(--sly-ink);color:#fff;border-radius:var(--sly-radius);padding:3.5rem 2.5rem;text-align:center}
	.sly-rp-cta__headline{font-size:clamp(1.6rem,4vw,2.6rem)!important;font-weight:900;text-transform:uppercase;letter-spacing:.04em;margin:0 0 .75rem;color:#fff;line-height:1.15}
	.sly-rp-cta__sub{font-size:1rem!important;opacity:.82;margin:0 0 2rem;color:#fff;font-weight:300}
	.sly-rp-cta__btns{display:flex;gap:1rem;justify-content:center;flex-wrap:wrap}
	.sly-rp-cta__btns .sly-button{background:#fff;color:var(--sly-ink);border:2px solid #fff}
	.sly-rp-cta__btns .sly-button:hover{background:var(--sly-accent);color:#fff;border-color:var(--sly-accent)}
	.sly-rp-cta__btns .sly-button--ghost{background:transparent;color:#fff;border:2px solid rgba(255,255,255,.45)}
	.sly-rp-cta__btns .sly-button--ghost:hover{background:rgba(255,255,255,.12);border-color:#fff}

	/* ── Responsive ────────────────────────────────────────────────── */
	@media(max-width:1080px){
		.sly-rp-two-col{grid-template-columns:1fr 1fr}
	}
	@media(max-width:900px){
		.sly-rp-hero{padding:3rem 0 2.25rem}
		.sly-rp-two-col{grid-template-columns:1fr}
		.sly-rp-cta__inner{padding:2.75rem 1.75rem}
		.sly-rp-guarantee{padding:2rem 1.5rem}
	}
	@media(max-width:600px){
		.sly-rp-stats__grid{grid-template-columns:1fr}
		.sly-rp-step{grid-template-columns:2.25rem 1fr;padding:1rem 1.1rem}
		.sly-rp-address{display:block}
		.sly-rp-cta__inner{padding:2.25rem 1.25rem}
	}
	</style>
	<?php
}, 2 );

get_header();
?>

<!-- ── Hero ──────────────────────────────────────────────────────────────── -->
<section class="sly-rp-hero" data-reveal>
	<div class="container">
		<p class="sly-rp-hero__kicker">No Drama. Just Solutions.</p>
		<h1 class="sly-rp-hero__title">Returns &amp; Exchanges</h1>
		<p class="sly-rp-hero__sub">Not feeling it? Wrong size? Defective? We'll make it right — no guilt trips, no lectures.</p>
	</div>
</section>

<!-- ── At-a-Glance Stats ─────────────────────────────────────────────────── -->
<section class="container sly-rp-stats" data-reveal>
	<div class="sly-rp-stats__grid">

		<div class="sly-rp-stat" data-reveal>
			<div class="sly-rp-stat__value">30</div>
			<div class="sly-rp-stat__label">Days to Return</div>
			<div class="sly-rp-stat__note">From your delivery date</div>
		</div>

		<div class="sly-rp-stat" data-reveal>
			<div class="sly-rp-stat__value">FREE</div>
			<div class="sly-rp-stat__label">Size Exchanges</div>
			<div class="sly-rp-stat__note">We cover the return postage</div>
		</div>

		<div class="sly-rp-stat" data-reveal>
			<div class="sly-rp-stat__value">12M</div>
			<div class="sly-rp-stat__label">Warranty</div>
			<div class="sly-rp-stat__note">On all manufacturer defects</div>
		</div>

	</div>
</section>

<!-- ── Intro ─────────────────────────────────────────────────────────────── -->
<section class="container sly-rp-intro" data-reveal>
	<p>Look, we get it. Online shopping for underwear is a bit of a gamble. Maybe the size is off. Maybe your partner accidentally ordered a Medium for someone who is very much an XL. Whatever the story — we've made this process as painless as humanly possible, because nobody should be stressed about their undies.</p>
</section>

<hr class="sly-rp-divider">

<!-- ── Comfort Guarantee ─────────────────────────────────────────────────── -->
<section class="container sly-rp-section" data-reveal>
	<h2>The SLY Comfort Guarantee</h2>
	<p class="sly-rp-section__sub">Buy with confidence. Fit feels off? We'll fix it.</p>

	<div class="sly-rp-guarantee" data-reveal>
		<div class="sly-rp-guarantee__icon">🛡️</div>
		<p class="sly-rp-guarantee__title">Buy One. Try One. Love It or Swap It.</p>
		<p class="sly-rp-guarantee__body">Ordered your usual size and it's sitting a bit weird? That's what the Comfort Guarantee is for. If the fit isn't quite right, we'll either refund your purchase or swap it for the right size — no hard feelings. If you've bought multiple pairs, you can return any that are still <strong>sealed and unopened</strong>. Just include your order number when you reach out and we'll handle the rest.</p>
	</div>
</section>

<hr class="sly-rp-divider">

<!-- ── Refunds ───────────────────────────────────────────────────────────── -->
<section class="container sly-rp-section" data-reveal>
	<h2>Refunds — Changed Your Mind?</h2>
	<p class="sly-rp-section__sub">No worries. Here's what needs to be true before you post anything back.</p>

	<ul class="sly-rp-checklist">
		<li>Items must be <strong>unused and unwashed</strong> with <strong>original tags still attached</strong>. If the pouch has seen any action, we can't take it back — that's just basic hygiene.</li>
		<li>Items must be posted back <strong>within 30 days of your delivery date</strong>, with your proof of purchase included in the parcel.</li>
		<li>Only <strong>regular-priced items</strong> are eligible for a refund. Sale items are final — a discount was applied at checkout, and that decision sticks.</li>
		<li><strong>Return postage is covered by the buyer</strong> for refunds. We recommend using tracked postage — we can't process what we haven't received, and "it got lost" is a rough situation for everyone.</li>
	</ul>
</section>

<!-- ── How To Return ─────────────────────────────────────────────────────── -->
<section class="container sly-rp-section" data-reveal>
	<h2>How to Return Your Item</h2>
	<p class="sly-rp-section__sub">Four steps. That's it. No hoops, no forms, no 47-page policy document.</p>

	<div class="sly-rp-steps">

		<div class="sly-rp-step" data-reveal>
			<div class="sly-rp-step__num">01</div>
			<div class="sly-rp-step__body">
				<h3>Fire Us an Email First</h3>
				<p>Send your name and order number to <a href="mailto:sales@slycollective.com">sales@slycollective.com</a> so we know a return is on its way. No surprise parcels — a heads-up keeps things moving quickly on our end.</p>
			</div>
		</div>

		<div class="sly-rp-step" data-reveal>
			<div class="sly-rp-step__num">02</div>
			<div class="sly-rp-step__body">
				<h3>Pack It Up &amp; Post It Back</h3>
				<p>Pop the item back in its original packaging (or something equally protective), include your proof of purchase, and post it to the address below. Unused. Tags on. You know the deal.</p>
			</div>
		</div>

		<div class="sly-rp-step" data-reveal>
			<div class="sly-rp-step__num">03</div>
			<div class="sly-rp-step__body">
				<h3>Email Your Tracking Number — This Part Matters</h3>
				<p>The moment your parcel is in the system, email us your tracking number. <strong>This step is non-negotiable.</strong> No tracking number means delays on our end — and nobody wants that. It's a 30-second job that saves days of back-and-forth.</p>
			</div>
		</div>

		<div class="sly-rp-step" data-reveal>
			<div class="sly-rp-step__num">04</div>
			<div class="sly-rp-step__body">
				<h3>We'll Take It From There</h3>
				<p>Once we receive and inspect your return, we'll email you with the outcome — approved or not, with a reason either way. Approved refunds are credited back to your original payment method within a few business days.</p>
			</div>
		</div>

	</div>

	<div class="sly-rp-address-wrap" data-reveal>
		<div class="sly-rp-address">
			<strong>📦 Return Address</strong>
			SLY Collective Returns<br>
			6 Martinique Court<br>
			Parrearra&nbsp; QLD&nbsp; 4575<br>
			Australia
		</div>
	</div>
</section>

<hr class="sly-rp-divider">

<!-- ── Exchanges ─────────────────────────────────────────────────────────── -->
<section class="container sly-rp-section" data-reveal>
	<h2>Size Exchanges — Getting the Right Fit</h2>
	<p class="sly-rp-section__sub">Sizing online is never a perfect science. If it's off, we fix it — and for size swaps, we cover the shipping.</p>

	<div class="sly-rp-two-col">

		<div class="sly-rp-card" data-reveal>
			<h3>What You Need to Do</h3>
			<p>Get in touch at <a href="mailto:info@slycollective.com">info@slycollective.com</a> with your order number and the size you're after. We'll confirm availability and arrange the swap from there.</p>
			<p>Same rules apply: item must be unused, unwashed, tags intact, and posted back within 30 days of delivery. Think of it like returning a library book — in the exact condition you borrowed it, minus any overdue fines.</p>
		</div>

		<div class="sly-rp-card" data-reveal>
			<h3>What We'll Do</h3>
			<p>For size exchanges, <strong>SLY Collective covers the return postage</strong>. Send it back, we ship out the right size — no charge to you.</p>
			<p>We can only swap for sizes that are in stock on the website at the time of exchange. If yours happens to be sold out, we'll work through the options with you.</p>
			<p>Please note: exchanges are not available for international orders at this time. We're working on it.</p>
		</div>

	</div>

	<ul class="sly-rp-checklist" style="margin-top:1.5rem">
		<li>Item must be unused, unwashed, and have original tags attached — same rules as refunds.</li>
		<li>Posted back within 30 days of delivery with proof of purchase in the parcel.</li>
		<li>For size exchanges, <strong>return postage is covered by SLY Collective</strong>.</li>
		<li>Not sure which size to order next time? Our <a href="<?php echo esc_url( home_url( '/size_chart/size-guide/' ) ); ?>">Size Guide</a> will sort you out — measure once, order right.</li>
	</ul>
</section>

<hr class="sly-rp-divider">

<!-- ── Warranty & Replacements ───────────────────────────────────────────── -->
<section class="container sly-rp-section" data-reveal>
	<h2>Warranty &amp; Defective Items</h2>
	<p class="sly-rp-section__sub">We stand behind what we make. 12 months, no exceptions for genuine manufacturing faults.</p>

	<div class="sly-rp-two-col">

		<div class="sly-rp-card" data-reveal>
			<h3>12-Month Manufacturer Warranty</h3>
			<p>Every SLY product carries a <strong>12-month warranty</strong> against manufacturer defects. The clock starts from the date of your original purchase — not from any exchange or replacement date. First Pair Guarantee or exchange? Still covered from day one.</p>
			<p>If something's gone wrong because of how it was made — stitching failure, material defect, the waistband gave up after a week — we want to know about it.</p>
		</div>

		<div class="sly-rp-card" data-reveal>
			<h3>Replacements for Defective Items</h3>
			<p>We replace items that are genuinely defective or damaged due to manufacturing faults. General wear-and-tear after years of faithful service is a different matter — that's just a life well lived.</p>
			<p>To process a warranty claim, we may ask you to <strong>photograph the defect</strong> or send the item back for inspection before we assess anything. We'll let you know what we need when you get in touch.</p>
		</div>

	</div>
</section>

<hr class="sly-rp-divider">

<!-- ── When We Receive ────────────────────────────────────────────────────── -->
<section class="container sly-rp-section" data-reveal>
	<h2>Once We've Got Your Return</h2>
	<p class="sly-rp-section__sub">Here's what happens at our end once your parcel lands.</p>

	<div class="sly-rp-steps">

		<div class="sly-rp-step" data-reveal>
			<div class="sly-rp-step__num">01</div>
			<div class="sly-rp-step__body">
				<h3>We Inspect It</h3>
				<p>Every return is checked to confirm it meets the requirements above. This typically happens within 2–3 business days of us receiving your parcel.</p>
			</div>
		</div>

		<div class="sly-rp-step" data-reveal>
			<div class="sly-rp-step__num">02</div>
			<div class="sly-rp-step__body">
				<h3>We Email You the Outcome</h3>
				<p>You'll get an email confirming whether your return is approved or rejected — with a clear reason either way. No ghosting. No radio silence. You'll know where things stand.</p>
			</div>
		</div>

		<div class="sly-rp-step" data-reveal>
			<div class="sly-rp-step__num">03</div>
			<div class="sly-rp-step__body">
				<h3>Refund Hits Your Account — or Replacement Ships</h3>
				<p>Approved refunds are credited back to your original payment method. Timing depends on your bank, but generally 3–5 business days after approval. Exchanges ship as soon as the replacement is in hand.</p>
			</div>
		</div>

	</div>
</section>

<hr class="sly-rp-divider">

<!-- ── When We Can't ─────────────────────────────────────────────────────── -->
<section class="container sly-rp-section" data-reveal>
	<h2>When We Have to Say No</h2>
	<p class="sly-rp-section__sub">We wish we could say yes to everything. Here's where we genuinely can't, and why.</p>

	<ul class="sly-rp-nolist">
		<li>More than 30 days have passed since your delivery date. Time waits for no one — and neither does our returns window.</li>
		<li>The item isn't in original condition — used, washed, damaged, or missing tags. If the boys have been in there, that pair is yours now. That's just hygiene.</li>
		<li>The order wasn't delivered due to an incorrect address you provided at checkout. We ship where you tell us to ship — always double-check before you hit confirm.</li>
		<li>The parcel was delayed or lost by the courier after it left us. We'll do what we can to help, but we can't be held responsible for what happens once it's in Australia Post's hands.</li>
		<li>International orders. We're not set up for international returns or exchanges yet — working on it.</li>
		<li>Sale items. A discount was applied at purchase. That trade-off was made at checkout and it's final.</li>
	</ul>
</section>

<!-- ── CTA ───────────────────────────────────────────────────────────────── -->
<section class="container sly-rp-cta" data-reveal>
	<div class="sly-rp-cta__inner">
		<p class="sly-rp-cta__headline">Ready to Sort It Out?</p>
		<p class="sly-rp-cta__sub">Drop us an email and we'll handle the rest. Or if you're already eyeing the next pair, the shop is right there.</p>
		<div class="sly-rp-cta__btns">
			<a href="mailto:sales@slycollective.com" class="sly-button">Email Us Now</a>
			<a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="sly-button sly-button--ghost">Back to Shop</a>
		</div>
	</div>
</section>

<?php
get_footer();
