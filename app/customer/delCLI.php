<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
if ($CIE_STRIPE_KEY != ""){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/api/stripe/init.php');
    $stripe = new \Stripe\StripeClient($CIE_STRIPE_KEY);
}
$ID  = $_GET['clID'];

//clID 0 = Client cash
	if ($ID  == "0") {
        $dw3_conn->close();
		die ("Erreur: Le client par défaut ne peut être supprimé.");
	}
	
//VERIFICATIONS
	$sql = "SELECT COUNT(customer_id) as rowCount FROM order_head WHERE customer_id = " . $ID;
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['rowCount'] >= "1") {
        $dw3_conn->close();
		die ("Erreur: Seul le status du client peut être modifié après avoir placé une commande.");
	}

//aller chercher certaines infos avant de deleter
	$sql = "SELECT * FROM customer WHERE id = " . $ID;
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	$stripe_id = $data['stripe_id'];
    
//BDCLNT DELETE
	$sql = "DELETE FROM customer
	 WHERE id = '" . $ID ."' AND id <> 0
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo $ID;
	} else {
        $dw3_conn->close();
        die("Erreur: CLNT " . $dw3_conn->error);
	}

    //ajout évènement
    $sql_task = "INSERT INTO event (event_type,name,description,date_start,customer_id,user_id) 
        VALUES('CUSTOMER','Client effacé','Nom: ". dw3_decrypt($data['first_name']) ." ".dw3_decrypt($data['last_name']) ."\nCourriel: ".dw3_decrypt($data['eml1']) ."\nTéléphone: ".dw3_decrypt($data['tel1']) ."\nAdresse: ".dw3_decrypt($data['adr1']) ."\n\nEffacé par: ".$USER_FULLNAME ."','". $datetime ."','".$ID."','".$USER."')";
    $result_task = $dw3_conn->query($sql_task); 

//RTE_CLI DELETE
	$sql = "DELETE FROM road_line
	 WHERE customer_id = '" . $ID ."' 
	 ";
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo $ID;
	} else {
        $dw3_conn->close();
        die("Erreur: RTE " . $dw3_conn->error);
	}	

    if (trim($stripe_id)!="" && $CIE_STRIPE_KEY != ""){
        $stripe_result = $stripe->customers->delete($stripe_id,[]);
        if ($stripe_result->deleted != true){
            $dw3_conn->close();
            die("Erreur Stripe:  " . $stripe_result);
        };
    }

$dw3_conn->close();
die("");
?>