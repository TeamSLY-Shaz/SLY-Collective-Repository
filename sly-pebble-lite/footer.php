<?php
if (!defined('ABSPATH')) {
	exit;
}
?>
</main>

<footer class="site-footer">
	<div class="container site-footer__grid">
		<section class="site-footer__brand" data-reveal>
			<h2>SLY Collective</h2>
			<p>Premium men's underwear with engineered pouch comfort, zero ride-up design, and all-day support.</p>
		</section>
		<section class="site-footer__menu" data-reveal>
			<h3><?php esc_html_e('Quick Links', 'sly-pebble-lite'); ?></h3>
			<?php
			wp_nav_menu(array(
				'theme_location' => 'footer',
				'container'      => false,
				'menu_class'     => 'footer-nav',
				'fallback_cb'    => 'sly_pebble_lite_fallback_menu',
			));
			?>
		</section>
		<section class="site-footer__promise" data-reveal>
			<h3><?php esc_html_e('Our Promise', 'sly-pebble-lite'); ?></h3>
			<ul>
				<li><?php esc_html_e('Fast dispatch', 'sly-pebble-lite'); ?></li>
				<li><?php esc_html_e('Secure checkout', 'sly-pebble-lite'); ?></li>
				<li><?php esc_html_e('Comfort guarantee', 'sly-pebble-lite'); ?></li>
			</ul>
		</section>
	</div>
	<div class="container site-footer__bottom">
		<p>&copy; <?php echo esc_html(gmdate('Y')); ?> SLY Collective. <?php esc_html_e('All rights reserved.', 'sly-pebble-lite'); ?></p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
