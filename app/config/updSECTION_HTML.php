<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID= $_POST['ID'];
$html_fr = mysqli_real_escape_string($dw3_conn,$_POST['FR']);
$html_en = mysqli_real_escape_string($dw3_conn,$_POST['EN']);
/* $html_fr = $_POST['FR'];
$html_en = $_POST['EN']; */


$sql = "UPDATE index_head SET    
html_fr = '" . $html_fr . "',
html_en = '" . $html_en . "'
WHERE id = '" . $ID . "' 
LIMIT 1";

if ($dw3_conn->query($sql) === TRUE) {
    echo "";
} else {
    echo $dw3_conn->error;
}

//TO_DO: Uncomment to enable writing HTML files
// Write to HTML files
//FR
/* $filename = $_SERVER['DOCUMENT_ROOT'] . "/pub/html/fr/" . $ID ;
$file_handle = fopen($filename, "w");
if ($file_handle) {
    fwrite($file_handle, html_entity_decode($html_fr));
    fclose($file_handle);
} else {
    echo "Erreur d'écriture du fichier.";
} */
//EN
/* $filename = $_SERVER['DOCUMENT_ROOT'] . "/pub/html/en/" . $ID ;
$file_handle = fopen($filename, "w");
if ($file_handle) {
    fwrite($file_handle, html_entity_decode($html_en));
    fclose($file_handle);
} else {
    echo "Error opening file for writing.";
} */

$dw3_conn->close();
die();
?>