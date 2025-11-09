<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$option_id  = $_GET['OPT'];
$html = "";

    $sql2 = "SELECT * FROM product_option WHERE id = '".$option_id."';";
    $result2 = $dw3_conn->query($sql2);
    if ($result2->num_rows > 0) {
        while($row2 = $result2->fetch_assoc()) {
            $html .= "<div class='divBOX'>Titre français: <input id='opt_name_fr' type='text' value='".$row2["name_fr"]."'></div><br>";
            $html .= "<div class='divBOX'>Titre anglais: <input id='opt_name_en' type='text' value='".$row2["name_en"]."'></div>";
        }
    }
    
$dw3_conn->close();
header('Status: 200');
die($html);
?>
