<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
if ($CIE_STRIPE_KEY != ""){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/api/stripe/init.php');
    $stripe = new \Stripe\StripeClient($CIE_STRIPE_KEY);
}
$ID   = $_GET['prID'];

if ($ID == "") {
	die ("Erreur: # de produit invalide.");
}
//VERIFICATIONS
$sql = "SELECT COUNT(id) as rowCount FROM order_line WHERE product_id = " . $ID;
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
if ($data['rowCount'] >= "1") {
    die ("Erreur: Seul le status peut être modifié après avoir été placé en commande.");
}
$sql = "SELECT COUNT(id) as rowCount FROM invoice_line WHERE product_id = " . $ID;
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
if ($data['rowCount'] >= "1") {
    die ("Erreur: Seul le status peut être modifié après avoir été facturé.");
}
//aller chercher certaines infos avant de deleter
/* $sql = "SELECT * FROM product WHERE id = " . $ID;
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$stripe_id = $data['stripe_id'];
 */
	$sql = "DELETE FROM product
	 WHERE id = '" . $ID ."'
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo $ID;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}

    
    //if (trim($stripe_price_id)!=""){
        //$stripe_result = $stripe->prices->delete($stripe__price_id,[]);
        //if ($stripe_result->deleted != true){
            //$dw3_conn->close();
            //echo "Erreur Stripe:  " . $stripe_result;
        //};
    //}
    //if (trim($stripe_id)!="" && $CIE_STRIPE_KEY != ""){
        //$stripe_result = $stripe->products->update($stripe_id,['active'=>false,]);
        //if ($stripe_result->deleted != true){
           // $dw3_conn->close();
           // echo "Erreur Stripe:  " . $stripe_result;
        //};
    //}

//$dir = $_SERVER['DOCUMENT_ROOT'] . '/fs/product/' . '$ID';
//foreach(glob($dir . '/*') as $file) { if(is_dir($file)) deleteAll($file); else unlink($file); } rmdir($dir);
$dw3_conn->close();
exit();
?>