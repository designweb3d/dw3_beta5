<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$budYEAR   = $_GET['YEAR'];

//aller cherche le solde d'ouverture
$sql = "SELECT * FROM config WHERE kind = 'GL' AND code = 'YEAR' LIMIT 1";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    $SOLDE_OUVERTURE = trim($data["text2"]);
} else {
    $SOLDE_OUVERTURE = 0;
}

$tot_rev = 0;
$tot_dep = 0;

function getLineTotal($amount,$freq,$date_start,$date_end,$budYEAR) {
        $lines_count = 0;
        $total_out = 0;
        $next_date = $date_start;
        do {
            if (date('Y', strtotime($next_date)) == $budYEAR){
                $total_out = $total_out + $amount;
            }
            if($freq == "WEEKLY"){
                $next_date = date('Y-m-d', strtotime($next_date . ' +7 day'));
            }
            if($freq == "BI-WEEKLY"){
                $next_date = date('Y-m-d', strtotime($next_date . ' +14 day'));
            }
            if($freq == "MONTHLY"){
                $next_date = date('Y-m-d', strtotime($next_date . ' +1 month'));
            }
            if($freq == "MONTHLY2"){
                $next_date = date('Y-m-d', strtotime($next_date . ' +2 month'));
            }
            if($freq == "MONTHLY3"){
                $next_date = date('Y-m-d', strtotime($next_date . ' +3 month'));
            }
            if($freq == "MONTHLY4"){
                $next_date = date('Y-m-d', strtotime($next_date . ' +4 month'));
            }
            if($freq == "MONTHLY6"){
                $next_date = date('Y-m-d', strtotime($next_date . ' +6 month'));
            }
            if($freq == "YEARLY"){
                $next_date = date('Y-m-d', strtotime($next_date . ' +1 year'));
            }
            if($freq == "DAILY"){
                $next_date = date('Y-m-d', strtotime($next_date . ' +1 day'));
            }  
            $lines_count++;
        //} while ($next_date <= $event_end && YEAR($next_date) == $budYEAR);
        } while ($next_date <= $date_end && date('Y', strtotime($next_date)) <= $budYEAR && $lines_count < 9999);
        return $total_out;
}

//REVENUS
echo "<h4 style='margin-top:0px;'>Revenus pour l'année " . $budYEAR . "</h4>";
$sql = "SELECT * FROM budget WHERE revenu=1 AND YEAR(date_start) <= '" . $budYEAR . "' AND YEAR(date_end) >= '" . $budYEAR . "' ORDER BY date_start DESC";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table id='tblRevenus' class='tblSEL' style='width:100%;'>
            <thead>
                <tr>
                    <th width='5%' onclick=\"sortTable2(0,'tblRevenus')\">#</th>
                    <th width='*' onclick=\"sortTable2(1,'tblRevenus')\">Nom</th>
                    <th width='5%' style='text-align:right;' onclick=\"sortTable2(2,'tblRevenus')\">Montant</th>
                    <th width='5%' onclick=\"sortTable2(3,'tblRevenus')\">Fréquence</th>
                    <th width='5%' style='text-align:right;' onclick=\"sortTable2(4,'tblRevenus')\">Total</th>
                </tr>
            </thead>
            <tbody>";
    while($row = $result->fetch_assoc()) {
        if ($row["freq"] == "ONETIME"){
            $FREQ = "Une fois"; 
            //$TOTAL = $row["amount"];
        } else if ($row["freq"] == "DAILY"){
            $FREQ = "Quotidien"; 
            //$TOTAL = $row["amount"] * 365;
        } else if ($row["freq"] == "WEEKLY"){
            $FREQ = "Hebdomadaire"; 
            //$TOTAL = $row["amount"] * 52;   
        } else if ($row["freq"] == "BI-WEEKLY"){
            $FREQ = "Bihebdomadaire"; 
            //$TOTAL = $row["amount"] * 26;
        } else if ($row["freq"] == "MONTHLY"){
            $FREQ = "Mensuel"; 
            //$TOTAL = $row["amount"] * 12;
        } else if ($row["freq"] == "MONTHLY2"){
            $FREQ = "Bimestriel"; 
            //$TOTAL = $row["amount"] * 6;
        } else if ($row["freq"] == "MONTHLY3"){
            $FREQ = "Trimestriel"; 
            //$TOTAL = $row["amount"] * 4;
        } else if ($row["freq"] == "MONTHLY4"){
            $FREQ = "Quadrimestriel"; 
            //$TOTAL = $row["amount"] * 3;
        } else if ($row["freq"] == "MONTHLY6"){
            $FREQ = "Semestriel"; 
            //$TOTAL = $row["amount"] * 2;
        } else if ($row["freq"] == "YEARLY"){
            $FREQ = "Annuel"; 
            //$TOTAL = $row["amount"];
        } else {
            $FREQ = "Non défini";
            //$TOTAL = $row["amount"]; 
        }
        $TOTAL = getLineTotal($row["amount"],$row["freq"],$row["date_start"],$row["date_end"],$budYEAR);
        echo "<tr onclick='getBUD(\"" . $row["id"] . "\");'>
                <td>" . $row["id"] . "</td>
                <td>" . htmlspecialchars($row["name_fr"], ENT_QUOTES) . "</td>
                <td style='text-align:right;'>" . number_format($row["amount"], 2, '.', '') . " $</td>
                <td>" . $FREQ  . "</td>
                <td style='text-align:right;'>" . number_format($TOTAL, 2, '.', '') . " $</td>
              </tr>";
              $tot_rev = $tot_rev + $TOTAL;
    }
    echo "</tbody></table><table class='tblDATA'><tbody><tr style='font-weight:bold;'>
            <td colspan='4'>Total</td>
            <td style='text-align:right;'>" . number_format($tot_rev, 2, '.', ' ') . " $</td>
          </tr>";
    echo "  </tbody>
        </table>";
} else {
    echo "<div style='text-align:center;padding:20px;color:grey;'><span class='material-icons' style='font-size:40px;'>info</span><br>Aucun revenu</div>";
}

//DÉPENSES
echo "<h4 style='margin-top:0px;'>Dépenses pour l'année " . $budYEAR . "</h4>";
$sql = "SELECT * FROM budget WHERE revenu=0 AND YEAR(date_start) <= '" . $budYEAR . "' AND YEAR(date_end) >= '" . $budYEAR . "' ORDER BY date_start DESC";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table id='tblDepenses' class='tblSEL' style='width:100%;'>
            <thead>
                <tr>
                    <th width='5%' onclick=\"sortTable2(0,'tblDepenses')\">#</th>
                    <th width='*' onclick=\"sortTable2(1,'tblDepenses')\">Nom</th>
                    <th width='5%' onclick=\"sortTable2(2,'tblDepenses')\" style='text-align:right;'>Montant</th>
                    <th width='5%' onclick=\"sortTable2(3,'tblDepenses')\">Fréquence</th>
                    <th width='5%' onclick=\"sortTable2(4,'tblDepenses')\" style='text-align:right;'>Total</th>
                </tr>
            </thead>
            <tbody>";
    while($row = $result->fetch_assoc()) {
        if ($row["freq"] == "ONETIME"){
            $FREQ = "Une fois"; 
            //$TOTAL = $row["amount"];
        } else if ($row["freq"] == "DAILY"){
            $FREQ = "Quotidien"; 
            //$TOTAL = $row["amount"] * 365;
        } else if ($row["freq"] == "WEEKLY"){
            $FREQ = "Hebdomadaire"; 
            //$TOTAL = $row["amount"] * 52;   
        } else if ($row["freq"] == "BI-WEEKLY"){
            $FREQ = "Bihebdomadaire"; 
            //$TOTAL = $row["amount"] * 26;
        } else if ($row["freq"] == "MONTHLY"){
            $FREQ = "Mensuel"; 
            //$TOTAL = $row["amount"] * 12;
        } else if ($row["freq"] == "MONTHLY2"){
            $FREQ = "Bimestriel"; 
            //$TOTAL = $row["amount"] * 6;
        } else if ($row["freq"] == "MONTHLY3"){
            $FREQ = "Trimestriel"; 
            //$TOTAL = $row["amount"] * 4;
        } else if ($row["freq"] == "MONTHLY4"){
            $FREQ = "Quadrimestriel"; 
            //$TOTAL = $row["amount"] * 3;
        } else if ($row["freq"] == "MONTHLY6"){
            $FREQ = "Semestriel"; 
            //$TOTAL = $row["amount"] * 2;
        } else if ($row["freq"] == "YEARLY"){
            $FREQ = "Annuel"; 
            //$TOTAL = $row["amount"];
        } else {
            $FREQ = "Non défini";
            //$TOTAL = $row["amount"]; 
        }
        $TOTAL = getLineTotal($row["amount"],$row["freq"],$row["date_start"],$row["date_end"],$budYEAR);
        echo "<tr onclick='getBUD(\"" . $row["id"] . "\");'>
                <td>" . $row["id"] . "</td>
                <td>" . htmlspecialchars($row["name_fr"], ENT_QUOTES) . "</td>
                <td style='text-align:right;'>" . number_format($row["amount"], 2, '.', '') . " $</td>
                <td>" . $FREQ  . "</td>
                <td style='text-align:right;'>" . number_format($TOTAL, 2, '.', '') . " $</td>
              </tr>";
              $tot_dep = $tot_dep + $TOTAL;
    }
    echo "</tbody></table><table class='tblDATA'><tbody><tr style='font-weight:bold;'>
            <td colspan='4'>Total</td>
            <td style='text-align:right;'>" . number_format($tot_dep, 2, ',', ' ') . " $</td>
          </tr>";
    echo "  </tbody>
        </table>";
} else {
    echo "<div style='text-align:center;padding:20px;color:grey;'><span class='material-icons' style='font-size:40px;'>info</span><br>Aucune dépense</div>";
}

//BALANCE
echo "<h4 style='margin-top:0px;padding:5px;text-shadow:none;font-weight:bold;color:black;background-color:#EEE;'>Balance";
$balance = $tot_rev - $tot_dep;
if ($balance < 0) {
    echo "<div style='float:right;font-weight:bold;color:red;'>" . number_format($balance, 2, ',', ' ') . " $</div>";
} else if ($balance == 0) {
    echo "<div style='float:right;font-weight:bold;color:black;'>" . number_format($balance, 2, ',', ' ') . " $</div>";
} else if ($balance > 0) {
    echo "<div style='float:right;font-weight:bold;color:green;'>+" . number_format($balance, 2, ',', ' ') . " $</div>";
}
echo "</h4>";

if ($budYEAR == date('Y')) {
    echo "<h4 style='margin-top:0px;padding:5px;text-shadow:none;font-weight:bold;color:black;background-color:#EEE;'>Solde d'ouverture " . $budYEAR . "<span style='float:right;'><input type='number' value='".$SOLDE_OUVERTURE."' id='bud_year_opening' style='width:100px;background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #fff;padding-right:20px;'>";
    if ($APREAD_ONLY == false){
        echo "<button class='green' style='padding:4px;' onclick='updOpening();'><span class='material-icons' style='font-size:14px'>save</span></button>";
    }
    echo "</span></h4>";
    $year_balance = $SOLDE_OUVERTURE+$balance;
    if ($year_balance < 0) {
        echo "<hr style='margin:0px;'><h4 style='margin-bottom:10px;padding:5px;text-shadow:none;font-weight:bold;color:black;background-color:#EEE;'>Solde d'ouverture prévu pour " . ($budYEAR+1) . "<span style='float:right;color:red;'>-".number_format(($year_balance), 2, ',', ' ')." $</span></h4>";
    } else if ($year_balance == 0) {
        echo "<hr style='margin:0px;'><h4 style='margin-bottom:10px;padding:5px;text-shadow:none;font-weight:bold;color:black;background-color:#EEE;'>Solde d'ouverture prévu pour " . ($budYEAR+1) . "<span style='float:right;color:black;'>".number_format(($year_balance), 2, ',', ' ')." $</span></h4>";
    } else if ($year_balance > 0) {
        echo "<hr style='margin:0px;'><h4 style='margin-bottom:10px;padding:5px;text-shadow:none;font-weight:bold;color:black;background-color:#EEE;'>Solde d'ouverture prévu pour " . ($budYEAR+1) . "<span style='float:right;color:green;'>+".number_format(($year_balance), 2, ',', ' ')." $</span></h4>";
    }
} else {
    echo "<hr style='margin:0px 0px 10px 0px;'>";
}
//LIST OF EVENTS FOR THE YEAR
echo "<h4 style='margin-top:20px;'>Événements pour l'année " . $budYEAR . "</h4>";
$sql = "CREATE TEMPORARY TABLE temp_budget (
    id INT(6) NOT NULL,
    revenu INT(1) NOT NULL,
    name_fr VARCHAR(30) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    date_event DATE NOT NULL
)";
$dw3_conn->query($sql);

$lines_count = 0;

$sql = "SELECT * FROM budget WHERE YEAR(date_start) <= '" . $budYEAR . "' AND YEAR(date_end) >= '" . $budYEAR . "' ORDER BY date_start DESC";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $event_start = $row["date_start"];
        $next_date = $row["date_start"];
        $event_end = $row["date_end"];
        $TYPE = $row["freq"];
        $lines_count = 0;
        do {
            if (date('Y', strtotime($next_date)) == $budYEAR){
                $sql = "INSERT INTO temp_budget (id, name_fr, revenu, amount, date_event) VALUES ('" . $row["id"] . "', '" . $row["name_fr"] . "', " . $row["revenu"] . ", " . $row["amount"] . ", '" . $next_date. "')";
                $dw3_conn->query($sql);
            }
            if($TYPE == "WEEKLY"){
                $next_date = date('Y-m-d', strtotime($next_date . ' +7 day'));
            }
            if($TYPE == "BI-WEEKLY"){
                $next_date = date('Y-m-d', strtotime($next_date . ' +14 day'));
            }
            if($TYPE == "MONTHLY"){
                $next_date = date('Y-m-d', strtotime($next_date . ' +1 month'));
            }
            if($TYPE == "MONTHLY2"){
                $next_date = date('Y-m-d', strtotime($next_date . ' +2 month'));
            }
            if($TYPE == "MONTHLY3"){
                $next_date = date('Y-m-d', strtotime($next_date . ' +3 month'));
            }
            if($TYPE == "MONTHLY4"){
                $next_date = date('Y-m-d', strtotime($next_date . ' +4 month'));
            }
            if($TYPE == "MONTHLY6"){
                $next_date = date('Y-m-d', strtotime($next_date . ' +6 month'));
            }
            if($TYPE == "YEARLY"){
                $next_date = date('Y-m-d', strtotime($next_date . ' +1 year'));
            }
            if($TYPE == "DAILY"){
                $next_date = date('Y-m-d', strtotime($next_date . ' +1 day'));
            }  
            $lines_count++;
        //} while ($next_date <= $event_end && YEAR($next_date) == $budYEAR);
        } while ($next_date <= $event_end && date('Y', strtotime($next_date)) <= $budYEAR && $lines_count < 9999);
    }
}
$month_total = 0;
$MONTH = "";
$is_before = true;
$is_before_event = false;
$is_before_dsp = "";
$sql = "SELECT * FROM temp_budget ORDER BY date_event ASC, revenu DESC";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if( strtotime($row["date_event"]) > strtotime(date("Y-m-d")) ) {
            if ($is_before_event == false) {
                $is_before_dsp = " border-top: 2px solid black;";
                $is_before_event = true;
            } else {
                $is_before_dsp = "";
            }
            $is_before = false;
        }
        if ($row["revenu"] == '1'){
            $minus = "";
        } else {
            $minus = "-";
        }
        if ($MONTH != date('m', strtotime($row["date_event"]))) {
            if ($MONTH != "") {
                echo "</table><table class='tblDATA'><tr style='font-weight:bold;border-top: 2px solid black;border-bottom: 2px solid black;'>
                        <td colspan='3'>Total</td>
                        <td style='text-align:right;'>" . number_format($month_total, 2, '.', '') . " $</td>";
                       if ($budYEAR == date('Y')) { echo "<td width='120px'></td>"; }
                      echo "</tr>";
                echo "</table></div>";
                $month_total = 0;
            }
            if (date('m', strtotime($row["date_event"])) == date('m') && date('Y', strtotime($row["date_event"])) == date('Y')) {
                echo "<h4 onclick=\"toggleMonth('divSubBud".date('m', strtotime($row["date_event"]))."','up".date('m', strtotime($row["date_event"]))."');\" style=\"background: rgba(255, 255, 255, 0.7);color:#333;text-shadow:none;text-align:left;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;text-shadow:none;border-bottom: 1mm ridge rgba(127, 127, 127, .6);\">
                        <span id='up".date('m', strtotime($row["date_event"]))."' class=\"material-icons\">calendar_month</span> " . date('F Y', strtotime($row["date_event"])) . "
                        </h4>";
                echo "<div class=\"divMAIN\" id='divSubBud".date('m', strtotime($row["date_event"]))."' style='padding-top:0px;transition: height 1.5s;height:auto;display:inline-block;'>";
            } else {
                echo "<h4 onclick=\"toggleMonth('divSubBud".date('m', strtotime($row["date_event"]))."','up".date('m', strtotime($row["date_event"]))."');\" style=\"background: rgba(255, 255, 255, 0.7);color:#333;text-shadow:none;text-align:left;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;text-shadow:none;border-bottom: 1mm ridge rgba(127, 127, 127, .6);\">
                        <span id='up".date('m', strtotime($row["date_event"]))."' class=\"material-icons\">calendar_today</span> " . date('F Y', strtotime($row["date_event"])) . "
                    </h4>";
                echo "<div class=\"divMAIN\" id='divSubBud".date('m', strtotime($row["date_event"]))."' style='padding-top:0px;transition: height 1.5s;height:0px;display:none;'>";
            }
            $MONTH = date('m', strtotime($row["date_event"]));
            echo "<table id='tblBUDS_".$MONTH."' class='tblSEL'><tr>
                    <th width='100px' onclick=\"sortTable2(0,'tblBUDS_".$MONTH."')\">Date</th>
                    <th width='90px' onclick=\"sortTable2(1,'tblBUDS_".$MONTH."')\">Type</th>
                    <th onclick=\"sortTable2(2,'tblBUDS_".$MONTH."')\">Nom</th>
                    <th width='120px' style='text-align:right;' onclick=\"sortTable2(3,'tblBUDS_".$MONTH."')\">Montant</th>";
                    if ($budYEAR == date('Y')) {
                        echo "<th width='120px' style='text-align:right;' onclick=\"sortTable2(4,'tblBUDS_".$MONTH."')\">Solde</th>";
                    }
                  echo "</tr>";
        }
        if ($row["revenu"] == '1'){
            $rev_text = " <span style='color:white;background-color:darkgreen;padding:2px 4px;border-radius:10px;width:80px;text-align:center;font-size:0.8em;'>Revenu</span>";
            $month_total = $month_total + $row["amount"];
            $SOLDE_OUVERTURE = $SOLDE_OUVERTURE + $row["amount"];
        } else {
            $rev_text = " <span style='color:white;background-color:darkred;padding:2px 4px;border-radius:10px;width:80px;text-align:center;font-size:0.8em;'>Dépense</span>";
            $month_total = $month_total - $row["amount"];
            $SOLDE_OUVERTURE = $SOLDE_OUVERTURE - $row["amount"];
        }
        if ($is_before == false) {
            echo "<tr style='text-shadow: 0px 0px 3px rgba(0, 0, 0, 0.5); " . $is_before_dsp . "' onclick='getBUD(\"" . $row["id"] . "\");'>
                <td width='100px'>" . $row["date_event"] . "</td>
                <td width='90px'>" . $rev_text. "</td>
                <td>" . htmlspecialchars($row["name_fr"], ENT_QUOTES) . "</td>
                <td style='text-align:right;'>" .$minus. number_format($row["amount"], 2, '.', '') . " $</td>";
                if ($budYEAR == date('Y')) {
                    if ($SOLDE_OUVERTURE < 0) {
                        echo "<td style='text-align:right;color:red;'>" . number_format($SOLDE_OUVERTURE, 2, '.', '') . " $</td>";
                    } else if ($SOLDE_OUVERTURE == 0) {
                        echo "<td style='text-align:right;color:black;'>" . number_format($SOLDE_OUVERTURE, 2, '.', '') . " $</td>";
                    } else if ($SOLDE_OUVERTURE > 0) {
                        echo "<td style='text-align:right;color:green;'>+" . number_format($SOLDE_OUVERTURE, 2, '.', '') . " $</td>";
                    }
                }
              echo "</tr>";
        } else {
            echo "<tr style='text-shadow: 0px 0px 3px rgba(255, 255, 255, 0.7);" . $is_before_dsp . "' onclick='getBUD(\"" . $row["id"] . "\");'>
                <td width='100px'>" . $row["date_event"] . "</td>
                <td width='90px'>" . $rev_text . "</td>
                <td>" . htmlspecialchars($row["name_fr"], ENT_QUOTES) . "</td>
                <td style='text-align:right;'>" .$minus. number_format($row["amount"], 2, '.', '') . " $</td>";
                if ($budYEAR == date('Y')) {
                    if ($SOLDE_OUVERTURE < 0) {
                        echo "<td style='text-align:right;color:red;'>" . number_format($SOLDE_OUVERTURE, 2, '.', '') . " $</td>";
                    } else if ($SOLDE_OUVERTURE == 0) {
                        echo "<td style='text-align:right;color:black;'>" . number_format($SOLDE_OUVERTURE, 2, '.', '') . " $</td>";
                    } else if ($SOLDE_OUVERTURE > 0) {
                        echo "<td style='text-align:right;color:green;'>+" . number_format($SOLDE_OUVERTURE, 2, '.', '') . " $</td>";
                    }
                }
              echo "</tr>";
        }

    }
    echo "</table><table class='tblDATA'><tr style='font-weight:bold;border-top: 2px solid black;border-bottom: 2px solid black;'>
        <td colspan='3'>Total</td>
        <td style='text-align:right;'>" . number_format($month_total, 2, ',', ' ') . " $</td>";
        if ($budYEAR == date('Y')) { echo "<td width='120px'></td>"; }
    echo "</tr>";
}
echo "</table></div>";
$sql = "DELETE FROM temp_budget";
$result = $dw3_conn->query($sql);
$dw3_conn->close();
?>