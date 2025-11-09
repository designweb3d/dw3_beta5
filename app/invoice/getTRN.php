<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['ID'];
$html = "";
    $sql = "SELECT *
    FROM transaction
    WHERE invoice_id = " . $ID . "
    ORDER BY created DESC";
	$result = $dw3_conn->query($sql);
    $numrows = $result->num_rows;
        $html .= "<h4 onclick=\"toggleSub('divSub3','up3');\" style=\"text-align:left;width:100%;padding:5px;border-block-start-width: thick;cursor:pointer; border-bottom-left-radius: 8px 8px;border-bottom: 1mm ridge rgba(0, 199, 250, .6);background: rgba(200, 200, 200, 0.7);\">
        <span class=\"material-icons\">inventory_2</span> Transactions <sup>(" . $numrows . ")</sup><span id='up3' class=\"material-icons\" style='float:right;margin-right:5px;'>keyboard_arrow_down</span>
        </h4>";
	if ($numrows > 0) {
        $html .= "<div class='divMAIN' id='divSub3' style='width:100%;overflow-y:auto;margin:0px;padding:0px;'>
        <table id='dataTABLE' class='tblDATA'><tr><th>#ID Transaction</th><th>Source</th><th>Montant</th><th>Devise</th><th>Status</th><th>Date et heure</th></tr>";
		while($row = $result->fetch_assoc()) {
            $html .= "<tr>";
            $html .= "<td>" . $row["id"] . "</td>";
            $html .= "<td>" . $row["payment_type"] . "</td>";
            $html .= "<td>" . number_format($row["paid_amount"],2,'.',',') . "</td>";
            $html .= "<td>" . $row["paid_amount_currency"] . "</td>";
            $html .= "<td>" . $row["payment_status"] . "</td>";
            $html .= "<td>" . $row["modified"] . "</td>";
            $html .= "</tr>";
		}
    } else {
        $html .= "<div class='divMAIN' id='divSub3' style='width:100%;overflow-y:auto;margin:0px;padding:0px;height: 0px;display: none;'>
        <table id='dataTABLE' class='tblDATA'><tr><th>#ID Transaction</th><th>Source</th><th>Montant</th><th>Devise</th><th>Status</th><th>Date et heure</th></tr>";
        $html .= "<tr><td colspan='6'>Aucune transaction trouvé.</td></tr>";
    }
$html .= "</table></div>
";
$dw3_conn->close();
die($html);
?>