  <?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$OPT  = htmlspecialchars($_GET['OPT']);
$LST  = htmlspecialchars($_GET['LST']);
if($LST == ""){$dw3_conn->close();die ("Erreur: La liste de produits vide.");}
$LSTA = explode(",",str_replace("(", "",str_replace(")", "",$LST)));

$sql = "SELECT * FROM product_option WHERE id = '" . $OPT . "';";
$result = mysqli_query($dw3_conn, $sql);
if ($result->num_rows > 0) {
    $data = mysqli_fetch_assoc($result);
} else {
    $dw3_conn->close();
    die ("Erreur: Option invalide.");
}

//VERIFICATIONS
	foreach ($LSTA as $product_id) {
        //verif si option deja appliquée
        $sqlx = "SELECT COUNT(id) as rowCount FROM product_option WHERE product_id = '" . $product_id . "' AND name_fr = '" . $data["name_fr"] . "'";
        $resultx = mysqli_query($dw3_conn, $sqlx);
        $datax = mysqli_fetch_assoc($resultx);
        if ($datax['rowCount'] == "0") {
            //insert option
            $sql = "INSERT INTO product_option (product_id,name_fr,name_en) VALUES ('".$product_id."','".$data["name_fr"]."','".$data["name_en"]."')";
            if ($dw3_conn->query($sql) === TRUE) {
                $inserted_id = $dw3_conn->insert_id;
            } else {
                $dw3_conn->close();
                die ( $dw3_conn->error);
            }

            //insert option_lines
            $sql2 = "SELECT * FROM product_option_line WHERE option_id = '".$OPT."';";
            $result2 = $dw3_conn->query($sql2);
            if ($result2->num_rows > 0) {
                while($row2 = $result2->fetch_assoc()) {
                    $sql3 = "INSERT INTO product_option_line (option_id,name_fr,name_en,amount,default_selection,liter,kg,height,width,depth) 
                    VALUES ('".$inserted_id."','".$row2["name_fr"]."','".$row2["name_en"]."','".$row2["amount"]."','".$row2["default_selection"]."','".$row2["liter"]."','".$row2["kg"]."','".$row2["height"]."','".$row2["width"]."','".$row2["depth"]."')";
                    if ($dw3_conn->query($sql3) === TRUE) {
                        //continue
                    } else {
                        $dw3_conn->close();
                        die ( $dw3_conn->error);
                    }     		
                }
            }
        }
	}

$dw3_conn->close();
?>
