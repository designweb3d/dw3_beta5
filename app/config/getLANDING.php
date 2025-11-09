
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
    $myfile = fopen($req_root . "/landing/index.php", "r")??null;
    $HTML = fread($myfile,filesize($req_root . "/landing/index.php"))??null;
    fclose($myfile);
    echo trim($HTML);
    $dw3_conn->close();
    exit();
?>