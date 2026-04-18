<?php

add_filter('wp_headers', function ($headers) {
    if (WP_DEBUG || isset($headers['Cache-Control'])) {
        return $headers;
    }

    // only set cache-headers on safe HTTP methods
    $method = $_SERVER['REQUEST_METHOD'] ?? 'POST';
    if ($method !== 'GET') {
        return $headers;
    }

    // never set cache headers for logged-in users
    if (is_user_logged_in()) {
        $headers['Cache-Control'] = 'must-revalidate, max-age=0, private';

    // cache 404 pages for 1 hour
    } elseif (is_404()) {
        $headers['Cache-Control'] = 'public, max-age=3600';

    // cache feeds and XML files (ie sitemap) for 1 day
    } elseif (is_feed() || str_ends_with($_SERVER['REQUEST_URI'] ?? '', '.xml')) {
        $headers['Cache-Control'] = 'public, max-age=81600';
    // cache all other pages for 1 year
    } else {
        $headers['Cache-Control'] = 'public, max-age=2592000';
    }

    return $headers;
});
