<?php

/*
Plugin Name: Cache Headers
Description: Sets Cache-Control headers on all GET requests for guest visitors
Author: Danny van Kooten
Version: 1.0
Author URI: https://dannyvankooten.com/
Private: True
*/

add_filter('wp_headers', function ($headers) {
    if (WP_DEBUG) {
        return $headers;
    }

    // only set cache-headers on safe HTTP methods
    $method = $_SERVER['REQUEST_METHOD'] ?? 'POST';
    if ($method !== 'GET') {
        return $headers;
    }

    // never set cache headers for logged-in users
    if (is_user_logged_in()) {
        $headers["Cache-Control"] = "must-revalidate, max-age=0, private";

    // cache 404 pages for 1 hour
    } elseif (is_404()) {
        $headers["Cache-Control"] = "public, max-age=3600";

    // cache all other pages for 30 days
    } else {
        $headers["Cache-Control"] = "public, max-age=2592000";
    }

    return $headers;
});
