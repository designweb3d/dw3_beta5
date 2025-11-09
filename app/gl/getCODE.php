<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$CODE = $_GET['CODE'];
$html = "";	
$sql = "SELECT * FROM gl 
        WHERE code = '" . $CODE . "' ";
        //die($sql);
$result = $dw3_conn->query($sql);
$numrows = $result->num_rows;
$html .= "    <div id='edtGL_HEADER' class='dw3_form_head'>
                <br><h2>Modification du poste de GL# " . $row["code"] . "</h2>
                <button class='dw3_form_close' onclick='closeEDT_GL();'><span class='material-icons'>close</span></button>
             </div>";
if ($numrows > 0) {		
    while($row = $result->fetch_assoc()) {
        $html .= "<div class='dw3_form_data'>
                    <div class='divBOX'>Poste/Code GL:
                        <input id='glCODE' type='text' value='" . $row["code"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX'>Catégorie:
                        <input id='glKIND' type='text' value='" . $row["kind"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX'>Nom du poste FR:
                        <input id='glNAME_FR' type='text' value='" . $row["name_fr"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX'>Nom du poste EN:
                        <input id='glNAME_EN' type='text' value='" . $row["name_en"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX'>Description du poste FR:
                        <input id='glDESC_FR' type='text' value='" . $row["desc_fr"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                    <div class='divBOX'>Description du poste EN:
                        <input id='glDESC_EN' type='text' value='" . $row["desc_en"] . "' onclick='detectCLICK(event,this);'>
                    </div>
                </div>
                <div class='dw3_form_foot'>
                    <button class='red' onclick='deleteGL(" . $row["code"] . ");'><span class='material-icons'>delete</span></button>
                    <button class='grey' onclick='closeEDT_GL();'><span class='material-icons'>cancel</span>" . $dw3_lbl['CANCEL'] . "</button>
                    <button class='green' onclick='updGL(" . $row["code"] . ");'><span class='material-icons'>save</span>" . $dw3_lbl['SAVE'] . "</button>
                </div>";
    }
}else {
    $html .= "Erreur de code";
}
echo $html;
$dw3_conn->close();
?>
    
