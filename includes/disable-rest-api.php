<?php

defined('ABSPATH') or exit;

add_action('template_redirect', static function () {
    remove_action('template_redirect', 'rest_output_link_header', 11);
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');
});

// Do not allow access to WordPress REST API for non-logged-in users
add_filter('rest_authentication_errors', static function ($result) {
    if (! is_user_logged_in()) {
        return new WP_Error(
            'rest_not_logged_in',
            'You are not currently logged in.',
            ['status' => 401]
        );
    }

    return $result;
});
