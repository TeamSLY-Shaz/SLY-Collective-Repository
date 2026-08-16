<?php
if (!defined('ABSPATH')) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="dns-prefetch" href="https://fonts.googleapis.com">
	<link rel="dns-prefetch" href="https://fonts.gstatic.com">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
	<div class="site-strip">Free AU shipping over $100 | Secure checkout</div>
	<div class="header-shell container">
		<a class="brandmark" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php esc_attr_e('SLY Collective', 'sly-pebble-lite'); ?>">
			<img class="brandmark__emblem" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/sly-emblem.webp'); ?>" alt="" width="80" height="80">
			<span class="brandmark__text">
				<span class="brandmark__primary">SLY</span>
				<span class="brandmark__secondary">Collective</span>
			</span>
		</a>

		<button class="menu-toggle" type="button" data-menu-toggle aria-expanded="false" aria-controls="site-navigation">
			<span class="menu-toggle__bar"></span>
			<span class="menu-toggle__bar"></span>
			<span class="menu-toggle__bar"></span>
			<span class="screen-reader-text"><?php esc_html_e('Toggle navigation', 'sly-pebble-lite'); ?></span>
		</button>

		<nav id="site-navigation" class="site-nav" aria-label="<?php esc_attr_e('Primary Menu', 'sly-pebble-lite'); ?>">
			<?php
			wp_nav_menu(array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'nav-list',
				'fallback_cb'    => 'sly_pebble_lite_fallback_menu',
			));
			?>
		</nav>

		<div class="header-actions">
			<?php if (class_exists('WooCommerce')) : ?>
				<a class="header-link" href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"><?php esc_html_e('Account', 'sly-pebble-lite'); ?></a>
				<a class="header-cart" href="<?php echo esc_url(wc_get_cart_url()); ?>">
					<?php esc_html_e('Cart', 'sly-pebble-lite'); ?>
					<span>
						<?php
						echo absint((function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0);
						?>
					</span>
				</a>
			<?php endif; ?>
		</div>
	</div>
</header>

<div class="sly-tagline-banner">
	<div class="sly-tagline-banner__inner container">POUCH UNDERWEAR BUILT FOR THE WAY MEN ACTUALLY MOVE</div>
</div>

<main id="primary" class="site-main">
