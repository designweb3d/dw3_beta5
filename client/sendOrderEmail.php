<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php');
$enID  = $_GET['ID'];
$head_stotal = 0;

//data from head
$sql = "SELECT * FROM order_head WHERE id = '" . $enID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);

if ($data["ship_type"] == "" || $data["ship_type"] == "PICKUP"){
    $sql2 = "SELECT * FROM location WHERE id = '" .  $data["location_id"] . "'";
    $result2 = mysqli_query($dw3_conn, $sql2);
    $data2 = mysqli_fetch_assoc($result2);
    $province_tx = $data2["province"];
} else {
    if ($data["province_sh"] == ""){
        $province_tx = $data["province"];
    } else if ($data["prov"] != ""){
        $province_tx = $data["prov"];
    } else {
        $province_tx = $CIE_PROV;
    }
}

switch ($province_tx) {
    case "AB":case "Alberta":
        $PTPS = $TPS_AB;$PTVP = $TVP_AB;$PTVH = $TVH_AB;break;
    case "BC":case "British Columbia":
        $PTPS = $TPS_BC;$PTVP = $TVP_BC;$PTVH = $TVH_BC;break;
    case "QC":case "Quebec":case "Québec":
        $PTPS = $TPS_QC;$PTVP = $TVP_QC;$PTVH = $TVH_QC;break;
    case "MB":case "Manitoba":
        $PTPS = $TPS_MB;$PTVP = $TVP_MB;$PTVH = $TVH_MB;break;
    case "NB":case "New Brunswick":
        $PTPS = $TPS_NB;$PTVP = $TVP_NB;$PTVH = $TVH_NB;break;
    case "NT":
        $PTPS = $TPS_NT;$PTVP = $TVP_NT;$PTVH = $TVH_NT;break;
    case "NL":
        $PTPS = $TPS_NL;$PTVP = $TVP_NL;$PTVH = $TVH_NL;break;
    case "NS":case "Nova Scotia":
        $PTPS = $TPS_NS;$PTVP = $TVP_NS;$PTVH = $TVH_NS;break;
    case "NU":
        $PTPS = $TPS_NU;$PTVP = $TVP_NU;$PTVH = $TVH_NU;break;
    case "ON":case "Ontario":
        $PTPS = $TPS_ON;$PTVP = $TVP_ON;$PTVH = $TVH_ON;break;
    case "PE":
        $PTPS = $TPS_PE;$PTVP = $TVP_PE;$PTVH = $TVH_PE;break;
    case "SK":case "Saskatshewan":
        $PTPS = $TPS_SK;$PTVP = $TVP_SK;$PTVH = $TVH_SK;break;
    case "YT":case "Yukon":
        $PTPS = $TPS_YT;$PTVP = $TVP_YT;$PTVH = $TVH_YT;break;
}

if ($data['company'] != ""){
    $head_bill_to = $data['company'];
} else {
    $head_bill_to = dw3_decrypt($data['name']);
}


//$subject = iconv('UTF-8','ASCII//TRANSLIT',$CIE_NOM ." - Facture #". $enID . " " . $datetime); //je sais pas pk mais si je met un accent dans le sujet ca passe pas..
$subject = 'Commande #'. $enID . ' ' . $CIE_NOM;
$mainMessage = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head><body>
        <h3>Bonjour ' .$head_bill_to . ',</h3>
        Votre commande a bien été reçu! Les détails se retrouvent aussi dans votre espace client sur <a href="https://' . $_SERVER["SERVER_NAME"] . '/client" target="_blank">https://' . $_SERVER["SERVER_NAME"] . '/client</a>
        <br>'; 
        $sql = "SELECT A.*, B.name_fr, B.url_img, B.upc, B.tax_fed, B.tax_prov FROM order_line A 
        LEFT JOIN product B ON A.product_id = B.id WHERE A.head_id = " . $enID . " ORDER BY A.line";
        $result = $dw3_conn->query($sql);
        $numrows = $result->num_rows;
        if ($numrows > 0) {	
            $mainMessage.= "<table cellspacing=0 style='margin-top:20px;width:100%;border-collapse: collapse;border-left: none;border-right: none;'>
                            <tr style='background:#555;color:#EEE;text-align:left;'>
                                <th style='text-align:left;'></th><th style='text-align:left;'>Description</th><th style='text-align:center;'>Quantité</th>";
                                if ($CIE_HIDE_PRICE != true){
                                    $mainMessage.= "<th style='text-align:right;'>Prix unitaire</th><th style='text-align:right;'>Avant taxes</th></tr>";
                                }
            while($row = $result->fetch_assoc()) {
                $filename= $row["url_img"];
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["product_id"] . "/" . $filename)){
                    $filename = "/img/nd.png";
                } else {
                    if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["product_id"] . "/" . $filename)){
                        $filename = "/img/nd.png";
                    }else{
                        $filename = "/fs/product/" . $row["product_id"] . "/" . $filename;
                    }
                }
                $PRIX_LGN = round($row["qty_order"] * $row["price"],2);
                $mainMessage.= "<tr>";
                $mainMessage.= "<td style='border-bottom:1px solid gold;'><img src='https://" . $_SERVER["SERVER_NAME"] .  $filename . "' style='height:40px;width:auto;max-width:60px;'></td>";
                $mainMessage.= "<td style='border-bottom:1px solid gold;'>" . $row["product_desc"].$row["product_opt"] . "</td>";
                $mainMessage.= "<td style='border-bottom:1px solid gold;text-align:center;'>" . number_format($row["qty_order"],2,'.',',') . "</td>";
                if ($CIE_HIDE_PRICE != true){
                    $mainMessage.= "<td style='border-bottom:1px solid gold;text-align:right;'>" . number_format($row["price"],2,'.',',') . "$</td>";
                    $mainMessage.= "<td style='border-bottom:1px solid gold;text-align:right;'>" . number_format($PRIX_LGN,2,'.',',') . "$</td>";
                }
                $mainMessage.= "</tr>";
            }
        } else {
            $dw3_conn->close();
            die("Erreur la facture ne contient aucuns items.");
        }

        $mainMessage .= '</table><br>Pour obtenir plus de renseignements, veuillez communiquer avec nous. 
        <table style="border: 0px dashed #FB4314;font-size:17px;font-size:13px;"><tr> 
            <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/pub/img/'.$CIE_LOGO2.'" height="100"></td>
            <td style="vertical-align:top;padding-top:10px;"><b style="font-size:15px;">' . $CIE_NOM . '</b>
            <br>' . $CIE_TEL1 . ' 
            ' . $CIE_TEL2 . '
            <br>' . $CIE_EML1 . '</td></tr>
        </table><br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a>
        </body></html>';


 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
 $email = new PHPMailer();
 $email->CharSet = "UTF-8";
 $email->SetFrom($CIE_EML1,$CIE_NOM);
 $email->Subject = $subject;
 $email->Body = $mainMessage;
 $email->IsHTML(true);
 $email->AddAddress(dw3_decrypt($data['eml']));
 $mail_ret = $email->Send();

if ($mail_ret == 1) {
        echo "";
} else {
    echo $mail_ret;
}

$dw3_conn->close();
?>