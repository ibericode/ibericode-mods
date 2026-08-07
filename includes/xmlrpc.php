<?php

// Prevent direct file access
defined('ABSPATH') or exit;

/**
 * Disables XML-RPC entirely. No configuration required.
 */
add_filter('xmlrpc_enabled', '__return_false');
