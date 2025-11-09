<?php
$ID  = $_GET['ID']??'';
if (trim($ID) == "") {die("");}
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$html = "";
	$sql = "SELECT * FROM product WHERE id = '" . $ID . "' LIMIT 1";
	$result = mysqli_query($dw3_conn, $sql);
    $numrows = $result->num_rows;
    if ($numrows=1) {	
	    $data = mysqli_fetch_assoc($result);
        $filename= $data["url_img"];
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/product/" . $data["id"] . "/" . $filename)){
            $filename = "/img/nd.png";
        } else {
            if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/product/" . $data["id"] . "/" . $filename)){
                $filename = "/img/nd.png";
            }else{
                $filename = "/product/" . $data["id"] . "/" . $filename;
            }
        }
        if ($data['id'] !=""){
            $html = '["'. $data['id'] .'","' . $data['name_fr'] .'","' .$filename . '","' . $data['qty_box'] .'","' . $data['kg'] .'","' . $data['height'] .'","' . $data['width'] .'","' . $data['depth'] .'"]';
        }
    }
echo $html ;
$dw3_conn->close();
?>