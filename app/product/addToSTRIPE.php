<?php //returns new stripe id or error
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
if ($CIE_STRIPE_KEY == ""){
    $dw3_conn->close();
    header('Status: 200');
    die("");
}
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/stripe/init.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/stripe/init.php');
if ($CIE_STRIPE_MODE == "" || $CIE_STRIPE_MODE == "DEV"){
    $stripe = new \Stripe\StripeClient($CIE_STRIPE_TKEY);
} else if ($CIE_STRIPE_MODE == "PROD"){
    $stripe = new \Stripe\StripeClient($CIE_STRIPE_KEY);
}

$ID = $_GET['ID'];
$sql = "SELECT *
FROM product 
WHERE id = '" . $ID . "'
LIMIT 1";
$new_stripe_id = "";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $filename= $row["link_img"];
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/product/" . $row["id"] . "/" . $filename)) {
            $filename = "/pub/img/nd.png";
        } else {
            if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/product/" . $row["id"] . "/" . $filename)) {
                $filename = "/pub/img/nd.png";
            } else {
                $filename = "/fs/product/" . $row["id"] . "/" . $filename;
            }
        }
        $filename = ["https://" . $_SERVER["SERVER_NAME"] . $filename];
        if ($row["tax_fed"] == '1') {
            $TX_FED = round($row["price1"] * (5/100),2);
        } else { $TX_FED = 0; }
        if ($row["tax_prov"] == '1') {
            $TX_PROV = round($row["price1"] * (9.975/100),2);
        } else { $TX_PROV = 0; }
        $price_tx = $row["price1"] + $TX_PROV + $TX_FED ;
        $stripe_result = $stripe->products->create([
            'name' => trim($row["name_fr"]),
            'description' => $row["description_fr"] . " ",
            'images' => $filename,
        ]);
        //get new product id
        $new_stripe_id = $stripe_result->id;
        //get default price id
        $stripe_price_id = $stripe_result->default_price;

        if ($row["billing"]=="MENSUEL"){
            $stripe_result2 = $stripe->prices->create([
                'unit_amount' => number_format($price_tx,2,"",""),
                'currency' => 'cad',
                'recurring' => ['interval' => 'month'],
                'product' => $new_stripe_id,
            ]);
        } else if ($row["billing"]=="ANNUEL") {
            $stripe_result2 = $stripe->prices->create([
                'unit_amount' => number_format($price_tx,2,"",""),
                'currency' => 'cad',
                'recurring' => ['interval' => 'year'],
                'product' => $new_stripe_id,
            ]);
        } else if ($row["billing"]=="HEBDO") {
            $stripe_result2 = $stripe->prices->create([
                'unit_amount' => number_format($price_tx,2,"",""),
                'currency' => 'cad',
                'recurring' => ['interval' => 'week'],
                'product' => $new_stripe_id,
            ]);
        } else {
            $stripe_result2 = $stripe->prices->create([
                'unit_amount' => number_format($price_tx,2,"",""),
                'currency' => 'cad',
                'product' => $new_stripe_id,
            ]);
        }
        $new_stripe_price_id = $stripe_result2->id;
        $stripe_result3 = $stripe->products->update($new_stripe_id,[
            'default_price' => $new_stripe_price_id ,
            ]);
        //$jresult = json_decode($result, true);
        //$new_stripe_id = $jresult['id'];
        $sql = "UPDATE product
        SET    
        date_modified   = '" . $datetime   . "',
        stripe_id   = '" .  $new_stripe_id . "',
        stripe_price_id   = '" .  $new_stripe_price_id . "',
        user_modified = '" . $USER   . "'
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
header('Status: 200');
?>