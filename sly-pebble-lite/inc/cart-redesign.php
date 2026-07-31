<?php
/**
 * Cart page redesign — SLY Collective
 *
 * Leaves WooCommerce's core cart.php template (and its AJAX/nonce/coupon
 * mechanics) completely untouched. Instead:
 *   - Injects a "cart intel" header (item count, free-shipping progress,
 *     bulk-discount progress) before the cart table.
 *   - Injects a trust/confidence badge band after the cart (fires on both
 *     empty and non-empty states).
 *   - Overrides only the leaf cart-empty.php template for a fun, on-brand
 *     empty-cart moment.
 *   - Re-skins the whole page via a footer-injected <style> block (same
 *     "hard fix" approach already proven on the mobile category pages —
 *     guarantees the rules win regardless of CSS caching/combining).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'sly_cart_is_cart_page' ) ) {
	function sly_cart_is_cart_page() {
		return function_exists( 'is_cart' ) && is_cart();
	}
}

if ( ! function_exists( 'sly_cart_free_shipping_threshold' ) ) {
	function sly_cart_free_shipping_threshold() {
		return (float) apply_filters( 'sly_cart_free_shipping_threshold', 100 );
	}
}

if ( ! function_exists( 'sly_cart_bulk_tiers' ) ) {
	function sly_cart_bulk_tiers() {
		return array(
			array( 'min' => 21, 'pct' => 25 ),
			array( 'min' => 14, 'pct' => 20 ),
			array( 'min' => 7,  'pct' => 15 ),
		);
	}
}

// ── Cart intel — free shipping + bulk discount progress ───────────────────────
if ( ! function_exists( 'sly_cart_render_intel' ) ) {
	function sly_cart_render_intel() {
		if ( ! sly_cart_is_cart_page() || ! WC()->cart || WC()->cart->is_empty() ) {
			return;
		}

		$count     = WC()->cart->get_cart_contents_count();
		$subtotal  = (float) WC()->cart->get_subtotal();
		$threshold = sly_cart_free_shipping_threshold();
		$remaining = max( 0, $threshold - $subtotal );
		$ship_pct  = $threshold > 0 ? min( 100, ( $subtotal / $threshold ) * 100 ) : 100;
		$ship_won  = $remaining <= 0;

		$tiers    = sly_cart_bulk_tiers();
		$top_tier = $tiers[0];
		$bulk_won = $count >= $top_tier['min'];
		$bulk_pct = 100;
		$next_msg = '';

		if ( ! $bulk_won ) {
			// Find the next tier up from current quantity.
			$sorted = array_reverse( $tiers ); // ascending by min
			$prev_min = 0;
			$next     = null;
			foreach ( $sorted as $tier ) {
				if ( $count < $tier['min'] ) {
					$next = $tier;
					break;
				}
				$prev_min = $tier['min'];
			}
			if ( $next ) {
				$span     = max( 1, $next['min'] - $prev_min );
				$bulk_pct = min( 100, ( ( $count - $prev_min ) / $span ) * 100 );
				$more     = $next['min'] - $count;
				$next_msg = sprintf(
					/* translators: 1: items needed, 2: discount percent */
					_n( 'Add %1$d more item for %2$d%% off', 'Add %1$d more items for %2$d%% off', $more, 'sly-pebble-lite' ),
					$more,
					$next['pct']
				);
			}
		} else {
			$current_pct = $top_tier['pct'];
			foreach ( $tiers as $tier ) {
				if ( $count >= $tier['min'] ) {
					$current_pct = $tier['pct'];
					break;
				}
			}
			$next_msg = sprintf( __( 'Bulk Discount unlocked — %d%% off!', 'sly-pebble-lite' ), $current_pct );
		}

		?>
		<div class="sly-cart-intel" data-reveal>
			<p class="sly-cart-intel__count">🛒 <strong><?php echo absint( $count ); ?></strong> <?php echo esc_html( _n( 'item ready to ship', 'items ready to ship', $count, 'sly-pebble-lite' ) ); ?></p>

			<div class="sly-cart-intel__row">
				<p class="sly-cart-intel__label">
					<?php if ( $ship_won ) : ?>
						🎉 <?php esc_html_e( "You've unlocked FREE shipping!", 'sly-pebble-lite' ); ?>
					<?php else : ?>
						🚚 <?php echo wp_kses_post( sprintf( __( 'Add %s more for FREE shipping', 'sly-pebble-lite' ), wc_price( $remaining ) ) ); ?>
					<?php endif; ?>
				</p>
				<div class="sly-cart-intel__track">
					<div class="sly-cart-intel__fill" style="width:<?php echo esc_attr( round( $ship_pct, 1 ) ); ?>%"></div>
				</div>
			</div>

			<div class="sly-cart-intel__row">
				<p class="sly-cart-intel__label">
					<?php echo $bulk_won ? '🔥 ' : '📦 '; ?><?php echo esc_html( $next_msg ); ?>
				</p>
				<div class="sly-cart-intel__track sly-cart-intel__track--lime">
					<div class="sly-cart-intel__fill sly-cart-intel__fill--lime" style="width:<?php echo esc_attr( round( $bulk_pct, 1 ) ); ?>%"></div>
				</div>
			</div>
		</div>
		<?php
	}
}
// Hooked to woocommerce_before_cart (not before_cart_table) so the markup
// lands as a direct sibling of .woocommerce-cart-form / .cart-collaterals —
// required for the grid-column:1/-1 full-width span in the CSS below.
add_action( 'woocommerce_before_cart', 'sly_cart_render_intel', 20 );

// ── Trust / confidence badge band — shows on empty AND full cart ─────────────
if ( ! function_exists( 'sly_cart_render_trust_band' ) ) {
	function sly_cart_render_trust_band() {
		if ( ! sly_cart_is_cart_page() ) {
			return;
		}
		?>
		<div class="sly-cart-trust" data-reveal>
			<div class="sly-cart-trust__item">
				<span class="sly-cart-trust__icon">🔒</span>
				<span>Secure Checkout</span>
			</div>
			<div class="sly-cart-trust__item">
				<span class="sly-cart-trust__icon">🔁</span>
				<span>Free Size Exchanges</span>
			</div>
			<div class="sly-cart-trust__item">
				<span class="sly-cart-trust__icon">💬</span>
				<span>Real Humans, Real Fast</span>
			</div>
			<div class="sly-cart-trust__item">
				<span class="sly-cart-trust__icon">🚚</span>
				<span>Fast AU Dispatch</span>
			</div>
		</div>
		<?php
	}
}
add_action( 'woocommerce_after_cart', 'sly_cart_render_trust_band', 20 );

// Note: the native "Proceed to Checkout" button is restyled entirely via the
// .wc-proceed-to-checkout a.checkout-button CSS rule below — no PHP needed.

// ── Page CSS + JS — footer-injected, high priority so it always wins ─────────
add_action( 'wp_footer', function () {
	if ( ! sly_cart_is_cart_page() ) {
		return;
	}
	?>
	<style>
	body.woocommerce-cart .site-main{padding-top:1.5rem}
	body.woocommerce-cart .commerce-shell{font-size:13px}

	/* ── Cart intel card ──────────────────────────────────────────── */
	.sly-cart-intel{grid-column:1/-1;background:linear-gradient(120deg,#146a7b 0%,#197E92 55%,#1a8fa5 100%);border-radius:16px;padding:1.25rem 1.5rem;color:#fff;margin-bottom:1.5rem;position:relative;overflow:hidden}
	.sly-cart-intel::after{content:"";position:absolute;inset:0;background:radial-gradient(circle at 85% 15%,rgba(255,255,255,.14),transparent 55%);pointer-events:none}
	.sly-cart-intel__count{position:relative;z-index:1;font-size:.85rem!important;font-weight:700;text-transform:uppercase;letter-spacing:.04em;margin:0 0 .9rem;color:#fff}
	.sly-cart-intel__row{position:relative;z-index:1;margin-bottom:.7rem}
	.sly-cart-intel__row:last-child{margin-bottom:0}
	.sly-cart-intel__label{font-size:.78rem!important;font-weight:500;margin:0 0 .35rem;color:rgba(255,255,255,.92)}
	.sly-cart-intel__track{width:100%;height:7px;border-radius:999px;background:rgba(255,255,255,.22);overflow:hidden}
	.sly-cart-intel__fill{height:100%;border-radius:999px;background:#fff;transition:width .5s cubic-bezier(.34,1.56,.64,1)}
	.sly-cart-intel__fill--lime{background:#D7E05A}

	/* ── Two-column desktop layout ────────────────────────────────── */
	@media(min-width:900px){
		body.woocommerce-cart .commerce-shell{display:grid;grid-template-columns:1fr 340px;gap:1.75rem;align-items:start}
		body.woocommerce-cart .woocommerce-cart-form{grid-column:1}
		body.woocommerce-cart .cart-collaterals{grid-column:2;position:sticky;top:6rem}
		.sly-cart-trust{grid-column:1/-1}
	}

	/* ── Cart items — card-ified table, both breakpoints ──────────── */
	body.woocommerce-cart table.cart{display:block;width:100%;border:none;border-collapse:separate;border-spacing:0}
	body.woocommerce-cart table.cart thead{display:none}
	body.woocommerce-cart table.cart tbody{display:flex;flex-direction:column;gap:.65rem}
	body.woocommerce-cart table.cart tr{display:flex;flex-wrap:wrap;align-items:center;gap:.6rem;background:#fff;border:1px solid var(--sly-line);border-radius:14px;padding:.85rem .9rem;position:relative;transition:all .25s ease}
	body.woocommerce-cart table.cart tr:hover{box-shadow:0 8px 20px rgba(0,0,0,.06);transform:translateY(-2px)}
	body.woocommerce-cart table.cart tbody tr:last-child{background:transparent;border:none;box-shadow:none;transform:none;padding:.5rem 0 0}
	body.woocommerce-cart table.cart td{display:block;border:none;padding:0;font-size:.82rem!important}
	body.woocommerce-cart table.cart td.actions{width:100%;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.75rem}

	body.woocommerce-cart td.product-remove{order:1;position:absolute;top:.6rem;right:.6rem;width:auto}
	body.woocommerce-cart td.product-remove a.remove{display:flex!important;align-items:center;justify-content:center;width:24px;height:24px;border-radius:50%;background:var(--sly-sand);color:var(--sly-ink)!important;font-size:1rem!important;line-height:1;transition:all .2s ease}
	body.woocommerce-cart td.product-remove a.remove:hover{background:#c53c3c;color:#fff!important;transform:rotate(90deg)}

	body.woocommerce-cart td.product-thumbnail{order:2;flex:0 0 52px}
	body.woocommerce-cart td.product-thumbnail img{width:52px;height:52px;object-fit:cover;border-radius:10px}

	body.woocommerce-cart td.product-name{order:3;flex:1 1 140px;min-width:110px;font-weight:600;font-size:.85rem!important;padding-right:1.75rem!important}
	body.woocommerce-cart td.product-name a{color:var(--sly-ink);font-weight:700}
	body.woocommerce-cart td.product-name .variation{font-size:.72rem!important;opacity:.65;margin-top:.2rem;font-weight:400}
	body.woocommerce-cart td.product-name dl.variation{display:flex;flex-wrap:wrap;gap:.3rem .5rem;margin:.2rem 0 0}
	body.woocommerce-cart td.product-name dl.variation dt,
	body.woocommerce-cart td.product-name dl.variation dd{display:inline;margin:0;font-size:.72rem!important;font-weight:400}

	body.woocommerce-cart td.product-price{order:4;flex:0 0 auto;opacity:.5;font-size:.74rem!important}

	body.woocommerce-cart td.product-quantity{order:5;flex:0 0 auto}
	body.woocommerce-cart td.product-quantity .quantity{margin:0}
	body.woocommerce-cart td.product-quantity .qty{width:52px!important;min-height:34px!important;height:34px!important;text-align:center;border:1.5px solid var(--sly-line)!important;border-radius:8px!important;font-size:.82rem!important}

	body.woocommerce-cart td.product-subtotal{order:6;flex:0 0 auto;font-weight:800;font-size:.9rem!important;color:var(--sly-ink);margin-left:auto}

	/* Coupon + update-cart row */
	body.woocommerce-cart .coupon{display:flex;gap:.5rem;flex-wrap:wrap;align-items:center}
	body.woocommerce-cart .coupon .input-text{flex:1 1 160px;padding:.6rem .85rem;border:1.5px solid var(--sly-line);border-radius:10px;font-size:.82rem}
	body.woocommerce-cart .coupon button,
	body.woocommerce-cart table.cart button[name="update_cart"]{background:transparent;border:1.5px solid var(--sly-ink);color:var(--sly-ink);border-radius:999px;padding:.55rem 1.25rem;font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.03em;cursor:pointer;transition:all .25s ease}
	body.woocommerce-cart .coupon button:hover,
	body.woocommerce-cart table.cart button[name="update_cart"]:hover{background:var(--sly-ink);color:#fff}

	/* ── Order summary / collaterals sidebar ──────────────────────── */
	body.woocommerce-cart .cart-collaterals{margin-top:1.5rem}
	@media(min-width:900px){body.woocommerce-cart .cart-collaterals{margin-top:0}}
	body.woocommerce-cart .cart_totals{background:#fff;border:1px solid var(--sly-line);border-radius:16px;padding:1.25rem 1.35rem;box-shadow:var(--sly-shadow)}
	body.woocommerce-cart .cart_totals h2{font-size:.95rem!important;font-weight:900;text-transform:uppercase;letter-spacing:.03em;margin:0 0 .9rem;padding-bottom:.6rem;border-bottom:1px dashed var(--sly-line)}
	body.woocommerce-cart .cart_totals table{width:100%;border:none}
	body.woocommerce-cart .cart_totals table th,
	body.woocommerce-cart .cart_totals table td{border:none;padding:.5rem 0;font-size:.8rem!important}
	body.woocommerce-cart .cart_totals table th{font-weight:500;opacity:.7}
	body.woocommerce-cart .cart_totals .order-total th,
	body.woocommerce-cart .cart_totals .order-total td{border-top:1px dashed var(--sly-line);padding-top:.75rem;font-size:.95rem!important;font-weight:800}
	body.woocommerce-cart .wc-proceed-to-checkout{margin-top:1rem;padding:0}
	body.woocommerce-cart .wc-proceed-to-checkout a.checkout-button{display:flex;justify-content:center;align-items:center;width:100%;background:linear-gradient(100deg,#197E92,#1a8fa5);color:#fff!important;border:none;border-radius:999px;padding:.9rem 1.5rem;font-size:.85rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;transition:all .3s cubic-bezier(.34,1.56,.64,1);box-shadow:0 4px 15px rgba(20,106,123,.25)}
	body.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(20,106,123,.35);opacity:.95}

	/* Continue-shopping style link near update cart */
	body.woocommerce-cart .woocommerce-cart-form{margin-bottom:0}

	/* Shipping calculator row */
	body.woocommerce-cart .woocommerce-shipping-calculator{font-size:.8rem;margin-top:.75rem}
	body.woocommerce-cart .shipping-calculator-button{color:var(--sly-accent);font-weight:600;font-size:.78rem}

	/* ── Trust badge band ─────────────────────────────────────────── */
	.sly-cart-trust{display:grid;grid-template-columns:repeat(4,1fr);gap:.75rem;margin-top:1.75rem;padding-top:1.5rem;border-top:1px dashed var(--sly-line)}
	.sly-cart-trust__item{display:flex;flex-direction:column;align-items:center;text-align:center;gap:.35rem;padding:.9rem .5rem;background:var(--sly-sand);border-radius:12px;font-size:.72rem!important;font-weight:600;color:var(--sly-ink);transition:transform .25s ease}
	.sly-cart-trust__item:hover{transform:translateY(-3px)}
	.sly-cart-trust__icon{font-size:1.3rem;line-height:1}

	/* ── Empty cart — fun quirky state ────────────────────────────── */
	.sly-cart-empty{grid-column:1/-1;text-align:center;padding:3.5rem 1.5rem;max-width:460px;margin:0 auto}
	.sly-cart-empty__icon{font-size:3rem;line-height:1;margin-bottom:1rem;animation:sly-cart-bounce 2.4s ease-in-out infinite}
	.sly-cart-empty__title{font-size:1.35rem!important;font-weight:900;text-transform:uppercase;letter-spacing:.03em;margin:0 0 .6rem;color:var(--sly-ink)}
	.sly-cart-empty__sub{font-size:.88rem!important;line-height:1.6;color:var(--sly-ink);opacity:.75;margin:0 0 1.75rem;font-weight:300}
	.sly-cart-empty__btn{display:inline-block;background:linear-gradient(100deg,#197E92,#1a8fa5);color:#fff!important;border-radius:999px;padding:.85rem 2.25rem;font-size:.85rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;transition:all .3s cubic-bezier(.34,1.56,.64,1);box-shadow:0 4px 15px rgba(20,106,123,.2)}
	.sly-cart-empty__btn:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(20,106,123,.3);color:#fff!important}
	@keyframes sly-cart-bounce{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}

	/* ── Mobile ────────────────────────────────────────────────────── */
	@media(max-width:600px){
		.sly-cart-trust{grid-template-columns:repeat(2,1fr)}
		body.woocommerce-cart td.product-subtotal{margin-left:0;flex:1 1 auto;text-align:right}
		body.woocommerce-cart .coupon{flex-direction:column;align-items:stretch}
		body.woocommerce-cart .coupon .input-text,
		body.woocommerce-cart .coupon button{width:100%}
	}
	</style>
	<script>
	(function($){
		function buildCartQtySteppers(){
			$('table.cart .qty').each(function(){
				var $qty = $(this);
				if ($qty.data('sly-cart-stepper')) { return; }
				$qty.data('sly-cart-stepper', true).hide();
				var val = parseInt($qty.val()) || 1;
				var $box = $('<span class="sly-cart-qty-box" style="display:inline-flex;align-items:center;height:34px;border:1.5px solid var(--sly-line,#ddd);border-radius:8px;overflow:hidden;background:#fff"></span>');
				var $minus = $('<button type="button" aria-label="Decrease quantity" style="width:26px;height:34px;border:none;background:#fff;cursor:pointer;font-size:1rem;line-height:1">−</button>');
				var $num = $('<span style="width:28px;text-align:center;font-size:.82rem;font-weight:600">' + val + '</span>');
				var $plus = $('<button type="button" aria-label="Increase quantity" style="width:26px;height:34px;border:none;background:#fff;cursor:pointer;font-size:1rem;line-height:1">+</button>');
				$box.append($minus).append($num).append($plus);
				$qty.after($box);
				function update(n){
					n = Math.max(1, n);
					$qty.val(n).trigger('change');
					$num.text(n);
				}
				$minus.on('click', function(){ update(parseInt($num.text()) - 1); });
				$plus.on('click', function(){ update(parseInt($num.text()) + 1); });
			});
		}
		$(function(){ setTimeout(buildCartQtySteppers, 0); });
		// Rebuild after any AJAX cart refresh (qty change, item removal, coupon
		// apply) — WooCommerce replaces the cart table markup on all of these,
		// which wipes out the injected stepper UI along with it.
		$(document.body).on('updated_cart_totals updated_wc_div wc_fragments_refreshed wc_fragments_loaded removed_from_cart', buildCartQtySteppers);
	})(jQuery);
	</script>
	<?php
}, 9999 );
