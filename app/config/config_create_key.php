<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$KEY_TYPE = $_GET["TYPE"];
//fichier de création de la clé de cryptage
if ($KEY_TYPE == "MASTER"){
    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/sbin/hash_master.ini")) {
        echo "La clé maître existe déjà.";
        exit;
    } else {
        $key_str = dw3_make_key();
        $characters = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/sbin/hash_master.ini", "masterk=" . $key_str);
        echo "OK";
    }
} else if ($KEY_TYPE == "DECRYPT"){
    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/sbin/hash.ini")) {
        echo "La clé de cryptage existe déjà.";
        exit;
    } else {
        $key_str = '';
        $characters = '0123456789abcdef';
        for ($i = 0; $i < 16; $i++) {
            $next_char = rand(0, strlen($characters) - 1);
            $key_str .= $characters[$next_char];
            $characters = str_replace($characters[$next_char], '', $characters);
        }
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/sbin/hash.ini", "cryptk=" . $key_str);
        echo "OK";
    }
}
$dw3_conn->close();
exit(); 
?>