<?php
$ID = $_GET['ID'];
$cookie_name = "SUBSCRIBE";
$cookie_value = $ID;
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/",".".$_SERVER['SERVER_NAME'],true); //30 days
?>