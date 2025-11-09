<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$glYEAR_FROM = $_GET['YF'];
$glPERIODE_FROM = $_GET['PF'];
$glYEAR_TO = $_GET['YT'];
$glPERIODE_TO = $_GET['PT'];

//chiffre d'affaire avant taxes
$sql = "SELECT ROUND(SUM(amount),2) as stot FROM gls 
        WHERE year >= '" . $glYEAR_FROM . "' AND period >= '" . $glPERIODE_FROM . "' AND year <= '" . $glYEAR_TO . "' AND period <= '" . $glPERIODE_TO . "'
        AND gl_code = '4200' AND kind='CREDIT';";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$stot = $data['stot'];
//chiffre d'affaire brut
    //ventes avec taxes
    $sql = "SELECT ROUND(SUM(amount),2) as gtot FROM gls 
            WHERE year >= '" . $glYEAR_FROM . "' AND period >= '" . $glPERIODE_FROM . "' AND year <= '" . $glYEAR_TO . "' AND period <= '" . $glPERIODE_TO . "'
            AND gl_code = '1060' AND kind='DEBIT';";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $gtot = $data['gtot'];
    //+frais de transport chargés
/*     $sql = "SELECT ROUND(SUM(amount),2) as gtot FROM gls 
            WHERE year >= '" . $glYEAR_FROM . "' AND period >= '" . $glPERIODE_FROM . "' AND year <= '" . $glYEAR_TO . "' AND period <= '" . $glPERIODE_TO . "'
            AND gl_code = '5300';";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $gtot = round($gtot + $data['gtot'],2); */
    //+frais de cartes de credit chargés
    $sql = "SELECT ROUND(SUM(amount),2) as gtot FROM gls 
            WHERE year >= '" . $glYEAR_FROM . "' AND period >= '" . $glPERIODE_FROM . "' AND year <= '" . $glYEAR_TO . "' AND period <= '" . $glPERIODE_TO . "'
            AND gl_code = '5896';";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $gtot = round($gtot + $data['gtot'],2);
//tps recu
$sql = "SELECT ROUND(SUM(amount),2) as tot_tx FROM gls 
        WHERE year >= '" . $glYEAR_FROM . "' AND period >= '" . $glPERIODE_FROM . "' AND year <= '" . $glYEAR_TO . "' AND period <= '" . $glPERIODE_TO . "'
        AND gl_code = '2310';";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$tps_recu = $data['tot_tx'];
//tvp recu
$sql = "SELECT ROUND(SUM(amount),2) as tot_tx FROM gls 
        WHERE year >= '" . $glYEAR_FROM . "' AND period >= '" . $glPERIODE_FROM . "' AND year <= '" . $glYEAR_TO . "' AND period <= '" . $glPERIODE_TO . "'
        AND gl_code = '2340';";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$tvp_recu = $data['tot_tx'];
//tps paye
$sql = "SELECT ROUND(SUM(amount),2) as tot_tx FROM gls 
        WHERE year >= '" . $glYEAR_FROM . "' AND period >= '" . $glPERIODE_FROM . "' AND year <= '" . $glYEAR_TO . "' AND period <= '" . $glPERIODE_TO . "'
        AND gl_code = '2315';";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$tps_paye = $data['tot_tx'];
//tvp paye
$sql = "SELECT ROUND(SUM(amount),2) as tot_tx FROM gls 
        WHERE year >= '" . $glYEAR_FROM . "' AND period >= '" . $glPERIODE_FROM . "' AND year <= '" . $glYEAR_TO . "' AND period <= '" . $glPERIODE_TO . "'
        AND gl_code = '2345';";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$tvp_paye = $data['tot_tx'];

$tx_recu = floatval($tps_recu) + floatval($tvp_recu);
$tx_paye = floatval($tps_paye) + floatval($tvp_paye);
$tx_to_pay = floatval($tx_recu) - floatval($tx_paye);

$html = "Taxes à payer<table class='tblDATA'>"
      . "<tr><td>Période de</td><td style='min-width:120px;text-align:center;'>".$glYEAR_FROM."-".$glPERIODE_FROM."</td></tr>"
      . "<tr><td>Période à</td><td style='text-align:center;'>".$glYEAR_TO."-".$glPERIODE_TO."</td></tr>"
      . "<tr><td>Chiffre d'affaire avant taxes (ligne 101)</td><td style='text-align:right;'>".number_format($stot,2,"."," ")."$</td></tr>"
      . "<tr><td>Chiffre d'affaire brut</td><td style='text-align:right;'>".number_format($gtot,2,"."," ")."$</td></tr>"
      . "<tr><td>TPS perçus (ligne 103)</td><td style='text-align:right;'>".number_format($tps_recu,2,"."," ")."$</td></tr>"
      . "<tr><td>TVP perçus (ligne 203)</td><td style='text-align:right;'>".number_format($tvp_recu,2,"."," ")."$</td></tr>"
      . "<tr><td>Total des taxes perçus</td><td style='text-align:right;'>".number_format($tx_recu,2,"."," ")."$</td></tr>"
      . "<tr><td>TPS payés (ligne 106)</td><td style='text-align:right;'>".number_format($tps_paye,2,"."," ")."$</td></tr>"
      . "<tr><td>TVP payés (ligne 206)</td><td style='text-align:right;'>".number_format($tvp_paye,2,"."," ")."$</td></tr>"
      . "<tr><td>Total des taxes payés</td><td style='text-align:right;'>".number_format($tx_paye,2,"."," ")."$</td></tr>"
      . "<tr><td>Total des taxes à payer</td><td style='text-align:right;'><b>".number_format($tx_to_pay,2,"."," ")."$</b></td></tr>"
      . "</table><a href='https://www.revenuquebec.ca/fr/entreprises/taxes/tpstvh-et-tvq/declaration-de-la-tps-et-de-la-tvq/' target='_blank'><button>Site de Revenu QC</button></a>";

$dw3_conn->close();
header('Status: 200');
die($html);
?>