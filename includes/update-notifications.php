<?php

defined('ABSPATH') or exit;

/**
 * Keeps plugin/theme/core update notifications and the automatic updater working even when
 * `DISALLOW_FILE_MODS` is set to `true` in wp-config.php (which normally hides update
 * notices and blocks all update capabilities). Three cooperating hooks:
 *
 * - `map_meta_cap`: restores the `update_plugins`/`update_themes`/`update_core` capabilities
 *   (limited to super admins on multisite).
 * - `file_mod_allowed`: explicitly allows the `automatic_updater` context so background
 *   updates still run.
 * - `load-plugins.php`: re-adds the "update available" row to the plugins list table, which
 *   WordPress otherwise skips rendering when file mods are disallowed.
 *
 * No configuration required; these hooks are harmless no-ops when `DISALLOW_FILE_MODS` is
 * unset or false.
 */

add_filter('map_meta_cap', static function ($caps, $cap, $user_id) {
    switch ($cap) {
        case 'update_plugins':
        case 'update_themes':
        case 'update_core':
            /* @phpstan-ignore phpstanWP.wpConstant.fetch */
            if (defined('DISALLOW_FILE_MODS') && DISALLOW_FILE_MODS) {
                  $caps = array_diff($caps, ['do_not_allow']);
                if (is_multisite() && ! is_super_admin($user_id)) {
                    $caps[] = 'do_not_allow';
                } else {
                    $caps[] = $cap;
                }
            }
            break;
        default:
            break;
    }
        return $caps;
}, 100, 3);

add_filter('file_mod_allowed', static function ($allow, $context) {
    if ('automatic_updater' === $context) {
        return true;
    }
    return $allow;
}, 10, 2);

add_action('load-plugins.php', static function () {

    if (wp_is_file_mod_allowed('install_plugins')) {
        return;
    }

    $plugins = get_site_transient('update_plugins');
    if (isset($plugins->response) && is_array($plugins->response)) {
        $plugins = array_keys($plugins->response);
        foreach ($plugins as $plugin_file) {
            add_action("after_plugin_row_$plugin_file", 'wp_plugin_update_row', 10, 2); /* @phpstan-ignore return.void */
        }
    }
}, 30);
