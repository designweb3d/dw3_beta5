<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SIG = file_get_contents('php://input');

$sig_path = $_SERVER['DOCUMENT_ROOT'] . "/fs/user/".$USER."/signature.png";
base64_to_jpeg($SIG,$sig_path);
/* $data_png = $SIG;
list($type, $data_png) = explode(';', $data_png);
list(, $data_png)      = explode(',', $data_png);
$data_png = base64_decode($data_png);
file_put_contents($sig_path, $data_png); */

//sleep(1);
/* $imageData = base64_encode(file_get_contents($sig_path));
$sig_src = 'data:'.mime_content_type($sig_path).';base64,'.$imageData; */

function base64_to_jpeg($base64_string, $output_file) {
    // open the output file for writing
    $ifp = fopen( $output_file, 'wb' ); 

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

    // clean up the file resource
    fclose( $ifp ); 

    //return $output_file; 
}
$dw3_conn->close();
exit; 
?>