<?php
header("X-Robots-Tag: noindex, nofollow", true);
$current_path = (realpath(dirname(__FILE__)));
$root_path = substr($current_path, 0, strpos($current_path, '/sbin'));

parse_str($argv[1], $params);
$KEY = $params['K'];

if (file_exists($current_path  . "/hash_master.ini")) {
    $dw3_read_ini = parse_ini_file($current_path  . "/hash_master.ini");
    if (isset($dw3_read_ini["masterk"])){
        $MASTERKEY = $dw3_read_ini["masterk"];
    } else {
        die("KEY Error");
    }
} else {
    die("KEY Error");
}

if ($KEY != $MASTERKEY || $KEY == "" || $MASTERKEY == ""){
    die("KEY Error");
}


//$current_path = $_SERVER["DOCUMENT_ROOT"];
//$server_name = substr($current_path,strpos($current_path,'/',7)+1,strlen($current_path)-5-strpos($current_path,'/',7)-1);

date_default_timezone_set('America/New_York');
$dw3_ini = parse_ini_file($current_path . "/config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
$dw3_conn->set_charset("utf8mb4");
if ($dw3_conn->connect_error) {
    $dw3_conn->close();
    die("DB Error");
}	
$datetime = date("Y-m-d H:i:s"); // 2023-02-23 11:00:30
$today = date("Y-m-d"); // 2023-02-23
//die($today);
//CIE VARS
$sql = "SELECT * FROM config WHERE kind = 'CIE'";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row["code"] == "TITRE")			{$CIE_TITRE = trim($row["text1"]);
        } else if ($row["code"] == "EML1")	{$CIE_EML1 = trim($row["text1"]); 
        } else if ($row["code"] == "EML2")	{$CIE_EML2 = trim($row["text1"]); 
        } else if ($row["code"] == "EML3")	{$CIE_EML3= trim($row["text1"]); 
        } else if ($row["code"] == "ADR1")	{$CIE_ADR1 = trim($row["text1"]); 
        } else if ($row["code"] == "ADR2")	{$CIE_ADR2 = trim($row["text1"]); 
        } else if ($row["code"] == "DFT_ADR1")	{$CIE_DFT_ADR1 = trim($row["text1"]); //location fct dft
        } else if ($row["code"] == "DFT_ADR2")	{$CIE_DFT_ADR2 = trim($row["text1"]); //location exped dft
        } else if ($row["code"] == "DFT_ADR3")	{$CIE_DFT_ADR3 = trim($row["text1"]); //location pickup dft
        } else if ($row["code"] == "TX_YT")	{$TPS_YT = trim($row["text1"]);$TVP_YT = trim($row["text2"]);$TVH_YT = trim($row["text3"]);			
        } else if ($row["code"] == "TX_QC")	{$TPS_QC = trim($row["text1"]);$TVP_QC = trim($row["text2"]);$TVH_QC = trim($row["text3"]);			
        } else if ($row["code"] == "TX_SK")	{$TPS_SK = trim($row["text1"]);$TVP_SK = trim($row["text2"]);$TVH_SK = trim($row["text3"]);			
        } else if ($row["code"] == "TX_PE")	{$TPS_PE = trim($row["text1"]);$TVP_PE = trim($row["text2"]);$TVH_PE = trim($row["text3"]);			
        } else if ($row["code"] == "TX_ON")	{$TPS_ON = trim($row["text1"]);$TVP_ON = trim($row["text2"]);$TVH_ON = trim($row["text3"]);			
        } else if ($row["code"] == "TX_MB")	{$TPS_MB = trim($row["text1"]);$TVP_MB = trim($row["text2"]);$TVH_MB = trim($row["text3"]);			
        } else if ($row["code"] == "TX_NU")	{$TPS_NU = trim($row["text1"]);$TVP_NU = trim($row["text2"]);$TVH_NU = trim($row["text3"]);			
        } else if ($row["code"] == "TX_NL")	{$TPS_NL = trim($row["text1"]);$TVP_NL = trim($row["text2"]);$TVH_NL = trim($row["text3"]);			
        } else if ($row["code"] == "TX_NS")	{$TPS_NS = trim($row["text1"]);$TVP_NS = trim($row["text2"]);$TVH_NS = trim($row["text3"]);			
        } else if ($row["code"] == "TX_NT")	{$TPS_NT = trim($row["text1"]);$TVP_NT = trim($row["text2"]);$TVH_NT = trim($row["text3"]);			
        } else if ($row["code"] == "TX_NB")	{$TPS_NB = trim($row["text1"]);$TVP_NB = trim($row["text2"]);$TVH_NB = trim($row["text3"]);			
        } else if ($row["code"] == "TX_BC")	{$TPS_BC = trim($row["text1"]);$TVP_BC = trim($row["text2"]);$TVH_BC = trim($row["text3"]);			
        } else if ($row["code"] == "TX_AB")	{$TPS_AB = trim($row["text1"]);$TVP_AB = trim($row["text2"]);$TVH_AB = trim($row["text3"]);			
        } else if ($row["code"] == "TPS")		{$CIE_TPS = trim($row["text1"]);
        } else if ($row["code"] == "TVQ")		{$CIE_TVQ = trim($row["text1"]);
        } else if ($row["code"] == "NE")		{$CIE_NE = trim($row["text1"]);	
        } else if ($row["code"] == "RBQ")		{$CIE_RBQ = trim($row["text1"]);
        } else if ($row["code"] == "VILLE")		{$CIE_VILLE = trim($row["text1"]);
        } else if ($row["code"] == "PROV")		{$CIE_PROV = trim($row["text1"]);
        } else if ($row["code"] == "PAYS")		{$CIE_PAYS = trim($row["text1"]);			
        } else if ($row["code"] == "CP")	{$CIE_CP = trim($row["text1"]);				
        } else if ($row["code"] == "VILLE_ID")		{$CIE_VILLE_ID = trim($row["text1"]);
        } else if ($row["code"] == "PROV_ID")		{$CIE_PROV_ID = trim($row["text1"]);
        } else if ($row["code"] == "PAYS_ID")		{$CIE_PAYS_ID = trim($row["text1"]);
        } else if ($row["code"] == "DTLVDU")		{$CIE_LV_F1 = trim($row["text1"]);	$CIE_LV_F2 = trim($row["text2"]); $CIE_DU_F1 = trim($row["text3"]);	$CIE_DU_F2 = trim($row["text4"]);			
        }
    }
}

$nb_new_invoices = 0;

//CHECK ANNUAL PRODUCTS
	$sql = "SELECT A.date_due, A.head_id AS order_id, A.product_id, A.qty_order AS qty_order,
    B.billing AS billing, B.tax_fed AS tax_fed, B.tax_prov AS tax_prov, B.name_fr AS product_name, B.price1 AS price,
    C.invoice_due, C.customer_id, C.invoice_id, C.head_stat as head_stat,
    D.customer_stat
	FROM order_line A
    LEFT JOIN (SELECT price1,tax_fed,tax_prov,name_fr,billing,id FROM product) B ON B.id = A.product_id
    LEFT JOIN (SELECT id AS invoice_id, order_id,stat AS head_stat, customer_id, date_due AS invoice_due FROM invoice_head) C ON C.order_id = A.head_id
    LEFT JOIN (SELECT id,stat AS customer_stat, company FROM customer) D ON D.id = C.customer_id
    WHERE B.billing = 'ANNUEL'
    AND A.product_renew = '1'
    AND A.date_due < DATE_SUB(NOW(),INTERVAL 1 YEAR)
    AND A.head_id NOT IN (SELECT order_id from invoice_head WHERE date_due > DATE_SUB(NOW(),INTERVAL 1 YEAR))
    AND C.head_stat <> '3'
    AND D.customer_stat = '0' 
    OR B.billing = 'MENSUEL'
    AND A.product_renew = '1'
    AND A.date_due < DATE_SUB(NOW(),INTERVAL 1 MONTH)
    AND A.head_id NOT IN (SELECT order_id from invoice_head WHERE date_due > DATE_SUB(NOW(),INTERVAL 1 MONTH))
    AND C.head_stat <> '3'
    AND D.customer_stat = '0' 
    OR B.billing = 'HEBDO'
    AND A.product_renew = '1'
    AND A.date_due < DATE_SUB(NOW(),INTERVAL 1 WEEK)
    AND A.head_id NOT IN (SELECT order_id from invoice_head WHERE date_due > DATE_SUB(NOW(),INTERVAL 1 WEEK))
    AND C.head_stat <> '3'
    AND D.customer_stat = '0' 
    GROUP BY order_id, product_id;";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            //get head data before insert 
            $sql1 = "SELECT * FROM order_head WHERE id = '" . $row["order_id"] . "'";
            $result1 = $dw3_conn->query($sql1);
            $data = $result1->fetch_assoc();
            $location_id = $data["location_id"];
            //verif si location et province toujours bonne
            if ($data["ship_type"] == "" || $data["ship_type"] == "PICKUP"){
                $sql2 = "SELECT * FROM location WHERE id = '" .  $data["location_id"] . "'";
                $result2 = $dw3_conn->query($sql2);
                $numrows2 = $result2->num_rows;
                if ($numrows2 > 0) {	
                    $data2 = $result2->fetch_assoc();
                    $province_tx = $data2["province"];
                } else {
                    $location_id = $CIE_DFT_ADR1;
                    $province_tx = $CIE_PROV;
                }
            } else {
                if ($data["province_sh"] == ""){
                    $province_tx = $data["prov"];
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
            //get stotal,tps,tvp,tvh,total
            $stotal = 0;
            $taxable = 0;
            $non_taxable = 0;
            $tps = 0;
            $tvp = 0;
            $tvh = 0;
            $total = 0;

/*             $sql4 = "SELECT A.*, B.upc, B.tax_fed AS tax_fed, B.tax_prov AS tax_prov, B.name_fr AS product_name FROM order_line A 
            LEFT JOIN product B ON A.product_id = B.id WHERE A.head_id = '" . $row["order_id"] . "' AND B.id = '".$row["product_id"]."' ORDER BY A.line";
            $result4 = $dw3_conn->query($sql4);
            $numrows = $result4->num_rows;
            if ($numrows > 0) {	
                while($row4 = $result4->fetch_assoc()) {
                    if ($row4["tax_fed"]==1){
                        $taxable = $taxable + round($row4["price"]*$row4["qty_order"],2);
                    } else {
                        $non_taxable = $non_taxable + round($row4["price"]*$row4["qty_order"],2); 
                    }
                    $product_id = $row4["product_id"];
                    $product_desc = $row4["product_name"];
                    $product_qty = $row4["qty_order"];
                }
            } */

            //die ("tax_fed:".$row["tax_fed"]." price:".$row["price"]." qty_order:".$row["qty_order"]);

            if ($row["tax_fed"]==1){
                $taxable = $taxable + round($row["price"]*$row["qty_order"],2);
            } else {
                $non_taxable = $non_taxable + round($row["price"]*$row["qty_order"],2); 
            }
            $product_id = $row["product_id"];
            $product_desc = $row["product_name"];
            $product_qty = $row["qty_order"];
            $stotal = $non_taxable + $taxable;
            if ($taxable > 0){
                $taxable = $taxable - $data['discount'];
                $tvp = round(($taxable/100)*$PTVP,2);
                $tvh = round(($taxable/100)*$PTVH,2);
                $tps = round(($taxable/100)*$PTPS,2);
            }
            $total = $stotal + $tvp + $tvh + $tps + $data["transport"]-$data['discount'] ;

            //calcul date due
            $duetime = strtotime($today);
            if (isset($CIE_DU_F1) && $CIE_DU_F1 != ""){ 
                $duefinal = date("Y-m-d", strtotime("+".$CIE_DU_F1. " ".$CIE_DU_F2, $duetime));
            } else {
                $duefinal = date("Y-m-d", strtotime("+1 month", $duetime));   
            }

            //get customer data before insert 
            $sql3 = "SELECT * FROM customer WHERE id = '" . $data["customer_id"] . "';";
            $result3 = $dw3_conn->query($sql3);
            $data3 = $result3->fetch_assoc();

            //insert head
            $sql5 = "INSERT INTO invoice_head
            (order_id,customer_id,location_id,stotal,tps,tvp,tvh,total,discount,transport,ship_type,name,company,eml,tel,adr1,adr2,city,prov,country,postal_code,date_created,date_due,date_modified)
            VALUES 
                ('" . $row["order_id"] . "',
                '" . $data['customer_id'] . "',
                '" . $location_id . "',
                '" . $stotal. "',
                '" . $tps. "',
                '" . $tvp. "',
                '" . $tvh. "',
                '" . $total. "',
                '" . $data['discount']. "',
                '" . $data['transport'] . "',
                '" . $data['ship_type'] . "',
                '" . $data3['last_name'] . "',
                '" . $data3['company'] . "',
                '" . $data3['eml1'] . "',
                '" . $data3['tel1'] . "',
                '" . $data3['adr1'] . "',
                '" . $data3['adr2'] . "',
                '" . $data3['city'] . "',
                '" . $data3['prov'] . "',
                '" . $data3['country'] . "',
                '" . $data3['postal_code'] . "',
                '" . $datetime . "',
                '" . $duefinal . "',
                '" . $datetime . "')";
            if ($dw3_conn->query($sql5) === TRUE) {
                $inserted_id = $dw3_conn->insert_id;
                    //ajout évènement
                    $sql_task = "INSERT INTO event (event_type,name,description,date_start,customer_id) 
                        VALUES('INVOICE','Nouvelle facture','Facture No:".$inserted_id ."\n Créée par la tâche Fin de Jour.','". $datetime ."','".$data['customer_id']."')";
                    $result_task = $dw3_conn->query($sql_task); 
                $nb_new_invoices++;
                $sql6 = "INSERT INTO invoice_line (head_id,product_id,product_desc,qty_order,qty_shipped,price,date_created,date_modified)
                VALUES ('".$inserted_id."','".$product_id."','".$product_desc."','".$product_qty."','".$product_qty."','".$stotal."','" . $datetime . "','" . $datetime . "')";
                if ($dw3_conn->query($sql6) === TRUE) {
                    //done
                }
            }
        }	
    }

$sql = "INSERT INTO event (event_type,name,description,date_start) 
        VALUES('SYSTEM','Tâche planifié - Fin de jour','Nombre de factures générés :".$nb_new_invoices."','". $datetime ."')";
$result = $dw3_conn->query($sql); 

if ($nb_new_invoices > 0){

    if ($CIE_EML3 == ""){
        if ($CIE_EML2 == ""){
            $EML = $CIE_EML1;
        } else {
            $EML = $CIE_EML2;
        }
    } else {
        $EML = $CIE_EML3;
    }
    $subject = $nb_new_invoices." nouvelle(s) facture(s)";
    $subject = "Subject: =?UTF-8?B?".base64_encode($subject)."?=";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    //$headers .= 'From: no-reply@'.$server_name . "\r\n" ;
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $htmlContent = " 
    <html> 
    <head> 
        <title>Nouvelles factures</title> 
    </head> 
    <body>
        Bonjour,<br><br>
        La tâche de fin de jour a généré <b>".$nb_new_invoices."</b> nouvelle(s) facture(s).<br>
        Il ne reste qu'à les confirmer pour pouvoir les facturer et faire les écritures au GL.
        <br><br>
        Script de fin de jour ;)
    </body> 
    </html>";
    $mailer = mail(strtolower(trim($EML)), $subject, $htmlContent, $headers);
}
//echo strval($nb_new_invoices);
$dw3_conn->close();		
exit();
?>
