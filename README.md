ibericode mods
==============

A collection of lightweight WordPress modifications that we commonly use on our sites.

Each modification lives in its own file under [`includes/`](includes/), documented with a
docblock at the top of the file describing what it does and how to configure it (if at all).

- [`includes/bunny-cdn.php`](includes/bunny-cdn.php) — Purge Bunny CDN cache when a post is saved or published.
- [`includes/cache-control.php`](includes/cache-control.php) — Set an HTTP `Cache-Control` header on safe requests for logged-out visitors.
- [`includes/comment-spam.php`](includes/comment-spam.php) — Mark comments as spam through a collection of empirically discovered heuristics.
- [`includes/login-timing.php`](includes/login-timing.php) — Reject login attempts submitted within 2.5 seconds of the login page loading.
- [`includes/noindex-archives.php`](includes/noindex-archives.php) — Add `Robots: noindex` to all non-singular pages except the front page.
- [`includes/disable-rest-api.php`](includes/disable-rest-api.php) — Restrict the WordPress REST API to logged-in users.
- [`includes/smtp.php`](includes/smtp.php) — Send `wp_mail()` through SMTP.
- [`includes/user-enumeration.php`](includes/user-enumeration.php) — Prevent user enumeration via `?author=1`.
- [`includes/xmlrpc.php`](includes/xmlrpc.php) — Disable XML-RPC.
- [`includes/yoast-debug-markers.php`](includes/yoast-debug-markers.php) — Remove Yoast SEO's HTML debug comments.

Every modification is always active except `bunny-cdn.php` and `smtp.php`, which are no-ops
until their required PHP constants are defined in `wp-config.php` (see the docblock in each
file). You can also disable individual modifications with the `ibericode_mods` filter:

```php
add_filter( 'ibericode_mods', function ( $mods ) {
    return array_diff( $mods, [ 'xmlrpc' ] );
} );
```

## Install

Download the plugin package from the [latest release here on GitHub](https://github.com/ibericode/ibericode-mods/releases/latest).

Go to **Plugins > Add Plugin > Upload Plugin** to install the plugin. 

Alternatively, download or clone this repository and place in `/wp-content/plugins/`.

## License

GPL v2 or later
