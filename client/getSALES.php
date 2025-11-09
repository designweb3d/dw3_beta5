<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$OFFSET  = $_GET['OFFSET'];
$LIMIT  = $_GET['LIMIT'];
if ($OFFSET == ""){
	$OFFSET = "0";	
}
if ($LIMIT == "" || $LIMIT == "0"){
	$LIMIT = "10";	
}

//GET RETAILER LOC ID
$sql = "SELECT * FROM customer WHERE id = '" . $USER . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$ret_loc = $data['retailer_loc_id'];

//ROW COUNT
$sql = "SELECT COUNT(*) as rowCount FROM invoice_head WHERE location_id = '" . $ret_loc . "' AND stat >=2";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$numrows = $data['rowCount'];

//ROW DSP
$sql = "SELECT * FROM invoice_head WHERE location_id = '" . $ret_loc . "' AND stat >=2 ORDER BY id DESC LIMIT " . $LIMIT . " OFFSET " . $OFFSET . ";";
$result = $dw3_conn->query($sql);
$QTY_ROWS = $result->num_rows??0;
if ($QTY_ROWS > 0) {
    if ($USER_LANG == "FR"){
        echo "<table class='tblDATA'><tr><th style='text-align:center;'>#</th><th>Date vente</th><th>Total</th><th style='text-align:center;'>État</th><th></th></tr>";
    } else {
        echo "<table class='tblDATA'><tr><th style='text-align:center;'>#</th><th>Sale date</th><th>Total</th><th style='text-align:center;'>Stat</th><th></th></tr>";
    }
    while($row = $result->fetch_assoc()) {
        echo "<tr style='font-size:0.8em;'><td style='text-align:center;'><b>". $row["id"] ."</b></td>
        <td style='text-align:left;'>". substr($row["date_due"],0,10)."</td>
        <td style='text-align:left;'>". number_format($row["total"],2,"."," ") ."$</td>";
        if($row["stat"] == "2"){
            if ($USER_LANG == "FR"){
                echo "<td style='text-align:center;color:green;font-size:0.6em;'><b>Payé</b></td>";
            }else{
                echo "<td style='text-align:center;color:green;font-size:0.6em;'><b>Paid</b></td>";
            }
        } else if($row["stat"] == "3"){
            if ($USER_LANG == "FR"){
                echo "<td style='text-align:center;color:darkgrey;font-size:0.6em;'><b>Annulé</b></td>";
            } else{
                echo "<td style='text-align:center;color:darkgrey;font-size:0.6em;'><b>Canceled</b></td>";
            }
        }
        if ($USER_LANG == "FR"){
            echo "<td width='80px'><button style='cursor:help;' onclick='getFCT(".$row["id"].")'><span class='material-icons'>file_download</span> Voir </button></td></tr>"; 
        } else {
            echo "<td width='80px'><button style='cursor:help;' onclick='getFCT(".$row["id"].")'><span class='material-icons'>file_download</span> </button></td></tr>"; 
        }
    }
    echo "</table>";
    //FIRST PAGE
    if ($OFFSET > 0){
        echo "<button onclick='getSALES(\"\",\"" . $LIMIT . "\");'><span class='material-icons'>first_page</span></button>";
     } else {
        echo "<button disabled style='background:#777;color:#DDD;'><span class='material-icons'>first_page</span></button>";
     }
     //PREVIOUS PAGE
     if ($OFFSET > 0){
         $page = $OFFSET-$LIMIT;
         if ($page<0){$page=0;}
        echo "<button onclick='getSALES(\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_before</span></button>";
     } else {
        echo "<button disabled style='background:#777;color:#DDD;'><span class='material-icons'>navigate_before</span></button>";
     }
     //CURRENT PAGE
    echo "<span style='font-size:10px;'><b style='font-size:12px;'>" . ceil(($OFFSET/$LIMIT)+1) 
     . "</b>/<b>" . ceil($numrows/$LIMIT)
     . "</b></span>";
     //NEXTPAGE
     if (($OFFSET+$LIMIT) < ($numrows)){
         $page = $OFFSET+$LIMIT;
        echo "<button onclick='getSALES(\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_next</span></button>";
     } else {
        echo "<button disabled style='background:#777;color:#DDD;'><span class='material-icons'>navigate_next</span></button>";
     }
     //LASTPAGE
     if (($OFFSET+$LIMIT) < ($numrows)){
         $lastpage = $numrows-$LIMIT;
        echo "<button onclick='getSALES(\"". $lastpage ."\",\"" . $LIMIT . "\");'><span class='material-icons'>last_page</span></button>";
     } else {
        echo "<button disabled style='background:#777;color:#DDD;'><span class='material-icons'>last_page</span></button>";
     }
    } else {
        echo "<div class='divBOX' style='text-align:center;'>"; if ($USER_LANG == "FR"){ echo "Aucun historique de facture trouvé."; }else{echo "No invoice history found.";} echo "</div>";            
    }
    echo "</div>";
?>