<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$line_id  = $_GET['ID'];
$platform  = $_GET['PLATFORM'];
$link_url  = $_GET['LINK'];
$link_pw  = $_GET['PW'];

$sql = "UPDATE schedule_line SET link_platform = '" . mysqli_real_escape_string($dw3_conn,$platform) . "',
        link_url = '" . mysqli_real_escape_string($dw3_conn,$link_url) . "',
        link_pw = '" . mysqli_real_escape_string($dw3_conn,$link_pw) . "',
        is_link_sent = '0'
        WHERE id = '" . $line_id . "';";
        //error_log($sql); 
if ($dw3_conn->query($sql) === TRUE) {
    echo "OK";
} else {
    echo "Erreur: " . $dw3_conn->error;
}    
$dw3_conn->close(); 
?>

