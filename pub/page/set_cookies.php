<?php
$PREF1 = $_GET['PREF1']??'OK';
$PREF2 = $_GET['PREF2']??'NO';
$PREF3 = $_GET['PREF3']??'OK';
$PREF4 = $_GET['PREF4']??'OK';

$cookie_domain = $_SERVER["SERVER_NAME"];

//pref1
    setcookie("COOKIE_PREF1", $PREF1, [
        'expires' => time() + 86400,
        'path' => '/',
        'domain' => $cookie_domain,
        'secure' => true,
        'httponly' => true,
        'samesite' => 'None',
    ]);
//pref2
    setcookie("COOKIE_PREF2", $PREF2, [
        'expires' => time() + 86400,
        'path' => '/',
        'domain' => $cookie_domain,
        'secure' => true,
        'httponly' => true,
        'samesite' => 'None',
    ]);
//pref3
    setcookie("COOKIE_PREF3", $PREF3, [
        'expires' => time() + 86400,
        'path' => '/',
        'domain' => $cookie_domain,
        'secure' => true,
        'httponly' => true,
        'samesite' => 'None',
    ]);
//pref4
    setcookie("COOKIE_PREF4", $PREF4, [
        'expires' => time() + 86400,
        'path' => '/',
        'domain' => $cookie_domain,
        'secure' => true,
        'httponly' => true,
        'samesite' => 'None',
    ]);

?>