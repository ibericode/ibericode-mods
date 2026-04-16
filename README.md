ibericode mods
==============

A collection of lightweight WordPress plugins that we commonly use on our sites.

- Allow SVG uploads
- Disable installing or updating plugins through the WP Admin interface.
- Disable the `/wp-json/wp/v2/users` REST API endpoint.
- Adds `Robots: noindex` HTTP header to all non-singular pages (except the front page).
- Protect WP Login through a 2 second timeout and `Origin` check.
- Purge Bunny CDN Cache on `save_post`
- Set HTTP `Cache-Control` header on all safe requests for logged-out users.
- Configure `wp_mail()` to use SMTP.
- Automatically mark comments as spam through a collection of empirically discovered checks.

Some of these are simple no-ops if the relevant PHP constants are not set.

## Install

We install this plugin on all our sites through Composer, but you can also just download the ZIP and drop it in `wp-content/plugins`.

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/ibericode/ibericode-mods"
        }
    ],
    "require": {
        "composer/installers": "^2.2",
        "ibericode/ibericode-mods": "*@dev",
    },
    "config": {
        "allow-plugins": {
            "composer/installers": true
        }
    },
    "extra": {
        "installer-paths": {
            "wp-content/plugins/{$name}/": ["type:wordpress-plugin"]
        }
    }
}

```

## License

GPL v2 or later