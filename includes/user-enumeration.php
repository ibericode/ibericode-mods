<?php

// Prevent direct file access
defined('ABSPATH') or exit;

/**
 * Prevents user enumeration through the `?author=<id>` query parameter by stripping it
 * before WordPress gets a chance to redirect to the matching author archive. No configuration
 * required.
 */
add_action('init', static function () {
    if (isset($_GET['author'])) {
        unset($_GET['author']);
        unset($_REQUEST['author']);
    }
}, 1);
