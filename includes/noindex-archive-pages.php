<?php

add_filter('wp_robots', function (array $robots) {
    if (!is_singular() && !is_front_page()) {
        $robots['noindex'] = true;
    }

    return $robots;
});
