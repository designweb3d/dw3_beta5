<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$line_id  = $_GET['ID'];

echo "<div id='divEDIT_HEADER' class='dw3_form_head'>
        <h3>Rendez-vous</h3>
        <button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>close</span></button>
    </div>";

$sql = "SELECT A.*, B.adr1 as loc_adr1, B.adr2 as loc_adr2, B.city as loc_city, B.postal_code as loc_cp, B.name as loc_name, B.type as loc_type,
        C.last_name as cust_name, C.adr1 as cust_adr1, C.adr2 as cust_adr2, C.postal_code as cust_cp, C.city as cust_city,C.eml1 as cust_eml, C.tel1 as cust_tel,
        D.name_fr as prod_name, D.service_length as service_length, D.inter_length as inter_length
        FROM schedule_line A
        LEFT JOIN (SELECT * FROM location) B ON A.location_id = B.id
        LEFT JOIN (SELECT * FROM customer) C ON A.customer_id = C.id
        LEFT JOIN (SELECT * FROM product) D ON A.product_id = D.id
        WHERE A.id = '" . $line_id . "';";
        //error_log($sql);
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {	
        while($row = $result->fetch_assoc()) {
            //confirmé ou pas
            if ($row["confirmed"] == "1"){$confirmed = "<span class='dw3_font'>Ē</span>";}else{$confirmed = "<span class='dw3_font'>ē</span>";}
            //location type
            if ($row["location_type"] == "V"){$loc_type = "Rencontre virtuelle"; } 
            else if ($row["location_type"] == "R"){$loc_type = "Chez le client";}
            else if ($row["location_type"] == "L" || $row["location_type"] == "L0"){$loc_type = "Dans nos locaux";}
            else if ($row["location_type"] == "P"){$loc_type = "Au téléphone";}
            else {$loc_type = "ND";}
            if ($row["confirmed"] == "1"){$confirmed = "Oui";}else{$confirmed = "Non <button onclick=\"sendConfirmationSMS('".$row["id"]."');\"><span class='material-icons' style='font-size:16px;'>sms</span></button>";}
            //form
            echo "<div class='dw3_form_data'>
            <button onclick='window.open(\"https://" . $_SERVER["SERVER_NAME"] . "/app/timesheet/authCAL.php?KEY=".$KEY."&ID=".$row["id"]."\");'><span class='material-icons'>event_available</span> Ajouter à mon agenda</button>
            <table class='tblDATA'>";
            echo "<tr><th>Début</th><td>" . $row["start_date"]. "</td></tr>";
            echo "<tr><th>Fin</th><td>" . $row["end_date"]. "</td></tr>";
            echo "<tr><th>Durée</th><td>" . $row["service_length"]. " minutes</td></tr>";
            echo "<tr><th>Entracte</th><td>" . $row["inter_length"]. " minutes</td></tr>";
            echo "<tr><th>Client</th><td>" . dw3_decrypt($row["cust_name"]) .
                "<br><span class='dw3_font'>M</span> <a href='mailto:".dw3_decrypt($row["cust_eml"])."'>".dw3_decrypt($row["cust_eml"])."</a>
                    <br><span class='dw3_font'>N</span> <a href='mailto:".dw3_decrypt($row["cust_tel"])."'>".dw3_decrypt($row["cust_tel"])."</a>
                </td></tr>";
            echo "<tr><th>Type</th><td>" . $loc_type. "</td></tr>";
            echo "<tr><th>Emplacement</th><td>";
            if ($row["location_type"] == "R"){
                    echo dw3_decrypt($row["cust_adr1"]) . " " . dw3_decrypt($row["cust_adr2"]) . "<br>" . $row["cust_cp"] . " " . $row["cust_city"] . "";
            } else if ($row["location_type"] == "L"){
                    echo $row["loc_name"] . "<br>" . $row["loc_adr1"] . " " . $row["loc_adr2"] . "<br>" . $row["loc_cp"] . " " . $row["loc_city"] . "";
            }
            echo "</td></tr>";
            echo "<tr><th>Produit/Service</th><td>" . $row["prod_name"] . "</td></tr>";
            echo "<tr><th>Video-Conférence</th><td>
            Plateforme:<br>
            <select id='linePLATFORM' style='margin-bottom:7px;'>
                <option value=''>Autre plateforme</option>
                <option value='ZOOM'" . ($row["link_platform"] == "ZOOM" ? " selected" : "") . ">Zoom</option>
                <option value='TEAMS'" . ($row["link_platform"] == "TEAMS" ? " selected" : "") . ">Microsoft Teams</option>
                <option value='MEET'" . ($row["link_platform"] == "MEET" ? " selected" : "") . ">Google Meet</option>
                <option value='SKYPE'" . ($row["link_platform"] == "SKYPE" ? " selected" : "") . ">Skype</option>
            </select><br>
            Lien:<br>
            <input type='text' value='" . $row["link_url"] . "' id='lineLINK' style='margin-bottom:7px;'><br>
            Code secret:<br>
            <input type='text' value='" . $row["link_pw"] . "' id='linePW' style='margin-bottom:7px;'>";
            if ($row["location_type"] == "V"){
                $loc_type = "Rencontre virtuelle"; 
                if ($row["is_link_sent"] == "0"){
                    echo "<br><button onclick=\"sendLinkEmail('".$row["id"]."');\"><span class='material-icons' style='font-size:16px;'>email</span> Envoyer le lien du meeting</button>";
                } else {
                    echo "<br><button onclick=\"sendLinkEmail('".$row["id"]."');\"><span class='material-icons' style='font-size:16px;'>email</span> Renvoyer le lien du meeting</button>";
                }
            }
            echo "</td></tr>";

            echo "<tr><th>Confirmé</th><td>" . $confirmed . "</td></tr>";
            echo "<tr style='min-height:60px;'><th>Notes<br><br><br></th><td style='white-space: pre-line;'>" . $row["commentaire"]  . "</td></tr>";
            echo "<tr><th>Créé le</th><td>" . $row["date_created"] . "</td></tr>";
            echo "<tr><th>Créé par</th><td>" . $row["state"] . "</td></tr>";
        echo "</table></div><div class='dw3_form_foot'>";
        echo "<button class='red' onclick='delLINE(\"" .  $row["id"]  . "\");'><span class='material-icons'>delete</span></button> <button class='grey' onclick='closeEDITOR();'><span class='material-icons'>cancel</span> Fermer</button> <button class='green' onclick='updLINE(\"" .  $row["id"]  . "\");'><span class='material-icons' style='font-size:16px;'>save</span> Enregistrer</button>";
        echo "</div>";
        }
    }
    $dw3_conn->close();
?>