<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$adID  = $_GET['ID'];

//delete images
$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/fs/customer/"  . $USER . "/";
$sql = "SELECT * FROM classified WHERE id = '" . $adID ."' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);

    //img1 exist or used somewhere else before delete?
    $target_file = $target_dir.$data["img_link"];
/*     $sqlx = "SELECT count(*) as rowCount FROM classified WHERE customer_id = '" . $USER ."' AND img_link='".$data["img_link"]."' OR customer_id = '" . $USER ."' AND img_link2='".$data["img_link"]."' OR customer_id = '" . $USER ."' AND img_link3='".$data["img_link"]."' LIMIT 1";
    $resultx = mysqli_query($dw3_conn, $sqlx);
    $datax = mysqli_fetch_assoc($resultx); */
    //if (file_exists($target_file) && $datax["rowCount"]=="0") { 
    if (file_exists($target_file)) { 
        $delete_status=unlink($target_file);    
    }

    //img2 exist or used somewhere else before delete?
    $target_file2 = $target_dir.$data["img_link2"];
/*     $sqlx = "SELECT count(*) as rowCount FROM classified WHERE customer_id = '" . $USER ."' AND img_link='".$data["img_link2"]."' OR customer_id = '" . $USER ."' AND img_link2='".$data["img_link2"]."' OR customer_id = '" . $USER ."' AND img_link3='".$data["img_link2"]."' LIMIT 1";
    $resultx = mysqli_query($dw3_conn, $sqlx);
    $datax = mysqli_fetch_assoc($resultx); */
    //if (file_exists($target_file2) && $datax["rowCount"]=="0") { 
    if (file_exists($target_file2)) { 
        $delete_status=unlink($target_file2);    
    }

    //img3 exist or used somewhere else before delete?
    $target_file3 = $target_dir.$data["img_link3"];
/*     $sqlx = "SELECT count(*) as rowCount FROM classified WHERE customer_id = '" . $USER ."' AND img_link='".$data["img_link3"]."' OR customer_id = '" . $USER ."' AND img_link2='".$data["img_link3"]."' OR customer_id = '" . $USER ."' AND img_link3='".$data["img_link3"]."' LIMIT 1";
    $resultx = mysqli_query($dw3_conn, $sqlx);
    $datax = mysqli_fetch_assoc($resultx); */
    //if (file_exists($target_file3) && $datax["rowCount"]=="0") { 
    if (file_exists($target_file3)) { 
        $delete_status=unlink($target_file3);    
    }

//delete record
$sql = "DELETE FROM classified WHERE id = '" . $adID ."' LIMIT 1";
if ($dw3_conn->query($sql) === TRUE) {
    //echo $sql;
} else {
    $dw3_conn->close();
    die("Erreur: " . $dw3_conn->error);
}
$dw3_conn->close();
die("");
?>
