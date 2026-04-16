<?php

/*
Plugin Name: noindex archive pages
Description: Sets robots noindex for non-singular pages
Author: Danny van Kooten
Version: 1.0
Author URI: https://dannyvankooten.com/
Private: True
*/

add_filter('wp_robots', function ($robots) {
    if (!is_singular() && !is_front_page()) {
        $robots['noindex'] = true;
    }

    return $robots;
}, 0);
