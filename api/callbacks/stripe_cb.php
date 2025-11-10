<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
if($CIE_STRIPE_KEY!=""){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/api/stripe/init.php');
    if ($CIE_STRIPE_MODE == "" || $CIE_STRIPE_MODE == "DEV"){
        $stripe = new \Stripe\StripeClient($CIE_STRIPE_TKEY);
    } else if ($CIE_STRIPE_MODE == "PROD"){
        $stripe = new \Stripe\StripeClient($CIE_STRIPE_KEY);
    }
}else {
    $dw3_conn->close();
    header('Status: 200');
    die("");
}
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE']??'';
$payload = @file_get_contents('php://input');
$event = null;
$log=trim(preg_replace('/\s+/', ' ', $payload));
/* foreach ($payload as $header => $value) {
    $log .= "$header: $value, ";
} */
$remote_ip = $_SERVER['REMOTE_ADDR'];
$trusted_ips = "174.93.171.96 54.39.100.229 3.18.12.63 3.130.192.231 13.235.14.237 13.235.122.149 18.211.135.69 35.154.171.200 52.15.183.38 54.88.130.119 54.88.130.237 54.187.174.169 54.187.205.235 54.187.216.72
13.112.224.240 13.115.13.148 13.210.129.177 13.210.176.167 13.228.126.182 13.228.224.121 13.230.11.13 13.230.90.110 13.55.153.188 13.55.5.15 13.56.126.253 13.56.173.200 13.56.173.232 13.57.108.134 13.57.155.157  13.57.156.206 
13.57.157.116 13.57.90.254 13.57.98.27 18.194.147.12 18.195.120.229 18.195.125.165 34.200.27.109 34.200.47.89 34.202.153.183 34.204.109.15 34.213.149.138 34.214.229.69 34.223.201.215 34.237.201.68 34.237.253.141 34.238.187.115 34.239.14.72 34.240.123.193 34.241.202.139 34.241.54.72 34.241.59.225 34.250.29.31 34.250.89.120 35.156.131.6 35.156.194.238 35.157.227.67 35.158.254.198 35.163.82.19 35.164.105.206 35.164.124.216 50.16.2.231 50.18.212.157 50.18.212.223 50.18.219.232 52.1.23.197 52.196.53.105 52.196.95.231 52.204.6.233 52.205.132.193
52.211.198.11 52.212.99.37 52.213.35.125 52.22.83.139 52.220.44.249 52.25.214.31 52.26.11.205 52.26.132.102 52.26.14.11 52.36.167.221 52.53.133.6 52.54.150.82 52.57.221.37 52.59.173.230 52.62.14.35 52.62.203.73 52.63.106.9 52.63.119.77 52.65.161.237 52.73.161.98 52.74.114.251 52.74.98.83 52.76.14.176 52.76.156.251
52.76.174.156 52.77.80.43 52.8.19.58 52.8.8.189 54.149.153.72 54.152.36.104 54.183.95.195 54.187.182.230 54.187.199.38 54.187.208.163 54.238.140.239 54.65.115.204 54.65.97.98 54.67.48.128 54.67.52.245 54.68.165.206 54.68.183.151 107.23.48.182 107.23.48.232 198.137.150.21 198.137.150.22 198.137.150.23 198.137.150.24 198.137.150.25 198.137.150.26 198.137.150.27 198.137.150.28 198.137.150.101 198.137.150.102 198.137.150.103
198.137.150.104 198.137.150.105 198.137.150.106 198.137.150.107 198.137.150.108 198.137.150.171 198.137.150.172 198.137.150.173 198.137.150.174 198.137.150.175 198.137.150.176 198.137.150.177 198.137.150.178 198.137.150.221 198.137.150.222 198.137.150.223 198.137.150.224 198.137.150.225 198.137.150.226 198.137.150.227 198.137.150.228 198.202.176.21 198.202.176.22 198.202.176.23 198.202.176.24 198.202.176.25 198.202.176.26 198.202.176.27 198.202.176.28 198.202.176.101 198.202.176.102 198.202.176.103
198.202.176.104 198.202.176.105 198.202.176.106 198.202.176.107 198.202.176.108 198.202.176.171 198.202.176.172 198.202.176.173 198.202.176.174 198.202.176.175 198.202.176.176 198.202.176.177 198.202.176.178 198.202.176.221 198.202.176.222 198.202.176.223 198.202.176.224 198.202.176.225 198.202.176.226 198.202.176.227 198.202.176.228";

if (strpos($trusted_ips,$remote_ip)==""){
        // Invalid ip, update list: https://stripe.com/docs/ips
        $dw3_conn->close();
        http_response_code(400);
        error_log("\n" . "Untrusted Ip:".$remote_ip. " ". $log);
        exit();
}

try {
    $event = \Stripe\Event::constructFrom(
        json_decode($payload, true)
    );
} catch(\UnexpectedValueException $e) {
    // Invalid payload
    $dw3_conn->close();
    http_response_code(400);
    error_log("\n" . "Invalid payload:". $log);
    exit();
}

/* try {
    $event = \Stripe\Webhook::constructEvent(
      $payload, $sig_header, $CIE_STRIPE_SECRET
    );
  } catch(\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400);
    exit();
  } catch(\Stripe\Exception\SignatureVerificationException $e) {
    // Invalid signature
    http_response_code(400);
    exit();
  } */

// Handle the event
switch ($event->type) {
    //CHECKOUT SESSION
    //step1: 1st payment used to get invoice id
    case 'checkout.session.completed':
        $data = $event->data->object; 
        if (isset($data->id) && !empty($data->id)) {
            $sessionId = $data->id;
            if (isset($data->invoice) && !empty($data->invoice)) {
                $invoiceId = $data->invoice;
                $sql = "UPDATE invoice_head SET stripe_invoice ='" .  $invoiceId . "' WHERE stripe_checkout_session_id = '" . $sessionId  . "' LIMIT 1";
                $result = mysqli_query($dw3_conn, $sql);
            }
        }
        break;
    //PAYMENT INTENT
    case 'payment_intent.succeeded':
        $data = $event->data->object;
        break;
    case 'payment_intent.canceled':
        $data = $event->data->object; 
        break;
    case 'payment_intent.payment_failed':
        $data = $event->data->object;
        break;
    //PAYMENT METHOD
    case 'payment_method.attached':
        $data = $event->data->object; 
        break;
    case 'payment_method.detached':
        $data = $event->data->object;
        break;
    //INVOICE
    case 'invoice.upcoming':
        $data = $event->data->object; 
        break;
    case 'invoice.created':
        //step2: 1st payment: used to get subscription id and give positive response to stripe if needed so they proceed payment
        $data = $event->data->object; 
        if (isset($data->billing_reason) && !empty($data->billing_reason) && $data->billing_reason=="subscription_create") {
            error_log("_________________________________________________________________________" . PHP_EOL ."Subscription Create Invoice Event Found. +billing_reason");
            if (isset($data->parent->subscription_details->subscription) && !empty($data->parent->subscription_details->subscription)) {
                error_log("_________________________________________________________________________" . PHP_EOL ."Subscription Create Invoice Event Found. +subscription_id");
                $formattedDate = date('Y-m-d H:i:s', $data->period_end);
                $sql = "UPDATE order_head SET subscription_id ='" .  $data->parent->subscription_details->subscription . "', date_renew = '" . $formattedDate . "' WHERE id IN (SELECT order_id FROM invoice_head WHERE stripe_invoice = '" . $data->id  . "') LIMIT 1";
                $result = mysqli_query($dw3_conn, $sql);
                echo "1";
            }
        } else {
            if (isset($data->lines->data[1]->subscription_item_details->subscription) && !empty($data->lines->data[1]->subscription_item_details->subscription)) {
                //recurring payment: create new invoice for the order
                //get order head info
                $sql = "SELECT * FROM order_head WHERE subscription_id = '" .  $data->lines->data[1]->subscription_item_details->subscription . "'";
                $result = mysqli_query($dw3_conn, $sql);
                $data = mysqli_fetch_assoc($result);
                //get order line info
                $sql2 = "SELECT * FROM order_line WHERE order_id = '" .  $data['id'] . "'";
                $result2 = mysqli_query($dw3_conn, $sql2);
                $data2 = mysqli_fetch_assoc($result2);
                if ($data["subscription_stat"]=="active"){
                    //create invoice
                    $sql_head="INSERT INTO invoice_head (stripe_invoice,subscription_stat,line_source,order_id,location_id,stat,customer_id,name,company,eml,tel,adr1,adr2,city,prov,country,postal_code,adr1_sh,adr2_sh,city_sh,province_sh,country_sh,postal_code_sh,date_created,date_modified,date_due)"
                    . " VALUES ('".$data->id."','unpaid','product','".$data['id']."','".$data['location_id']. "','1','".$data['customer_id']."','".$data['name']."','".$data['company']."','".$data['eml']."','".$data['tel']."','".$data['adr1']."','".$data['adr2']."','".$data['city']."','".$data['province']."','".$data['country']."','".$data['postal_code']."','".$data['adr1_sh']."','".$data['adr2_sh']."','".$data['city_sh']."','".$data['province_sh']."','".$data['country_sh']."','".$data['postal_code_sh']."','".$datetime."','".$datetime."','".$datetime."')" ;
                    $result = mysqli_query($dw3_conn, $sql_head);
                    $invoice_id = $dw3_conn->insert_id;
                    $sql_line = "INSERT INTO invoice_line (head_id,product_id,product_desc,qty_order,price,tps,tvp,date_created,date_modified)"
                    . " VALUES ('".$invoice_id."','".$data2["product_id"]."','".$data2["product_desc"]."','1','".$data2["price"]."','".$data2["tps"]."','".$data2["tvp"]."','".$datetime."','".$datetime."') ; ";
                    $result = mysqli_query($dw3_conn, $sql_line);
                    echo "1";
                }
            }
        }

        break;
    case 'invoice.finalized':
        $data = $event->data->object; 
        break;
    case 'invoice.finalization_failed':
        $data = $event->data->object; 
        break;
    case 'invoice.payment_succeeded':
        $data = $event->data->object;
        //recurring payment: update invoice status to paid (first payment was made from client checkout)
        if (isset($data->subscription) && !empty($data->subscription)) {
            //if (isset($data->billing_reason) && !empty($data->billing_reason) && $data->billing_reason!="subscription_create") {
                //get product info
                $sql = "SELECT billing FROM product WHERE id IN (SELECT product_id FROM invoice_line WHERE head_id = '" .   $data->id . "')";
                $result = mysqli_query($dw3_conn, $sql);
                $data = mysqli_fetch_assoc($result);
                $billing = $data["billing"];
                if ($billing == "HEBDO"){
                    $next_date = date('Y-m-d', strtotime($datetime . ' +7 day'));
                } else if ($billing == "MENSUEL"){
                    $next_date = date('Y-m-d', strtotime($datetime . ' +1 month'));
                } else if ($billing == "ANNUEL"){
                    $next_date = date('Y-m-d', strtotime($datetime . ' +1 year'));
                } 
                //update invoice and order head
                $sql = "UPDATE invoice_head SET stat = 2,subscription_stat = 'active', date_renew = '" . $next_date . "' WHERE stripe_invoice = '" .  $data->id . "' LIMIT 1;";
                $result = mysqli_query($dw3_conn, $sql);
                $sql = "UPDATE order_head SET subscription_stat = 'active', date_renew = '" . $next_date . "' WHERE id IN (SELECT order_id FROM invoice_head WHERE stripe_invoice = '" . $data->id  . "') LIMIT 1;";
                $result = mysqli_query($dw3_conn, $sql);
            //}
         }
        break;
    case 'invoice.payment_failed':
        $data = $event->data->object; 
        //recurring payment: update invoice status to unpaid
        if (isset($data->subscription) && !empty($data->subscription)) {
            //if (isset($data->billing_reason) && !empty($data->billing_reason) && $data->billing_reason!="subscription_create") {
                $sql = "UPDATE invoice_head SET subscription_stat = 'unpaid' WHERE stripe_invoice = '" .  $data->id . "' LIMIT 1;";
                $result = mysqli_query($dw3_conn, $sql);
                $sql = "UPDATE order_head SET subscription_stat = 'unpaid' WHERE id IN (SELECT order_id FROM invoice_head WHERE stripe_invoice = '" . $data->id  . "') LIMIT 1;";
                $result = mysqli_query($dw3_conn, $sql);
            //}
         }
        break;
    //CASH BALANCE & PAYOUT
    case 'cash_balance.funds_available':
        $data = $event->data->object; 
        break;
    case 'payout.paid':
        $data = $event->data->object; 
        break;
    //REFUND
    case 'refund.created':
        $data = $event->data->object; 
        break;

    default:
     $data =  'Received unknown event type ' . $event->type;
}
$dw3_conn->close();
http_response_code(200);
error_log("_________________________________________________________________________" . PHP_EOL ."Event:".$event->type. PHP_EOL ."Event Object:". $data );
exit(); ?>