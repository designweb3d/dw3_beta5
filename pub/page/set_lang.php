<?php
$USER_LANG = $_GET['LANG']??'FR';
    $cookie_name = "LANG";
    $cookie_value = $USER_LANG;
    $cookie_domain = $_SERVER["SERVER_NAME"];
    setcookie($cookie_name, $cookie_value, [
        'expires' => time() + 86400,
        'path' => '/',
        'domain' => $cookie_domain,
        'secure' => true,
        'httponly' => true,
        'samesite' => 'None',
    ]);

?>