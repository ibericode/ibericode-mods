<?php

// Prevent direct file access
defined('ABSPATH') or exit;

/**
 * Adds `Robots: noindex` to all non-singular pages (archives, search results, etc), except
 * the front page. No configuration required.
 */
add_filter('wp_robots', static function (array $robots): array {
    if (did_action('wp') && !is_singular() && !is_front_page()) {
        $robots['noindex'] = true;
    }

    return $robots;
});
