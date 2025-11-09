<?php 
$invoice_id = $_GET['FCT']??NULL;
$invoice_type = $_GET['FROM']??'';
require_once 'security_db.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/stripe/init.php');
if ($CIE_STRIPE_MODE == "" || $CIE_STRIPE_MODE == "DEV"){
    $stripe = new \Stripe\StripeClient($CIE_STRIPE_TKEY);
} else if ($CIE_STRIPE_MODE == "PROD"){
    $stripe = new \Stripe\StripeClient($CIE_STRIPE_KEY);
}
$statusMsg = '';
$status = 'error';

//data from transaction
$sql = "SELECT * FROM invoice_head WHERE id = '" .  $invoice_id . "' ";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$session_id= $data["stripe_checkout_session_id"];
$paid = $data["paid_stripe"] + $data["paid_moneris"] + $data["paid_cash"] + $data["paid_paypal"];
$to_pay = round($data["total"]-$paid,2);
$stripe_cost = round(($to_pay*2.9)/100,2)+.3;
error_log("STRIPE_SUCCESS: Processing Stripe success for Invoice ID: " . $invoice_id . ", Session ID: " . $session_id);
        // Fetch the Checkout Session to display the JSON result on the success page
        try {
            $checkout_session = $stripe->checkout->sessions->retrieve($session_id);
            error_log("STRIPE_SUCCESS: Retrieved Stripe Checkout Session successfully.");
        } catch(Exception $e) { 
            $api_error = $e->getMessage(); 
            error_log($dw3_conn, "STRIPE_SUCCESS", "Error retrieving Stripe Checkout Session: " . $api_error);
        }
        
        if(empty($api_error) && $checkout_session){
            // Get customer details
            $customer_details = $checkout_session->customer_details;
            error_log("STRIPE_SUCCESS: Retrieved customer details from Checkout Session.");
            if ($invoice_type == 'subscription'){
                // Retrieve the subscription details
                try {
                    $subscription = $stripe->subscriptions->retrieve($checkout_session->subscription);
                    error_log("STRIPE_SUCCESS: Retrieved Stripe Subscription successfully.");
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    $api_error = $e->getMessage();
                    error_log($dw3_conn, "STRIPE_SUCCESS", "Error retrieving Stripe Subscription: " . $api_error);
                }

                if(empty($api_error) && $subscription){
                    // Check whether the payment was successful
                    if(!empty($subscription) && $subscription->status == 'active'){
                        $transactionID = $subscription->id;
                        $paidAmount = $subscription->items->data[0]->price->unit_amount;
                        $paidAmount = ($paidAmount/100);
                        $paidCurrency = $subscription->currency;
                        $payment_status = 'succeeded';
                        
                        // Customer info
                        $customer_name = $customer_email = '';
                        if(!empty($customer_details)){
                            $customer_name = !empty($customer_details->name)?$customer_details->name:'';
                            $customer_email = !empty($customer_details->email)?$customer_details->email:'';
                        }
                            $sql = "UPDATE transaction SET paid_amount = '" . $paidAmount . "',
                                                            paid_amount_currency = '" . $paidCurrency . "',
                                                            txn_id = '" . $transactionID . "',
                                                            payment_status = '" . $payment_status . "',
                                                            modified = '" . $datetime . "' 
                                    WHERE stripe_checkout_session_id = '" . $session_id  . "' ";
                            $result = mysqli_query($dw3_conn, $sql);
                            //$data = mysqli_fetch_assoc($result);
                            if ($invoice_type == 'subscription'){
                                $sql = "UPDATE invoice_head SET paid_stripe = '" . $paidAmount . "',transaction_cost = '".$stripe_cost."', subscription_stat = 'active', date_modified = '" . $datetime . "' WHERE id = '" . $invoice_id  . "' ";
                            } else {
                                $sql = "UPDATE invoice_head SET paid_stripe = '" . $paidAmount . "',transaction_cost = '".$stripe_cost."', date_modified = '" . $datetime . "' WHERE id = '" . $invoice_id  . "' ";
                            }
                            $result = mysqli_query($dw3_conn, $sql);

                        $status = 'success';
                        $statusMsg = 'Your Subscription has been Successful!';
                        if (isset($_COOKIE["SUBSCRIBE"])){unset($_COOKIE["SUBSCRIBE"]);}
                    }
                }

            } else {
                // Retrieve the details of a PaymentIntent
                try {
                    $paymentIntent = $stripe->paymentIntents->retrieve($checkout_session->payment_intent);
                    error_log("STRIPE_SUCCESS: Retrieved Stripe Payment Intent successfully.");
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    $api_error = $e->getMessage();
                    error_log($dw3_conn, "STRIPE_SUCCESS", "Error retrieving Stripe Payment Intent: " . $api_error);
                }
                
                if(empty($api_error) && $paymentIntent){
                    // Check whether the payment was successful
                    if(!empty($paymentIntent) && $paymentIntent->status == 'succeeded'){
                        // Transaction details 
                        $transactionID = $paymentIntent->id;
                        $paidAmount = $paymentIntent->amount;
                        $paidAmount = ($paidAmount/100);
                        $paidCurrency = $paymentIntent->currency;
                        $payment_status = $paymentIntent->status;
                        
                        // Customer info
                        $customer_name = $customer_email = '';
                        if(!empty($customer_details)){
                            $customer_name = !empty($customer_details->name)?$customer_details->name:'';
                            $customer_email = !empty($customer_details->email)?$customer_details->email:'';
                        }
                            $sql = "UPDATE transaction SET paid_amount = '" . $paidAmount . "',
                                                            paid_amount_currency = '" . $paidCurrency . "',
                                                            txn_id = '" . $transactionID . "',
                                                            payment_status = '" . $payment_status . "',
                                                            modified = '" . $datetime . "' 
                                    WHERE stripe_checkout_session_id = '" . $session_id  . "' ";
                            $result = mysqli_query($dw3_conn, $sql);
                            //$data = mysqli_fetch_assoc($result);
                            if ($invoice_type == 'subscription'){
                                $sql = "UPDATE invoice_head SET paid_stripe = '" . $paidAmount . "',transaction_cost = '".$stripe_cost."', subscription_stat = 'active', date_modified = '" . $datetime . "' WHERE id = '" . $invoice_id  . "' ";
                            } else {
                                $sql = "UPDATE invoice_head SET paid_stripe = '" . $paidAmount . "',transaction_cost = '".$stripe_cost."', date_modified = '" . $datetime . "' WHERE id = '" . $invoice_id  . "' ";
                            }
                            $result = mysqli_query($dw3_conn, $sql);
                            //$data = mysqli_fetch_assoc($result);
                        }else{
                            // Insert transaction data into the database
                            //$sql = "INSERT INTO transaction (invoice_id,customer_name,customer_email,paid_amount,paid_amount_currency,txn_id,payment_status,stripe_checkout_session_id,created,modified) 
                            //VALUES ('" . $invoice_id . "','" . $customer_name . "','" . $customer_email . "','" . $paidAmount . "','" . $paidCurrency . "','" . $transactionID . "','" . $payment_status . "','" . $session_id . "','" . $datetime . "','" . $datetime . "')";
                            //$result = mysqli_query($dw3_conn, $sql);
                            //$data = mysqli_fetch_assoc($result);
                            
                            //if($insert){
                                //$payment_id = $stmt->insert_id;
                            //}
                        }
                        
                        $status = 'success';
                        $statusMsg = 'Your Payment has been Successful!';
                }else{
                        $statusMsg = "Transaction has been failed!";
                }
            }
        }else{
                $statusMsg = "Unable to fetch the transaction details! $api_error"; 
        }

        header("HTTP/1.1 303 See Other");
        header("Location: dashboard.php?KEY=". $KEY. "&STRIPE_RESULT=". $status."&FCT=".$invoice_id."&STRIPE_FROM=".$invoice_type);
?>