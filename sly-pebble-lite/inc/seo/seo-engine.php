<?php
/**
 * SLY SEO — ENGINE  (do not edit — change values in seo-pages.php)
 *
 * Applies the entries in seo-pages.php to the matching page:
 *  - Rank Math active   → Rank Math prints the tags, using the theme's values,
 *                         so there is exactly one of each tag.
 *  - No SEO plugin      → the theme prints title, description, robots,
 *                         canonical, Open Graph and Twitter tags itself.
 *  - Yoast/AIOSEO/SEOPress → the theme stays silent (no duplicate tags).
 *
 * Kill switch (wp-config.php):  define( 'SLY_SEO_DISABLE', true );
 *
 * @package sly-pebble-lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( defined( 'SLY_SEO_DISABLE' ) && SLY_SEO_DISABLE ) {
	return;
}

/* ===========================================================================
 * Data
 * ======================================================================== */

if ( ! function_exists( 'sly_seo_register' ) ) {
	/** All entries from seo-pages.php (loaded once). */
	function sly_seo_register() {
		static $register = null;
		if ( null === $register ) {
			$file     = __DIR__ . '/seo-pages.php';
			$loaded   = file_exists( $file ) ? include $file : array();
			$register = is_array( $loaded ) ? $loaded : array();
		}
		return $register;
	}
}

if ( ! function_exists( 'sly_seo_key' ) ) {
	/** The register key for the current front-end request, or ''. */
	function sly_seo_key() {
		if ( is_admin() || is_feed() || is_404() || is_search() ) {
			return '';
		}
		if ( is_front_page() ) {
			return 'front_page';
		}
		if ( is_home() ) {
			return 'blog';
		}
		if ( function_exists( 'is_shop' ) && is_shop() ) {
			return 'shop';
		}
		if ( is_singular( array( 'page', 'post', 'product' ) ) ) {
			$object = get_queried_object();
			if ( $object instanceof WP_Post ) {
				return $object->post_type . ':' . $object->post_name;
			}
		}
		if ( is_tax( 'product_cat' ) || is_category() ) {
			$term = get_queried_object();
			if ( $term instanceof WP_Term ) {
				return ( 'category' === $term->taxonomy ? 'category' : 'product_cat' ) . ':' . $term->slug;
			}
		}
		return '';
	}
}

if ( ! function_exists( 'sly_seo_entry' ) ) {
	/** The register entry for the current request (with fallbacks filled), or null. */
	function sly_seo_entry() {
		static $cache = array();
		$key = sly_seo_key();
		if ( '' === $key ) {
			return null;
		}
		if ( array_key_exists( $key, $cache ) ) {
			return $cache[ $key ];
		}

		$register = sly_seo_register();
		$entry    = isset( $register[ $key ] ) && is_array( $register[ $key ] ) ? $register[ $key ] : null;

		if ( $entry ) {
			$entry = array_map( function ( $v ) {
				return is_string( $v ) ? trim( $v ) : $v;
			}, $entry );
			if ( empty( $entry['og_title'] ) && ! empty( $entry['title'] ) ) {
				$entry['og_title'] = $entry['title'];
			}
			if ( empty( $entry['og_description'] ) && ! empty( $entry['description'] ) ) {
				$entry['og_description'] = $entry['description'];
			}
			if ( empty( $entry['twitter_title'] ) && ! empty( $entry['og_title'] ) ) {
				$entry['twitter_title'] = $entry['og_title'];
			}
			if ( empty( $entry['twitter_description'] ) && ! empty( $entry['og_description'] ) ) {
				$entry['twitter_description'] = $entry['og_description'];
			}
		}

		$cache[ $key ] = $entry;
		return $entry;
	}
}

if ( ! function_exists( 'sly_seo_value' ) ) {
	/** One field for the current request, or ''. */
	function sly_seo_value( $field ) {
		$entry = sly_seo_entry();
		return ( $entry && ! empty( $entry[ $field ] ) ) ? $entry[ $field ] : '';
	}
}

if ( ! function_exists( 'sly_seo_mode' ) ) {
	/** 'rankmath' | 'other_plugin' | 'theme' */
	function sly_seo_mode() {
		if ( defined( 'RANK_MATH_VERSION' ) || class_exists( 'RankMath' ) ) {
			return 'rankmath';
		}
		if ( defined( 'WPSEO_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) ) {
			return 'other_plugin';
		}
		return 'theme';
	}
}

/* ===========================================================================
 * Rank Math mode — feed the register into Rank Math's own output
 * ======================================================================== */

add_action( 'init', function () {
	if ( 'rankmath' !== sly_seo_mode() ) {
		return;
	}

	$use = function ( $field ) {
		return function ( $value ) use ( $field ) {
			$custom = sly_seo_value( $field );
			return '' !== $custom ? $custom : $value;
		};
	};

	add_filter( 'rank_math/frontend/title', $use( 'title' ), 99 );
	add_filter( 'rank_math/frontend/description', $use( 'description' ), 99 );
	add_filter( 'rank_math/frontend/canonical', $use( 'canonical' ), 99 );
	add_filter( 'rank_math/opengraph/facebook/og_title', $use( 'og_title' ), 99 );
	add_filter( 'rank_math/opengraph/facebook/og_description', $use( 'og_description' ), 99 );
	add_filter( 'rank_math/opengraph/facebook/og_url', $use( 'canonical' ), 99 );
	add_filter( 'rank_math/opengraph/twitter/twitter_title', $use( 'twitter_title' ), 99 );
	add_filter( 'rank_math/opengraph/twitter/twitter_description', $use( 'twitter_description' ), 99 );

	add_filter( 'rank_math/frontend/robots', function ( $robots ) {
		if ( sly_seo_value( 'noindex' ) && is_array( $robots ) ) {
			$robots['index'] = 'noindex';
		}
		return $robots;
	}, 99 );
} );

/* ===========================================================================
 * Theme mode — no SEO plugin installed, the theme prints everything
 * ======================================================================== */

add_filter( 'pre_get_document_title', function ( $title ) {
	if ( 'theme' !== sly_seo_mode() ) {
		return $title;
	}
	$custom = sly_seo_value( 'title' );
	return '' !== $custom ? $custom : $title;
}, 99 );

add_filter( 'wp_robots', function ( $robots ) {
	if ( 'theme' === sly_seo_mode() && sly_seo_value( 'noindex' ) ) {
		unset( $robots['index'] );
		$robots['noindex'] = true;
	}
	return $robots;
}, 99 );

// Singular pages: WordPress core prints the canonical — override its URL only.
add_filter( 'get_canonical_url', function ( $url ) {
	if ( 'theme' !== sly_seo_mode() ) {
		return $url;
	}
	$custom = sly_seo_value( 'canonical' );
	return '' !== $custom ? $custom : $url;
}, 99 );

if ( ! function_exists( 'sly_seo_current_url' ) ) {
	/** Self-referencing URL for the current request. */
	function sly_seo_current_url() {
		if ( is_front_page() ) {
			return home_url( '/' );
		}
		if ( is_singular() ) {
			return wp_get_canonical_url();
		}
		if ( is_tax() || is_category() || is_tag() ) {
			$link = get_term_link( get_queried_object() );
			return is_wp_error( $link ) ? '' : $link;
		}
		if ( is_home() ) {
			$id = (int) get_option( 'page_for_posts' );
			return $id ? get_permalink( $id ) : home_url( '/' );
		}
		if ( function_exists( 'is_shop' ) && is_shop() && function_exists( 'wc_get_page_id' ) ) {
			return get_permalink( wc_get_page_id( 'shop' ) );
		}
		return '';
	}
}

add_action( 'wp_head', function () {
	if ( 'theme' !== sly_seo_mode() ) {
		return;
	}

	$entry = sly_seo_entry();
	$url   = sly_seo_value( 'canonical' );
	$url   = '' !== $url ? $url : sly_seo_current_url();

	// Archives get no canonical from WordPress core — print one.
	if ( $url && ! is_singular() && ! is_front_page() ) {
		printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $url ) );
	}

	if ( ! $entry ) {
		return;
	}

	$title = sly_seo_value( 'og_title' );
	$title = '' !== $title ? $title : wp_get_document_title();
	$tags  = array(
		array( 'name', 'description', sly_seo_value( 'description' ) ),
		array( 'property', 'og:locale', get_locale() ),
		array( 'property', 'og:type', is_singular( array( 'post' ) ) ? 'article' : ( is_singular( 'product' ) ? 'product' : 'website' ) ),
		array( 'property', 'og:site_name', get_bloginfo( 'name' ) ),
		array( 'property', 'og:title', $title ),
		array( 'property', 'og:description', sly_seo_value( 'og_description' ) ),
		array( 'property', 'og:url', $url ),
		array( 'property', 'og:image', sly_seo_value( 'og_image' ) ),
		array( 'name', 'twitter:card', 'summary_large_image' ),
		array( 'name', 'twitter:title', sly_seo_value( 'twitter_title' ) ? sly_seo_value( 'twitter_title' ) : $title ),
		array( 'name', 'twitter:description', sly_seo_value( 'twitter_description' ) ),
	);

	echo "\n<!-- SLY SEO -->\n";
	foreach ( $tags as $tag ) {
		if ( '' === (string) $tag[2] ) {
			continue;
		}
		$value = ( 'og:url' === $tag[1] || 'og:image' === $tag[1] ) ? esc_url( $tag[2] ) : esc_attr( $tag[2] );
		printf( '<meta %s="%s" content="%s">' . "\n", $tag[0], esc_attr( $tag[1] ), $value );
	}
	echo "<!-- /SLY SEO -->\n";
}, 2 );

/* ===========================================================================
 * Admin — read-only overview: Appearance → SLY SEO
 * ======================================================================== */

add_action( 'admin_menu', function () {
	add_theme_page( 'SLY SEO', 'SLY SEO', 'manage_options', 'sly-seo', 'sly_seo_admin_page' );
} );

if ( ! function_exists( 'sly_seo_resolve_key' ) ) {
	/** Returns [label, URL] for a register key, or [warning, ''] if nothing matches. */
	function sly_seo_resolve_key( $key ) {
		if ( 'front_page' === $key ) {
			return array( 'Homepage', home_url( '/' ) );
		}
		if ( 'blog' === $key ) {
			$id = (int) get_option( 'page_for_posts' );
			return $id ? array( get_the_title( $id ), get_permalink( $id ) ) : array( 'No blog page set', '' );
		}
		if ( 'shop' === $key ) {
			$id = function_exists( 'wc_get_page_id' ) ? (int) wc_get_page_id( 'shop' ) : 0;
			return $id > 0 ? array( get_the_title( $id ), get_permalink( $id ) ) : array( 'No shop page set', '' );
		}
		$parts = explode( ':', $key, 2 );
		if ( 2 !== count( $parts ) ) {
			return array( 'Unknown key format', '' );
		}
		list( $type, $slug ) = $parts;
		if ( in_array( $type, array( 'page', 'post', 'product' ), true ) ) {
			$found = get_posts( array(
				'name'           => $slug,
				'post_type'      => $type,
				'post_status'    => 'publish',
				'posts_per_page' => 1,
			) );
			return $found ? array( get_the_title( $found[0] ), get_permalink( $found[0] ) ) : array( 'No published ' . $type . ' with this slug', '' );
		}
		if ( in_array( $type, array( 'product_cat', 'category' ), true ) ) {
			$term = get_term_by( 'slug', $slug, $type );
			if ( $term ) {
				$link = get_term_link( $term );
				return array( $term->name, is_wp_error( $link ) ? '' : $link );
			}
			return array( 'No ' . $type . ' with this slug', '' );
		}
		return array( 'Unknown key type', '' );
	}
}

if ( ! function_exists( 'sly_seo_admin_page' ) ) {
	function sly_seo_admin_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$modes = array(
			'rankmath'     => 'Rank Math is active — it prints the tags using the values below.',
			'theme'        => 'No SEO plugin — the theme prints the tags itself.',
			'other_plugin' => 'Another SEO plugin is active — the theme is NOT applying these values.',
		);
		$len = function ( $s ) {
			return function_exists( 'mb_strlen' ) ? mb_strlen( $s ) : strlen( $s );
		};
		?>
		<div class="wrap">
			<h1>SLY SEO</h1>
			<p><strong>Mode:</strong> <?php echo esc_html( $modes[ sly_seo_mode() ] ); ?></p>
			<p>Read-only. To change anything, edit <code>inc/seo/seo-pages.php</code> in the theme, upload a new theme version and purge the cache.</p>
			<table class="widefat striped">
				<thead><tr><th>Key</th><th>Page</th><th>Title</th><th>Description</th><th>Other</th></tr></thead>
				<tbody>
				<?php foreach ( sly_seo_register() as $key => $entry ) :
					list( $label, $url ) = sly_seo_resolve_key( $key );
					$title = isset( $entry['title'] ) ? $entry['title'] : '';
					$desc  = isset( $entry['description'] ) ? $entry['description'] : '';
					$tl    = $len( $title );
					$dl    = $len( $desc );
					$other = array_diff( array_keys( $entry ), array( 'title', 'description' ) );
					?>
					<tr>
						<td><code><?php echo esc_html( $key ); ?></code></td>
						<td><?php echo $url ? '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener">' . esc_html( $label ) . '</a>' : '<span style="color:#b32d2e">⚠ ' . esc_html( $label ) . '</span>'; ?></td>
						<td><?php
						if ( $title ) {
							echo esc_html( $title ) . '<br><small style="color:' . ( $tl > 65 ? '#b32d2e' : '#2271b1' ) . '">' . (int) $tl . ' chars' . ( $tl > 65 ? ' — may be cut off' : '' ) . '</small>';
						} else {
							echo '<small>default</small>';
						}
						?></td>
						<td><?php
						if ( $desc ) {
							$ok = $dl >= 120 && $dl <= 160;
							echo esc_html( $desc ) . '<br><small style="color:' . ( $ok ? '#2271b1' : '#b32d2e' ) . '">' . (int) $dl . ' chars' . ( $ok ? '' : ' — aim for 150–160' ) . '</small>';
						} else {
							echo '<small>default</small>';
						}
						?></td>
						<td><small><?php echo esc_html( implode( ', ', $other ) ); ?></small></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
	}
}
