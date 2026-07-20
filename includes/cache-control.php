<?php

/**
 * Sets an HTTP `Cache-Control` header on all safe (GET/HEAD) requests for logged-out visitors.
 *
 * Logged-in users always get a `must-revalidate, max-age=0, private` header so nothing of
 * theirs is cached. Everyone else gets a longer-lived cacheable header, tuned per page type:
 * 404s cache for 1 hour (shared) / 5 minutes (browser); feeds and `.xml` files (eg. sitemaps)
 * cache for 1 day / 1 hour; everything else caches for 30 days (shared) / 1 hour (browser).
 *
 * No-op when `WP_DEBUG` is enabled, when a `Cache-Control` header is already set, or in wp-admin.
 */

namespace ibericode;

add_filter('wp_headers', static function (array $headers) {
    if (WP_DEBUG || isset($headers['Cache-Control']) || is_admin()) {
        return $headers;
    }

    // only set cache-headers on safe HTTP methods
    $method = $_SERVER['REQUEST_METHOD'] ?? 'POST'; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash
    if ($method !== 'GET' && $method !== 'HEAD') {
        return $headers;
    }

    $url = trim($_SERVER['REQUEST_URI'] ?? ''); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash

    // never set cache headers for logged-in users
    if (is_user_logged_in()) {
        $headers['Cache-Control'] = 'must-revalidate, max-age=0, private';

        // cache 404 pages for 1 hour (shared) or 5 minutes (browser)
    } elseif (is_404()) {
        $headers['Cache-Control'] = 'public, s-max-age=3600, max-age=300';

        // cache feeds and XML files (ie sitemap) for 1 day (shared) or 1 hour (browser)
    } elseif (is_feed() || str_ends_with($url, '.xml')) {
        $headers['Cache-Control'] = 'public, s-max-age=86400, max-age=3600';

        // cache all other pages for 30 days (shared) or 1 hour (browser)
    } else {
        $headers['Cache-Control'] = 'public, s-max-age=2592000, max-age=3600';
    }

    return $headers;
});
