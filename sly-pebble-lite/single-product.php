<?php
/**
 * The Template for displaying all single products.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package sly-pebble-lite
 * @version 1.6.4
 */

defined('ABSPATH') || exit;

get_header();
?>
<section class="container commerce-shell single-product-shell">
	<?php
	while (have_posts()) :
		the_post();
		wc_get_template_part('content', 'single-product');
	endwhile;
	?>
</section>
<?php
get_footer();
