# SLY SEO — how page SEO works in this theme

All SEO titles, meta descriptions and social-share text for slycollective.com live in **one file**:

```
sly-pebble-lite/inc/seo/seo-pages.php   ← edit this
sly-pebble-lite/inc/seo/seo-engine.php  ← never edit
```

Page templates must **not** print their own `<meta name="description">`, `rel="canonical"`, `robots` or Open Graph tags. Doing so creates duplicate tags. Add an entry to `seo-pages.php` instead.

## Adding or changing a page

1. Find the page's slug, which is the last part of its URL.
   `https://slycollective.com/product-category/men-underwear/mens-pouch-underwear/` → `mens-pouch-underwear`
2. Add an entry under the matching heading in `seo-pages.php`:

```php
'product_cat:mens-pouch-underwear' => array(
    'title'       => "Men's Pouch Underwear | Separation Pouch, No Chafe | SLY",
    'description' => "Shop men's pouch underwear with a separation pouch that ...",
),
```

3. Bump `Version:` in `style.css`, package the theme as `sly-pebble-lite-theme/vNNN.zip` and upload it.
4. Purge the SiteGround cache.
5. Check **WP Admin → Appearance → SLY SEO**. Every entry should link to a real page, and none should show red length warnings.

## Keys

| Key | Applies to |
|---|---|
| `front_page` | Homepage |
| `blog` | Blog index |
| `shop` | WooCommerce shop page |
| `page:<slug>` | WordPress page |
| `post:<slug>` | Blog post |
| `product:<slug>` | Product |
| `product_cat:<slug>` | Product category |
| `category:<slug>` | Blog category |

## Fields (all optional)

| Field | Use | Length |
|---|---|---|
| `title` | `<title>` tag shown in Google | ≤ 60 chars |
| `description` | Meta description shown in Google | 150–160 chars |
| `og_title` / `og_description` | Facebook / LinkedIn shares | defaults to title / description |
| `twitter_title` / `twitter_description` | X shares | defaults to the og values |
| `og_image` | Share image URL (only used when no SEO plugin is active) | — |
| `canonical` | Only when this page duplicates another page | — |
| `noindex` | `true` hides the page from Google | — |

## How it behaves

- **Rank Math active**: Rank Math prints the tags using these values, so there is one of each tag. Values here override anything typed into Rank Math's page boxes.
- **No SEO plugin**: the theme prints title, description, robots, canonical, Open Graph and Twitter tags itself.
- **Yoast / AIOSEO / SEOPress active**: the theme does nothing, to avoid duplicates.
- **Emergency off switch**: add `define( 'SLY_SEO_DISABLE', true );` to `wp-config.php`.

## Change log

- **v243**: system created. Homepage title and description added. SEO tags moved out of the size guide, contact, terms, refund policy and returns templates. This fixed duplicate canonical, robots and description tags, and the size guide's canonical that pointed at a URL redirecting to the homepage.
