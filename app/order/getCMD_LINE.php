<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$enID  = $_GET['enID'];
$html = "";
    $sql = "SELECT A.*, B.name_fr, B.url_img, B.upc, B.price_suffix_fr, C.stat as stat, B.billing AS product_billing
    FROM order_line A
    LEFT JOIN product B ON A.product_id = B.id
    LEFT JOIN order_head C ON A.head_id = C.id
    WHERE A.head_id = " . $enID . "
    ORDER BY A.line DESC";
    $counter= 0;
	$result = $dw3_conn->query($sql);
    $numrows = $result->num_rows;
        $html .= "<h4 onclick=\"toggleSub('divSub2','up2');\" style=\"text-align:left;width:100%;padding:0px 5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(250, 199, 0, .6);background: rgba(200, 200, 200, 0.7);\">
        <span class=\"material-icons\">inventory_2</span> Produits en commande <sup>(" . $numrows . ")</sup><span id='up2' class=\"material-icons\" style='float:right;margin-right:5px;'>keyboard_arrow_down</span>
        </h4>";
        $html .= "<div class='divMAIN' id='divSub2' style='height:300px;max-height:300px;width:100%;overflow-y:auto;margin:0px;padding:0px 2px 4px 2px;'>";
	if ($numrows > 0) {
        $html .= "<table id='dataTABLE' style='border-collapse:collapse;table-layout: fixed;'><tr style='height:20px;font-size:14px;'><th style='padding:2px;'></th><th style='padding:2px;'></th><th style='padding:2px;'>QT Commandé</th><th style='padding:2px;'>$ Unité</th><th style='padding:2px;'>$ TOT LGN / Renouv.</th></tr>
            <colgroup>
                <col style='width:40px' />
                <col style='width:64px' />
                <col style='width:auto' />
                <col style='width:auto' />
                <col style='width:auto' />
            </colgroup>";
		while($row = $result->fetch_assoc()) {
            $head_stat = $row["stat"];
            $line_billing = $row["product_billing"];
            if ($line_billing == "ANNUEL" || $line_billing == "MENSUEL" || $line_billing == "HEBDO"){
                $line_renew = '1';
            } else {
                $line_renew = '0';
            }
            if ($counter % 2 == 0) {
                $hl_last_line = " style='background:#8da;'";
            } else {
                $hl_last_line = " style='background:#fff;'";
            }
            $counter ++;
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
            
            $line_price = $row["price"];

            $sql2 = "SELECT * FROM order_option WHERE line_id = '".$row["id"]."';";
            $result2 = $dw3_conn->query($sql2);
            if ($result2->num_rows > 0) {
                while($row2 = $result2->fetch_assoc()) { 
                    $line_price = $line_price + $row2["price"];
                }
            }
            $html .= "<tr" . $hl_last_line ."><td rowspan='2' style=padding:0px;'>";
            if ($APREAD_ONLY == false) { $html .= "<button onclick='delLGN(" . $row["id"] . ");' class='red' style='padding:5px;"; if ($head_stat !=0){$html .= "opacity: 0.4;pointer-events: none;";} $html .= "'> <span class=\"material-icons\" style='font-size:20px'>delete</span></button>"; }
            $html .= "</td>";
            $html .= "<td rowspan='2' style='padding:0px 2px 4px 2px;text-align:center;'><img src='" . $filename . "' style='height:64px;width:auto;max-width:64px;margin:-2px 0px;'></td>";
            if ($APREAD_ONLY == false) { 
                $html .= "<td style='padding:0px 2px 4px 2px;'><input style=\"padding:5px 25px 5px 5px;text-align:right;background: url('/pub/img/dw3/arrow-number.png') 99% / 20px no-repeat transparent;"; if ($head_stat !=0){$html .= "opacity: 0.4;pointer-events: none;";} $html .= "\" type='number' step='.01' lang='en' value='" . number_format($row["qty_order"],2) . "' onchange=\"updLGN_QTY('" . $row["id"] . "',this.value);\" onClick='detectCLICK(event,this);'></td>";
                //$html .= "<td width='10%' style='padding:0px 2px 4px 2px;'><input style=\"padding:5px 25px 5px 5px;text-align:right;background: url('/pub/img/dw3/arrow-number.png') 99% / 20px no-repeat;\" type='number' value='" . number_format($row["qty_shipped"]) . "' onchange=\"updLGN_QTY_SHIPPED('" . $row["id"] . "',this.value);\" onClick='detectCLICK(event,this);'></td>";
                $html .= "<td style='padding:0px 2px 4px 2px;'><input style=\"padding:5px 25px 5px 5px;text-align:right;background: url('/pub/img/dw3/arrow-money.png') 99% / 20px no-repeat transparent;"; if ($head_stat !=0){$html .= "opacity: 0.4;pointer-events: none;";} $html .= "\" type='number' step='.01' lang='en' value='" .round($row["price"],2) . "' onchange=\"updLGN_PRICE('" . $row["id"] . "',this.value);\" onClick='detectCLICK(event,this);'></td>";
            } else {
                $html .= "<td style='padding:0px 2px 4px 2px;text-align:right;'>" . number_format($row["qty_order"],2) . "</td>";
                //$html .= "<td width='10%' style='padding:0px 2px 4px 2px;'>" . number_format($row["qty_shipped"]) . "</td>";
                $html .= "<td style='padding:0px 2px 4px 2px;text-align:right;'>" . round($row["price"],2) . "</td>";
            }  
            $PRIX_LGN = $row["qty_order"] * $line_price;
            $html .= "<td style='font-size:22px;padding:0px 4px 4px 2px;text-align:right;'>" . number_format($PRIX_LGN,2,".",",") . "$</td>";
            if ($APREAD_ONLY == false) { 
                $html .= "</tr><tr" . $hl_last_line ."><td style='padding:0px 2px 4px 2px;'><input style=\"padding:5px;background: transparent;"; if ($head_stat !=0){$html .= "opacity: 0.4;pointer-events: none;";} $html .= "\" type='text' value='" . $row["product_desc"] . "' onchange=\"updLGN_DESC('" . $row["id"] . "',this.value);\"  onClick='detectCLICK(event,this);'></td><td><button class='blue' onclick='getPRD_OPTIONS(".$row["id"].",".$row["product_id"].")'><span class='material-icons'>build_circle</span> Options</button></td>";
            } else {
                $html .= "</tr><tr" . $hl_last_line ."><td style='padding:0px 2px 4px 2px;'>" . $row["product_desc"] . "</td><td></td>";
            }
            if ($line_renew == "0"){
                $html .= "<td width='20' style='padding:0px 2px 4px 2px;'><input type='checkbox' disabled></td>";
            } else {
                if ($APREAD_ONLY == false) { 
                    $html .= "<td width='20' style='padding:0px 2px 4px 2px;'><input type='checkbox' "; if ($row["product_renew"] == "1"){$html .= " checked ";} $html .= " onchange=\"updLGN_RENEW('" . $row["id"] . "',this.checked);\"></td>";
                } else {
                    $html .= "<td width='20' style='padding:0px 2px 4px 2px;'><input type='checkbox' disabled "; if ($row["product_renew"] == "1"){$html .= " checked ";} $html .= "></td>";
                }
            }
            $html .= "</tr>";
		}
    }else{
        $html .= "<table id='dataTABLE' class='tblDATA'>";
        $html .= "<tr><td>Aucune ligne de produit en commande</td></tr>";
    }
$html .= "</table></div>";
$dw3_conn->close();
die($html);
?>