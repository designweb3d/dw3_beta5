<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['ID'];

//data from head
$sql = "SELECT *
FROM project 
WHERE id = '" . $ID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$head_stat= $data['status'];
$html = "";
$html2 = "";
$html3 = "";
$html2 = "<div><span style='width:100%;font-size:20px;text-align:left;max-width:800px;'>Montants totaux avant taxes:</span><br><table id='dataTABLE' class='tblDATA' style='max-width:800px;margin-right:auto;margin-left:auto;'>";
$total_orders = 0;
$total_billed = 0;
$total_cost = 0;
$total_task = 0;

    //COMMANDES
    $sql = "SELECT A.*,  SUBSTRING(`adr1`, LOCATE(' ', `adr1`)) as enSTREET, IFNULL(B.stotal,0) AS enNET, CONCAT(IFNULL(C.first_name,''), ' ', IFNULL(C.last_name,'')) AS user_fullname, IFNULL(D.product_desc,'') AS products_desc, IFNULL(E.product_desc,'') AS products_desc2
				FROM order_head A
            LEFT JOIN (SELECT head_id, SUM(qty_order*price) AS stotal FROM order_line GROUP BY head_id) B ON B.head_id = A.id
            LEFT JOIN (SELECT id, first_name,last_name FROM user) C ON A.user_id = C.id 
            LEFT JOIN (SELECT * FROM order_line) D ON D.id = (SELECT MIN(id) FROM order_line DD WHERE DD.head_id = A.id) 
            LEFT JOIN (SELECT * FROM order_line) E ON E.id = (SELECT MAX(id) FROM order_line EE WHERE EE.head_id = A.id) 
            WHERE project_id = ".$ID."";
    $counter= 0;
	$result = $dw3_conn->query($sql);
    $numrows = $result->num_rows;
        $html .= "<h4 onclick=\"toggleSub('divSub0','up0');\" style=\"text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(250, 199, 0, .6);background: rgba(200, 200, 200, 0.7);\">
        <span class=\"material-icons\">request_quote</span> Commandes (" . $numrows . ") ";
        if ($APREAD_ONLY == false) {$html .= "<button onclick=\"openSEL_ENT('order');\" style='padding:0px;'><span class='dw3_font'>Ĉ</span></button>";}
        $html .= "<span id='up0' class=\"material-icons\" style='float:right;margin-right:5px;'>keyboard_arrow_up</span>
        </h4>";
	if ($numrows > 0) {
        $html .= "<div class='divMAIN' id='divSub0'  style='width:100%;height:0px;display:none;margin:0px;overflow-y:auto;'>
                    <table id='dataTABLE' class='tblDATA'><tr><th>#ID</th><th>Utilisateur</th><th>Status</th><th>Produits</th><th>Date crée</th><th>Sous-Total</th></tr>";
		while($row = $result->fetch_assoc()) {
            $cmd_stat = "";
            if ($row["stat"] == "0"){$cmd_stat = "En traitement";}
            if ($row["stat"] == "1"){$cmd_stat = "En facturation";}
            if ($row["stat"] == "2"){$cmd_stat = "À expédier";}
            if ($row["stat"] == "3"){$cmd_stat = "En expédition";}
            if ($row["stat"] == "4"){$cmd_stat = "Payée et livrée";}
            if ($row["stat"] == "5"){$cmd_stat = "Annulée";}
            $html .= "<tr>";
            $html .= "<td>" . $row["id"] . "</td>";
            $html .= "<td>" . $row["user_fullname"]. "</td>";
            $html .= "<td>" . $cmd_stat . "</td>";
            if ($row["products_desc"] != $row["products_desc2"]){
                $html .= "<td>" . $row["products_desc"] .", ".$row["products_desc2"] .  "..</td>";
            } else {
                $html .= "<td>" . $row["products_desc"] .  "</td>";
            }
            $html .= "<td>" . $row["date_created"] . "</td>";
            $html .= "<td>" . number_format($row["enNET"], 2, '.', ','). "</td>";
            $html .= "</tr>";
            $total_orders += $row["enNET"];
		}
        $html2 .= "<tr><th>Commandes client</th><td style='text-align:right;border-bottom:2px solid #444;'>".number_format($total_orders, 2, '.', ',')."$</td></tr>";
    } else {
        $html .= "<div class='divMAIN' id='divSub0'  style='width:100%;height:0px;display:none;margin:0px;overflow-y:auto;'>
                    <table id='dataTABLE' class='tblDATA'><tr><td>Aucune commande trouvée pour ce projet</td></tr>";
    }
    $html .= "</table></div>";

    //FACTURES
    $sql = "SELECT * FROM invoice_head WHERE project_id = ".$ID."";
    $counter= 0;
	$result = $dw3_conn->query($sql);
    $numrows = $result->num_rows;
        $html .= "<h4 onclick=\"toggleSub('divSub1','up1');\" style=\"display:none;text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(250, 199, 0, .6);background: rgba(200, 200, 200, 0.7);\">
        <span class=\"material-icons\">receipt_long</span> Facturé au client (" . $numrows . ") ";
        if ($APREAD_ONLY == false) {$html .= "<button onclick=\"openSEL_ENT('invoice');\"><span class='dw3_font'>Ĉ</span></button>";}
        $html .= "<span id='up1' class=\"material-icons\" style='float:right;margin-right:5px;'>keyboard_arrow_up</span>
        </h4>";
	if ($numrows > 0) {
        $html .= "<div class='divMAIN' id='divSub1'  style='width:100%;height:0px;display:none;margin:0px;overflow-y:auto;'>
                    <table id='dataTABLE' class='tblDATA'><tr><th>Utilisateur</th><th>Status</th><th>Date crée</th><th>Sous-Total</th><th><span class='material-icons'>picture_as_pdf</span></th></tr>";
		while($row = $result->fetch_assoc()) {
                $html .= "<tr>";
                $html .= "<td>" . $row["user_id"] . "</td>";
                $html .= "<td>" . $row["stat"] . "</td>";
                $html .= "<td>" . number_format($row["stotal"], 2, '.', ',') . "</td>";
                $html .= "<td>" . $row["date_created"] . "</td>";
                $html .= "<td onclick=\"getFCT_FILE('".$row["id"]."')\" style='cursor:pointer;'><span class='material-icons'>download</span></td>";
                $html .= "</tr>";
                $total_billed += $row["stotal"];
		}
        //$html3 .= "<tr style='border-bottom:2px solid #444;'><th>Facturé</th><td style='text-align:right;'>".number_format($total_billed, 2, '.', ',')."$</td></tr>";
    } else {
        $html .= "<div class='divMAIN' id='divSub1'  style='width:100%;height:0px;display:none;margin:0px;overflow-y:auto;'>
                    <table id='dataTABLE' class='tblDATA'><tr><td>Aucune facture client trouvée pour ce projet</td></tr>";
    }
    $html .= "</table></div>";

    //ACHATS
    $sql = "SELECT *,  SUBSTRING(`adr1`, LOCATE(' ', `adr1`)) as enSTREET, IFNULL(B.stotal,0) AS enNET, IFNULL(C.name_fr,'') AS products_desc, IFNULL(D.name_fr,'') AS products_desc2
            FROM purchase_head A
            LEFT JOIN (SELECT head_id, SUM(qty_order*price) AS stotal FROM purchase_line GROUP BY head_id) B ON B.head_id = A.id 
            LEFT JOIN (SELECT * FROM purchase_line) C ON C.id = (SELECT MIN(id) FROM purchase_line CC WHERE CC.head_id = A.id) 
            LEFT JOIN (SELECT * FROM purchase_line) D ON D.id = (SELECT MAX(id) FROM purchase_line DD WHERE DD.head_id = A.id) 
            WHERE project_id = ".$ID."";
    $counter= 0;
	$result = $dw3_conn->query($sql);
    $numrows = $result->num_rows;
        $html .= "<h4 onclick=\"toggleSub('divSub2','up2');\" style=\"text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(250, 199, 0, .6);background: rgba(200, 200, 200, 0.7);\">
        <span class=\"material-icons\">inventory_2</span> Factures d'achats (" . $numrows . ") ";
        if ($APREAD_ONLY == false) {$html .= "<button onclick=\"openSEL_ENT('purchase');\" style='padding:0px;'><span class='dw3_font'>Ĉ</span></button>";}
        $html .= "<span id='up2' class=\"material-icons\" style='float:right;margin-right:5px;'>keyboard_arrow_up</span>
        </h4>";
	if ($numrows > 0) {
        $html .= "<div class='divMAIN' id='divSub2'  style='width:100%;height:0px;display:none;margin:0px;overflow-y:auto;'>
                    <table id='dataTABLE' class='tblDATA'><tr><th>#ID</th><th>Fournisseur</th><th>#Facture du fournisseur</th><th>Produits</th><th>Date crée</th><th>Sous-Total</th><th><span class='material-icons'>insert_drive_file</span></th></tr>";
		while($row = $result->fetch_assoc()) {
            $cmd_stat = "";
            if ($row["stat"] == "0"){$cmd_stat = "À payer";}
            if ($row["stat"] == "1"){$cmd_stat = "Payée";}
            if ($row["stat"] == "2"){$cmd_stat = "Annulée";}
            $html .= "<tr>";
            $html .= "<td>" . $row["id"] . "</td>";
            $html .= "<td>" . $row["name"] . "</td>";
            $html .= "<td>" . $row["supplier_pid"] . "</td>";
            if ($row["products_desc"] != $row["products_desc2"]){
                $html .= "<td>" . $row["products_desc"] .", ".$row["products_desc2"] .  "..</td>";
            } else {
                $html .= "<td>" . $row["products_desc"] .  "</td>";
            }
            $html .= "<td>" . $row["date_created"] . "</td>";
            $html .= "<td>" .number_format( $row["enNET"], 2, '.', ',') . "</td>";
            if ($row["document"] != ""){
                $html .= "<td onclick=\"getACH_FILE('".$row["document"]."')\" style='cursor:pointer;'><span class='material-icons'>download</span></td>";
            } else {
                $html .= "<td></td>";
            }
            $html .= "</tr>";
            $total_cost += $row["enNET"];
		}
        $html2 .= "<tr><th>Achats</th><td style='text-align:right;'>".number_format($total_cost, 2, '.', ',')."$</td></tr>";
    } else {
        $html .= "<div class='divMAIN' id='divSub2'  style='width:100%;height:0px;display:none;margin:0px;overflow-y:auto;'>
                    <table id='dataTABLE' class='tblDATA'><tr><td>Aucune facture d'achat trouvée pour ce projet</td></tr>";
    }
    $html .= "</table></div>";

    //TACHES
    $sql = "SELECT A.*, CONCAT(IFNULL(B.first_name,''), ' ', IFNULL(B.last_name,'')) AS user_fullname, B.salary as user_salary
    FROM event A
    LEFT JOIN (SELECT * FROM user) B ON B.id = A.user_id
    WHERE project_id = ".$ID." ORDER BY date_start, end_date";
    $counter= 0;
	$result = $dw3_conn->query($sql);
    $numrows = $result->num_rows;
        $html .= "<h4 onclick=\"toggleSub('divSub4','up4');\" style=\"text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(250, 199, 0, .6);background: rgba(200, 200, 200, 0.7);\">
        <span class=\"material-icons\">event</span> Tâches (" . $numrows . ") ";
        if ($APREAD_ONLY == false) {$html .= "<button onclick=\"openSEL_TASK();\" style='padding:0px;'><span class='dw3_font'>Ĉ</span></button>";}
        $html .= "<span id='up4' class=\"material-icons\" style='float:right;margin-right:5px;'>keyboard_arrow_up</span>
        </h4>";
	if ($numrows > 0) {
        $html .= "<div class='divMAIN' id='divSub4' style='width:100%;height:0px;display:none;margin:0px;overflow-y:auto;'>
                    <canvas id='task_chart' style='position:relative;display:inline-block;width:300px;height:300px;background:#". $CIE_COLOR3 ."' width=\"300\" height=\"300\"></canvas>
                    <br><table id='dataTABLE' class='tblDATA'><tr><th>Tâche</th><th>Utilisateur</th><th>Status</th><th>Type</th><th>Date</th><th>Debut</th><th>Fin</th><th>Temps (h)</th><th>Honoraire brut</th></tr>";
		while($row = $result->fetch_assoc()) {
            $t1 = strtotime( $row["date_start"] );
            $t2 = strtotime( $row["end_date"] );
            $diff = $t2 - $t1;
            $task_hours = ($diff /  60)/60 ;
            $task_cost = $task_hours * $row["user_salary"];

            //calcul des heures et minutes 
            $start_date = new DateTime($row["date_start"]);
            $since_start = $start_date->diff(new DateTime($row["end_date"]));
            $task_h = $since_start->h;
            $task_m = $since_start->i;

            $total_task += $task_cost;
                $html .= "<tr>";
                $html .= "<td>" . $row["name"] . "</td>";
                $html .= "<td>" . $row["user_fullname"] . "</td>";
                $html .= "<td>" . $row["status"] . "</td>";
                $html .= "<td>" . $row["event_type"] . "</td>";
                $html .= "<td>" . substr($row["date_start"],0,10) . "</td>";
                $html .= "<td>" . substr($row["date_start"],11,5) . "</td>";
                $html .= "<td>" . substr($row["end_date"],11,5) . "</td>";
                $html .= "<td>" . $task_h."h : " . $task_m . "m</td>";
                $html .= "<td>" . number_format($task_cost, 2, '.', ',') . "</td>";
                $html .= "</tr>";
                //$total_price += $row["total"];
		}
        $html2 .= "<tr><th>Temps</th><td style='text-align:right;border-bottom:2px solid #444;'>". number_format($total_task, 2, '.', ',')."$</td></tr>";
    } else {
        $html .= "<div class='divMAIN' id='divSub4'  style='width:100%;height:0px;display:none;margin:0px;overflow-y:auto;'>
                    <table id='dataTABLE' class='tblDATA'><tr><td>Aucune tâche trouvée pour ce projet</td></tr>";
    }
    $html .= "</table></div>";

    //progression chart    
    $sql = "SELECT status, COUNT(*) as pourcent_done FROM event 
                WHERE project_id = ".$ID. "
                GROUP BY status ORDER BY status";  
                //echo $sql;                  
        $result = mysqli_query($dw3_conn, $sql);
        $numResults = $result->num_rows;
        $counter = 0;
        $var_label = "";
        $var_data = "";
        $var_colors = "";
        date_default_timezone_set('America/New_York');
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $var_data .= $row["pourcent_done"];
                if ($row["status"] == "TO_DO") {$var_colors .= 'rgba(0,0,0,0.5)'; $var_label .= 'À faire';}
                else if ($row["status"] == "IN_PROGRESS") {$var_colors .= 'rgba(64, 224, 208,0.5)'; $var_label .= 'En cours';}
                else if ($row["status"] == "DONE") {$var_colors .= 'rgba(0,128,0,0.5)'; $var_label .= 'Terminé';}
                else {$var_colors .= 'rgba(0,0,0,0.3)'; $var_label .= 'N/A';}
                if (++$counter == $numResults) {
                // last row
                        //echo "";
                } else {
                // not last row
                        $var_label .= ",";
                        $var_data .= ",";
                        $var_colors .= ";";
                }
            }
        }
        $html .= "<input type='text' id='var_label' value=\"" . $var_label . "\" style='display:none;'>";
        $html .= "<input type='text' id='var_data' value=\"" . $var_data. "\" style='display:none;'>";
        $html .= "<input type='text' id='var_colors' value=\"" . $var_colors. "\" style='display:none;'>";


    $profits = $total_orders - $total_cost - $total_task;
    if ($profits < 0){
        $html2 .= "<tr><th>Profits estimés</th><td style='text-align:right;box-shadow:inset 0px 0px 3px 1px red;border:1px solid red;'><b>".number_format($profits, 2, '.', ',')."</b>$</td></tr>";
    } else if ($profits > 0){
        $html2 .= "<tr><th>Profits estimés</th><td style='text-align:right;box-shadow:inset 0px 0px 3px 1px green;border:1px solid green;'><b>".number_format($profits, 2, '.', ',')."</b>$</td></tr>";
    } else {
        $html2 .= "<tr><th>Profits estimés</th><td style='text-align:right;box-shadow:inset 0px 0px 3px 1px grey;border:1px solid grey;'><b>".number_format($profits, 2, '.', ',')."</b>$</td></tr>";
    }

$dw3_conn->close();
die($html2.$html3."</table></div>".$html);
?>