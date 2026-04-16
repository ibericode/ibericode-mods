<?php

add_action('login_footer', function () {
    ?><script>
        window.setTimeout(() => {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'login-ok';
            input.value = '1';
            document.querySelector('#loginform').prepend(input);
        }, 3000);
    </script><?php
});

add_action('wp_authenticate', function (&$username, &$password) {
    if (! isset($_POST['log'])) {
        return;
    }

    $js_timeout_check = ($_POST['login-ok'] ?? '') === '1';
    $csrf_check = parse_url($_SERVER['HTTP_ORIGIN'] ?? '', PHP_URL_HOST) === parse_url(home_url(), PHP_URL_HOST);
    if (!$js_timeout_check || ! $csrf_check) {
        $password = 'invalid';
    }
}, 10, 2);