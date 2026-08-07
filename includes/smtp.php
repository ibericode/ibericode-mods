<?php

// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase

use PHPMailer\PHPMailer\PHPMailer;

// Prevent direct file access
defined('ABSPATH') or exit;

/**
 * Configures `wp_mail()` to send through SMTP instead of PHP's `mail()`, and defaults the
 * "From" address to `SMTP_USER`.
 *
 * No-op unless `SMTP_HOST` and `SMTP_USER` are both defined in wp-config.php:
 *
 *     define( 'SMTP_HOST', 'smtp.example.com' );
 *     define( 'SMTP_USER', 'youremail@example.com' );
 *     define( 'SMTP_PASSWORD', 'your_password' ); // Optional
 *     define( 'SMTP_PORT', 587 ); // Optional
 *     define( 'SMTP_ENCRYPTION', 'tls' ); // Optional, defaults to 'tls' (PHPMailer::ENCRYPTION_STARTTLS)
 */
add_action('phpmailer_init', function (PHPMailer $phpmailer) {
    // make sure all configuration constants are given
    if (! defined('SMTP_HOST') || ! defined('SMTP_USER')) {
        return;
    }

    $phpmailer->Mailer = 'smtp';
    $phpmailer->Host = constant('SMTP_HOST');
    if (defined('SMTP_PORT')) {
        $phpmailer->Port = (int) constant('SMTP_PORT');
    }
    $phpmailer->SMTPAuth = true;
    $phpmailer->Username = constant('SMTP_USER');
    if (defined('SMTP_PASSWORD')) {
        $phpmailer->Password = constant('SMTP_PASSWORD');
    }
    $phpmailer->SMTPSecure = defined('SMTP_ENCRYPTION') ? constant('SMTP_ENCRYPTION') : PHPMailer::ENCRYPTION_STARTTLS;
});

add_filter('wp_mail_from', static function (string $from) {
    return defined('SMTP_USER') ? constant('SMTP_USER') : $from;
});
