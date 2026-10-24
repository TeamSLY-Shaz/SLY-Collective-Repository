<?php
/**
 * SLY SEO Meta — theme-owned titles, meta descriptions and social tags.
 *
 * The theme is the single source of truth for the values in sly_seo_meta_map().
 * - Rank Math active   → Rank Math prints the tags, but with the theme's values
 *                        (filtered in), so there are never duplicate tags.
 * - No SEO plugin      → the theme prints the tags itself.
 * - Yoast / AIOSEO     → the theme stays silent (avoids duplicate tags).
 *
 * To switch the module off without removing it, add this line to wp-config.php:
 *   define( 'SLY_SEO_META_DISABLE', true );
 *
 * Works as a theme include (inc/seo-meta.php, required from functions.php).
 *
 * @package sly-pebble-lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( defined( 'SLY_SEO_META_DISABLE' ) && SLY_SEO_META_DISABLE ) {
	return;
}

if ( ! function_exists( 'sly_seo_meta_map' ) ) {
	/**
	 * Meta values, keyed by context.
	 * 'front_page' = the site homepage. Further pages can be added later
	 * keyed by page slug, e.g. 'about-us' => array( ... ).
	 *
	 * Keep titles ≤ 60–65 chars and descriptions 150–160 chars.
	 */
	function sly_seo_meta_map() {
		return array(
			'front_page' => array(
				'title'       => "Men's Bamboo Pouch Underwear | No Chafe, No Ride-Up | SLY Collective",
				'description' => "Men's bamboo pouch underwear built to stop chafe and ride-up. A separation pouch keeps everything lifted, cool and supported. Free AU shipping over $100.",
			),
		);
	}
}

if ( ! function_exists( 'sly_seo_meta_current' ) ) {
	/**
	 * Returns the meta entry for the current request, or null.
	 */
	function sly_seo_meta_current() {
		if ( is_admin() || is_feed() ) {
			return null;
		}

		$map = sly_seo_meta_map();

		if ( is_front_page() && isset( $map['front_page'] ) ) {
			return $map['front_page'];
		}

		if ( is_page() ) {
			$page = get_queried_object();
			if ( $page instanceof WP_Post && isset( $map[ $page->post_name ] ) ) {
				return $map[ $page->post_name ];
			}
		}

		return null;
	}
}

if ( ! function_exists( 'sly_seo_meta_get' ) ) {
	/**
	 * Returns one field (title|description) for the current request, or ''.
	 */
	function sly_seo_meta_get( $field ) {
		$entry = sly_seo_meta_current();
		return ( $entry && ! empty( $entry[ $field ] ) ) ? $entry[ $field ] : '';
	}
}

if ( ! function_exists( 'sly_seo_meta_mode' ) ) {
	/**
	 * 'rankmath' | 'other_plugin' | 'theme'
	 */
	function sly_seo_meta_mode() {
		if ( defined( 'RANK_MATH_VERSION' ) || class_exists( 'RankMath' ) ) {
			return 'rankmath';
		}
		if ( defined( 'WPSEO_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) ) {
			return 'other_plugin';
		}
		return 'theme';
	}
}

/* ---------------------------------------------------------------------------
 * Title — WordPress core (used when no SEO plugin is active)
 * ------------------------------------------------------------------------ */
add_filter( 'pre_get_document_title', function ( $title ) {
	if ( 'theme' !== sly_seo_meta_mode() ) {
		return $title;
	}
	$custom = sly_seo_meta_get( 'title' );
	return $custom ? $custom : $title;
}, 99 );

/* ---------------------------------------------------------------------------
 * Rank Math — feed the theme's values into Rank Math's own output
 * ------------------------------------------------------------------------ */
add_action( 'init', function () {
	if ( 'rankmath' !== sly_seo_meta_mode() ) {
		return;
	}

	$title = function ( $value ) {
		$custom = sly_seo_meta_get( 'title' );
		return $custom ? $custom : $value;
	};
	$description = function ( $value ) {
		$custom = sly_seo_meta_get( 'description' );
		return $custom ? $custom : $value;
	};

	// <title> and meta description.
	add_filter( 'rank_math/frontend/title', $title, 99 );
	add_filter( 'rank_math/frontend/description', $description, 99 );

	// Open Graph + Twitter.
	add_filter( 'rank_math/opengraph/facebook/og_title', $title, 99 );
	add_filter( 'rank_math/opengraph/facebook/og_description', $description, 99 );
	add_filter( 'rank_math/opengraph/twitter/twitter_title', $title, 99 );
	add_filter( 'rank_math/opengraph/twitter/twitter_description', $description, 99 );
} );

/* ---------------------------------------------------------------------------
 * No SEO plugin — theme prints the tags itself
 * ------------------------------------------------------------------------ */
add_action( 'wp_head', function () {
	if ( 'theme' !== sly_seo_meta_mode() ) {
		return;
	}

	$entry = sly_seo_meta_current();
	if ( ! $entry ) {
		return;
	}

	$title       = isset( $entry['title'] ) ? $entry['title'] : wp_get_document_title();
	$description = isset( $entry['description'] ) ? $entry['description'] : '';
	$url         = is_front_page() ? home_url( '/' ) : get_permalink( get_queried_object_id() );

	echo "\n<!-- SLY SEO Meta -->\n";
	if ( $description ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
	}
	printf( '<meta property="og:locale" content="%s">' . "\n", esc_attr( get_locale() ) );
	printf( '<meta property="og:type" content="%s">' . "\n", is_front_page() ? 'website' : 'article' );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
	if ( $description ) {
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $description ) );
	}
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $title ) );
	if ( $description ) {
		printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $description ) );
	}
	echo "<!-- /SLY SEO Meta -->\n";
}, 2 );
