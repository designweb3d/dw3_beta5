<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$enID  = $_GET['enID'];
$text_width  = $_GET['tw'];
$html = "<div id='divEDIT_HEADER' class='dw3_form_head'>";

//data from head
$sql = "SELECT A.*, IFNULL(B.name,A.user_created) as user_cr_name, 
IFNULL(C.name,A.user_modified) as user_md_name, IFNULL(D.name,'') as user_eml_name,
IFNULL(E.date_renew,'') as date_renew
        FROM invoice_head A
        LEFT JOIN (SELECT id,name FROM user) B ON B.id = A.user_created 
        LEFT JOIN (SELECT id,name FROM user) C ON C.id = A.user_modified 
        LEFT JOIN (SELECT id,name FROM user) D ON D.id = A.user_email 
        LEFT JOIN (SELECT id,date_renew FROM order_head) E ON E.id = A.order_id 
        WHERE A.id = " . $enID . " ORDER BY A.date_modified ASC LIMIT 1";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {	
    while($row = $result->fetch_assoc()) {
        $html .= "<span id='spanSTAT' style='font-size:0.8em;position:absolute;top:5px;left:15px;background:#" .$CIE_COLOR2 . ";border-radius:6px;padding:3px;'>";
                        if 	($row["stat"] =="0"){ $html .= " <b style='color:#DFC000;'>(NON-FACTURÉ)</b>"; }
                        if 	($row["stat"] =="1"){ $html .= " <b style='color:darkblue;'>(FACTURÉ)</b>"; }
                        if 	($row["stat"] =="2"){ $html .= " <b style='color:green;'>(PAYÉ)</b>"; }
                        if 	($row["stat"] =="3"){ $html .= " <b style='color:#E38600;'>(ANNULÉ)</b>"; }
        $html .= " </span>        
                        <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'>" .$dw3_lbl["INVOICE"] . " #" . $row["id"]."</div></h3>
                        <button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
                    </div>
                <div class='dw3_form_data' id='divFCT'>
                <div class='divBOX'>#ID du Projet:
                    <input id='enPRJ' type='number' value='" . $row["project_id"] . "'>";
                    if ($APREAD_ONLY == false) { $html .="<span style='width:100%;text-align:center'><button onclick='updPRJ_ID(".$row["id"].")'><span class='material-icons'>save</span> Enregistrer le # de projet</button></span>";}
                $html .="</div>
                "; 
        if ($row["subscription_stat"] == "active"){
            $html .= "<div class='divBOX' style='background-color:rgba(0,255,0,0.1);padding:5px;border-radius:8px;'>
                        <span style='width:100%;text-align:center'><span class='material-icons' style='vertical-align:middle;color:green;'>autorenew</span> Abonnement actif</span>
                        <br>Prochaine facture le: " . substr($row["date_renew"],0,10) . "
                        <span style='width:100%;text-align:center'><button class='red' onclick=\"stripe_cancel_subscription('" . $row["order_id"] . "','" . $row["id"] . "')\"><span class='material-icons'>block</span> Annuler l'abonnement</button></span>
                    </div>";
        } else if ($row["subscription_stat"] == "canceled"){
            $html .= "<div class='divBOX' style='background-color:rgba(255,0,0,0.1);padding:5px;border-radius:8px;'><span class='material-icons' style='vertical-align:middle;color:red;'>block</span> Abonnement annulé (" . substr($row["cancel_reason"],0,10) . ")</div>";
        } else if ($row["subscription_stat"] == "expired"){
            $html .= "<div class='divBOX' style='background-color:rgba(255,0,0,0.1);padding:5px;border-radius:8px;'>
                        <span style='width:100%;text-align:center'><span class='material-icons' style='vertical-align:middle;color:red;'>cancel</span> Abonnement expiré</span>
                        <br>Expiration: " . substr($row["date_renew"],0,10) . "
                        <br><span style='width:100%;text-align:center'><button class='red' onclick=\"stripe_cancel_subscription('" . $row["order_id"] . "','" . $row["id"] . "')\"><span class='material-icons'>block</span> Annuler l'abonnement</button></span>
                        </div>";
        } else if ($row["subscription_stat"] == "unpaid"){
            $html .= "<div class='divBOX' style='background-color:rgba(255,0,0,0.1);padding:5px;border-radius:8px;'>
                        <span style='width:100%;text-align:center'><span class='material-icons' style='vertical-align:middle;color:red;'>error</span> Abonnement impayé</span>
                        <br>Prochaine facture le: " . substr($row["date_renew"],0,10) . "
                        <br><span style='width:100%;text-align:center'><button class='red' onclick=\"stripe_cancel_subscription('" . $row["order_id"] . "','" . $row["id"] . "')\"><span class='material-icons'>block</span> Annuler l'abonnement</button></span>
                    </div>";
        }
        
        $html .= "<h4 onclick=\"toggleSub('divSub1','up1');\" style=\"text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(0, 199, 30, .6);background: rgba(200, 200, 200, 0.7);\">
                <span class=\"material-icons\">sticky_note_2</span> Entete de facture <sup>(Sous-total: " . number_format($row["stotal"],2,',','.') . "$" . ")</sup><span id='up1' class=\"material-icons\" style='float:right;margin-right:5px;'>keyboard_arrow_up</span>
                </h4>
            <div class='divMAIN' id='divSub1' style='height:0px;display:none;margin-bottom:0px;'>
                <div class='divBOX'>No de commande:
                    <input id='cmdID' disabled type='number' value='" . $row["order_id"] . "'>
                </div>				
                <div class='divBOX'>No de facture:
                    <input id='enID' disabled type='number' value='" . $row["id"] . "'>
                </div>			
                <div class='divBOX'>" .$dw3_lbl["FULLNAME"] . ":
                    <input id='enNOM' type='text' value='" . str_replace("'", "\'", htmlspecialchars(dw3_decrypt($row["name"]), ENT_QUOTES)) . "' onclick='detectCLICK(event,this);'>
                </div>				
                <div class='divBOX'>Compagnie:
                    <input id='enCIE' type='text' value='" . htmlspecialchars($row["company"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                </div>				
                <div class='divBOX'>" .$dw3_lbl["ADR1"] . ":
                    <input id='enADR1' type='text' value='" . htmlspecialchars(dw3_decrypt($row["adr1"]), ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                </div>				
                <div class='divBOX'>" .$dw3_lbl["ADR2"] . ":
                    <input id='enADR2' type='text' value='" . htmlspecialchars(dw3_decrypt($row["adr2"]), ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                </div>				
                <div class='divBOX'>" .$dw3_lbl["VILLE"] . ":
                    <input id='enVILLE' type='text' value='" . htmlspecialchars($row["city"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                </div>				
                <div class='divBOX'>" .$dw3_lbl["PROV"] . ":
                    <input id='enPROV' type='text' value='" . htmlspecialchars($row["prov"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                </div>				
                <div class='divBOX'>" .$dw3_lbl["PAYS"] . ":
                    <input id='enPAYS' type='text' value='" . htmlspecialchars($row["country"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                </div>				
                <div class='divBOX'>" .$dw3_lbl["CP"] . ":
                    <input id='enCP' type='text' value='" . htmlspecialchars($row["postal_code"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                </div>
                <div class='divBOX' style='width:auto;max-width:100%;'>" .$dw3_lbl["NOTE"] . ":<br>
                    <textarea style='height:100px;width:" . $text_width . "px;' id='enNOTE'>" . $row["note"] . "</textarea>
                </div>
            <br>				
                <div class='divBOX'>" .$dw3_lbl["DTDU"] . ":
                    <input id='enDTDU' type='datetime-local' value='" . $row["date_due"] . "'>
                </div><br>	
                <div class='divBOX'>Notification de facture par courriel:
                    <input id='enDTEML' type='datetime-local' value='" . $row["date_email"] . "'  disabled>
                    <input id='enUSEML' type='text' value='" . $row["user_eml_name"] . "' disabled>
                    <input type='text' value='" . dw3_decrypt($row['eml']) . "' id='txtEML'>
                </div>
            <br>
                <div class='divBOX'>" .$dw3_lbl["DTAD"] . ":
                    <input id='enDTAD' type='datetime-local' value='" . $row["date_created"] . "' disabled>
                    <input id='enUSAD' type='text' value='" . $row["user_cr_name"] . "' disabled>
                </div>			
                <div class='divBOX'>" .$dw3_lbl["DTMD"] . ":
                    <input id='enDTMD' type='datetime-local' value='" . $row["date_modified"] . "' disabled>
                    <input id='enUSMD' type='text' value='" . $row["user_md_name"] . "' disabled>
                </div>
                <br>";
                if ($APREAD_ONLY == false) { 
                    $html .=" <button ";if ($row["stat"] !="0" && $row["stat"] !="1"){$html .="disabled";} else {$html.=" onclick='deleteFCT(\"" . $row["id"] . "\");'";}  $html.=" class='red'><span class='material-icons'>delete</span> Annuler la facture</button>";
                    $html .=" <button ";if ($row["stat"] !="0" && $row["stat"] !="1"){$html .="disabled";} else {$html.=" onclick='updFCT(\"" . $row["id"] . "\");'";}  $html.=" class='green'><span class='material-icons'>save</span> " .$dw3_lbl["SAVE"] . "</button>";
                }
        $html .="</div>";
    }
}
$html .= "<div id='divFCT_LINE'></div><div id='divTRANSACTION'></div></div>";
$html .= "<div id='divTOTAL'  class='dw3_form_foot' style='height:auto;'></div>";
$dw3_conn->close();
die($html);
?>
