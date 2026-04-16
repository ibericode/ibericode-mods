<?php

add_filter('upload_mimes', function (array $mime_types) {
    $mime_types['svg'] = 'image/svg+xml';
    return $mime_types;
});
