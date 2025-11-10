<?php 
//header("SECTION_ID:".$_SERVER['HTTP_SECTION_ID'])??'';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/loader.min.php';

$retID  = $_GET['C']??"";

$html = "";
	$sql = "SELECT * FROM customer WHERE id = '" . $retID . "' LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
            
			$html .= "<div class='dw3_form_head' id='dw3_editor_HEAD' style='min-width:300px;'>
                        <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'>";
                    if($USER_LANG == "FR"){ $html .= "Informations sur le détaillant"; }else{$html .= "Retailer informations"; } $html .="</div></h3>
                        <button class='dw3_form_close' onclick='dw3_editor_close();'><span class='material-icons'>cancel</span></button>
                    </div>
                    <div class='dw3_form_data' style='background:#f0f0f0;color:#333;min-width:300px;'>";
            
                //INFORMNATIONS GÉNÉRALES
                    $html .="<div class='dw3_box' style='line-height:1.3em;background:rgba(255,255,255,0.7);color:#222;min-height:25px;width:90%;max-width:95%;font-weight:normal;'><b>" . dw3_decrypt($row["last_name"]) . "</b><br>".dw3_decrypt($row["adr1"]). "<br>".dw3_decrypt($row["adr2"]). "<br>".$row["city"]." ".$row["province"]. "<br>".$row["postal_code"]." ".$row["country"]. "</div>	";
                    $html .="<div class='dw3_box' style='line-height:1.3em;background:rgba(255,255,255,0.7);color:gold;min-height:25px;width:90%;max-width:95%;font-weight:normal;text-align:center;'><span class='material-icons'>star</span><span class='material-icons'>star</span><span class='material-icons'>star</span><span class='material-icons'>star</span><span class='material-icons'>star</span></div>	";
                //carte
                $html .="<div id='googleMap' style='height:300px;width:100%;'><div>";
            //actions
            $html .= "</div>";				
				$html .= "<div class='dw3_form_foot' style='min-width:300px;vertical-align:middle!important;text-align:center;'>";
                if($USER_LANG == "FR"){
                    $html .= "<button onclick=\"getRET_ADS('" . $row["id"]  . "');\" style='min-height:45px;margin-left:0px;border-bottom-right-radius:10px;padding:2px 7px;'><span style='width:92px;'>Voir les produits du détaillant</span> <span class='material-icons' style='font-size:24px;vertical-align:middle;'>store</span></button>";
                } else {
                    $html .= "<button onclick=\"getRET_ADS('" . $row["id"]  . "');\" style='min-height:45px;margin-left:0px;border-bottom-right-radius:10px;padding:2px 7px;'><span style='width:92px;'>See retailer products</span> <span class='material-icons' style='font-size:24px;vertical-align:middle;'>store</span></button>";
                } 
            $html .= "</div>";
		}
	}else{
        //$html .= $sql;
        $html .= "Error on retailer #".$retID;
    }
$dw3_conn->close();
header('Status: 200');
die($html);
?>