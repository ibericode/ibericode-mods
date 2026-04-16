<?php

 /*
Plugin Name: Allow SVG Uploads
Description: Allows uploading .svg files as WP Media
Author: Danny van Kooten
Version: 1.0
Author URI: https://dannyvankooten.com/
Private: True
*/

add_filter('upload_mimes', function (array $mime_types) {
    $mime_types['svg'] = 'image/svg+xml';
    return $mime_types;
});
