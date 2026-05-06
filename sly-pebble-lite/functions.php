<?php
if (!defined('ABSPATH')) {
	exit;
}

if (!defined('SLY_PEBBLE_LITE_VERSION')) {
	$theme = wp_get_theme();
	define('SLY_PEBBLE_LITE_VERSION', $theme->get('Version') ?: '1.0.0');
}

if (!function_exists('sly_pebble_lite_setup')) {
	function sly_pebble_lite_setup() {
		load_theme_textdomain('sly-pebble-lite', get_template_directory() . '/languages');

		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		add_theme_support('automatic-feed-links');
		add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
		add_theme_support('wp-block-styles');
		add_theme_support('align-wide');
		add_theme_support('responsive-embeds');
		add_theme_support('editor-styles');
		add_theme_support('woocommerce', array(
			'thumbnail_image_width' => 560,
			'single_image_width'    => 980,
			'product_grid'          => array(
				'default_rows'    => 2,
				'min_rows'        => 1,
				'max_rows'        => 6,
				'default_columns' => 4,
				'min_columns'     => 2,
				'max_columns'     => 4,
			),
		));
		add_theme_support('wc-product-gallery-zoom');
		add_theme_support('wc-product-gallery-lightbox');
		add_theme_support('wc-product-gallery-slider');

		register_nav_menus(array(
			'primary' => __('Primary Menu', 'sly-pebble-lite'),
			'footer'  => __('Footer Menu', 'sly-pebble-lite'),
		));

		add_image_size('sly_product_card', 720, 900, true);
	}
}
add_action('after_setup_theme', 'sly_pebble_lite_setup');

if (!function_exists('sly_pebble_lite_content_width')) {
	function sly_pebble_lite_content_width() {
		$GLOBALS['content_width'] = 1200;
	}
}
add_action('after_setup_theme', 'sly_pebble_lite_content_width', 0);

if (!function_exists('sly_pebble_lite_disable_wp_bloat')) {
	function sly_pebble_lite_disable_wp_bloat() {
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('wp_print_styles', 'print_emoji_styles');
		remove_action('admin_print_scripts', 'print_emoji_detection_script');
		remove_action('admin_print_styles', 'print_emoji_styles');
		remove_action('wp_head', 'rest_output_link_wp_head');
		remove_action('wp_head', 'wp_oembed_add_discovery_links');
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'wp_shortlink_wp_head');
	}
}
add_action('init', 'sly_pebble_lite_disable_wp_bloat');

// Remove render-blocking WordPress default CSS
if (!function_exists('sly_pebble_lite_remove_block_styles')) {
	function sly_pebble_lite_remove_block_styles() {
		wp_dequeue_style('wp-block-library');
		wp_dequeue_style('wp-block-library-theme');
		wp_dequeue_style('classic-theme-styles');
		wp_dequeue_style('global-styles');
	}
}
add_action('wp_enqueue_scripts', 'sly_pebble_lite_remove_block_styles', 100);

// Remove jQuery Migrate (~10 KB) — not needed by this theme
if (!function_exists('sly_pebble_lite_remove_jquery_migrate')) {
	function sly_pebble_lite_remove_jquery_migrate($scripts) {
		if (!is_admin() && isset($scripts->registered['jquery'])) {
			$scripts->registered['jquery']->deps = array_diff(
				$scripts->registered['jquery']->deps,
				array('jquery-migrate')
			);
		}
	}
}
add_action('wp_default_scripts', 'sly_pebble_lite_remove_jquery_migrate');

// Preload hero image in <head> — must be early so browser fetches it immediately
if (!function_exists('sly_pebble_lite_preload_hero_image')) {
	function sly_pebble_lite_preload_hero_image() {
		if (!is_front_page()) {
			return;
		}
		$image_id = absint(get_theme_mod('sly_hero_image'));
		if ($image_id) {
			$src = wp_get_attachment_image_url($image_id, 'full');
		} else {
			$src = get_template_directory_uri() . '/assets/images/hero-model.webp';
		}
		if ($src) {
			echo '<link rel="preload" as="image" href="' . esc_url($src) . '" fetchpriority="high">' . "\n";
		}
	}
}
add_action('wp_head', 'sly_pebble_lite_preload_hero_image', 1);

if (!function_exists('sly_pebble_lite_enqueue_assets')) {
	function sly_pebble_lite_enqueue_assets() {
		$css_file = get_template_directory() . '/assets/css/main.css';
		$js_file  = get_template_directory() . '/assets/js/main.js';

		wp_enqueue_style(
			'sly-pebble-lite-fonts',
			'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap',
			array(),
			null
		);

		wp_enqueue_style(
			'sly-pebble-lite-main',
			get_template_directory_uri() . '/assets/css/main.css',
			array(),
			file_exists($css_file) ? (string) filemtime($css_file) : SLY_PEBBLE_LITE_VERSION
		);

		// Inline overrides — bypasses all caching layers
		wp_add_inline_style('sly-pebble-lite-main', '
			.sly-product-card h3,
			.sly-product-card h3 a,
			.sly-product-card .sly-product-card__title,
			.sly-product-card .sly-product-card__title a,
			.sly-shop-card h3,
			.sly-shop-card h3 a,
			.sly-shop-card .woocommerce-loop-product__title,
			.sly-shop-card .woocommerce-loop-product__title a { font-size: 18px !important; font-weight: 500 !important; text-transform: none !important; }
			.sly-product-card .sly-product-card__price,
			.sly-product-card .price,
			.sly-shop-card .price { font-size: 16px !important; font-weight: 600 !important; }
			.sly-product-card .sly-button--ghost { padding-top: 5px !important; padding-bottom: 5px !important; }
			.sly-product-card, .sly-shop-card { border: none !important; }
		');

		// Category/archive page overrides — injected AFTER the block above so these
		// !important rules win over the equal-specificity rules above.
		wp_add_inline_style('sly-pebble-lite-main', '
			.sly-shop-grid li.product,
			.sly-shop-grid .sly-shop-card { border:none!important; border-radius:0!important; box-shadow:none!important; padding:0!important; background:transparent!important; }
			.sly-shop-grid .sly-shop-card__media { border-radius:0!important; border:none!important; overflow:hidden!important; }
			.sly-shop-grid .sly-shop-card__media img,
			.sly-shop-grid li.product a img { border:none!important; border-radius:0!important; box-shadow:none!important; outline:none!important; }
			.sly-shop-grid .woocommerce-loop-product__title,
			.sly-shop-grid .woocommerce-loop-product__title a { font-size:12px!important; font-weight:500!important; letter-spacing:0!important; line-height:1.3!important; margin:0.3rem 0 0.1rem!important; padding:0 0.4rem!important; }
			.sly-shop-grid .price { font-size:11px!important; font-weight:600!important; display:inline-flex!important; align-items:baseline!important; flex-wrap:wrap!important; gap:0.25em!important; margin:0 0 0.35rem!important; padding:0 0.4rem!important; }
			.sly-shop-grid .price .woocommerce-price-suffix,
			.sly-shop-grid .price small { display:inline!important; font-size:9px!important; font-weight:400!important; opacity:0.65!important; margin:0!important; padding:0!important; white-space:nowrap!important; vertical-align:baseline!important; }
		');

		// Product page overrides — third call, last in HTML output, beats all main.css rules.
		wp_add_inline_style('sly-pebble-lite-main', '
			@media(max-width:900px){
				body.single-product .sly-pd-gallery-col { position:static!important; }
				.sly-pd-wc .woocommerce-variation-add-to-cart,
				.sly-pd-wc .variations_button,
				.sly-pd-wc form.cart:not(.variations_form) { display:flex!important; flex-direction:column!important; flex-wrap:nowrap!important; align-items:flex-start!important; }
				.sly-pd-wc .single_add_to_cart_button,
				.sly-pd-wc .sly-buy-now { width:100%!important; flex:none!important; box-sizing:border-box!important; }
				.sly-pd-var-row { flex-wrap:nowrap!important; align-items:center!important; gap:0.4rem!important; }
				.sly-pd-var-row .sly-size-boxes { flex:1 1 auto!important; min-width:0!important; flex-wrap:nowrap!important; overflow-x:auto!important; }
				.sly-pd-var-row .quantity { flex:0 0 auto!important; width:auto!important; }
			}
			.sly-qty-box { height:auto!important; border:1.5px solid var(--sly-line)!important; border-radius:6px!important; }
			.sly-qty-btn { flex:0 0 auto!important; height:auto!important; padding:0.4rem 0.6rem!important; font-size:0.82rem!important; font-weight:600!important; line-height:1.2!important; }
			.sly-qty-num { flex:0 0 auto!important; height:auto!important; min-width:2em!important; padding:0.4rem 0.5rem!important; font-size:0.82rem!important; font-weight:600!important; line-height:1.2!important; }
			.sly-qty-divider { height:1em!important; }
			body.single-product .sly-pd-price .price { display:inline-flex!important; align-items:baseline!important; flex-wrap:wrap!important; gap:0.35em!important; }
			body.single-product .sly-pd-price .price .woocommerce-price-suffix,
			body.single-product .sly-pd-price .price small { display:inline!important; font-size:0.8rem!important; font-weight:400!important; margin:0!important; padding:0!important; vertical-align:baseline!important; }
			.sly-pd-feature-icon { font-size:1.6rem!important; line-height:1!important; color:var(--sly-accent)!important; flex-shrink:0!important; display:inline-flex!important; align-items:center!important; }
			.sly-rv-track { overflow-x:scroll!important; overflow-y:visible!important; }
			.sly-pd-home-btn { margin-top:2rem!important; padding-top:1.5rem!important; border-top:1px solid var(--sly-line)!important; text-align:center!important; }
			.sly-pd-home-btn .sly-button { background:var(--sly-ink)!important; color:#fff!important; border:1px solid var(--sly-ink)!important; width:50%!important; max-width:50%!important; }
			.sly-pd-home-btn .sly-button:hover { background:var(--sly-accent)!important; border-color:var(--sly-accent)!important; }
		');

		wp_enqueue_script(
			'sly-pebble-lite-main',
			get_template_directory_uri() . '/assets/js/main.js',
			array(),
			file_exists($js_file) ? (string) filemtime($js_file) : SLY_PEBBLE_LITE_VERSION,
			true
		);

		if (class_exists('WooCommerce')) {
			wp_localize_script('sly-pebble-lite-main', 'slyAjax', array(
				'url'   => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('sly-ajax-atc'),
			));
		}

		if (function_exists('is_checkout') && is_checkout()) {
			$checkout_js = get_template_directory() . '/assets/js/checkout-guard.js';
			wp_enqueue_script(
				'sly-pebble-lite-checkout-guard',
				get_template_directory_uri() . '/assets/js/checkout-guard.js',
				array(),
				file_exists($checkout_js) ? (string) filemtime($checkout_js) : SLY_PEBBLE_LITE_VERSION,
				true
			);
		}

		// Google Places address autocomplete — only on cart + checkout
		$google_api_key = get_theme_mod('sly_google_places_key', '');
		if ($google_api_key && function_exists('is_cart') && (is_cart() || is_checkout())) {
			$ac_js = get_template_directory() . '/assets/js/address-autocomplete.js';
			wp_enqueue_script(
				'google-places',
				'https://maps.googleapis.com/maps/api/js?key=' . esc_attr($google_api_key) . '&libraries=places&callback=Function.prototype',
				array(),
				null,
				true
			);
			wp_enqueue_script(
				'sly-pebble-lite-address-ac',
				get_template_directory_uri() . '/assets/js/address-autocomplete.js',
				array('google-places'),
				file_exists($ac_js) ? (string) filemtime($ac_js) : SLY_PEBBLE_LITE_VERSION,
				true
			);
			wp_localize_script('sly-pebble-lite-address-ac', 'slyAddressAC', array(
				'country' => get_option('woocommerce_default_country', 'AU'),
			));
		}
	}
}
add_action('wp_enqueue_scripts', 'sly_pebble_lite_enqueue_assets');

if (!function_exists('sly_pebble_lite_body_classes')) {
	function sly_pebble_lite_body_classes($classes) {
		if (is_front_page()) {
			$classes[] = 'sly-home';
		}

		if (function_exists('is_woocommerce') && (is_woocommerce() || is_cart() || is_checkout() || is_account_page())) {
			$classes[] = 'sly-commerce';
		}

		return $classes;
	}
}
add_filter('body_class', 'sly_pebble_lite_body_classes');

if (!function_exists('sly_pebble_lite_remove_woo_styles')) {
	function sly_pebble_lite_remove_woo_styles($styles) {
		return array();
	}
}
add_filter('woocommerce_enqueue_styles', 'sly_pebble_lite_remove_woo_styles');

if (!function_exists('sly_pebble_lite_wc_page_needs_fallback')) {
	/**
	 * Detect if the WooCommerce page content is missing required cart/checkout/account block or shortcode.
	 *
	 * @param string $content      Current post content.
	 * @param string $block_name   Woo block name.
	 * @param string $shortcode_id Woo shortcode id.
	 * @return bool
	 */
	function sly_pebble_lite_wc_page_needs_fallback($content, $block_name, $shortcode_id) {
		$post = get_post();
		if (!$post instanceof WP_Post) {
			return false;
		}

		if (function_exists('has_block') && has_block($block_name, $post)) {
			return false;
		}

		if (stripos((string) $content, '[woocommerce_' . $shortcode_id . ']') !== false) {
			return false;
		}

		if (stripos((string) $post->post_content, '[woocommerce_' . $shortcode_id . ']') !== false) {
			return false;
		}

		return true;
	}
}

if (!function_exists('sly_pebble_lite_force_wc_page_content')) {
	/**
	 * Force Woo shortcodes for core pages if content is missing.
	 *
	 * This prevents blank/broken cart or checkout pages when Woo page setup is incomplete.
	 *
	 * @param string $content The content.
	 * @return string
	 */
	function sly_pebble_lite_force_wc_page_content($content) {
		if (!class_exists('WooCommerce')) {
			return $content;
		}

		if (is_admin() || wp_doing_ajax() || !is_main_query() || !in_the_loop()) {
			return $content;
		}

		if (function_exists('is_cart') && is_cart() && sly_pebble_lite_wc_page_needs_fallback($content, 'woocommerce/cart', 'cart')) {
			return '[woocommerce_cart]';
		}

		if (
			function_exists('is_checkout') &&
			is_checkout() &&
			(!function_exists('is_order_received_page') || !is_order_received_page()) &&
			sly_pebble_lite_wc_page_needs_fallback($content, 'woocommerce/checkout', 'checkout')
		) {
			return '[woocommerce_checkout]';
		}

		if (
			function_exists('is_account_page') &&
			is_account_page() &&
			sly_pebble_lite_wc_page_needs_fallback($content, 'woocommerce/my-account', 'my_account')
		) {
			return '[woocommerce_my_account]';
		}

		return $content;
	}
}
add_filter('the_content', 'sly_pebble_lite_force_wc_page_content', 6);

if (!function_exists('sly_pebble_lite_customize_register')) {
	function sly_pebble_lite_customize_register($wp_customize) {
		$add_text_control = static function($id, $default, $label, $section) use ($wp_customize) {
			$wp_customize->add_setting($id, array(
				'default'           => $default,
				'sanitize_callback' => 'sanitize_text_field',
			));
			$wp_customize->add_control($id, array(
				'label'   => $label,
				'section' => $section,
				'type'    => 'text',
			));
		};

		$add_textarea_control = static function($id, $default, $label, $section) use ($wp_customize) {
			$wp_customize->add_setting($id, array(
				'default'           => $default,
				'sanitize_callback' => 'sanitize_textarea_field',
			));
			$wp_customize->add_control($id, array(
				'label'   => $label,
				'section' => $section,
				'type'    => 'textarea',
			));
		};

		$add_url_control = static function($id, $default, $label, $section) use ($wp_customize) {
			$wp_customize->add_setting($id, array(
				'default'           => $default,
				'sanitize_callback' => 'esc_url_raw',
			));
			$wp_customize->add_control($id, array(
				'label'   => $label,
				'section' => $section,
				'type'    => 'url',
			));
		};

		$wp_customize->add_section('sly_home_hero', array(
			'title'    => __('SLY Homepage Hero', 'sly-pebble-lite'),
			'priority' => 30,
		));

		$add_text_control('sly_hero_kicker', 'SLY COLLECTIVE MEN\'S UNDERWEAR', __('Hero Kicker', 'sly-pebble-lite'), 'sly_home_hero');
		$add_text_control('sly_hero_title', 'Underwear Built For The Way Men Actually Move', __('Hero Title', 'sly-pebble-lite'), 'sly_home_hero');
		$add_textarea_control('sly_hero_text', 'Supportive pouch engineering, no-ride-up fit, premium fabrics, and daily comfort from office to trail.', __('Hero Text', 'sly-pebble-lite'), 'sly_home_hero');
		$add_text_control('sly_hero_cta_label', 'Shop Best Sellers', __('Hero CTA Label', 'sly-pebble-lite'), 'sly_home_hero');
		$add_url_control('sly_hero_cta_url', '/shop', __('Hero CTA URL', 'sly-pebble-lite'), 'sly_home_hero');
		$add_text_control('sly_hero_cta2_label', 'Why SLY?', __('Hero Secondary CTA Label', 'sly-pebble-lite'), 'sly_home_hero');
		$add_url_control('sly_hero_cta2_url', home_url('/about-us'), __('Hero Secondary CTA URL', 'sly-pebble-lite'), 'sly_home_hero');

		$wp_customize->add_setting('sly_hero_image', array('sanitize_callback' => 'absint'));
		$wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'sly_hero_image', array(
			'label'     => __('Hero Image', 'sly-pebble-lite'),
			'section'   => 'sly_home_hero',
			'mime_type' => 'image',
		)));

		$wp_customize->add_section('sly_home_focus', array(
			'title'    => __('SLY Homepage Focus Cards', 'sly-pebble-lite'),
			'priority' => 31,
		));

		$focus_defaults = array(
			1 => array(
				'label'      => 'Travel Underwear',
				'kicker'     => 'Travel Collection',
				'title'      => 'Built To Move Through Every Trip',
				'text'       => 'Pack-light comfort with anti-chafe support, breathable fabric, and fit that holds all day in transit.',
				'link_label' => 'Shop Travel Underwear',
				'url'        => home_url('/product-category/men-underwear/pocket-underwear/'),
			),
			2 => array(
				'label'      => 'Urologist Recommended',
				'kicker'     => 'Expert Approved',
				'title'      => 'Support Science, Not Compression',
				'text'       => 'Structured pouch support and airflow-first construction designed to reduce pressure and daily discomfort.',
				'link_label' => 'Explore Recommended Styles',
				'url'        => home_url('/product-category/men-underwear/mens-pouch-underwear/'),
			),
			3 => array(
				'label'      => 'Pouch Underwear',
				'kicker'     => 'Pouch Collection',
				'title'      => 'Room In Front. Stability Everywhere Else.',
				'text'       => 'Engineered pouch geometry eliminates squeeze while keeping everything centered and supported.',
				'link_label' => 'Shop Pouch Underwear',
				'url'        => home_url('/product-category/men-underwear/mens-pouch-underwear/'),
			),
			4 => array(
				'label'      => 'Quick-Dry Underwear',
				'kicker'     => 'Quick-Dry Collection',
				'title'      => 'Dry Faster. Stay Ready.',
				'text'       => 'Moisture-wicking performance for heat, workouts, and long days, without bulk or cling.',
				'link_label' => 'Shop Quick-Dry Underwear',
				'url'        => home_url('/product-category/men-underwear/quick-dry-underwear/'),
			),
		);

		foreach ($focus_defaults as $focus_index => $focus_default) {
			$prefix = 'sly_home_focus_' . $focus_index . '_';

			$add_text_control($prefix . 'label', $focus_default['label'], sprintf(__('Focus %d Label', 'sly-pebble-lite'), $focus_index), 'sly_home_focus');
			$add_text_control($prefix . 'kicker', $focus_default['kicker'], sprintf(__('Focus %d Kicker', 'sly-pebble-lite'), $focus_index), 'sly_home_focus');
			$add_text_control($prefix . 'title', $focus_default['title'], sprintf(__('Focus %d Title', 'sly-pebble-lite'), $focus_index), 'sly_home_focus');
			$add_textarea_control($prefix . 'text', $focus_default['text'], sprintf(__('Focus %d Summary', 'sly-pebble-lite'), $focus_index), 'sly_home_focus');
			$add_text_control($prefix . 'link_label', $focus_default['link_label'], sprintf(__('Focus %d CTA Label', 'sly-pebble-lite'), $focus_index), 'sly_home_focus');
			$add_url_control($prefix . 'url', $focus_default['url'], sprintf(__('Focus %d URL', 'sly-pebble-lite'), $focus_index), 'sly_home_focus');

			$wp_customize->add_setting($prefix . 'image', array('sanitize_callback' => 'absint'));
			$wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, $prefix . 'image', array(
				'label'     => sprintf(__('Focus %d Image', 'sly-pebble-lite'), $focus_index),
				'section'   => 'sly_home_focus',
				'mime_type' => 'image',
			)));
		}

		$wp_customize->add_section('sly_home_categories', array(
			'title'    => __('SLY Homepage Category Header', 'sly-pebble-lite'),
			'priority' => 32,
		));
		$add_text_control('sly_home_category_heading', 'Explore Categories', __('Categories Heading', 'sly-pebble-lite'), 'sly_home_categories');
		$add_text_control('sly_home_category_chip_1', 'Men', __('Category Chip 1', 'sly-pebble-lite'), 'sly_home_categories');
		$add_text_control('sly_home_category_chip_2', 'New', __('Category Chip 2', 'sly-pebble-lite'), 'sly_home_categories');

		$wp_customize->add_section('sly_home_features', array(
			'title'    => __('SLY Homepage Feature Tiles', 'sly-pebble-lite'),
			'priority' => 33,
		));
		$add_text_control('sly_home_feature_1_title', 'No Ride Up', __('Feature Tile 1 Title', 'sly-pebble-lite'), 'sly_home_features');
		$add_textarea_control('sly_home_feature_1_text', 'Cut and panel engineering that stays put through daily movement.', __('Feature Tile 1 Text', 'sly-pebble-lite'), 'sly_home_features');
		$add_text_control('sly_home_feature_2_title', 'Supportive Pouch', __('Feature Tile 2 Title', 'sly-pebble-lite'), 'sly_home_features');
		$add_textarea_control('sly_home_feature_2_text', 'Room where needed, support where it matters, comfort all day.', __('Feature Tile 2 Text', 'sly-pebble-lite'), 'sly_home_features');
		$add_text_control('sly_home_feature_3_title', 'Fast Dispatch', __('Feature Tile 3 Title', 'sly-pebble-lite'), 'sly_home_features');
		$add_textarea_control('sly_home_feature_3_text', 'Lean operations for quick turnaround and reliable order updates.', __('Feature Tile 3 Text', 'sly-pebble-lite'), 'sly_home_features');

		$wp_customize->add_section('sly_home_best_sellers', array(
			'title'    => __('SLY Homepage Best Sellers', 'sly-pebble-lite'),
			'priority' => 34,
		));
		$add_text_control('sly_home_best_sellers_heading', 'Best Sellers', __('Best Sellers Heading', 'sly-pebble-lite'), 'sly_home_best_sellers');
		$add_text_control('sly_home_best_sellers_cta', 'View All', __('Best Sellers CTA Label', 'sly-pebble-lite'), 'sly_home_best_sellers');
		$add_textarea_control('sly_home_best_sellers_empty_text', 'Add products in WooCommerce to populate this section.', __('Best Sellers Empty State Text', 'sly-pebble-lite'), 'sly_home_best_sellers');

		$wp_customize->add_section('sly_home_trust', array(
			'title'    => __('SLY Homepage Trust Band', 'sly-pebble-lite'),
			'priority' => 35,
		));
		$add_text_control('sly_home_trust_heading', 'Comfort You Can Trust', __('Trust Band Heading', 'sly-pebble-lite'), 'sly_home_trust');
		$add_textarea_control('sly_home_trust_text', 'Free AU shipping over $100. Hassle-free returns. Secure checkout with encrypted payments. Thousands of happy customers across Australia.', __('Trust Band Text', 'sly-pebble-lite'), 'sly_home_trust');

		$wp_customize->add_section('sly_home_proof', array(
			'title'    => __('SLY Homepage Social Proof', 'sly-pebble-lite'),
			'priority' => 36,
		));
		$add_text_control('sly_proof_rating', '4.8/5', __('Rating Stat', 'sly-pebble-lite'), 'sly_home_proof');
		$add_text_control('sly_proof_rating_label', 'Average Rating', __('Rating Label', 'sly-pebble-lite'), 'sly_home_proof');
		$add_text_control('sly_proof_customers', '12,000+', __('Customers Stat', 'sly-pebble-lite'), 'sly_home_proof');
		$add_text_control('sly_proof_customers_label', 'Happy Customers', __('Customers Label', 'sly-pebble-lite'), 'sly_home_proof');
		$add_text_control('sly_proof_dispatch', '1-2 Days', __('Dispatch Stat', 'sly-pebble-lite'), 'sly_home_proof');
		$add_text_control('sly_proof_dispatch_label', 'Fast Dispatch', __('Dispatch Label', 'sly-pebble-lite'), 'sly_home_proof');
		$add_text_control('sly_proof_returns', '30 Days', __('Returns Stat', 'sly-pebble-lite'), 'sly_home_proof');
		$add_text_control('sly_proof_returns_label', 'Easy Returns', __('Returns Label', 'sly-pebble-lite'), 'sly_home_proof');

		$wp_customize->add_section('sly_about_page', array(
			'title'    => __('SLY About Us Page', 'sly-pebble-lite'),
			'priority' => 38,
		));
		$add_text_control('sly_about_slogan', 'Cheeky by nature. Serious about comfort. Proudly Aussie.', __('Slogan', 'sly-pebble-lite'), 'sly_about_page');
		$add_text_control('sly_about_intro_title', 'Why SLY?', __('Intro Heading', 'sly-pebble-lite'), 'sly_about_page');
		$add_textarea_control('sly_about_intro_text', 'At SLY, we focus on solving the stuff men actually deal with every day — chafing, sticking, sweating, overheating, bunching, ride-up, and a general lack of support where it really counts. We make premium men\'s underwear designed to solve real problems without carrying on like we invented fire. That means thoughtful design, proper support, practical features, and materials that feel bloody good on the body.', __('Intro Text', 'sly-pebble-lite'), 'sly_about_page');
		$add_textarea_control('sly_about_history_text', 'Born on Australia\'s east coast, SLY Collective is shaped by beach culture, street style, tattoo art, graffiti, music, and the kind of self-expression that doesn\'t ask permission. We\'re Aussie owned, Aussie run, and we\'ve been covering your butt since 2005.', __('History Text', 'sly-pebble-lite'), 'sly_about_page');
		$add_text_control('sly_about_value_1_title', 'Function First', __('Value 1 Title', 'sly-pebble-lite'), 'sly_about_page');
		$add_textarea_control('sly_about_value_1_text', 'We\'re designing for real blokes, and we build underwear to solve real-world problems — through work, workouts, weekends, and whatever else. That means better support, better movement, and less fiddling, riding, rubbing, or readjusting. No pointless extras. No fluff.', __('Value 1 Text', 'sly-pebble-lite'), 'sly_about_page');
		$add_text_control('sly_about_value_2_title', 'No BS', __('Value 2 Title', 'sly-pebble-lite'), 'sly_about_page');
		$add_textarea_control('sly_about_value_2_text', 'No gimmicks. No waffle. No overcooked marketing spin. Our underwear delivers because the engineering is dialled, the fit is considered, and every detail serves a purpose. It\'s comfort without the carry-on, support without the squeeze, and performance without the marketing circus. That\'s the pitch.', __('Value 2 Text', 'sly-pebble-lite'), 'sly_about_page');
		$add_text_control('sly_about_value_3_title', 'Aussie to the Core', __('Value 3 Title', 'sly-pebble-lite'), 'sly_about_page');
		$add_textarea_control('sly_about_value_3_text', 'Our Black Bamboo Pouch Range is proudly made in Australia, and every SLY Collective design is homegrown on the sunny east coast in collaboration with some of the best young designers around. Built for 40-degree scorchers, packed commutes, sweaty sessions, and everything in between. Built for Aussie conditions. Built for Aussie blokes. Built tough enough for whatever the day throws at you.', __('Value 3 Text', 'sly-pebble-lite'), 'sly_about_page');
		$add_textarea_control('sly_about_founders_dustin', 'It started with Dustin Slypen — a Sunshine Coast kid who came up with the idea for pocket underpants over a few beers with his mates.', __('Dustin Founder Text', 'sly-pebble-lite'), 'sly_about_page');
		$add_textarea_control('sly_about_founders_dan', 'Then Dan Murray got involved. A Gold Coast entrepreneur who was just 17 years old, Dan saw what SLY could become and made Dustin an offer.', __('Dan Founder Text', 'sly-pebble-lite'), 'sly_about_page');
		$add_text_control('sly_about_cta_label', 'Shop the Range', __('CTA Button Label', 'sly-pebble-lite'), 'sly_about_page');
		$add_url_control('sly_about_cta_url', home_url('/shop'), __('CTA Button URL', 'sly-pebble-lite'), 'sly_about_page');

		$wp_customize->add_section('sly_home_email', array(
			'title'    => __('SLY Homepage Email Capture', 'sly-pebble-lite'),
			'priority' => 37,
		));
		$add_text_control('sly_email_heading', 'Get 10% Off Your First Order', __('Email Heading', 'sly-pebble-lite'), 'sly_home_email');
		$add_textarea_control('sly_email_text', 'Join the SLY crew for exclusive drops, deals, and comfort tips. Unsubscribe anytime.', __('Email Text', 'sly-pebble-lite'), 'sly_home_email');
		$add_text_control('sly_email_wpforms_id', '', __('WPForms Form ID (create form in WPForms, enter ID here)', 'sly-pebble-lite'), 'sly_home_email');

		// Google Places API key for address autocomplete
		$wp_customize->add_section('sly_integrations', array(
			'title'    => __('SLY Integrations', 'sly-pebble-lite'),
			'priority' => 45,
		));
		$add_text_control('sly_google_places_key', '', __('Google Places API Key (enables address autocomplete on cart + checkout)', 'sly-pebble-lite'), 'sly_integrations');
	}
}
add_action('customize_register', 'sly_pebble_lite_customize_register');

if (!function_exists('sly_pebble_lite_buy_now_button')) {
	function sly_pebble_lite_buy_now_button() {
		echo '<button type="submit" class="button sly-buy-now" name="sly_buy_now" value="1">' . esc_html__('Buy It Now', 'sly-pebble-lite') . '</button>';
	}
}
add_action('woocommerce_after_add_to_cart_button', 'sly_pebble_lite_buy_now_button', 30);

if (!function_exists('sly_pebble_lite_buy_now_redirect')) {
	function sly_pebble_lite_buy_now_redirect($redirect_url) {
		if (isset($_REQUEST['sly_buy_now']) && '1' === (string) wp_unslash($_REQUEST['sly_buy_now'])) {
			return wc_get_checkout_url();
		}

		return $redirect_url;
	}
}
add_filter('woocommerce_add_to_cart_redirect', 'sly_pebble_lite_buy_now_redirect');

/**
 * Enable full street address in the cart shipping calculator.
 * WooCommerce hides address_1/address_2 by default on the cart page.
 */
add_filter('woocommerce_shipping_calculator_enable_city', '__return_true');
add_filter('woocommerce_shipping_calculator_enable_postcode', '__return_true');
add_filter('woocommerce_shipping_calculator_enable_state', '__return_true');

/**
 * Street address fields are now inside the shipping calculator template override:
 * woocommerce/cart/shipping-calculator.php
 */

if (!function_exists('sly_pebble_lite_save_shipping_calc_address')) {
	/**
	 * Persist address_1 and address_2 when the shipping calculator form is submitted.
	 */
	function sly_pebble_lite_save_shipping_calc_address() {
		if (isset($_POST['calc_shipping_address_1'])) {
			WC()->customer->set_shipping_address_1(
				wc_clean(wp_unslash($_POST['calc_shipping_address_1']))
			);
		}
		if (isset($_POST['calc_shipping_address_2'])) {
			WC()->customer->set_shipping_address_2(
				wc_clean(wp_unslash($_POST['calc_shipping_address_2']))
			);
		}
	}
}
add_action('woocommerce_calculated_shipping', 'sly_pebble_lite_save_shipping_calc_address', 10);

/**
 * Ensure checkout billing/shipping forms include address_1 and address_2.
 * WooCommerce includes these by default, but we customise labels and placeholders
 * to make them clear for Australian addresses.
 */
if (!function_exists('sly_pebble_lite_checkout_address_fields')) {
	function sly_pebble_lite_checkout_address_fields($fields) {
		// Billing
		if (isset($fields['billing'])) {
			if (isset($fields['billing']['billing_address_1'])) {
				$fields['billing']['billing_address_1']['placeholder'] = __('Street number and name', 'sly-pebble-lite');
				$fields['billing']['billing_address_1']['label']       = __('Street Address', 'sly-pebble-lite');
			}
			if (isset($fields['billing']['billing_address_2'])) {
				$fields['billing']['billing_address_2']['placeholder'] = __('Unit, apartment, suite (optional)', 'sly-pebble-lite');
				$fields['billing']['billing_address_2']['label']       = __('Unit / Apartment', 'sly-pebble-lite');
				$fields['billing']['billing_address_2']['label_class'] = array();
			}
		}

		// Shipping
		if (isset($fields['shipping'])) {
			if (isset($fields['shipping']['shipping_address_1'])) {
				$fields['shipping']['shipping_address_1']['placeholder'] = __('Street number and name', 'sly-pebble-lite');
				$fields['shipping']['shipping_address_1']['label']       = __('Street Address', 'sly-pebble-lite');
			}
			if (isset($fields['shipping']['shipping_address_2'])) {
				$fields['shipping']['shipping_address_2']['placeholder'] = __('Unit, apartment, suite (optional)', 'sly-pebble-lite');
				$fields['shipping']['shipping_address_2']['label']       = __('Unit / Apartment', 'sly-pebble-lite');
				$fields['shipping']['shipping_address_2']['label_class'] = array();
			}
		}

		return $fields;
	}
}
add_filter('woocommerce_checkout_fields', 'sly_pebble_lite_checkout_address_fields');

if (!function_exists('sly_pebble_lite_ajax_add_to_cart')) {
	function sly_pebble_lite_ajax_add_to_cart() {
		check_ajax_referer('sly-ajax-atc', 'nonce');

		$product_id   = absint($_POST['product_id'] ?? 0);
		$quantity     = absint($_POST['quantity'] ?? 1);
		$variation_id = absint($_POST['variation_id'] ?? 0);
		$variation    = [];

		if (!empty($_POST['variation'])) {
			$raw = json_decode(wp_unslash($_POST['variation']), true);
			if (is_array($raw)) {
				foreach ($raw as $k => $v) {
					$variation[sanitize_text_field($k)] = sanitize_text_field($v);
				}
			}
		}

		if (!$product_id || $quantity < 1) {
			wp_send_json_error(array('message' => __('Invalid product.', 'sly-pebble-lite')));
		}

		$added = WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation);

		if (!$added) {
			wp_send_json_error(array('message' => __('Could not add to cart.', 'sly-pebble-lite')));
		}

		wp_send_json_success(array(
			'count'        => WC()->cart->get_cart_contents_count(),
			'total'        => wp_strip_all_tags(WC()->cart->get_cart_total()),
			'message'      => __('Added to cart', 'sly-pebble-lite'),
			'cart_url'     => wc_get_cart_url(),
			'checkout_url' => wc_get_checkout_url(),
		));
	}
}
add_action('wp_ajax_sly_add_to_cart', 'sly_pebble_lite_ajax_add_to_cart');
add_action('wp_ajax_nopriv_sly_add_to_cart', 'sly_pebble_lite_ajax_add_to_cart');

/**
 * Product Features Meta Box — 3 editable checkmark bullets per product.
 */
if (!function_exists('sly_pebble_lite_product_features_meta_box')) {
	function sly_pebble_lite_product_features_meta_box() {
		add_meta_box('sly_product_features', __('Product Features (✔ checkmarks)', 'sly-pebble-lite'), 'sly_pebble_lite_product_features_meta_box_html', 'product', 'normal', 'high');
	}
	function sly_pebble_lite_product_features_meta_box_html($post) {
		wp_nonce_field('sly_product_features_save', 'sly_product_features_nonce');
		$f = [];
		for ($i = 1; $i <= 3; $i++) {
			$f[$i] = get_post_meta($post->ID, "_sly_feat_{$i}", true);
		}
		$placeholders = ['Regular Fit', 'Inner Pouch', 'Short Leg'];
		for ($i = 1; $i <= 3; $i++) : ?>
		<p>
			<label><strong><?php printf(esc_html__('Feature %d', 'sly-pebble-lite'), $i); ?></strong></label><br>
			<input type="text" name="sly_feat_<?php echo $i; ?>" value="<?php echo esc_attr($f[$i]); ?>" class="widefat" placeholder="<?php echo esc_attr($placeholders[$i - 1]); ?>">
		</p>
		<?php endfor;
		echo '<p class="description">' . esc_html__('Shown as ✔ checkmarks under the product price. Leave blank to hide the feature strip.', 'sly-pebble-lite') . '</p>';
	}
	function sly_pebble_lite_product_features_meta_box_save($post_id) {
		if (!isset($_POST['sly_product_features_nonce']) || !wp_verify_nonce($_POST['sly_product_features_nonce'], 'sly_product_features_save')) return;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
		if (!current_user_can('edit_post', $post_id)) return;
		for ($i = 1; $i <= 3; $i++) {
			$key = "sly_feat_{$i}";
			if (isset($_POST[$key])) {
				update_post_meta($post_id, "_sly_feat_{$i}", sanitize_text_field(wp_unslash($_POST[$key])));
			}
		}
	}
}
add_action('add_meta_boxes', 'sly_pebble_lite_product_features_meta_box');
add_action('save_post_product', 'sly_pebble_lite_product_features_meta_box_save');

/**
 * Review Spotlight Meta Box — summary line + 4 individual reviews per product.
 */
if (!function_exists('sly_pebble_lite_product_review_meta_box')) {
	function sly_pebble_lite_product_review_meta_box() {
		add_meta_box('sly_product_review', __('Review Spotlight (4 reviews)', 'sly-pebble-lite'), 'sly_pebble_lite_product_review_meta_box_html', 'product', 'normal', 'default');
	}
	function sly_pebble_lite_product_review_meta_box_html($post) {
		wp_nonce_field('sly_product_review_save', 'sly_product_review_nonce');
		$summary = get_post_meta($post->ID, '_sly_review_summary', true);
		?>
		<p>
			<label><strong><?php esc_html_e('Rating Summary Line', 'sly-pebble-lite'); ?></strong></label><br>
			<input type="text" name="sly_review_summary" value="<?php echo esc_attr($summary); ?>" class="widefat" placeholder="4.8 out of 5 (127 reviews)">
			<span class="description"><?php esc_html_e('Shown above the carousel. Leave blank to use WooCommerce average rating.', 'sly-pebble-lite'); ?></span>
		</p>
		<?php for ($i = 1; $i <= 4; $i++) :
			$stars  = get_post_meta($post->ID, "_sly_rv_{$i}_stars", true);
			$quote  = get_post_meta($post->ID, "_sly_rv_{$i}_quote", true);
			$author = get_post_meta($post->ID, "_sly_rv_{$i}_author", true);
			?>
		<hr style="margin:12px 0">
		<p><strong><?php printf(esc_html__('Review %d', 'sly-pebble-lite'), $i); ?></strong></p>
		<p>
			<label><?php esc_html_e('Stars (1–5)', 'sly-pebble-lite'); ?></label><br>
			<input type="number" name="sly_rv_<?php echo $i; ?>_stars" value="<?php echo esc_attr($stars); ?>" min="1" max="5" style="width:70px" placeholder="5">
		</p>
		<p>
			<label><?php esc_html_e('Quote', 'sly-pebble-lite'); ?></label><br>
			<textarea name="sly_rv_<?php echo $i; ?>_quote" class="widefat" rows="3" placeholder="<?php esc_attr_e('Customer quote…', 'sly-pebble-lite'); ?>"><?php echo esc_textarea($quote); ?></textarea>
		</p>
		<p>
			<label><?php esc_html_e('Reviewer Name', 'sly-pebble-lite'); ?></label><br>
			<input type="text" name="sly_rv_<?php echo $i; ?>_author" value="<?php echo esc_attr($author); ?>" class="widefat" placeholder="Trev — Melbourne">
		</p>
		<?php endfor;
	}
	function sly_pebble_lite_product_review_meta_box_save($post_id) {
		if (!isset($_POST['sly_product_review_nonce']) || !wp_verify_nonce($_POST['sly_product_review_nonce'], 'sly_product_review_save')) return;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
		if (!current_user_can('edit_post', $post_id)) return;
		if (isset($_POST['sly_review_summary'])) {
			update_post_meta($post_id, '_sly_review_summary', sanitize_text_field(wp_unslash($_POST['sly_review_summary'])));
		}
		for ($i = 1; $i <= 4; $i++) {
			foreach (['stars', 'quote', 'author'] as $field) {
				$input = "sly_rv_{$i}_{$field}";
				if (isset($_POST[$input])) {
					update_post_meta($post_id, "_sly_rv_{$i}_{$field}", sanitize_textarea_field(wp_unslash($_POST[$input])));
				}
			}
		}
	}
}
add_action('add_meta_boxes', 'sly_pebble_lite_product_review_meta_box');
add_action('save_post_product', 'sly_pebble_lite_product_review_meta_box_save');

/**
 * Product Video Meta Box — adds MP4/WebM/poster fields to the product editor.
 */
if (!function_exists('sly_pebble_lite_product_video_meta_box')) {
	function sly_pebble_lite_product_video_meta_box() {
		add_meta_box(
			'sly_product_video',
			__('Product Gallery Video', 'sly-pebble-lite'),
			'sly_pebble_lite_product_video_meta_box_html',
			'product',
			'side',
			'default'
		);
	}

	function sly_pebble_lite_product_video_meta_box_html($post) {
		wp_nonce_field('sly_product_video_save', 'sly_product_video_nonce');
		$mp4    = get_post_meta($post->ID, '_sly_video_mp4', true);
		$webm   = get_post_meta($post->ID, '_sly_video_webm', true);
		$poster = get_post_meta($post->ID, '_sly_video_poster', true);
		$position = get_post_meta($post->ID, '_sly_video_position', true);
		if ('' === $position) {
			$position = '1';
		}
		?>
		<p>
			<label for="sly_video_mp4"><strong><?php esc_html_e('MP4 URL', 'sly-pebble-lite'); ?></strong></label><br>
			<input type="url" id="sly_video_mp4" name="sly_video_mp4" value="<?php echo esc_url($mp4); ?>" class="widefat" placeholder="https://…/video.mp4">
		</p>
		<p>
			<label for="sly_video_webm"><strong><?php esc_html_e('WebM URL (optional)', 'sly-pebble-lite'); ?></strong></label><br>
			<input type="url" id="sly_video_webm" name="sly_video_webm" value="<?php echo esc_url($webm); ?>" class="widefat" placeholder="https://…/video.webm">
		</p>
		<p>
			<label for="sly_video_poster"><strong><?php esc_html_e('Poster Image URL', 'sly-pebble-lite'); ?></strong></label><br>
			<input type="url" id="sly_video_poster" name="sly_video_poster" value="<?php echo esc_url($poster); ?>" class="widefat" placeholder="https://…/poster.webp">
		</p>
		<p>
			<label for="sly_video_position"><strong><?php esc_html_e('Gallery Position', 'sly-pebble-lite'); ?></strong></label><br>
			<select id="sly_video_position" name="sly_video_position" class="widefat">
				<option value="0" <?php selected($position, '0'); ?>><?php esc_html_e('First (before all images)', 'sly-pebble-lite'); ?></option>
				<option value="1" <?php selected($position, '1'); ?>><?php esc_html_e('Second (after main image)', 'sly-pebble-lite'); ?></option>
				<option value="last" <?php selected($position, 'last'); ?>><?php esc_html_e('Last (after all images)', 'sly-pebble-lite'); ?></option>
			</select>
		</p>
		<p class="description"><?php esc_html_e('Upload MP4 + WebM to Media Library, paste URLs here. Video auto-plays muted on loop.', 'sly-pebble-lite'); ?></p>
		<?php
	}

	function sly_pebble_lite_product_video_meta_box_save($post_id) {
		if (!isset($_POST['sly_product_video_nonce']) || !wp_verify_nonce($_POST['sly_product_video_nonce'], 'sly_product_video_save')) {
			return;
		}
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
		if (!current_user_can('edit_post', $post_id)) {
			return;
		}

		$fields = array(
			'sly_video_mp4'      => '_sly_video_mp4',
			'sly_video_webm'     => '_sly_video_webm',
			'sly_video_poster'   => '_sly_video_poster',
			'sly_video_position' => '_sly_video_position',
		);

		foreach ($fields as $input => $meta_key) {
			if (isset($_POST[$input])) {
				$value = ('_sly_video_position' === $meta_key)
					? sanitize_text_field(wp_unslash($_POST[$input]))
					: esc_url_raw(wp_unslash($_POST[$input]));
				update_post_meta($post_id, $meta_key, $value);
			}
		}
	}
}
add_action('add_meta_boxes', 'sly_pebble_lite_product_video_meta_box');
add_action('save_post_product', 'sly_pebble_lite_product_video_meta_box_save');

// Rename "Shipping" / "Shipment" label in cart totals to "Ship"
add_filter('gettext', function($translated, $original, $domain) {
	if (in_array($original, ['Shipping', 'Shipment'], true)) {
		return 'Ship';
	}
	return $translated;
}, 10, 3);

// Strip "Choose " prefix from variation attribute labels (e.g. "Choose Size" → "Size")
add_filter('woocommerce_attribute_label', function($label, $name, $product) {
	return preg_replace('/^Choose\s+/i', '', $label);
}, 10, 3);

// Remove "Choose an option" placeholder from variation dropdowns — show sizes only
add_filter('woocommerce_dropdown_variation_attribute_options_args', function($args) {
	$args['show_option_none'] = '';
	return $args;
});

/**
 * Bulk Buy Discount — automatically applied at cart based on total item quantity.
 * 7+ items = 15% off | 14+ items = 20% off | 21+ items = 25% off
 */
add_action('woocommerce_cart_calculate_fees', function($cart) {
	if (is_admin() && !defined('DOING_AJAX')) {
		return;
	}
	if (!$cart instanceof WC_Cart) {
		return;
	}

	$total_qty = 0;
	$subtotal  = 0.0;

	foreach ($cart->get_cart() as $item) {
		$total_qty += (int) $item['quantity'];
		$subtotal  += (float) $item['line_total'] + (float) ($item['line_tax'] ?? 0);
	}

	if ($total_qty >= 21) {
		$pct   = 0.25;
		$label = __('Bulk Buy Discount — 25% off (21+ items)', 'sly-pebble-lite');
	} elseif ($total_qty >= 14) {
		$pct   = 0.20;
		$label = __('Bulk Buy Discount — 20% off (14+ items)', 'sly-pebble-lite');
	} elseif ($total_qty >= 7) {
		$pct   = 0.15;
		$label = __('Bulk Buy Discount — 15% off (7+ items)', 'sly-pebble-lite');
	} else {
		return;
	}

	$discount = -round($subtotal * $pct, 2);
	if ($discount < 0) {
		$cart->add_fee($label, $discount, false);
	}
});

require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/fraud-guard.php';
