<?php
if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>
<section class="container content-shell">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('content-card'); ?> data-reveal>
				<header class="entry-header">
					<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				</header>
				<div class="entry-content">
					<?php the_excerpt(); ?>
				</div>
			</article>
		<?php endwhile; ?>
		<?php the_posts_navigation(); ?>
	<?php else : ?>
		<article class="content-card">
			<h1><?php esc_html_e('Nothing found', 'sly-pebble-lite'); ?></h1>
			<p><?php esc_html_e('Try another search or check back soon.', 'sly-pebble-lite'); ?></p>
		</article>
	<?php endif; ?>
</section>
<?php
get_footer();
