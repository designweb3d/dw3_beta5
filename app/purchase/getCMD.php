<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$enID  = $_GET['enID'];
$html = "";
$text_width  = $_GET['tw'];

$head_stotal = 0;
//data from head
$sql = "SELECT *
FROM purchase_head 
WHERE id = '" . $enID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$head_prepaid = round($data['prepaid_cash'],2);
$head_stat = $data['stat'];
//data from lines
/* $sql = "SELECT IFNULL(SUM(price*(qty_order-qty_shipped)),0) as head_stotal
FROM purchase_line 
WHERE head_id = '" . $enID . "' ";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$head_stotal = $data['head_stotal'];
$head_tvq = round($head_stotal*0.05,2);
$head_tps = round($head_stotal*0.0975,2);
$head_total = round($head_stotal + $head_tps + $head_tvq - $head_prepaid,2); */

	$sql = "SELECT A.*, IFNULL(B.name,A.user_created) as user_cr_name, IFNULL(C.name,A.user_modified) as user_md_name, IFNULL(D.name,'') as user_eml_name
			FROM purchase_head A
            LEFT JOIN (SELECT id,name FROM user) B ON B.id = A.user_created 
            LEFT JOIN (SELECT id,name FROM user) C ON C.id = A.user_modified 
            LEFT JOIN (SELECT id,name FROM user) D ON D.id = A.user_email 
			WHERE A.id = '" . $enID . "'
            ORDER BY A.date_modified ASC
			LIMIT 1";

	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {	

		while($row = $result->fetch_assoc()) {
			$html .= "<div id='divEDIT_HEADER' class='dw3_form_head'>
                            <span style='font-size:0.8em;position:absolute;top:5px;left:15px;background:#" .$CIE_COLOR2 . ";border-radius:6px;padding:3px;'>";
                                if 	($row["stat"] =="0"){ $html .= " <b style='color:yellow;'>(À PAYER)</b>"; }
                                if 	($row["stat"] =="1"){ $html .= " <b style='color:green;'>(PAYÉ)</b>"; }
                                if 	($row["stat"] =="2"){ $html .= " <b style='color:red;'>(" .$dw3_lbl["CANCELED"] . ")</b>"; }
                $html .= " </span>
                            <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'>" .$dw3_lbl["PURCHASE"] . " #" . $row["id"]."</div></h3>
                            <button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
                        </div>
            <div style='position:absolute;top:40px;left:0px;width:100%;bottom:0px;overflow-x:hidden;overflow-y:auto;'>
            <div id='divTOTAL' style='padding:3px;background:rgba(200, 200, 200, 0.7);text-align:right;'></div>";
            $html .= "<h4 onclick=\"toggleSub('divSub1','up1');\" style=\"text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(0, 199, 30, .6);background: rgba(200, 200, 200, 0.7);\">
                    <span class=\"material-icons\">sticky_note_2</span> Entete d'achat (<span id='lbl_total_head'></span>)<span id='up1' class=\"material-icons\" style='float:right;margin-right:5px;'>keyboard_arrow_up</span>
                 </h4>
                <div class='divMAIN' id='divSub1' style='height:0px;display:none;margin-bottom:0px;'>
                    <div class='divBOX'>#Achat fournisseur:
                        <input id='enPID' type='text' value='" . $row["supplier_pid"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX'>#ID du Projet:
                        <input id='enPRJ' type='number' value='" . $row["project_id"] . "' style='floar:right;width:175px;'>
                    </div>
                    <hr>				
                    <div class='divBOX'><br>" .$dw3_lbl["FULLNAME"] . ":
                        <input id='enID' style='display:none;' type='text' value='" . $row["id"] . "'>
                        <input id='enNOM' type='text' value='" . str_replace("'", "\'", htmlspecialchars($row["name"], ENT_QUOTES)) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>" .$dw3_lbl["ADR1"] . ":
                        <input id='enADR1' type='text' value='" . htmlspecialchars($row["adr1"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>" .$dw3_lbl["ADR2"] . ":
                        <input id='enADR2' type='text' value='" . htmlspecialchars($row["adr2"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>" .$dw3_lbl["VILLE"] . ":
                        <input id='enVILLE' type='text' value='" . htmlspecialchars($row["city"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>" .$dw3_lbl["PROV"] . ":
                        <input id='enPROV' type='text' value='" . htmlspecialchars($row["prov"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'><br>" .$dw3_lbl["PAYS"] . ":
                        <input id='enPAYS' type='text' value='" . htmlspecialchars($row["country"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>				
                    <div class='divBOX'>" .$dw3_lbl["CP"] . ":
                        <input id='enCP' type='text' value='" . htmlspecialchars($row["postal_code"], ENT_QUOTES) . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX' style='width:auto;max-width:100%;'>" .$dw3_lbl["NOTE"] . ":<br>
                        <textarea style='height:100px;width:" . $text_width . "px;' id='enNOTE'>" . $row["note"] . "</textarea>
                    </div><br>   ";                 
        if ($APREAD_ONLY == false) { $html .= "<button onclick='updCMD(\"" . $row["id"] . "\");'><span class='material-icons'>save</span> " .$dw3_lbl["SAVE"] . "</button>";}
                $html .= "<br>				
                    <div class='divBOX'>" .$dw3_lbl["DTDU"] . ":
                        <input id='enDTDU' type='datetime-local' value='" . $row["date_due"] . "'>
                        <small><i>La période du Grand Livre sera basée sur cette date.</i></small>
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
                </div>";
		}
	
	}

//GET LGNS
    $html .= "<div id='divCMD_LINE'></div><h4 onclick=\"toggleSub('divSub3','up3');\" style=\"text-align:left;";
    if ($head_stat != "0" || $APREAD_ONLY == true){
        $html .= "display:none;";
    }
    $html .= "width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(0, 199, 250, .6);background: rgba(200, 200, 200, 0.7);\">
                <span class=\"material-icons\">inventory_2</span> Ajouter un item<span id='up3' class=\"material-icons\" style='float:right;margin-right:5px;'>keyboard_arrow_down</span>
                </h4>
                <div class='divMAIN' id='divSub3' style='";

if ($head_stat != "0" || $APREAD_ONLY == true){
    $html .= "display:none;";
}
//AJOUT DE PRODUIT
 
    $html .= "width:100%;overflow-x:scroll;margin:0px;padding:0px;'>
                    <div class='divBOX' style='padding:1px;min-height:0px;max-width:100%;background: rgba(180, 180, 180, 0.7);'>	
                        <table style='width:100%;'><tr>
                            <td style='width:20px;text-align:center;'><button style=\"margin:0px 2px 0px 2px;padding:2px;\" onclick=\"addBlankLine();\"><span class=\"material-icons\">add</span></button></td>
                            <td style='width:20px;text-align:center;'><button style=\"margin:0px 2px 0px 2px;padding:2px;\" onclick=\"scanUPC();\"><span class=\"material-icons\">search</span></button></td>
                            <td width='*'><input id='newPRD' onkeyup='scanUPC();' type='text' value=''></td>
                            <td style='width:20px;text-align:center;'><button style=\"margin:0px 2px 0px 2px;padding:2px;\" onclick=\"subQTY();\"><span class=\"material-icons\">arrow_circle_down</span></button></td>
                            <td style='width:80px;'><input id='newQTE' type='number' value='1'></td>
                            <td style='width:20px;text-align:center;'><button style=\"margin:0px 2px 0px 2px;padding:2px;\" onclick=\"addQTY();\"><span class=\"material-icons\">arrow_circle_up</span></button></td>
                            <td style='width:20px;text-align:center;'><button style=\"margin:0px 2px 0px 2px;padding:2px;\" onclick=\"lockQTY();\"><span class=\"material-icons\">lock_open</span></button></td>
                        </tr></table>
                    </div>
                    <div id='lstPRD' style='width:100%;background:rgba(0, 0, 0, 0.3);'></div>
                </div>
                
                <br>
                
            </div>";

$dw3_conn->close();
die($html);
?>
