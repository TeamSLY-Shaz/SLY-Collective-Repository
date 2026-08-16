<?php
/**
 * Template Name: Terms & Conditions
 * Slug: terms-and-conditions
 *
 * Automatically used for any page with the slug "terms-and-conditions".
 * Complete drafted terms are built into the template so the page renders
 * fully even with an empty editor body. Styled to match the Refund &
 * Returns Policy and Contact page family (teal gradient hero, white
 * content card, lime accent pops — no coral).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ── SEO meta ──────────────────────────────────────────────────────────────────
add_action( 'wp_head', function () {
	$canonical = home_url( '/terms-and-conditions/' );
	?>
	<meta name="description" content="SLY Collective's Terms &amp; Conditions — ordering, pricing, shipping, returns, warranties and your Australian Consumer Law rights, laid out in plain English.">
	<meta name="robots" content="index, follow">
	<link rel="canonical" href="<?php echo esc_url( $canonical ); ?>">
	<?php
}, 1 );

// ── Page CSS ──────────────────────────────────────────────────────────────────
add_action( 'wp_head', function () {
	?>
	<style>
	/* ── Gradient teal hero ────────────────────────────────────────── */
	.sly-tc-hero{position:relative;overflow:hidden;padding:5rem 0 4rem;text-align:center;background:linear-gradient(120deg,#146a7b 0%,#197E92 45%,#1a8fa5 100%);color:#fff}
	.sly-tc-hero::after{content:"";position:absolute;inset:0;background:radial-gradient(circle at 80% 20%,rgba(255,255,255,0.14),transparent 55%);pointer-events:none}
	.sly-tc-hero__inner{position:relative;z-index:1}
	.sly-tc-hero__kicker{font-size:.78rem;font-weight:700;letter-spacing:.18em;color:#fff;opacity:.85;text-transform:uppercase;margin:0 0 .85rem}
	.sly-tc-hero__title{font-size:clamp(2.2rem,5.5vw,3.8rem)!important;font-weight:900;text-transform:uppercase;color:#fff;margin:0 0 1rem;letter-spacing:.04em;line-height:1.1}
	.sly-tc-hero__sub{font-size:1.05rem!important;color:rgba(255,255,255,.88);margin:0 auto;max-width:60ch;font-weight:300}
	.sly-tc-chips{display:flex;flex-wrap:wrap;justify-content:center;gap:.6rem;margin-top:1.75rem;position:relative;z-index:1}
	.sly-tc-chip{display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1.15rem;border-radius:999px;background:rgba(255,255,255,.16);border:1px solid rgba(255,255,255,.35);color:#fff;font-size:.82rem;font-weight:600;letter-spacing:.02em;backdrop-filter:blur(4px)}
	.sly-tc-chip--lime{background:#D7E05A;border-color:#D7E05A;color:#146a7b}

	/* ── Full-width page: hero flush under header, no outer card ───── */
	.site-main{padding-top:0!important}

	/* ── Content — full width, no container/border ─────────────────── */
	.sly-tc-wrap{width:100%;max-width:none;margin:0;padding:3rem clamp(1rem,4vw,3rem) 0}
	.sly-tc-card{background:transparent;border:none;border-radius:0;padding:0;box-shadow:none}
	.sly-tc-card .sly-tc-updated{font-size:.82rem!important;font-weight:600!important;text-transform:uppercase;letter-spacing:.08em;color:var(--sly-accent);margin:0 0 2rem}
	.sly-tc-card p{font-size:1rem!important;line-height:1.75!important;font-weight:300!important;color:var(--sly-ink);margin:0 0 1.25rem}
	.sly-tc-card h2{font-size:clamp(1.2rem,2.5vw,1.6rem)!important;font-weight:900!important;text-transform:uppercase;letter-spacing:.03em;color:var(--sly-ink);margin:2.5rem 0 .9rem;padding-bottom:.6rem;position:relative}
	.sly-tc-card h2::after{content:"";position:absolute;left:0;bottom:0;width:48px;height:4px;border-radius:999px;background:linear-gradient(100deg,#197E92,#1a8fa5)}
	.sly-tc-card h2:first-of-type{margin-top:0}
	.sly-tc-card h3{font-size:1rem!important;font-weight:700!important;text-transform:none;color:var(--sly-accent);margin:1.75rem 0 .6rem}
	.sly-tc-card ul{margin:0 0 1.5rem;padding:0;list-style:none;display:grid;gap:.55rem}
	.sly-tc-card ul li{position:relative;padding:.85rem 1.1rem .85rem 3rem;background:var(--sly-sand);border-radius:10px;font-size:.95rem;line-height:1.65;color:var(--sly-ink)}
	.sly-tc-card ul li::before{content:"✓";position:absolute;left:.95rem;top:.85rem;width:1.5rem;height:1.5rem;border-radius:50%;background:linear-gradient(135deg,#197E92,#1a8fa5);color:#fff;font-size:.7rem;font-weight:800;display:inline-flex;align-items:center;justify-content:center}
	.sly-tc-card a{color:var(--sly-accent);font-weight:600;text-decoration:underline;text-underline-offset:2px}
	.sly-tc-card a:hover{color:var(--sly-accent-hover)}
	.sly-tc-card strong{font-weight:700;color:var(--sly-ink)}
	.sly-tc-callout{margin:1.75rem 0;padding:1.4rem 1.6rem 1.4rem 1.75rem;border-left:4px solid #D7E05A;background:var(--sly-sand);border-radius:0 12px 12px 0;font-size:.95rem;line-height:1.7;color:var(--sly-ink)}
	.sly-tc-callout p{margin:0!important;font-size:.95rem!important}

	/* ── CTA — full width ──────────────────────────────────────────── */
	.sly-tc-cta{padding:3rem 0 4.5rem}
	.sly-tc-cta__inner{width:100%;max-width:none;margin:0;padding:0}
	.sly-tc-cta__panel{background:linear-gradient(120deg,#146a7b 0%,#197E92 50%,#1a8fa5 100%);border-radius:0;padding:3rem 2.5rem;text-align:center;color:#fff}
	.sly-tc-cta__dots{display:flex;justify-content:center;align-items:center;gap:.4rem;margin:0 0 1rem}
	.sly-tc-cta__dots span{display:inline-block;width:8px;height:8px;border-radius:50%}
	.sly-tc-cta__dots span:nth-child(1){background:rgba(255,255,255,.85)}
	.sly-tc-cta__dots span:nth-child(2){background:#D7E05A}
	.sly-tc-cta__dots span:nth-child(3){background:rgba(255,255,255,.4)}
	.sly-tc-cta__title{font-size:clamp(1.5rem,3.5vw,2.2rem)!important;font-weight:900;text-transform:uppercase;letter-spacing:.04em;margin:0 0 .65rem;color:#fff;line-height:1.2}
	.sly-tc-cta__sub{font-size:1rem!important;opacity:.9;margin:0 0 1.75rem;color:#fff;font-weight:300}
	.sly-tc-cta__btns{display:flex;gap:1rem;justify-content:center;flex-wrap:wrap}
	.sly-tc-cta__btns .sly-button{background:#fff;color:#146a7b;border:2px solid #fff}
	.sly-tc-cta__btns .sly-button:hover{background:transparent;color:#fff;border-color:#fff}
	.sly-tc-cta__btns .sly-button--ghost{background:transparent;color:#fff;border:2px solid rgba(255,255,255,.5)}
	.sly-tc-cta__btns .sly-button--ghost:hover{background:rgba(255,255,255,.16);border-color:#fff}

	/* ── Responsive ────────────────────────────────────────────────── */
	@media(max-width:900px){
		.sly-tc-hero{padding:3.5rem 0 2.75rem}
		.sly-tc-wrap{padding:2.25rem 1rem 0}
		.sly-tc-cta__panel{padding:2.25rem 1.5rem}
	}
	@media(max-width:600px){
		.sly-tc-card ul li{padding-left:2.6rem;font-size:.92rem}
	}
	</style>
	<?php
}, 2 );

get_header();
?>

<!-- ── Hero ──────────────────────────────────────────────────────────────── -->
<section class="sly-tc-hero" data-reveal>
	<div class="container sly-tc-hero__inner">
		<p class="sly-tc-hero__kicker">The Legal Bits. Minus the Waffle.</p>
		<h1 class="sly-tc-hero__title">Terms &amp; Conditions</h1>
		<p class="sly-tc-hero__sub">The ground rules for shopping with SLY Collective — written in plain English, because nobody should need a law degree to buy underwear.</p>
		<div class="sly-tc-chips">
			<span class="sly-tc-chip">📜 Plain English</span>
			<span class="sly-tc-chip sly-tc-chip--lime">🇦🇺 Australian Consumer Law Applies</span>
			<span class="sly-tc-chip">🤝 Fair Terms. No Traps.</span>
		</div>
	</div>
</section>

<!-- ── Terms content ─────────────────────────────────────────────────────── -->
<section class="sly-tc-wrap">
	<div class="sly-tc-card">

		<p class="sly-tc-updated">Last updated: 15 July 2026</p>

		<h2>1. Who We Are &amp; What These Terms Cover</h2>
		<p>Welcome to SLY Collective ("SLY", "we", "us", "our"). These Terms &amp; Conditions govern your use of <a href="<?php echo esc_url( home_url( '/' ) ); ?>">slycollective.com</a> and every purchase you make through it. By browsing the site or placing an order, you agree to these terms. If you don't agree with them, that's okay — but you won't be able to shop with us.</p>
		<p>We're an Australian-owned and operated business based on Australia's east coast, covering blokes' butts since 2005.</p>

		<h2>2. Orders &amp; Acceptance</h2>
		<p>When you place an order, you're making an offer to buy. Your order is accepted when we send you an order confirmation email. We reserve the right to decline or cancel an order — for example where stock is unavailable, payment can't be verified, there's an obvious pricing error, or we suspect the order is fraudulent. If we cancel an order you've already paid for, you'll receive a full refund.</p>
		<ul>
			<li><strong>Accuracy is on you</strong> — please double-check your size, delivery address and contact details before hitting the button. We ship what you tell us, where you tell us.</li>
			<li><strong>Order changes</strong> — contact us as fast as possible at <a href="mailto:sales@slycollective.com">sales@slycollective.com</a>. If the order hasn't shipped, we'll do our best to fix it.</li>
		</ul>

		<h2>3. Pricing &amp; Payment</h2>
		<p>All prices are in Australian Dollars (AUD) and include GST where applicable, unless stated otherwise. Prices can change at any time, but changes won't affect orders we've already confirmed. If we discover a genuine pricing error on an order you've placed, we'll contact you with the option to pay the correct price or cancel for a full refund.</p>
		<p>Payment is processed at checkout through our secure third-party payment providers. We never see or store your full card details.</p>

		<h2>4. Discount Codes &amp; Promotions</h2>
		<ul>
			<li><strong>One discount per purchase.</strong> Only one discount can be applied to any single order — full stop. Discount codes can't be stacked with each other, and a code can't be added on top of an automatic discount that's already applied to your order (for example, our bulk buy discount). If your order already benefits from a bulk buy or other automatic promotion, a coupon code can't be used on the same purchase.</li>
			<li>Discount codes (including <strong>SLY20</strong>) apply only as described in the specific offer — SLY20 is for your first order, one use per customer.</li>
			<li>Codes can't be applied retroactively to earlier orders.</li>
			<li>Where more than one discount could technically apply, the order will receive the single discount as determined by the checkout — we may remove or reverse stacked discounts applied in error.</li>
			<li>We may withdraw or change a promotion at any time, but we'll always honour a code validly applied before the change.</li>
		</ul>

		<h2>5. Shipping &amp; Delivery</h2>
		<p>We ship Australia-wide and internationally. Delivery timeframes shown at checkout are estimates, not guarantees — carriers occasionally have their own adventures. Risk in the goods passes to you on delivery to your nominated address.</p>
		<div class="sly-tc-callout">
			<p><strong>International orders:</strong> any customs duties, import taxes or local charges are set by your country's authorities and are your responsibility. That bit's out of our hands.</p>
		</div>

		<h2>6. Returns, Exchanges &amp; Refunds</h2>
		<p>The full details live in our <a href="<?php echo esc_url( home_url( '/refund-returns-policy/' ) ); ?>">Refund &amp; Returns Policy</a>, which forms part of these terms. The short version:</p>
		<ul>
			<li><strong>30-day window</strong> — change-of-mind returns accepted within 30 days of delivery.</li>
			<li><strong>Free size exchanges</strong> — wrong size? We'll swap it, no guilt trips.</li>
			<li><strong>Hygiene rules apply</strong> — it's underwear. Returned items must be unworn, unwashed and in original condition with tags attached, except where covered by our first pair guarantee or a fault claim.</li>
			<li><strong>12-month warranty</strong> — we stand behind our workmanship and materials for 12 months from purchase.</li>
		</ul>

		<h2>7. Your Australian Consumer Law Rights</h2>
		<p>Our goods come with guarantees that cannot be excluded under the Australian Consumer Law. You are entitled to a replacement or refund for a major failure, and compensation for any other reasonably foreseeable loss or damage. You are also entitled to have goods repaired or replaced if they fail to be of acceptable quality and the failure does not amount to a major failure.</p>
		<p>Nothing in these terms excludes, restricts or modifies any consumer guarantee, right or remedy you have under the Australian Consumer Law or any other law that can't be contracted out of.</p>

		<h2>8. Product Information &amp; Sizing</h2>
		<p>We work hard to display our products accurately, but screen colours vary and minor differences between images and the real thing can occur. Sizing is engineered to Australian standards — check the <a href="<?php echo esc_url( home_url( '/size_chart/size-guide/' ) ); ?>">Size Guide</a> before ordering, and when in doubt, size up.</p>

		<h2>9. Intellectual Property</h2>
		<p>Everything on this site — designs, artwork, product names, photography, copy, logos and the SLY Collective brand — is owned by or licensed to us. You're welcome to browse, share links and show your mates. You're not welcome to copy, scrape, reproduce or commercially exploit any of it without our written permission.</p>

		<h2>10. Acceptable Use of the Site</h2>
		<ul>
			<li>Don't misuse the site — no hacking, scraping, injecting malicious code or interfering with other users.</li>
			<li>Don't place fraudulent orders or impersonate other people.</li>
			<li>Reviews and submissions must be your own honest opinion and must not be unlawful, misleading or abusive.</li>
		</ul>

		<h2>11. Privacy</h2>
		<p>We handle your personal information in accordance with our Privacy Policy and the Australian Privacy Principles. We collect what we need to process your order and improve the site — we don't sell your data. Ever.</p>

		<h2>12. Liability</h2>
		<p>To the maximum extent permitted by law (and always subject to your Australian Consumer Law rights in section 7), our total liability for any claim arising out of your use of the site or purchase of products is limited to the amount you paid for the products in question. We're not liable for indirect or consequential loss, or for delays and failures caused by events outside our reasonable control.</p>

		<h2>13. Changes to These Terms</h2>
		<p>We may update these terms from time to time. The version published on this page at the time you place your order is the one that applies to that order. Material changes will be flagged by updating the "Last updated" date above.</p>

		<h2>14. Governing Law</h2>
		<p>These terms are governed by the laws of Queensland, Australia. Any disputes are subject to the non-exclusive jurisdiction of the courts of Queensland and the Commonwealth of Australia.</p>

		<h2>15. Contact Us</h2>
		<p>Questions about these terms? No dramas — email us at <a href="mailto:sales@slycollective.com">sales@slycollective.com</a> or head to our <a href="<?php echo esc_url( home_url( '/contact-us-sly-collective-mens-underwear/' ) ); ?>">Contact page</a>. A real human will get back to you.</p>

	</div>
</section>

<!-- ── CTA ───────────────────────────────────────────────────────────────── -->
<section class="sly-tc-cta">
	<div class="sly-tc-cta__inner">
		<div class="sly-tc-cta__panel" data-reveal>
			<div class="sly-tc-cta__dots" aria-hidden="true"><span></span><span></span><span></span></div>
			<p class="sly-tc-cta__title">Right. Now Back to the Good Stuff.</p>
			<p class="sly-tc-cta__sub">You've read the fine print (legend). Reward yourself with underwear that actually works.</p>
			<div class="sly-tc-cta__btns">
				<a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="sly-button">Shop the Range</a>
				<a href="<?php echo esc_url( home_url( '/refund-returns-policy/' ) ); ?>" class="sly-button sly-button--ghost">Refund &amp; Returns Policy</a>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
