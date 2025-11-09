<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$CMD   = $_GET['CMD'];

//get head data before insert 
$sql1 = "SELECT * FROM order_head WHERE id = '" .  $CMD . "'";
$result1 = mysqli_query($dw3_conn, $sql1);
$data = mysqli_fetch_assoc($result1);
$location_id = $data["location_id"];

//verif si location et province toujours bonne
if ($data["ship_type"] == "" || $data["ship_type"] == "PICKUP"){
    $sql2 = "SELECT * FROM location WHERE id = '" .  $data["location_id"] . "'";
    $result2 = mysqli_query($dw3_conn, $sql2);
    $numrows2 = $result2->num_rows;
    if ($numrows2 > 0) {	
        $data2 = mysqli_fetch_assoc($result2);
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

$sql = "SELECT A.*, B.upc, B.tax_fed AS tax_fed, B.tax_prov AS tax_prov FROM order_line A 
LEFT JOIN product B ON A.product_id = B.id WHERE A.head_id = " . $CMD . " ORDER BY A.line";
$result = $dw3_conn->query($sql);
$numrows = $result->num_rows;
if ($numrows > 0) {	
    while($row = $result->fetch_assoc()) {
        if ($row["tax_fed"]==1){
            $taxable = $taxable + round($row["price"]*$row["qty_order"],2);
        } else {
            $non_taxable = $non_taxable + round($row["price"]*$row["qty_order"],2); 
        }
    }
}
$stotal = $non_taxable + $taxable;
$taxable = $taxable - $data['discount'];
$tvp = round(($taxable/100)*$PTVP,2);
$tvh = round(($taxable/100)*$PTVH,2);
$tps = round(($taxable/100)*$PTPS,2);
$total = $stotal + $tvp + $tvh + $tps + $data["transport"]-$data['discount'] ;

//calcul date due
$duetime = strtotime($today);
if (isset($CIE_DU_F1) && $CIE_DU_F1 != ""){ 
    $duefinal = date("Y-m-d", strtotime("+".$CIE_DU_F1. " ".$CIE_DU_F2, $duetime));
} else {
    $duefinal = date("Y-m-d", strtotime("+1 month", $duetime));   
}

//insert head
	$sql = "INSERT INTO invoice_head
    (order_id,customer_id,location_id,project_id,stotal,tps,tvp,tvh,total,discount,transport,ship_type,name,company,eml,tel,adr1,adr2,city,prov,country,postal_code,date_created,date_due,date_modified)
    VALUES 
        ('" . $CMD . "',
        '" . $data['customer_id'] . "',
        '" . $location_id . "',
        '" . $data['project_id'] . "',
        '" . $stotal. "',
        '" . $tps. "',
        '" . $tvp. "',
        '" . $tvh. "',
        '" . $total. "',
        '" . $data['discount']. "',
        '" . $data['transport'] . "',
        '" . $data['ship_type'] . "',
        '" . $data['name'] . "',
        '" . $data['company'] . "',
         '" . $data['eml'] . "',
         '" . $data['tel'] . "',
         '" . $data['adr1'] . "',
         '" . $data['adr2'] . "',
         '" . $data['city'] . "',
         '" . $data['prov'] . "',
         '" . $data['country'] . "',
         '" . $data['postal_code'] . "',
         '" . $datetime . "',
         '" . $duefinal . "',
         '" . $datetime . "')";
	if ($dw3_conn->query($sql) === TRUE) {
        $inserted_id = $dw3_conn->insert_id;
        
//insert lines 
$sql = "INSERT INTO invoice_line (head_id,line,product_id,product_desc,product_opt,qty_order,qty_shipped,price,date_created,date_modified)
            SELECT '" . $inserted_id . "',line,product_id,product_desc,product_opt,qty_order,qty_shipped,price+options_price,date_created,date_modified
FROM order_line WHERE head_id = ". $CMD;
        if ($dw3_conn->query($sql) === TRUE) {
            echo $inserted_id;
            $sql = "UPDATE order_head SET stat=1 WHERE id = '" .  $CMD . "'";
            $result = mysqli_query($dw3_conn, $sql);
        } else {
            echo "Erreur: " . $dw3_conn->error;
          }
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}

    //ajout évènement
    $sql_task = "INSERT INTO event (event_type,name,description,date_start,customer_id,user_id) 
        VALUES('INVOICE','Nouvelle facture','No de Facture: ".$inserted_id."\nCréée par: ".$USER_FULLNAME ."','". $datetime ."','".$data['customer_id']."','".$USER."')";
    $result_task = $dw3_conn->query($sql_task); 

$dw3_conn->close();
?>
