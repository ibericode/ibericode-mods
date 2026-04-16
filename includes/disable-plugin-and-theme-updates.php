<?php

add_filter('user_has_cap', function (array $caps): array {
    $caps['install_plugins'] = false;
    $caps['update_plugins'] = false;
    $caps['delete_plugins'] = false;
    $caps['install_themes']  = false;
    $caps['update_themes']   = false;
    $caps['delete_themes']   = false;
    return $caps;
});
