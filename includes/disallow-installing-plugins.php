<?php

defined('ABSPATH') or exit;

add_filter('user_has_cap', function ($allcaps) {
    $allcaps['install_plugins'] = false;
    $allcaps['delete_plugins']  = false;
    $allcaps['install_themes']  = false;
    $allcaps['delete_themes']   = false;
    return $allcaps;
});
