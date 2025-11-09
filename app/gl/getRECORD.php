<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$rID  = $_GET['ID'];
$html = "";
	$sql = "SELECT * FROM gls WHERE id = " . $rID . " LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
			$html .= "<div id='divEDIT_HEADER' class='dw3_form_head'>
                        <h3><span>Modification de l'écriture #".trim($row["id"])."</span></h3>
                        <button class='dw3_form_close' onclick='closeEDITOR(this);'><span class='material-icons'>close</span></button>
                    </div>
                    <div class='dw3_form_data'>
                    <div class='divBOX'><b>Débit/Crédit</b>:
                    <select id='rKIND'>";
                    $html .= "<option";  if ($row["kind"] == "DEBIT"){ $html .= " selected";} $html .= " value='DEBIT'>Débit</option>";
                    $html .= "<option";  if ($row["kind"] == "CREDIT"){ $html .= " selected";} $html .= " value='CREDIT'>Crédit</option>";
                $html .= "</select></div>";
                $html .= "<div class='divBOX'>" . $dw3_lbl["GL_CODE"] . ":
                            <select id='rGL_CODE'>";
                            $sql2 = "SELECT * FROM gl ORDER BY code";
                            $result2 = $dw3_conn->query($sql2);
                            if ($result2->num_rows > 0) {	
                                while($row2 = $result2->fetch_assoc()) {
                                    $html .= "<option "; if($row2["code"]==$row["gl_code"]){$html .= " selected";}  $html .= " value='" . $row2["code"]  . "'>" . $row2["code"]. " " . $row2["name_fr"]. "</option>";
                                }
                            }
                        $html .= "</select></div>";
                        $html .= "<div class='divBOX'>" . $dw3_lbl["YEAR"] . ":
                        <select id='rYEAR'>
                        <option";  if ($row["year"] == "2020"){ $html .= " selected";} $html .= " value='2020'>2020</option>
                        <option";  if ($row["year"] == "2021"){ $html .= " selected";} $html .= " value='2021'>2021</option>
                        <option";  if ($row["year"] == "2022"){ $html .= " selected";} $html .= " value='2022'>2022</option>
                        <option";  if ($row["year"] == "2023"){ $html .= " selected";} $html .= " value='2023'>2023</option>
                        <option";  if ($row["year"] == "2024"){ $html .= " selected";} $html .= " value='2024'>2024</option>
                        <option";  if ($row["year"] == "2025"){ $html .= " selected";} $html .= " value='2025'>2025</option>
                        <option";  if ($row["year"] == "2026"){ $html .= " selected";} $html .= " value='2026'>2026</option>
                        <option";  if ($row["year"] == "2027"){ $html .= " selected";} $html .= " value='2027'>2027</option>
                        <option";  if ($row["year"] == "2028"){ $html .= " selected";} $html .= " value='2028'>2028</option>
                        <option";  if ($row["year"] == "2029"){ $html .= " selected";} $html .= " value='2029'>2029</option>
                        <option";  if ($row["year"] == "2030"){ $html .= " selected";} $html .= " value='2030'>2030</option>";
                        $html .= "</select></div>";
                        $html .= "<div class='divBOX'>" . $dw3_lbl["PERIOD"] . ":
                        <select id='rPERIOD'>
                        <option";  if ($row["period"] == "1"){ $html .= " selected";} $html .= " value='1'>1 - Janvier</option>
                        <option";  if ($row["period"] == "2"){ $html .= " selected";} $html .= " value='2'>2 - Février</option>
                        <option";  if ($row["period"] == "3"){ $html .= " selected";} $html .= " value='3'>3 - Mars</option>
                        <option";  if ($row["period"] == "4"){ $html .= " selected";} $html .= " value='4'>4 - Avril</option>
                        <option";  if ($row["period"] == "5"){ $html .= " selected";} $html .= " value='5'>5 - Mai</option>
                        <option";  if ($row["period"] == "6"){ $html .= " selected";} $html .= " value='6'>6 - Juin</option>
                        <option";  if ($row["period"] == "7"){ $html .= " selected";} $html .= " value='7'>7 - Juillet</option>
                        <option";  if ($row["period"] == "8"){ $html .= " selected";} $html .= " value='8'>8 - Aout</option>
                        <option";  if ($row["period"] == "9"){ $html .= " selected";} $html .= " value='9'>9 - Septembre</option>
                        <option";  if ($row["period"] == "10"){ $html .= " selected";} $html .= " value='10'>10 - Octobre</option>
                        <option";  if ($row["period"] == "11"){ $html .= " selected";} $html .= " value='11'>11 - Novembre</option>
                        <option";  if ($row["period"] == "12"){ $html .= " selected";} $html .= " value='12'>12 - Décembre</option>";
                        $html .= "</select></div>
                        <div class='divBOX'>" . $dw3_lbl['AMOUNT']. ":
                        <input id='rAMOUNT' type='text' class='money' value='" . $row["amount"] ."' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX'>" . $dw3_lbl['SOURCE'].":
                        <input id='rSOURCE' type='text' value='" . $row["source"] . "' onclick='detectCLICK(event,this);'>";
                if ($row['source']=="INVOICE"){
                    $html .= "<a href='/app/invoice/invoice.php?KEY=".$KEY."&of=getFCT&op=".$row['source_id']."' target='_record'><button style='float:right;'>" .$row['source'] . " #" .$row['source_id'] . "</button></a>";
                } 
                    $html.="</div>
                    <div class='divBOX'>" . $dw3_lbl['CUSTOMER_ID'].":
                        <input id='rCUSTOMER_ID' type='number' value='" . $row["customer_id"] . "' style='width:280px;' onclick='detectCLICK(event,this);'>";
                        if ($APREAD_ONLY == false) { $html.="<button onclick=\"openSEL_CLI('UPD');\"><span class='material-icons' style='font-size:14px;'>search</span></button>";}
                    $html .= "</div>
                    <div class='divBOX'>" . $dw3_lbl['SUPPLIER_ID'].":
                        <input id='rSUPPLIER_ID' type='number'  value='" . $row["supplier_id"] . "' style='width:280px;' onclick='detectCLICK(event,this);'>";
                        if ($APREAD_ONLY == false) { $html.="<button onclick=\"openSEL_FRN('UPD');\"><span class='material-icons' style='font-size:14px;'>search</span></button>";}
                    $html .= "</div>
                    <div class='divBOX'>" . $dw3_lbl['PRODUCT_ID'].":
                        <input id='rPRODUCT_ID' type='number' value='" . $row["product_id"] . "' style='width:280px;' onclick='detectCLICK(event,this);'>";
                        if ($APREAD_ONLY == false) { $html.="<button onclick=\"openSEL_PRD('UPD');\"><span class='material-icons' style='font-size:14px;'>search</span></button>";}
                    $html .= "</div>
                    <div class='divBOX'>" . $dw3_lbl['USER_ID'].":
                        <input id='rUSER_ID' type='number' value='" . $row["user_id"] . "' style='width:280px;' onclick='detectCLICK(event,this);'>";
                        if ($APREAD_ONLY == false) { $html.="<button onclick=\"openSEL_USR('UPD');\"><span class='material-icons' style='font-size:14px;'>search</span></button>";}
                    $html .= "</div>
                    <div class='divBOX'>" . $dw3_lbl['DOCUMENT'].":
                        <input id='rDOCUMENT' type='text' value='" . $row["document"] . "' onclick='detectCLICK(event,this);'>
                        <button style='float:right;' onclick=\"dw3_secure_download('" . $row["document"] . "')\">" . $row["document"] . "</button>
                    </div>
                </div>
                <div class='dw3_form_foot'>";
                    if ($APREAD_ONLY == false) { $html.="<button class='red' onclick='deleteRECORD(".$row["id"] . ");'><span class='material-icons'>delete</span></button>"; }
                    $html.="<button class='grey' onclick='closeEDITOR();'><span class='material-icons'>cancel</span> Fermer</button>";
                    if ($APREAD_ONLY == false) { $html.="<button class='green' onclick='updRECORD(".$row["id"] . ");'><span class='material-icons'>save</span> Enregistrer</button>";}
                $html.="</div>";
		}
	}
$dw3_conn->close();
header('Status: 200');
die($html);
?>