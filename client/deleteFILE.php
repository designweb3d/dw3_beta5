`<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$fn  = $_GET['fn'];
$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/fs/customer/"  . $USER . "/";
$target_file = $target_dir.$fn;

$dw3_conn->close();

    if (file_exists($target_file)) { 
        $delete_status=unlink($target_file);    
    } else {
        $dw3_conn->close();
        die("Erreur: Fichier introuvable");
    }
exit();
?>
`