<?php
/**
 * Template Name: About Us
 * Slug: about-us
 *
 * Automatically used for any page with the slug "about-us".
 */
if (!defined('ABSPATH')) {
	exit;
}

get_header();

$about_slogan       = get_theme_mod('sly_about_slogan', 'Cheeky by nature. Serious about comfort. Proudly Aussie.');
$about_intro_title  = get_theme_mod('sly_about_intro_title', 'Why SLY?');
$about_intro_text   = get_theme_mod('sly_about_intro_text',
	'At SLY, we focus on solving the stuff men actually deal with every day — chafing, sticking, sweating, overheating, bunching, ride-up, and a general lack of support where it really counts. We make premium men\'s underwear designed to solve real problems without carrying on like we invented fire. That means thoughtful design, proper support, practical features, and materials that feel bloody good on the body.'
);
$about_history_text = get_theme_mod('sly_about_history_text',
	'Born on Australia\'s east coast, SLY Collective is shaped by beach culture, street style, tattoo art, graffiti, music, and the kind of self-expression that doesn\'t ask permission. We\'re Aussie owned, Aussie run, and we\'ve been covering your butt since 2005.'
);

$about_founders_dustin = get_theme_mod('sly_about_founders_dustin',
	'It started with Dustin Slypen — a Sunshine Coast kid who came up with the idea for pocket underpants over a few beers with his mates. His grandfather ran Logic Clothing in Mooloolaba and used to work for Bonds, so Dustin took the design to him. They hemmed, stitched, and built the first prototypes by hand. He called them "Sly Fronts" — the name pulled from his own surname. Dustin sold 60 pairs to his mates, entered the Nescafe Big Break competition, and put SLY on the map before he\'d even finished studying.'
);
$about_founders_dan = get_theme_mod('sly_about_founders_dan',
	'Then Dan Murray got involved. A Gold Coast entrepreneur who was just 17 years old, Dan saw what SLY could become and made Dustin an offer. He designed the first commercial range in Microsoft Paint, got 1,000 units manufactured, and sold them out of his van at festivals, parties, and beaches up and down the east coast. People would yell "you\'re that underwear guy!" and Dan would say "yeah — want to buy some?" Within three years, SLY was in 170 stores across Australia with 25,000 units shifting every four months and distribution deals signed in the US, NZ, South Africa, and the UK.'
);

$about_values = array(
	array(
		'title' => get_theme_mod('sly_about_value_1_title', 'Function First'),
		'text'  => get_theme_mod('sly_about_value_1_text', 'We\'re designing for real blokes, and we build underwear to solve real-world problems — through work, workouts, weekends, and whatever else. That means better support, better movement, and less fiddling, riding, rubbing, or readjusting. No pointless extras. No fluff.'),
	),
	array(
		'title' => get_theme_mod('sly_about_value_2_title', 'No BS'),
		'text'  => get_theme_mod('sly_about_value_2_text', 'No gimmicks. No waffle. No overcooked marketing spin. Our underwear delivers because the engineering is dialled, the fit is considered, and every detail serves a purpose. It\'s comfort without the carry-on, support without the squeeze, and performance without the marketing circus. That\'s the pitch.'),
	),
	array(
		'title' => get_theme_mod('sly_about_value_3_title', 'Aussie to the Core'),
		'text'  => get_theme_mod('sly_about_value_3_text', 'Our Black Bamboo Pouch Range is proudly made in Australia, and every SLY Collective design is homegrown on the sunny east coast in collaboration with some of the best young designers around. Built for 40-degree scorchers, packed commutes, sweaty sessions, and everything in between. Built for Aussie conditions. Built for Aussie blokes. Built tough enough for whatever the day throws at you.'),
	),
);

$about_cta_label = get_theme_mod('sly_about_cta_label', 'Shop the Range');
$about_cta_url   = get_theme_mod('sly_about_cta_url', home_url('/shop'));

$img_base = get_template_directory_uri() . '/assets/images/about/';
?>

<section class="sly-about-hero" data-reveal>
	<div class="container">
		<p class="sly-about-slogan"><?php echo esc_html($about_slogan); ?></p>
	</div>
</section>

<section class="container sly-about-intro" data-reveal>
	<h2 class="sly-about-intro__title"><?php echo esc_html($about_intro_title); ?></h2>
	<p class="sly-about-intro__body"><?php echo esc_html($about_intro_text); ?></p>
</section>

<section class="container sly-about-history" data-reveal>
	<div class="sly-about-history__inner">
		<div class="sly-about-history__badge">
			<span class="sly-about-history__year">Est. 2005</span>
		</div>
		<div class="sly-about-history__body">
			<h3><?php esc_html_e('Our Story', 'sly-pebble-lite'); ?></h3>
			<p><?php echo esc_html($about_history_text); ?></p>
		</div>
	</div>
</section>

<section class="container sly-about-founders" data-reveal>
	<h2 class="sly-section-heading"><?php esc_html_e('The Blokes Behind the Brand', 'sly-pebble-lite'); ?></h2>

	<div class="sly-about-founder" data-reveal>
		<div class="sly-about-founder__media">
			<img src="<?php echo esc_url($img_base . 'dustin-article.webp'); ?>"
				 alt="<?php esc_attr_e('Dustin Slypen — newspaper article about the original SLY Fronts invention', 'sly-pebble-lite'); ?>"
				 width="800" height="283" loading="lazy" decoding="async">
		</div>
		<div class="sly-about-founder__text">
			<h3><?php esc_html_e('Dustin Slypen — The Inventor', 'sly-pebble-lite'); ?></h3>
			<p><?php echo esc_html($about_founders_dustin); ?></p>
		</div>
	</div>

	<div class="sly-about-founder sly-about-founder--reverse" data-reveal>
		<div class="sly-about-founder__media">
			<img src="<?php echo esc_url($img_base . 'dan-beach.webp'); ?>"
				 alt="<?php esc_attr_e('Dan Murray and the SLY crew on the Sunshine Coast — newspaper feature', 'sly-pebble-lite'); ?>"
				 width="692" height="497" loading="lazy" decoding="async">
		</div>
		<div class="sly-about-founder__text">
			<h3><?php esc_html_e('Dan Murray — The Hustler', 'sly-pebble-lite'); ?></h3>
			<p><?php echo esc_html($about_founders_dan); ?></p>
		</div>
	</div>
</section>

<section class="container sly-about-press" data-reveal>
	<h2 class="sly-section-heading"><?php esc_html_e('As Seen In', 'sly-pebble-lite'); ?></h2>
	<div class="sly-about-press__grid">
		<div class="sly-about-press__collage">
			<img src="<?php echo esc_url($img_base . 'press-collage.webp'); ?>"
				 alt="<?php esc_attr_e('SLY Collective media features — The Morning Show, Kerri-Anne, Men\'s Health, Penthouse, CLEO, Dynamic Business, Gold Coast Bulletin and more', 'sly-pebble-lite'); ?>"
				 width="595" height="793" loading="lazy" decoding="async">
		</div>
		<div class="sly-about-press__highlights">
			<p class="sly-about-press__lead"><?php esc_html_e('From beach festivals to national TV.', 'sly-pebble-lite'); ?></p>
			<ul>
				<li><?php esc_html_e('The Morning Show — Channel 7', 'sly-pebble-lite'); ?></li>
				<li><?php esc_html_e('Kerri-Anne — Channel 9', 'sly-pebble-lite'); ?></li>
				<li><?php esc_html_e('Men\'s Health Australia', 'sly-pebble-lite'); ?></li>
				<li><?php esc_html_e('Dynamic Business Magazine', 'sly-pebble-lite'); ?></li>
				<li><?php esc_html_e('CLEO 50 Most Eligible Bachelors', 'sly-pebble-lite'); ?></li>
				<li><?php esc_html_e('Gold Coast Bulletin', 'sly-pebble-lite'); ?></li>
				<li><?php esc_html_e('Penthouse Australia', 'sly-pebble-lite'); ?></li>
				<li><?php esc_html_e('Sunshine Coast Daily', 'sly-pebble-lite'); ?></li>
				<li><?php esc_html_e('NecesCity — Hong Kong', 'sly-pebble-lite'); ?></li>
			</ul>
		</div>
	</div>
</section>

<section class="container sly-about-values" data-reveal>
	<h2 class="sly-section-heading"><?php esc_html_e('What We Stand For', 'sly-pebble-lite'); ?></h2>
	<div class="sly-about-values__grid">
		<?php foreach ($about_values as $value) : ?>
			<div class="sly-about-value-card" data-reveal>
				<h3><?php echo esc_html($value['title']); ?></h3>
				<p><?php echo esc_html($value['text']); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<?php while (have_posts()) : the_post(); ?>
	<?php if ('' !== trim(get_the_content())) : ?>
		<section class="container sly-about-extra" data-reveal>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</section>
	<?php endif; ?>
<?php endwhile; ?>

<section class="container sly-about-cta" data-reveal>
	<div class="sly-about-cta__inner">
		<p class="sly-about-cta__text"><?php esc_html_e('Ready to upgrade your daily comfort?', 'sly-pebble-lite'); ?></p>
		<a href="<?php echo esc_url($about_cta_url); ?>" class="sly-button"><?php echo esc_html($about_cta_label); ?></a>
	</div>
</section>

<?php
get_footer();
