<?php
if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>
<section class="container commerce-shell">
	<?php woocommerce_content(); ?>
</section>
<?php
get_footer();
