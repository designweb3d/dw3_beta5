<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$PID  = mysqli_real_escape_string($dw3_conn, $_GET['ID']);
$GRP  = mysqli_real_escape_string($dw3_conn, $_GET['G']);

//get next LGN
$sql = "SELECT SUM(amount) as totECR FROM expense WHERE kind='DEBIT' AND group_name = '" . trim($GRP) . "'; ";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$totECR = $data['totECR'];

$html="";
		$sql = "UPDATE purchase_line SET name_fr='".trim($GRP)."',gl_group='".trim($GRP)."', price = '".$totECR."' WHERE id = '".$PID."';";
        if ($dw3_conn->query($sql) === TRUE) {
            echo "Mise à jour des écritures au GL pour cet ligne d'achat.";
          } else {
            echo $dw3_conn->error;
          }
      $dw3_conn->close();
      ?>
      