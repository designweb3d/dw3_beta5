<?php

//fonctions php generales
//Fonction pour generer un code de validation sms
function dw3_make_code($length = 6) {
    $characters = '123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//Fonction pour generer une clé
function dw3_make_key($length = 128) {
    $characters = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//Fonction pour generer un numero de tracking
function dw3_make_tracking_number($length = 32) {
    $characters = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//Fonction pour generer un password
function dw3_make_pw($length = 16) {
    $characters = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%?&*';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$dw3_crypt_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/hash.ini");
$dw3_cryptkey = $dw3_crypt_ini["cryptk"];
function dw3_crypt($str) {
    if ($str == ""){return $str;}
    $dw3_decryptk = "0123456789abcdef";
    $dw3_cryptk = $GLOBALS['dw3_cryptkey'];
    if (strlen($str) >= 1){
        $hstr = bin2hex($str);
        $strl = strlen($hstr);
        $keyl = strlen($dw3_cryptk);
        $crypted = '';
        for ($i = 0; $i < $strl; $i++) {
            for ($ii = 0; $ii < $keyl; $ii++) {
                if (substr($hstr,$i,1)==substr($dw3_decryptk,$ii,1)){
                    $crypted .= substr($dw3_cryptk,$ii,1);
                }
            }
        }
        return $crypted;
        //return $hstr;
    } else {
        return $str;
    }
}
function dw3_decrypt($str) {
    if ($str == ""){return $str;}
    $dw3_decryptk = "0123456789abcdef";
    $dw3_cryptk = $GLOBALS['dw3_cryptkey'];
        $strl = strlen($str);
        if ($strl >= 1){
            $keyl = strlen($dw3_cryptk);
            $decrypted = '';
            for ($i = 0; $i < $strl; $i++) {
                for ($ii = 0; $ii < $keyl; $ii++) {
                    if (substr($str,$i,1)==substr($dw3_cryptk,$ii,1)){
                        $decrypted .= substr($dw3_decryptk,$ii,1);
                    }
                }
            }
            if(strlen($decrypted)>=1){
                return hex2bin($decrypted);
            } else {
                return $decrypted;
            }
        } else {
            return $str;
        }
}
?>