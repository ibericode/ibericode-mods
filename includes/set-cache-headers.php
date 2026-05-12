<?php

// Prevent direct file access
defined('ABSPATH') or exit;

add_filter('wp_headers', function ($headers) {
    if (WP_DEBUG || isset($headers['Cache-Control']) || is_admin()) {
        return $headers;
    }

    // only set cache-headers on safe HTTP methods
    $method = $_SERVER['REQUEST_METHOD'] ?? 'POST';
    if ($method !== 'GET' && $method !== 'HEAD') {
        return $headers;
    }

    // never set cache headers for logged-in users
    if (is_user_logged_in()) {
        $headers['Cache-Control'] = 'must-revalidate, max-age=0, private';

    // cache 404 pages for 1 hour (shared), 5 minutes (browser)
    } elseif (is_404()) {
        $headers['Cache-Control'] = 'public, s-max-age=3600, max-age=300';

    // cache feeds and XML files (ie sitemap) for 1 day (both shared and browser)
    } elseif (is_feed() || str_ends_with($_SERVER['REQUEST_URI'] ?? '', '.xml')) {
        $headers['Cache-Control'] = 'public, max-age=86400';
    // cache all other pages for 30 days (shared) or 1 day (browser cache)
    } else {
        $headers['Cache-Control'] = 'public, s-max-age=2592000, max-age=86400';
    }

    return $headers;
});
