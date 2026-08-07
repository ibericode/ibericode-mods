<?php

// Prevent direct file access
defined('ABSPATH') or exit;

/**
 * Rejects login attempts submitted within 2.5 seconds of the login page loading, on the
 * assumption that a human can't fill in and submit the form that fast. The login button is
 * disabled and shown as "filling up" via CSS/JS for the first 2.5 seconds; on submit, a
 * `wp_authenticate` check confirms the timeout actually elapsed (`login-ok` field) and that
 * the request's Origin matches the site (basic CSRF check). No configuration required.
 */
add_action('login_footer', static function () {
    ?><style>
        #wp-submit {
            background-color: #2271b1 !important;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.28), rgba(255, 255, 255, 0.18)) !important;
            background-repeat: no-repeat !important;
            background-size: 0% 100% !important;
            border-color: #2271b1 !important;
            color: #fff !important;
        }

        #wp-submit.waiting-animate {
            background-size: 100% 100% !important;
            transition: background-size 2.5s linear !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let button = document.querySelector('#wp-submit');
            if (!button) {
                return;
            }
            requestAnimationFrame(() => {
                button.classList.add('waiting-animate');
                button.disabled = true;
            });

            window.setTimeout(() => {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'login-ok';
                input.value = '1';
                document.querySelector('#loginform').prepend(input);
                button.classList.remove('waiting-animate');
                button.disabled = false;
            }, 2500);
        })

    </script><?php
});

add_action('wp_authenticate', static function (&$username, &$password) {
    // phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce is handled by WP login itself
    if (! isset($_POST['log'])) {
        return;
    }

    // phpcs:ignore WordPress.Security.NonceVerification.Missing,WordPress.Security.ValidatedSanitizedInput.MissingUnslash -- nonce is handled by WP login itself
    $js_timeout_check = ($_POST['login-ok'] ?? '') === '1';

    // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash
    $csrf_check = parse_url($_SERVER['HTTP_ORIGIN'] ?? '', PHP_URL_HOST) === parse_url(home_url(), PHP_URL_HOST);

    if (!$js_timeout_check || ! $csrf_check) {
        wp_die("Sorry, we are unable to process your login request as we think you are a bot. Please try again if you're not.");
    }
}, 10, 2);
