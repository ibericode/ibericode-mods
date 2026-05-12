ibericode mods
==============

A collection of lightweight WordPress plugins that we commonly use on our sites.

- Allow SVG uploads
- Disable the `/wp-json/wp/v2/users` REST API endpoint.
- Adds `Robots: noindex` HTTP header to all non-singular pages (except the front page).
- Reject all WP Login attempts if submitted within 2.5 seconds of page load.
- Purge Bunny CDN Cache on `save_post`
- Set HTTP `Cache-Control` header on all safe requests for logged-out users.
- Configure `wp_mail()` to use SMTP.
- Automatically mark comments as spam through a collection of empirically discovered checks.

Some of these are simple no-ops if the relevant PHP constants are not set.

## Install

Download the plugin package from the [latest release here on GitHub](https://github.com/ibericode/ibericode-mods/releases/latest).

Go to **Plugins > Add Plugin > Upload Plugin** to install the plugin. 

Alternatively, download or clone this repository and place in `/wp-content/plugins/`.

## License

GPL v2 or later