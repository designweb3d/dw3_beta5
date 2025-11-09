<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

$photo = file_get_contents('php://input');
echo  strlen($photo)."\n";
$photoDir = $_SERVER['DOCUMENT_ROOT'] . "/fs/user/";
/* $x = 0;
do {
    $x++;
    $y = file_exists($photoDir . $head_id . "-" . $line_id . "-" . $x . ".png");
} while ($y == 1);
 */
//$photo_path = $photoDir . $head_id . "-" . $line_id . "-". $x .".png";

$photo_path = $photoDir . $USER .".png";
echo  $photo_path."\n";
base64_to_jpeg($photo,$photo_path);

$dw3_conn->close();
die("ok");

function base64_to_jpeg($base64_string, $output_file) {
    $data = explode( ',', $base64_string );
    if (count( $data ) > 1){
        $ifp = fopen( $output_file, 'wb' ); 
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );
        fclose( $ifp ); 
    }
}
?>