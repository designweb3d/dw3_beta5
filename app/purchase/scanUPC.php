<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$UPC  = mysqli_real_escape_string($dw3_conn,$_GET['UPC']);
$QTE  = $_GET['QTE'];
$html = "";
	$sql = "SELECT COUNT(upc) as rowCount FROM product WHERE upc = '" . $UPC . "' AND upc <> ''";
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['rowCount'] == "0" || $UPC == "0") {
        $sql = "SELECT *
        FROM product 
        WHERE CONCAT(id, upc, sku, name_fr, description_fr) LIKE '%" . $UPC . "%'
        LIMIT 100";

        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {	
            $html .= "<table class='tblSEL'>";
            while($row = $result->fetch_assoc()) {
                $filename= $row["url_img"];
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                    $filename = "/pub/img/nd.png";
                } else {
                    if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                        $filename = "/pub/img/nd.png";
                    }else{
                        $filename = "/fs/product/" . $row["id"] . "/" . $filename;
                    }
                }
                $html .= "<tr style='cursor:pointer;' onclick=\"document.getElementById('newPRD').value='';addNEW_by_ID(" . $row['id'] . ");\"><td><img src='" . $filename . "' style='height:30px;width:auto;max-width:40px;'></td><td>" . $row['upc'] . "</td><td style='text-align:left;'>" . $row['name_fr'] ."</td><td class='short' style='text-align:left;max-width:200px;'>" . substr($row['description_fr'],0,30) ."</td></tr>";
            }
            $html .= "</table>";
        } else {
            $html .= "Aucun résultat trouvé";
        }
    }
echo $html;
$dw3_conn->close();
?>
