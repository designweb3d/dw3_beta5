<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$OPT  = htmlspecialchars($_GET['OPT']);

//check if first line to make it default_selection option
    $sql = "SELECT COUNT(*) as counter FROM product_option_line WHERE option_id = '" . $OPT   . "';";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    if ($data['counter'] > 0){
        $default_selection = "0";
    } else {
        $default_selection = "1";
    }

//insert
	$sql = "INSERT INTO product_option_line
    (option_id,name_fr,name_en,default_selection)
    VALUES 
        ('".$OPT."',
         'Nouvelle ligne',
         'New line',
         '".$default_selection."')";
	if ($dw3_conn->query($sql) === TRUE) {
        $inserted_id = $dw3_conn->insert_id;
        echo $inserted_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
    
$dw3_conn->close();
?>
