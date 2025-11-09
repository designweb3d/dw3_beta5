<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$task_id  = $_GET['ID'];

$sql = "SELECT A.*, B.adr1 as loc_adr1, B.adr2 as loc_adr2, B.city as loc_city, B.postal_code as loc_cp, B.name as loc_name, B.type as loc_type,
        C.last_name as cust_name, C.adr1 as cust_adr1, C.adr2 as cust_adr2, C.postal_code as cust_cp, C.city as cust_city,C.eml1 as cust_eml, C.tel1 as cust_tel
        FROM event A
        LEFT JOIN (SELECT * FROM location) B ON A.location_id = B.id
        LEFT JOIN (SELECT * FROM customer) C ON A.customer_id = C.id
        WHERE A.id = '" . $task_id . "';";
        //error_log($sql);
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {	
        while($row = $result->fetch_assoc()) {
            //priorité de la tache
            if ($row["priority"] == "LOW"){
                $priority = "<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:gold;color:white;border-radius:10px;width:75px;text-align:center;'>BASSE</span>";
            }else if ($row["priority"] == "MEDIUM"){
                $priority = "<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:orange;color:white;border-radius:10px;width:75px;text-align:center;'>MOYENNE</span>";
            }else if ($row["priority"] == "HIGH"){
                $priority = "<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:red;color:white;border-radius:10px;width:75px;text-align:center;'>HAUTE</span>";
            } else {
                $priority = "<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:grey;color:white;border-radius:10px;width:75px;text-align:center;'>N/D</span>";
            } 
            //durée
            $from_time = strtotime($row["date_start"]); 
            $to_time = strtotime($row["end_date"]); 
            $diff = round(abs($from_time - $to_time) / 60);
            echo "<div id='divEDIT_HEADER' class='dw3_form_head'>
                    <h3>Tâche</h3>
                    <button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>close</span></button>
                </div>";

            //form
            echo "<div class='dw3_form_data' style='top:39px;'>
            <table class='tblDATA'>";
            echo "<tr><th>Tâche</th><td>" . $row["name"] . "</td></tr>";
            echo "<tr><th>Status</th><td>
                    <select id='taskSTATUS' style='width:100%;'>
                        <option value='TO_DO'"; if ($row["status"] == "TO_DO") { echo " selected"; } echo ">À FAIRE</option>
                        <option value='IN_PROGRESS'"; if ($row["status"] == "IN_PROGRESS") { echo " selected"; } echo ">EN COURS</option>
                        <option value='DONE'"; if ($row["status"] == "DONE") { echo " selected"; } echo ">TERMINÉ</option>
                        <option value='N/A'"; if ($row["status"] == "N/A" || $row["status"] == "") { echo " selected"; } echo ">Non applicable</option>
                    </select></td></tr>";
            echo "<tr><th>Priorité</th><td>".$priority."</td></tr>";
            echo "<tr><th>Lieu</th><td>".$row["loc_name"]." ". $row["loc_adr1"]." ". $row["loc_adr2"]." ". $row["loc_city"] ."</td></tr>";
            echo "<tr><th>Date</th><td>" . substr($row["date_start"],0,10). "</td></tr>";
            echo "<tr><th>Début</th><td>" . substr($row["date_start"],11,5). "</td></tr>";
            echo "<tr><th>Fin</th><td>" . substr($row["end_date"],11,5). "</td></tr>";
            if ($diff == 1){
                echo "<tr><th>Durée</th><td>" . $diff . " minute</td></tr>";
            } else {
                echo "<tr><th>Durée</th><td>" . $diff . " minutes</td></tr>";
            }
            echo "<tr><th>Détails</th><td><textarea onfocus='active_input=this.id;' rows='10' id='taskDESC'>" . $row["description"] . "</textarea></td></tr>";
            if ($row["customer_id"] != "0" && $row["customer_id"] != ""){
                echo "<tr><th>Client</th><td>" . dw3_decrypt($row["cust_name"]) .
                    "<br><span class='dw3_font'>M</span> <a href='mailto:".dw3_decrypt($row["cust_eml"])."'>".dw3_decrypt($row["cust_eml"])."</a>
                        <br><span class='dw3_font'>N</span> <a href='mailto:".dw3_decrypt($row["cust_tel"])."'>".dw3_decrypt($row["cust_tel"])."</a>";
                        echo "<br>" . dw3_decrypt($row["cust_adr1"]) . " " . dw3_decrypt($row["cust_adr2"]) . "<br>" . $row["cust_cp"] . " " . $row["cust_city"] . "";
                echo "</td></tr>";
            }
            //echo "<tr><th>Lien</th><td><input id='taskHREF' type='text' value='" . $row["href"] . "'></td></tr>";
            //echo "<tr><th>Image</th><td><input id='taskIMG' type='text' value='" . $row["img_src"] . "'></td></tr>";
        echo "</table></div><div class='dw3_form_foot'>";
        if ($APREAD_ONLY == false) {echo "<button class='red' onclick='delTASK();'><span class='material-icons'>delete</span></button>";}
        echo "<button class='grey' onclick='closeEDITOR();'><span class='material-icons'>cancel</span> Fermer</button>";
        if ($APREAD_ONLY == false) {echo "<button class='green' onclick='updTASK(\"" .  $row["id"]  . "\");'><span class='material-icons' style='font-size:16px;'>save</span> Enregistrer</button>";}
        echo "</div>";
        }
    }
    $dw3_conn->close();
?>