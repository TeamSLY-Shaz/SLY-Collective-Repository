<?php
/**
 * ============================================================================
 *  SLY SEO — PAGE REGISTER  (the ONLY file you edit to change SEO)
 * ============================================================================
 *
 * Every page's SEO title, meta description and social text lives here.
 * After editing: bump the theme version, upload, purge SiteGround cache,
 * then check WP Admin → Appearance → SLY SEO for warnings.
 *
 * KEYS — which page an entry applies to:
 *   'front_page'            the homepage
 *   'blog'                  the blog index (Undie Blog)
 *   'shop'                  the WooCommerce shop page
 *   'page:<slug>'           a WordPress page          e.g. 'page:about-us'
 *   'post:<slug>'           a blog post               e.g. 'post:best-pouch-underwear'
 *   'product:<slug>'        a product                 e.g. 'product:inkd-bamboo-trunks-no-chafe-hammock-pouch-bamboo'
 *   'product_cat:<slug>'    a product category        e.g. 'product_cat:mens-pouch-underwear'
 *   'category:<slug>'       a blog category
 *   The slug is the last part of the page's URL.
 *
 * FIELDS — all optional; leave a field out to keep the default:
 *   'title'               <title> tag. Aim ≤ 60 chars.
 *   'description'         meta description. Aim 150–160 chars.
 *   'og_title'            Facebook/LinkedIn title       (defaults to title)
 *   'og_description'      Facebook/LinkedIn description (defaults to description)
 *   'twitter_title'       X/Twitter title               (defaults to og_title)
 *   'twitter_description' X/Twitter description         (defaults to og_description)
 *   'og_image'            full image URL for social shares (theme-only mode)
 *   'canonical'           full URL — ONLY if this page duplicates another.
 *                         Leave out normally (page points to itself).
 *   'noindex'             true = hide from Google. Use with care.
 *
 * Write plain text — no HTML. Apostrophes are fine inside "double quotes".
 *
 * @package sly-pebble-lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(

	/* ------------------------------------------------------------------ *
	 * HOMEPAGE
	 * ------------------------------------------------------------------ */
	'front_page' => array(
		'title'       => "Men's Bamboo Pouch Underwear | No Chafe, No Ride-Up | SLY Collective",
		'description' => "Men's bamboo pouch underwear built to stop chafe and ride-up. A separation pouch keeps everything lifted, cool and supported. Free AU shipping over $100.",
	),

	/* ------------------------------------------------------------------ *
	 * INFORMATION PAGES
	 * (migrated from the page templates in v243 — values unchanged)
	 * ------------------------------------------------------------------ */
	'page:size-guide' => array(
		'description'         => "Not sure what size to grab? SLY's size guide sorts it out fast — waist & hip measurements in cm and inches, fit notes for every style, and international sizing for AU, US, UK & EU. Get it right first time.",
		'og_title'            => 'SLY Size Guide — Find Your Perfect Fit | SLY Collective',
		'og_description'      => "Measure once, order right. SLY Collective's size guide covers pouch underwear, pocket styles & quick-dry ranges — in cm, inches and international sizes.",
		'twitter_title'       => 'SLY Size Guide — Find Your Perfect Fit',
		'twitter_description' => "Measure once, order right. SLY's size guide covers every style — in cm, inches, and international sizes.",
	),

	'page:contact-us-sly-collective-mens-underwear' => array(
		'description' => 'Get in touch with SLY Collective. Real humans, no bots — email us at sales@slycollective.com for orders, returns, sizing questions, and anything else.',
	),

	'page:terms-and-conditions' => array(
		'description' => "SLY Collective's Terms & Conditions — ordering, pricing, shipping, returns, warranties and your Australian Consumer Law rights, laid out in plain English.",
	),

	// /returns/ currently redirects to the homepage, so this only applies
	// if a page with the slug "returns" is published again.
	'page:returns' => array(
		'description'         => 'SLY Collective returns & exchange policy. 30-day returns window, free size swaps, 12-month warranty on manufacturer defects, and a Comfort Guarantee. Hassle-free.',
		'og_title'            => 'Returns & Exchanges — No Drama | SLY Collective',
		'og_description'      => "Bought the wrong size? Changed your mind? SLY's return process is built to be painless — 30 days, free size swaps, tracked postage. We'll sort it.",
		'twitter_title'       => 'Returns & Exchanges | SLY Collective',
		'twitter_description' => '30-day returns, free size swaps, 12-month warranty. SLY Collective makes returns painless.',
	),

	/* ------------------------------------------------------------------ *
	 * PRODUCT CATEGORIES      (added during Section 11 — On-Page SEO)
	 * ------------------------------------------------------------------ */

	/* ------------------------------------------------------------------ *
	 * PRODUCTS                (added during Section 11 — On-Page SEO)
	 * ------------------------------------------------------------------ */

	/* ------------------------------------------------------------------ *
	 * BLOG                    (added during Sections 9–13)
	 * ------------------------------------------------------------------ */

);
