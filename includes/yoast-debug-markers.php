<?php

// Prevent direct file access
defined('ABSPATH') or exit;

/**
 * Removes the Yoast SEO HTML debug comments (`<!-- This site is optimized with the Yoast SEO
 * plugin ... -->`) from page output. No-op if Yoast SEO is not active.
 */
add_filter('wpseo_debug_markers', '__return_false');
