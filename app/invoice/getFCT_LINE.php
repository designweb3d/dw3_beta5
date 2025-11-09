<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$enID  = $_GET['enID'];

//data from head
$sql = "SELECT * FROM invoice_head WHERE id = '" . $enID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$head_stat = $data["stat"];
$lines_source = $data["line_source"];


if ($lines_source == "product" || $lines_source == ""){
    $html = "";
    $sql = "SELECT A.*, B.url_img FROM invoice_line A 
    LEFT JOIN product B ON A.product_id = B.id 
    WHERE A.head_id = " . $enID . "
    ORDER BY A.line ASC";
    $result = $dw3_conn->query($sql);
    $numrows = $result->num_rows;
        $html .= "<h4 onclick=\"toggleSub('divSub2','up2');\" style=\"text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(250, 199, 0, .6);background: rgba(200, 200, 200, 0.7);\">
        <span class=\"material-icons\">inventory_2</span> Produits facturés <sup>(" . $numrows . ")</sup><span id='up2' class=\"material-icons\" style='float:right;margin-right:5px;'>keyboard_arrow_down</span>
        </h4>";
    if ($numrows > 0) {
        $html .= "<div class='divMAIN' id='divSub2' style='width:100%;overflow-y:auto;margin:0px;padding:0px;'>
            <table id='dataTABLE' class='tblDATA'><tr><th>#</th><th>Image</th><th>Description</th><th style='text-align:center;'>Qt.</th><th style='text-align:right;'>$ ch.</th><th style='text-align:right;'>Tx</th><th style='text-align:right;'>Total</th></tr>";
        while($row = $result->fetch_assoc()) {
            $filename= $row["url_img"];
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["product_id"] . "/" . $filename)){
                $filename = "/pub/img/dw3/nd.png";
            } else {
                if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["product_id"] . "/" . $filename)){
                    $filename = "/pub/img/dw3/nd.png";
                }else{
                    $filename = "/fs/product/" . $row["product_id"] . "/" . $filename;
                }
            }

                $html .= "<tr>";
                $html .= "<td style='text-align:center;'>" . $row["line"] . "</td>";
                $html .= "<td><img src='" . $filename . "' style='height:40px;width:auto;max-width:60px;'></td>";
                $html .= "<td width='*'>(". $row["product_id"]. ") " . $row["product_desc"] . $row["product_opt"] . "</td>";
                $html .= "<td style='text-align:center;'>" . number_format($row["qty_order"]) . "</td>";
                $html .= "<td style='text-align:right;'>" . number_format($row["price"],2) . "</td>";
                $html .= "<td style='text-align:right;'>" . number_format($row["tps"]+$row["tvp"]+$row["tvh"],2) . "</td>";
                                $PRIX_LGN = ($row["qty_order"] * $row["price"])+$row["tps"]+$row["tvp"]+$row["tvh"];
                $html .= "<td style='text-align:right;'>" . number_format($PRIX_LGN,2,'.',',') . "$</td>";
                $html .= "</tr>";

        }
    }
} else if ($lines_source == "classified"){
    $html = "";
    $sql = "SELECT A.*, IFNULL(B.active,'deleted') as ad_status, IFNULL(B.img_link,'') as img_link, IFNULL(B.customer_id,'') as retailer_id FROM invoice_line A 
    LEFT JOIN classified B ON A.classified_id = B.id  
    WHERE A.head_id = " . $enID . "
    ORDER BY A.line ASC";
    $result = $dw3_conn->query($sql);
    $numrows = $result->num_rows;
        $html .= "<h4 onclick=\"toggleSub('divSub2','up2');\" style=\"text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(250, 199, 0, .6);background: rgba(200, 200, 200, 0.7);\">
        <span class=\"material-icons\">inventory_2</span> Annonce facturée<span id='up2' class=\"material-icons\" style='float:right;margin-right:5px;'>keyboard_arrow_down</span>
        </h4>";
    if ($numrows > 0) {
        $html .= "<div class='divMAIN' id='divSub2' style='width:100%;overflow-y:auto;margin:0px;padding:0px;'>
            <table id='dataTABLE' class='tblDATA'><tr><th>Status</th><th>Image</th><th>Description</th><th style='text-align:right;'>Total</th></tr>";
        while($row = $result->fetch_assoc()) {
            $filename= $row["img_link"];
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $row["retailer_id"] . "/" . $filename)){
                $filename = "/pub/img/dw3/nd.png";
            } else {
                if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $row["retailer_id"] . "/" . $filename)){
                    $filename = "/pub/img/dw3/nd.png";
                }else{
                    $filename = "/fs/customer/" . $row["retailer_id"] . "/" . $filename;
                }
            }

                $html .= "<tr>";
                if ($row["ad_status"] == "deleted"){
                    $html .= "<td style='color:red;'>Effacée</td>";
                } else if ($row["ad_status"] == "0"){
                    $html .= "<td style='color:gold;'>Inactive</td>";
                } else if ($row["ad_status"] == "1"){
                    $html .= "<td style='color:green;'>Active</td>";
                }
                $html .= "<td><img src='" . $filename . "' style='height:40px;width:auto;max-width:60px;'></td>";
                $html .= "<td width='*'>(". $row["classified_id"]. ") " . $row["product_desc"] . "</td>";
                $html .= "<td style='text-align:right;'>" . number_format($row["price"],2,'.',',') . "$</td>";
                $html .= "</tr>";

        }
    }
}
$html .= "</table></div>
";
$dw3_conn->close();
die($html);
?>