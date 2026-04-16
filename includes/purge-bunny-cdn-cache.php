<?php

/*
Plugin Name: Purge Bunny CDN cache
Author: Danny van Kooten
Version: 1.0
Author URI: https://dannyvankooten.com/
Private: True
*/

namespace ibericode;

function purge_cache_for_url(string $url)
{
    $url = urlencode($url);
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.bunny.net/purge?url=$url",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_MAXREDIRS => 5,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_HTTPHEADER => [
            "AccessKey: " . constant('BUNNY_API_KEY'),
        ],
    ]);

    curl_exec($curl);
    $error = curl_error($curl);
    if ($error) {
        error_log("Error purging Bunny CDN cache: $error");
    }
}

add_action('save_post', function ($post_id) {
    // Check if it's not an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // No-op if BUNNY_API_KEY constant is not set
    if (! defined('BUNNY_API_KEY')) {
        return;
    }

    $permalink = get_permalink($post_id);
    if (! $permalink) {
        return;
    }

    purge_cache_for_url($permalink);
    purge_cache_for_url(home_url('/sitemap.xml'));
});
