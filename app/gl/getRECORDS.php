<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$glYEAR_FROM = $_GET['YF'];
$glPERIODE_FROM = $_GET['PF'];
$glYEAR_TO = $_GET['YT'];
$glPERIODE_TO = $_GET['PT'];
$glSOMMAIRE = $_GET['T'];

$html = "";

if ($glSOMMAIRE == "true"){
    $html .= "<h2>SOMMAIRE</h2>";
} else {
    $html .= "<h2>DÉTAILLÉ</h2>";
}

$gtotal = 0.00;
if ($glSOMMAIRE == "true"){
    $sql = "SELECT kind, gl_code, IFNULL(B.name,'') as gl_name, SUM(amount) AS total_amount FROM gls
            LEFT JOIN (SELECT code,name_fr as name FROM gl) B ON B.code = gl_code
            WHERE year >= '" . $glYEAR_FROM . "' AND period >= '" . $glPERIODE_FROM . "' AND year <= '" . $glYEAR_TO . "' AND period <= '" . $glPERIODE_TO . "'
            GROUP BY kind, gl_code, gl_name
            ORDER BY gl_code ASC, kind DESC;";
            //die($sql);
    $result = $dw3_conn->query($sql);
    $html .= "<div class='divSECTION' style='margin-bottom:46px;'><table class='tblDATA' id='dataTABLE'>";
    if ($result->num_rows > 0) {
        $html .= "<tr><th style='cursor:default;'>Db/Cr</th><th style='cursor:default;'>Poste</th><th style='cursor:default;text-align:right;'>Total</th></tr>";
        while($row = $result->fetch_assoc()) {
            $html .= "<td>" .$row['kind'] . "</td>";
            $html .= "<td><b>" .$row['gl_code'] . "</b> - " .$row['gl_name'] . "</td>";
            $html .= "<td style='text-align:right;'><b>" .number_format($row['total_amount'],2,"."," ") ."</b>$</td></tr>";
        }
    } else {
        $html .= "<tr><td>Aucunes écritures trouvés pour cette période.</td></tr>";
    }
} else {
    $sql = "SELECT *, IFNULL(B.name,'') as gl_name FROM gls
            LEFT JOIN (SELECT code,name_fr as name FROM gl) B ON B.code = gl_code
            WHERE year >= '" . $glYEAR_FROM . "' AND period >= '" . $glPERIODE_FROM . "' AND year <= '" . $glYEAR_TO . "' AND period <= '" . $glPERIODE_TO . "'
            ORDER BY year, period, date_created, gl_code;";
            //die($sql);
    $result = $dw3_conn->query($sql);
    $html .= "<div class='divSECTION' style='margin-bottom:46px;'><table class='tblSEL' id='dataTABLE'>";
    if ($result->num_rows > 0) {
        $html .= "<tr><th style='cursor:default;'>Db/Cr</th><th style='cursor:default;'>An</th><th style='cursor:default;'>P</th><th style='cursor:default;'>Montant</th><th style='cursor:default;'>Poste</th><th style='cursor:default;'>Source</th><th style='cursor:default;'>Document justicicatif</th><th style='cursor:default;'>Date écriture</th></tr>";
        while($row = $result->fetch_assoc()) {
            if ($row['kind'] == "DEBIT"){
                $gtotal += round($row['amount'],2);
            } else if($row['kind'] == "CREDIT"){
                $gtotal = round($gtotal - round($row['amount'],2),2);
                //$rtotal += round($row['amount'],2);
            }
            $html .= "<tr onclick='getRECORD(" .$row['id'] . ");'><td>" .$row['kind'] . "</td>";
            $html .= "<td>" .$row['year'] . "</td>";
            $html .= "<td>" .$row['period'] . "</td>";
            $html .= "<td style='text-align:right;'><b>" .number_format($row['amount'],2,"."," ") ."</b>$</td>";
            $html .= "<td><b>" .$row['gl_code'] . "</b> - " .$row['gl_name'] . "</td>";
            $html .= "<td>" .$row['source'] . " #" .$row['source_id'] . "</td>";
            $html .= "<td>" .$row['document'] . "</td>";
            $html .= "<td>" .$row['date_created'] . "</td></tr>";
        }
    } else {
        $html .= "<tr><td>Aucunes écritures trouvés pour cette période.</td></tr>";
    }
}
    
$html .= "</table></div>";
if (round($gtotal,2) > 0){
    $html .= "<div class='dw3_main_foot' style='padding:5px;text-shadow:1px 1px darkred;box-shadow: inset 0px 1px 2px 4px darkred;font-size:1.4em;'>Total: +<b>" . number_format($gtotal,2,',','.') . "$<b><button style='float:right;margin:0px 5px 0px 0px;'><span class='material-icons'>table_view</span> Tableau Excel</button></div>";
}else if (round($gtotal,2) < 0){
    $html .= "<div class='dw3_main_foot' style='padding:5px;text-shadow:1px 1px red;box-shadow: inset 0px 1px 2px 4px red;font-size:1.4em;'>Total: <b>" . number_format($gtotal,2,',','.') . "$<b><button style='float:right;margin:0px 5px 0px 0px;'><span class='material-icons'>table_view</span> Tableau Excel</button></div>";
}else if(round($gtotal,2) == 0){
    $html .= "<div class='dw3_main_foot' style='padding:5px;text-shadow:1px 1px green;box-shadow: inset 0px 1px 2px 4px green;font-size:1.4em;'>Total balancé à 0.00$<button style='float:right;margin:0px 5px 0px 0px;'><span class='material-icons'>table_view</span> Tableau Excel</button></div>";
}

echo $html;
$dw3_conn->close();
?>