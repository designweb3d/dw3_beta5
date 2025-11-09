<?php //returns new stripe id or error
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
if ($CIE_STRIPE_KEY != ""){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/api/stripe/init.php');
    if ($CIE_STRIPE_MODE == "" || $CIE_STRIPE_MODE == "DEV"){
        $stripe = new \Stripe\StripeClient($CIE_STRIPE_TKEY);
    } else if ($CIE_STRIPE_MODE == "PROD"){
        $stripe = new \Stripe\StripeClient($CIE_STRIPE_KEY);
    }
}else {
    $dw3_conn->close();
    die("");
}
$ID = $_GET['clID'];
$sql = "SELECT * FROM customer WHERE id = '" . $ID . "' LIMIT 1";
$new_stripe_id = "";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row["type"]=="" || $row["type"]=="PARTICULAR" || $row["company"]==""){
            $cleanName = substr(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", dw3_decrypt($row["first_name"]) . ' ' . dw3_decrypt($row["last_name"]))),0,20);
        }else if ($row["company"] != "" && $row["type"]=="COMPANY"){
            $cleanName = substr(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $row["company"])),0,20);
        } else {
            $cleanName = substr(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", dw3_decrypt($row["first_name"]) . ' ' . dw3_decrypt($row["last_name"]))),0,20);
        }
        if ($CIE_STRIPE_KEY != ""){
            $stripe_result = $stripe->customers->create([
                'description' => 'Customer #' . $ID  . ' ' . dw3_decrypt($row["eml1"]),
                'address' => [
                    'city' => $row["city"],
                    'country' => $row["country"],
                    'line1' => dw3_decrypt($row["adr1"]),
                    'line2' => dw3_decrypt($row["adr2"]),
                    'postal_code' => $row["postal_code"],
                    'state' => $row["province"]
                ],    
                'name' => $cleanName,    
                'balance' => 0,   
                'phone' => dw3_decrypt($row["tel1"]),    
                'email' => dw3_decrypt($row["eml1"])
            ]);
            //echo $result;
            $new_stripe_id = $stripe_result->id;
        }else{
            $new_stripe_id = "";
        }
        //$jresult = json_decode($result, true);
        //$new_stripe_id = $jresult['id'];
        $sql = "UPDATE customer SET    
        date_modified   = '" . $datetime   . "',
        stripe_id   = '" .  $new_stripe_id . "',
        user_modified   = '" . $USER   . "'
        WHERE id = '" . $ID . "' 
        LIMIT 1";
        if ($dw3_conn->query($sql) === TRUE) {
            echo $new_stripe_id;
        } else {
            echo $dw3_conn->error;
        }
    }
}
$dw3_conn->close();
?>